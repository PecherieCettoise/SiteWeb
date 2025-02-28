<?php

namespace App\Pecherie\Modele\HTTP;

use App\Pecherie\Modele\HTTP\Session;

class ConnexionUtilisateur
{
// L'utilisateur connecté sera enregistré en session associé à la clé suivante
    private static string $cleConnexion = "_utilisateurConnecte";
    private static string $Role = "_roleUtilisateur";

    public static function connecter(string $loginUtilisateur, string $Role): void
    {
        Session::getInstance()->enregistrer(self::$cleConnexion, $loginUtilisateur);
        Session::getInstance()->enregistrer(self::$Role,  $Role);
    }

    public static function estConnecte(): bool
    {
        return Session::getInstance()->contient(self::$cleConnexion);
    }

    public static function deconnecter(): void
    {
        Session::getInstance()->supprimer(self::$cleConnexion);
        Session::getInstance()->detruire();
        session_unset();
        session_destroy();

    }


    public static function getLoginUtilisateurConnecte(): ?string
    {
        return Session::getInstance()->lire(self::$cleConnexion);
    }

    public static function getRole(): string {
        return Session::getInstance()->lire(self::$Role) ?? '';
    }
}