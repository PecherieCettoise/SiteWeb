<?php

namespace App\Pecherie\Controleur;

class ControleurPage {


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


}
