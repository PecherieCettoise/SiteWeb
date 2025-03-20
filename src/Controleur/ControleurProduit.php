<?php

namespace App\Pecherie\Controleur;

use App\Pecherie\Lib\MessageFlash;
use App\Pecherie\Lib\MotDePasse;
use App\Pecherie\Modele\DataObject\Produit;
use App\Pecherie\Modele\HTTP\ConnexionUtilisateur;
use App\Pecherie\Modele\Repository\ConnexionBaseDeDonnees;
use App\Pecherie\Modele\Repository\ProduitRepository;
use App\Pecherie\Modele\Repository\UtilisateurRepository;
use Exception;


class ControleurProduit extends ControleurGenerique{

    public static function ajouterProduit()
    {
        // Vérifier si les champs sont présents dans le POST
        if (
            isset($_POST['reference_article'], $_POST['designation'], $_POST['prixVente'],
                $_POST['stock_reel'], $_POST['stock_disponible'], $_POST['poids_Net'])
        ) {
            // Récupérer les valeurs du formulaire
            $reference_article = intval($_POST['reference_article']);
            $designation = htmlspecialchars($_POST['designation']);
            $prixVente = floatval($_POST['prixVente']);
            $stock_reel = floatval($_POST['stock_reel']);
            $stock_disponible = floatval($_POST['stock_disponible']);
            $stockATerme = isset($_POST['stockATerme']) ? floatval($_POST['stockATerme']) : null;
            $poids_Net = floatval($_POST['poids_Net']);
            $PERMANENT = htmlspecialchars($_POST['PERMANENT']);

            // Créer un objet Produit
            $produit = new Produit($reference_article, $designation, $prixVente,
                $stock_reel, $stock_disponible, $stockATerme, $poids_Net, $PERMANENT);

            try {
                // Ajouter le produit en base
                ProduitRepository::ajouterProd($produit);
                MessageFlash::ajouter("success", "Produit ajouté avec succès !");
                ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherFormulaireAjoutProduit&controleur=produit');
            } catch (Exception $e) {
                MessageFlash::ajouter("danger", "Erreur lors de l'ajout du produit : " . $e->getMessage());
                ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherFormulaireAjoutProduit&controleur=produit');
            }
        } else {
            MessageFlash::ajouter("danger", "Tous les champs obligatoires doivent être remplis.");
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherFormulaireAjoutProduit&controleur=produit');
        }
    }

    public static function afficherFormulaireAjoutProduit(){
        ControleurGenerique::afficherVue('vueGenerale.php', [
            'titre' => "Ajouter un produit",
            "cheminCorpsVue" => 'produit/formulaireAjoutProduit.php',
        ]);
    }


    public static function afficherFormulaireSuppressionProduit()
    {
        $produitRepository = new ProduitRepository();
        $produits= $produitRepository->recuperer(); // Récupérer tous les produits

        if (empty($produits)) {
            MessageFlash::ajouter("info", "Aucun produit disponible pour suppression.");
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherProfil&controleur=utilisateur');
            return;
        }

        $chemin = array(
            "Accueil" => "controleurFrontal.php?action=afficherAcceuil&controleur=page",
            "Produits" => "controleurFrontal.php?action=formulaireSuppressionProduit&controleur=produit",
            "Supprimer produit" => "#"
        );

        // Passer les produits à la vue
        ControleurGenerique::afficherVue('vueGenerale.php', [
            'titre' => "Supprimer des produits",
            'cheminCorpsVue' => 'produit/formulaireSuppressionProduit.php',
            'produits' => $produits, // Assurez-vous de passer les produits à la vue
            'chemin' => $chemin,
        ]);
    }

    public function afficherBoutique() {
        // Nombre de produits par page
        $produitsParPage = 30;

        // Récupérer tous les produits (y compris les permanents et non permanents)
        $produitRepository = new ProduitRepository();
        $produits = $produitRepository->recupererTousLesProduits();  // Méthode qui récupère tous les produits (permanents et non permanents)

        // Filtrer les produits permanents
        $produitsPermanents = array_filter($produits, function($produit) {
            return in_array($produit->getPERMANENT(), [0, 1, 'OUI']);
        });

        // Calcul du nombre total de produits permanents
        $totalProduits = count($produitsPermanents);
        $totalPages = ceil($totalProduits / $produitsParPage);

        // Récupérer la page actuelle à partir de la query string, par défaut la page 1
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = max(1, min($totalPages, $page)); // S'assurer que la page est valide

        // Produits à afficher sur la page
        $produitsAffiches = array_slice($produitsPermanents, ($page - 1) * $produitsParPage, $produitsParPage);

        // Passer les produits et la pagination à la vue
        ControleurGenerique::afficherVue("vueGenerale.php", [
            'titre' => "Boutique",
            "cheminCorpsVue" => "boutique/pageBoutique.php",
            'produits' => $produitsAffiches,
            'page' => $page,
            'totalPages' => $totalPages,
        ]);
    }





