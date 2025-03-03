<?php

// Désactiver l'affichage des erreurs pour éviter toute sortie avant redirection
ini_set('display_errors', 0);

// Vérifier si une session est déjà active avant de la démarrer
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use App\Pecherie\Controleur\ControleurGenerique;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../vendor/autoload.php';

// Activation du mode debug pour voir les erreurs (uniquement pendant le développement)
error_reporting(E_ALL);

$mail = new PHPMailer(true);

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
    $mail->Subject = 'Nouveau message du formulaire';
    $mail->Body    = nl2br("Nom: {$_POST['nom']}<br>Prénom: {$_POST['prenom']}<br>Email: {$_POST['email']}<br>Message:<br>{$_POST['message']}<br>Téléphone: {$_POST['telephone']}");

    // Vérification et ajout des fichiers joints
    if (!empty($_FILES['fichier']['name'][0])) {
        $uploadDir = __DIR__ . '/uploads/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0775, true);  // Création du dossier uploads
        }

        foreach ($_FILES['fichier']['name'] as $index => $fileName) {
            if ($_FILES['fichier']['error'][$index] === 0) {
                $fileTmpPath = $_FILES['fichier']['tmp_name'][$index];
                $destination = $uploadDir . basename($fileName);

                if (move_uploaded_file($fileTmpPath, $destination)) {
                    // Ajout du fichier attaché à l'email
                    $mail->addAttachment($destination, $fileName);
                } else {
                    echo "❌ Erreur lors du téléchargement du fichier : {$fileName}.<br>";
                }
            } else {
                echo "❌ Erreur fichier : " . $_FILES['fichier']['error'][$index] . "<br>";
            }
        }
    }

    // Envoi du message
    if ($mail->send()) {
        $_SESSION['flash_message'] = '✅ Candidature envoyée avec succès.';
        // Redirection après envoi de l'email
        header("Location: controleurFrontal.php?action=afficherCandidatures&controleur=page");
        exit;
    } else {
        echo "❌ L'email n'a pas été envoyé.";
    }
} catch (Exception $e) {
    echo "❌ Erreur d'envoi : {$mail->ErrorInfo}";
}
?>
