<?php

namespace App\Pecherie\Controleur;

class ControleurPage {

    public function afficherAccueil() {
        /* Récupérer les promotions
        $promotions = PageAccueil::getPromotions();*/
        // Inclure la vue d'accueil
        include __DIR__ . '/../../src/Vue/pageAccueil.php';
    }

    public function afficherContact() {
        // Inclure la vue de contact
        include __DIR__ . '/../Vue/contact.php';
    }

    public function afficherPecherieCettoise() {
        // Inclure la vue de contact
        include __DIR__ . '/../Vue/pecherieCettoise.php';
    }

    public function afficherProduits() {
        // Inclure la vue de contact
        include __DIR__ . '/../Vue/produits.php';
    }

    public function afficherEngagements() {
        // Inclure la vue de contact
        include __DIR__ . '/../Vue/engagements.php';
    }

    public function afficherActualites() {
        // Inclure la vue de contact
        include __DIR__ . '/../Vue/actualite.php';
    }

    public function afficherCandidatures() {
        // Inclure la vue de contact
        include __DIR__ . '/../Vue/candidature.php';
    }

    public function afficherMentionsLegales() {
        // Inclure la vue de contact
        include __DIR__ . '/../Vue/mentionsLegal.php';
    }

    public function afficherProfil() {
        // Inclure la vue de contact
        include __DIR__ . '/../Vue/profil.php';
    }

    public function envoyerCandidature(){
        include __DIR__ . '/../Vue/candidature.php';
    }

    public function afficherFormulaireConnexion() {
        include __DIR__ . '/../Vue/formulaireLogin.php';
    }

    public function afficherModifierMDP() {
        include __DIR__ . '/../Vue/changementMDP.php';
    }

    public function afficherFormulaireAjout() {
        include __DIR__ . '/../Vue/formulaireAjoutUtilisateurs.php';
    }







}
