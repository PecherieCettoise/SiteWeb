<?php

namespace App\Pecherie\Modele\HTTP;

class Cookie {

    public static function enregistrer(string $cle, mixed $valeur, ?int $dureeExpiration = null): void {
        if (isset($dureeExpiration)) {
            setcookie($cle, strval($valeur), $dureeExpiration);
        } else
            setcookie($cle, $valeur);
    }

    public static function lire(string $cle): mixed {
        return $_COOKIE[$cle];
    }

    public static function supprimer($cle) : void {
        unset($_COOKIE[$cle]);
        setcookie ($cle, "", 1);
    }

    public static function contient($cle) : bool {
        return isset($_COOKIE[$cle]);
    }
}