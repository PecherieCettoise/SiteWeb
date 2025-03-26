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
        if (isset(
            $_POST['reference_article'], $_POST['designation'], $_POST['parenthese'],
            $_POST['PV_POISS'], $_POST['MB_POISS'], $_POST['PV_RESTO'], $_POST['MB_RESTO'],
            $_POST['PV_GD'], $_POST['MB_GD']
        )) {
            $reference_article = intval($_POST['reference_article']);
            $designation = htmlspecialchars($_POST['designation']);
            $parenthese = htmlspecialchars($_POST['parenthese']);
            $PV_POISS = floatval($_POST['PV_POISS']);
            $MB_POISS = isset($_POST['MB_POISS']) ? floatval($_POST['MB_POISS']) : null;
            $PV_RESTO = floatval($_POST['PV_RESTO']);
            $MB_RESTO = isset($_POST['MB_RESTO']) ? floatval($_POST['MB_RESTO']) : null;
            $PV_GD = floatval($_POST['PV_GD']);
            $MB_GD = isset($_POST['MB_GD']) ? floatval($_POST['MB_GD']) : null;

            $produit = new Produit(
                $reference_article, $designation, $parenthese,
                $PV_POISS, $MB_POISS, $PV_RESTO, $MB_RESTO,
                $PV_GD, $MB_GD
            );

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

    public function afficherBoutique($page = 1) {
        // Nombre de produits par page
        $produitsParPage = 30;

        // Calcul du début de la page
        $offset = ($page - 1) * $produitsParPage;

        // Récupérer les produits avec la pagination
        $produits = (new ProduitRepository())->getProduitsParPage($offset, $produitsParPage);

        // Récupérer le nombre total de produits pour calculer le nombre de pages
        $totalProduits = (new ProduitRepository())->getTotalProduits();
        $totalPages = ceil($totalProduits / $produitsParPage);

        // Assurer que la page est dans les limites
        if ($page > $totalPages) {
            $page = $totalPages;
        }
        if ($page < 1) {
            $page = 1;
        }

        // Afficher la vue avec les produits et la pagination
        ControleurGenerique::afficherVue('vueGenerale.php', [
            'titre' => "Boutique",
            'cheminCorpsVue' => 'boutique/pageBoutique.php',
            'produits' => $produits,
            'page' => $page,
            'totalPages' => $totalPages
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
        $parenthese = htmlspecialchars($_POST['parenthese']);
        $PV_POISS = floatval($_POST['PV_POISS']);
        $MB_POISS = isset($_POST['MB_POISS']) ? floatval($_POST['MB_POISS']) : null;
        $PV_RESTO = floatval($_POST['PV_RESTO']);
        $MB_RESTO = isset($_POST['MB_RESTO']) ? floatval($_POST['MB_RESTO']) : null;
        $PV_GD = floatval($_POST['PV_GD']);
        $MB_GD = isset($_POST['MB_GD']) ? floatval($_POST['MB_GD']) : null;

        $produitRepository = new ProduitRepository();
        $produit = $produitRepository->recupererProduitParReference_article($reference_article);
        if (!$produit) {
            MessageFlash::ajouter("danger", "Produit introuvable.");
            ControleurGenerique::redirectionVersURL('controleurFrontal.php?action=afficherTousLesProduits&controleur=produit');
            return;
        }

        $produit->setDesignation($designation);
        $produit->setParenthese($parenthese);
        $produit->setPVPoiss($PV_POISS);
        $produit->setMBPoiss($MB_POISS);
        $produit->setPVResto($PV_RESTO);
        $produit->setMBResto($MB_RESTO);
        $produit->setPVGD($PV_GD);
        $produit->setMBGD($MB_GD);

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