    public static function supprimerProduit()
    {
        // Récupération du login et mot de passe de l'utilisateur courant
        $loginUtilisateurConnecte = ConnexionUtilisateur::getLoginUtilisateurConnecte();
        $motdepasseUtilisateurConnecte = $_POST['motdepasse'] ?? '';

        // Vérifier si le mot de passe de l'utilisateur connecté est correct
        $utilisateurConnecte = (new UtilisateurRepository())->recupererParClePrimaire($loginUtilisateurConnecte);

        // Vérifier si le mot de passe est correct
        if (MotDePasse::verifier($motdepasseUtilisateurConnecte, $utilisateurConnecte->getMdp())) {


            // Récupération des produits sélectionnés à partir des checkboxes envoyées
            $produitsASupprimer = $_POST['produit'] ?? [];

            if (!empty($produitsASupprimer)) {
                $produitRepository = new ProduitRepository();

                foreach ($produitsASupprimer as $referenceArticle) {
                    try {
                        $produitRepository->supprimerProduit(intval($referenceArticle));
                    } catch (Exception $e) {
                        MessageFlash::ajouter("danger", "Erreur lors de la suppression du produit avec la référence $referenceArticle : " . $e->getMessage());
                        continue;
                    }
                }

                MessageFlash::ajouter("success", "Produits supprimés avec succès");
                ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherFormulaireSuppressionProduit&controleur=produit');
            } else {
                MessageFlash::ajouter("info", "Aucun produit sélectionné");
                ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherFormulaireSuppressionProduit&controleur=produit');
            }
        }
    }






    public static function afficherTousLesProduits()
    {
        // Récupérer tous les produits via le repository
        $produitRepository = new ProduitRepository();
        $produits = $produitRepository->recuperer(); // Méthode qui récupère tous les produits

        // Définir le chemin de la vue
        $chemin = array(
            "Accueil" => "controleurFrontal.php?action=afficherAcceuil&controleur=page",
            "Produits" => "controleurFrontal.php?action=afficherTousLesProduits&controleur=produit"
        );

        // Afficher la vue avec les produits récupérés
        ControleurGenerique::afficherVue('vueGenerale.php', [
            'titre' => "Liste des produits",
            'cheminCorpsVue' => 'produit/formulaireModificationProduit.php', // Vue où seront affichés les produits
            'produits' => $produits,  // Passer les produits à la vue
            'chemin' => $chemin,
        ]);
    }

    public function recupererTousLesProduits(): array {
        $pdo = ConnexionBaseDeDonnees::getPDO(); // Assure-toi que ConnexionBD est bien configuré
        $stmt = $pdo->prepare("SELECT * FROM produit");
        $stmt->execute();

        // Retourner un tableau d'objets Produit
        return $stmt->fetchAll($pdo::FETCH_CLASS, Produit::class);
    }



    public static function modifierProduit()
    {
        // Vérifier si tous les champs sont bien envoyés
        if (!isset($_POST['reference_article'])) {
            MessageFlash::ajouter("danger", "Aucun produit sélectionné.");
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherTousLesProduits&controleur=produit');
            return;
        }

        $reference_article = intval($_POST['reference_article']);
        $designation = htmlspecialchars($_POST['designation']);
        $prixVente = floatval($_POST['prixVente']);
        $stock_reel = intval($_POST['stock_reel']);
        $stock_disponible = intval($_POST['stock_disponible']);
        $stockATerme = intval($_POST['stockATerme']);
        $poidsNet = floatval($_POST['poids_Net']);
        $PERMANENT = htmlspecialchars($_POST['PERMANENT']);


        $produitRepository = new ProduitRepository();
        $produit = $produitRepository->recupererProduitParReference_article($reference_article);
        if (!$produit) {
            MessageFlash::ajouter("danger", "Produit introuvable.");
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherTousLesProduits&controleur=produit');
            return;
        }

        // Mise à jour des valeurs
        $produit->setDesignation($designation);
        $produit->setPrixVente($prixVente);
        $produit->setStockReel($stock_reel);
        $produit->setStockDisponible($stock_disponible);
        $produit->setStockATerme($stockATerme);
        $produit->setPoidsNet($poidsNet);
        $produit->setPermanent($PERMANENT);

        try {
            // Mise à jour du produit
            $produitRepository->modifierProduit($produit);
            MessageFlash::ajouter("success", "Produit modifié avec succès !");
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherTousLesProduits&controleur=produit');
        } catch (Exception $e) {
            MessageFlash::ajouter("danger", "Erreur lors de la modification du produit : " . $e->getMessage());
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherTousLesProduits&controleur=produit');
        }
    }


}