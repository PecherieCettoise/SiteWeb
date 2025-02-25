<?php

namespace App\Pecherie\Lib;

class MessageFlash
{

// Les messages sont enregistrés en session associée à la clé suivante
    private static string $cleFlash = "_messagesFlash";

// $type parmi "success", "info", "warning" ou "danger"
    public static function ajouter(string $type, string $message): void {
        $_SESSION[self::$cleFlash][$type][] = $message;
    }

    public static function contientMessage(string $type): bool {
        return isset($_SESSION[self::$cleFlash][$type]);
    }

// Attention : la lecture doit détruire le message
    public static function lireMessages(string $type): array {
        $msgArray = array();
        if (!self::contientMessage($type)) {
            return $msgArray;
        }
        $i = 0;
        foreach ($_SESSION[self::$cleFlash][$type] as $msg) {
            $msgArray[$i] = $msg;
            $i++;
        }
        unset($_SESSION[self::$cleFlash][$type]);
        return $msgArray;
    }

    public static function lireTousMessages() : array {
        $msgArray = array();
        if (!isset($_SESSION[self::$cleFlash])) {
            return $msgArray;
        }
        foreach ($_SESSION[self::$cleFlash] as $type => $messages) {
            $msgArray[$type] = self::lireMessages($type);
        }
        return $msgArray;
    }

}