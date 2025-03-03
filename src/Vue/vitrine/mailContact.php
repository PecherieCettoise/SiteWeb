<?php

use App\Pecherie\Controleur\ControleurGenerique;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../vendor/autoload.php';

session_start();

// Activation du mode debug pour voir les erreurs (désactive après test)
error_reporting(E_ALL);
ini_set('display_errors', 1);

$mail = new PHPMailer(true);

try {
    // Activer le debug SMTP (mettre 0 en production)
    $mail->SMTPDebug = 2;

    // Configuration du serveur SMTP
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'testMessageriee@gmail.com'; // Ton email Gmail
    $mail->Password   = 'rums cold jmpq mxqw'; // Mot de passe d’application
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Destinataire
    $mail->setFrom('testMessageriee@gmail.com', htmlspecialchars($_POST['nom']));
    $mail->addAddress('testMessageriee@gmail.com'); // Destinataire (email admin)

    // Contenu de l'e-mail
    $mail->isHTML(true);
    $mail->Subject = 'Nouveau message du formulaire';
    $mail->Body    = nl2br("Nom: {$_POST['nom']}<br>Prénom: {$_POST['prenom']}<br>Email: {$_POST['email']}<br>Message:<br>{$_POST['message']}<br>Téléphone: {$_POST['telephone']}");

    // Envoi du message
    if ($mail->send()) {
        $_SESSION['flash_message'] = '✅ Message envoyé avec succès.';
        ControleurGenerique::redirectionVersURL("controleurFrontal.php?action=afficherContact&controleur=page");
        exit;
    } else {
        echo "❌ L'email n'a pas été envoyé.";
    }
} catch (Exception $e) {
    echo "❌ Erreur d'envoi : {$mail->ErrorInfo}";
}
?>
