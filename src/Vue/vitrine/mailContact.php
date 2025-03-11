<?php

use App\Pecherie\Controleur\ControleurGenerique;
use App\Pecherie\Lib\MessageFlash;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../vendor/autoload.php';

// Activation du mode debug pour voir les erreurs (désactive après test)
error_reporting(E_ALL);
ini_set('display_errors', 1);

$mail = new PHPMailer(false);

try {

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
    $mail->Subject = 'Nouvelle Demande';
    $mail->Body    = nl2br("Nom: {$_POST['nom']}<br>Prénom: {$_POST['prenom']}<br>Email: {$_POST['email']}<br>Message:<br>{$_POST['message']}<br>Téléphone: {$_POST['telephone']}");

    // Envoi du message
    if ($mail->send()) {
        MessageFlash::ajouter("success", "Votre demande a bien été envoyer");
        ControleurGenerique::redirectionVersURL("controleurFrontal.php?action=afficherContact&controleur=page");
    } else {
        MessageFlash::ajouter("danger", "Votre demande n'a pas été envoyer");
        ControleurGenerique::redirectionVersURL("controleurFrontal.php?action=afficherContact&controleur=page");
    }
} catch (Exception $e) {

    MessageFlash::ajouter("danger", "Erreur lors de l'envoi du message.");
    ControleurGenerique::redirectionVersURL("controleurFrontal.php?action=afficherContact&controleur=page");
}
?>
