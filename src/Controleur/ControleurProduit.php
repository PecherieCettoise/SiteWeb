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

class ControleurProduit extends ControleurGenerique {

    public static function ajouterProduit() {
        if (isset($_POST['reference_article'], $_POST['designation'], $_POST['prixVente'], $_POST['stock_reel'], $_POST['stock_disponible'], $_POST['poids_Net'])) {
            $reference_article = intval($_POST['reference_article']);
            $designation = htmlspecialchars($_POST['designation']);
            $prixVente = floatval($_POST['prixVente']);
            $stock_reel = floatval($_POST['stock_reel']);
            $stock_disponible = floatval($_POST['stock_disponible']);
            $stockATerme = isset($_POST['stockATerme']) ? floatval($_POST['stockATerme']) : null;
            $poids_Net = floatval($_POST['poids_Net']);
            $PERMANENT = htmlspecialchars($_POST['PERMANENT']);

            $produit = new Produit($reference_article, $designation, $prixVente, $stock_reel, $stock_disponible, $stockATerme, $poids_Net, $PERMANENT);

            try {
                ProduitRepository::ajouterProd($produit);
                MessageFlash::ajouter("success", "Produit ajouté avec succès !");
            } catch (Exception $e) {
                MessageFlash::ajouter("danger", "Erreur : " . $e->getMessage());
            }
        } else {
            MessageFlash::ajouter("danger", "Tous les champs obligatoires doivent être remplis.");
        }
        ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherFormulaireAjoutProduit&controleur=produit');
    }

    public static function afficherFormulaireAjoutProduit() {
        ControleurGenerique::afficherVue('vueGenerale.php', [
            'titre' => "Ajouter un produit",
            "cheminCorpsVue" => 'produit/formulaireAjoutProduit.php',
        ]);
    }

    public static function afficherBoutique() {
        $produitsParPage = 30;
        $produitRepository = new ProduitRepository();
        $produits = $produitRepository->recupererTousLesProduits();

        $produitsPermanents = array_filter($produits, function($produit) {
            return in_array($produit->getPERMANENT(), [0, 1, 'OUI']);
        });

        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $searchTerm = $_GET['search'];
            $produitsPermanents = array_filter($produitsPermanents, function($produit) use ($searchTerm) {
                return stripos($produit->getDesignation(), $searchTerm) !== false;
            });
        }

        $totalProduits = count($produitsPermanents);
        $totalPages = ceil($totalProduits / $produitsParPage);
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = max(1, min($totalPages, $page));

        $produitsAffiches = array_slice($produitsPermanents, ($page - 1) * $produitsParPage, $produitsParPage);

        ControleurGenerique::afficherVue("vueGenerale.php", [
            'titre' => "Boutique",
            "cheminCorpsVue" => "boutique/pageBoutique.php",
            'produits' => $produitsAffiches,
            'page' => $page,
            'totalPages' => $totalPages,
        ]);
    }

    public static function afficherProduit() {
        $idProduit = $_GET['id'] ?? null;

        if (!$idProduit) {
            MessageFlash::ajouter("danger", "Produit introuvable.");
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherBoutique&controleur=produit');
            return;
        }

        $produitRepository = new ProduitRepository();
        $produit = $produitRepository->recupererProduitParReference_article($idProduit);

        if (!$produit) {
            MessageFlash::ajouter("danger", "Produit introuvable.");
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherBoutique&controleur=produit');
            return;
        }

        ControleurGenerique::afficherVue('vueGenerale.php', [
            'titre' => "Détails du produit",
            "cheminCorpsVue" => "boutique/produitDetail.php",
            'produit' => $produit,
        ]);
    }

    public static function supprimerProduit() {
        $loginUtilisateurConnecte = ConnexionUtilisateur::getLoginUtilisateurConnecte();
        $motdepasseUtilisateurConnecte = $_POST['motdepasse'] ?? '';

        $utilisateurConnecte = (new UtilisateurRepository())->recupererParClePrimaire($loginUtilisateurConnecte);

        if (MotDePasse::verifier($motdepasseUtilisateurConnecte, $utilisateurConnecte->getMdp())) {
            $produitsASupprimer = $_POST['produit'] ?? [];

            if (!empty($produitsASupprimer)) {
                $produitRepository = new ProduitRepository();

                foreach ($produitsASupprimer as $referenceArticle) {
                    try {
                        $produitRepository->supprimerProduit(intval($referenceArticle));
                    } catch (Exception $e) {
                        MessageFlash::ajouter("danger", "Erreur suppression produit $referenceArticle : " . $e->getMessage());
                        continue;
                    }
                }

                MessageFlash::ajouter("success", "Produits supprimés avec succès");
            } else {
                MessageFlash::ajouter("info", "Aucun produit sélectionné");
            }
        }

        ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherFormulaireSuppressionProduit&controleur=produit');
    }


    public static function afficherFormulaireSuppressionProduit() {
        $produitRepository = new ProduitRepository();
        $produits = $produitRepository->recupererTousLesProduits(); // Vérifie que cette méthode retourne bien des produits

        ControleurGenerique::afficherVue("vueGenerale.php", [
            'titre' => "Suppression du produit",
            "cheminCorpsVue" => "produit/formulaireSuppressionProduit.php",
            "produits" => $produits // S'assurer que cette variable est bien passée
        ]);
    }


    public static function modifierProduit() {
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

        $produit->setDesignation($designation);
        $produit->setPrixVente($prixVente);
        $produit->setStockReel($stock_reel);
        $produit->setStockDisponible($stock_disponible);
        $produit->setStockATerme($stockATerme);
        $produit->setPoidsNet($poidsNet);
        $produit->setPermanent($PERMANENT);

        try {
            $produitRepository->modifierProduit($produit);
            MessageFlash::ajouter("success", "Produit modifié avec succès !");
        } catch (Exception $e) {
            MessageFlash::ajouter("danger", "Erreur : " . $e->getMessage());
        }

        ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherTousLesProduits&controleur=produit');
    }

    public static function afficherTousLesProduits(){
        $produitRepository = new ProduitRepository();
        $produits = $produitRepository->recupererTousLesProduits(); // Récupération des produits

        ControleurGenerique::afficherVue("vueGenerale.php", [
            'titre' => "Tous les produits",
            "cheminCorpsVue" => "produit/formulaireModificationProduit.php",
            "produits" => $produits // Envoi des produits à la vue
        ]);
    }


}
