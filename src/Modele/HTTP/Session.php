<?php
namespace App\Pecherie\Modele\HTTP;

use App\Pecherie\Configuration\ConfigurationBaseDeDonnees;
use Exception;

class Session
{
    private static ?Session $instance = null;

    /**
     * @throws Exception
     */
    private function __construct()
    {
        if (session_status() == PHP_SESSION_NONE && session_start() === false) {
            throw new Exception("La session n'a pas réussi à démarrer.");
        }
    }

    public static function getInstance(): Session
    {
        if (is_null(Session::$instance))
            Session::$instance = new Session();
        return Session::$instance;
    }

    public function contient($nom): bool
    {
        return isset($_SESSION[$nom]);
    }

    public function enregistrer(string $nom, mixed $valeur): void
    {
        $_SESSION[$nom] = $valeur;
    }

    public function lire(string $nom): mixed
    {
        return $_SESSION[$nom];
    }

    public function supprimer($nom): void
    {
        unset($_SESSION[$nom]);
    }

    public function detruire() : void
    {
        session_unset();     // unset $_SESSION variable for the run-time
        session_destroy();   // destroy session data in storage
        // Supprimer le cookie PHPSESSID en le configurant avec une date d'expiration dans le passé
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/');
        }
        Cookie::supprimer(session_name()); // Optionnel, dépend de votre gestion des cookies
        // Il faudra reconstruire la session au prochain appel de getInstance()
        Session::$instance = null;
    }

    public function regenarerID()
    {
        session_regenerate_id(true); // Générer un nouvel ID de session
    }


    public function verifierDerniereActivite() : void{
        $dureeExpiration = ConfigurationBaseDeDonnees::getDureeExpiration();
        if (isset($_SESSION['derniereActivite']) && (time() - $_SESSION['derniereActivite'] > ($dureeExpiration)))
            session_unset();     // unset $_SESSION variable for the run-time
        $_SESSION['derniereActivite'] = time(); // update last activity time stamp
    }
}