<?php

class PageControleur {
    public function afficherAccueil() {
        /* Récupérer les promotions
        $promotions = PageAccueil::getPromotions();*/
        // Inclure la vue d'accueil
        include __DIR__ . '/../Vue/pageAccueil.php';
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


}
