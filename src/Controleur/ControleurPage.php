<?php

namespace App\Pecherie\Controleur;

class ControleurPage extends ControleurGenerique {

    public function afficherAccueil() {
        /* Récupérer les promotions
        $promotions = PageAccueil::getPromotions();*/
        // Inclure la vue d'accueil
        ControleurGenerique::afficherVue('vueGenerale.php', [
            'titre' => "Accueil",
            "cheminCorpsVue" => 'vitrine/pageAccueil.php'
        ]);
    }

    public function afficherContact() {
        // Inclure la vue de contact
        ControleurGenerique::afficherVue('vueGenerale.php', [
            'titre' => "Contact",
            "cheminCorpsVue" => 'vitrine/contact.php'
        ]);
    }

    public function afficherPecherieCettoise() {
        // Inclure la vue de contact
        ControleurGenerique::afficherVue('vueGenerale.php', [
            'titre' => "Pecherie Cettoise",
            "cheminCorpsVue" => 'vitrine/pecherieCettoise.php'
        ]);
    }

    public function afficherProduits() {
        // Inclure la vue de contact
        ControleurGenerique::afficherVue('vueGenerale.php', [
            'titre' => "Produits",
            "cheminCorpsVue" => 'vitrine/produits.php'
        ]);
    }

    public function afficherEngagements() {
        // Inclure la vue de contact
        ControleurGenerique::afficherVue('vueGenerale.php', [
            'titre' => "Engagements",
            "cheminCorpsVue" => 'vitrine/engagements.php'
        ]);
    }

    public function afficherActualites() {
        // Inclure la vue de contact
        ControleurGenerique::afficherVue('vueGenerale.php', [
            'titre' => "Actualités",
            "cheminCorpsVue" => 'vitrine/actualite.php'
        ]);
    }

    public function afficherCandidatures() {
        // Inclure la vue de contact
        ControleurGenerique::afficherVue('vueGenerale.php', [
            'titre' => "Candidatures",
            'cheminCorpsVue' => 'vitrine/candidature.php',
        ]);
    }

    public function afficherMentionsLegales() {
        // Inclure la vue de contact
        ControleurGenerique::afficherVue('vueGenerale.php', [
            'titre' => "Mentions Légales",
            'cheminCorpsVue' => 'vitrine/mentionsLegal.php',
        ]);
    }

    public function afficherMailContact(){
        ControleurGenerique::afficherVue('vueGenerale.php', [
            'titre' => "Mail de contact",
            'cheminCorpsVue' => 'vitrine/mailContact.php',
        ]);
    }

    public function afficherMailCandidature(){
        ControleurGenerique::afficherVue('vueGenerale.php', [
            'titre' => "Mail de candidature",
            'cheminCorpsVue' => 'vitrine/mailCandidature.php',
        ]);
    }

    public static function traitement_demande() {
        ControleurGenerique::afficherVue('vueGenerale.php', [
            'titre' => "Formulaire de demande",
            "cheminCorpsVue" => 'utilisateur/traitement_demande.php',
        ]);
    }

    public static function reinitialisation() {
        ControleurGenerique::afficherVue('vueGenerale.php', [
            'titre' => "Reinitialisation de mot de passe",
            "cheminCorpsVue" => 'utilisateur/formulaireReinitialisation.php',
        ]);
    }

    public static function reinitialisationMotDePasse() {
        ControleurGenerique::afficherVue('vueGenerale.php', [
            'titre' => "Reinitialisation de mot de passe",
            "cheminCorpsVue" => 'utilisateur/reinitialisationMotDePasse.php',
        ]);
    }
}
