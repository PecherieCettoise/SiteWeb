<?php
require_once __DIR__ . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if (class_exists('PhpOffice\PhpSpreadsheet\IOFactory')) {
    echo "PhpSpreadsheet est bien chargé !";
} else {
    echo "PhpSpreadsheet n'est PAS chargé !";
}
