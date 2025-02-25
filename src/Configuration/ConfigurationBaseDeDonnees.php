<?php
namespace App\Pecherie\Configuration;

class ConfigurationBaseDeDonnees {
    protected static array $configurationBaseDeDonnees = [
        'nomHote' => '172.17.0.2',  // Adresse IP du conteneur MySQL (Docker)
        'nomBaseDeDonnees' => 'PecherieCettoise',
        'port' => '3306',
        'login' => 'root',
        'motDePasse' => 'Corentin2004',
    ];

    private static function getConfig(string $key): string {
        return self::$configurationBaseDeDonnees[$key] ?? throw new \Exception("Clé de configuration introuvable : $key");
    }

    public static function getLogin(): string { return self::getConfig('login'); }
    public static function getNomHote(): string { return self::getConfig('nomHote'); }
    public static function getNomBaseDeDonnees(): string { return self::getConfig('nomBaseDeDonnees'); }
    public static function getPort(): string { return self::getConfig('port'); }
    public static function getPassword(): string { return self::getConfig('motDePasse'); }
}
?>
