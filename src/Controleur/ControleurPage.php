<?php

namespace App\Pecherie\Controleur;

class ControleurPage extends ControleurGenerique {

    public function afficherAccueil() {
        /* Récupérer les promotions
        $promotions = PageAccueil::getPromotions();*/
        // Inclure la vue d'accueil
        include __DIR__ . '/../Vue/vitrine/pageAccueil.php';
    }

    public function afficherContact() {
        // Inclure la vue de contact
        include __DIR__ . '/../Vue/vitrine/contact.php';
    }

    public function afficherPecherieCettoise() {
        // Inclure la vue de contact
        include __DIR__ . '/../Vue/vitrine/pecherieCettoise.php';
    }

    public function afficherProduits() {
        // Inclure la vue de contact
        include __DIR__ . '/../Vue/vitrine/produits.php';
    }

    public function afficherEngagements() {
        // Inclure la vue de contact
        include __DIR__ . '/../Vue/vitrine/engagements.php';
    }

    public function afficherActualites() {
        // Inclure la vue de contact
        include __DIR__ . '/../Vue/vitrine/actualite.php';
    }

    public function afficherCandidatures() {
        // Inclure la vue de contact
        include __DIR__ . '/../Vue/vitrine/candidature.php';
    }

    public function afficherMentionsLegales() {
        // Inclure la vue de contact
        include __DIR__ . '/../Vue/vitrine/mentionsLegal.php';
    }

    public function afficherMailContact(){
        include __DIR__ . '/../Vue/vitrine/mailContact.php';
    }

    public function afficherMailCandidature(){
        include __DIR__ . '/../Vue/vitrine/mailCandidature.php';
    }

    public static function traitement_demande() {
        include __DIR__ . '/../Vue/utilisateur/traitement_demande.php';
    }

    public static function reinitialisation() {
        include __DIR__ . '/../Vue/utilisateur/reinitialisation_mot_de_passe.php';
    }

    public static function reinitialisationMotDePasse() {
        include __DIR__ . '/../Vue/utilisateur/modification_mot_de_passe.php';
    }
}
