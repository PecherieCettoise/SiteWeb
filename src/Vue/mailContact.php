<?php
ob_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../vendor/autoload.php';

// Activation du mode debug pour tester (désactive après debug)
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
    $mail->setFrom('testMessageriee@gmail.com', $_POST['nom']);
    $mail->addAddress('testMessageriee@gmail.com'); // Destinataire (email admin)

    // Contenu de l'e-mail
    $mail->isHTML(true);
    $mail->Subject = 'Nouveau message du formulaire';
    $mail->Body    = nl2br("Nom: {$_POST['nom']}\nPrénom: {$_POST['prenom']}\nEmail: {$_POST['email']}\nMessage:\n{$_POST['message']}\nTéléphone:{$_POST['telephone']}");

    // Envoi du message
    if ($mail->send()) {
        session_start();
        $_SESSION['flash_message'] = '✅ Message envoyé avec succès.';
        header('Location: ../Vue/contact.php');
        exit;
    } else {
        echo "❌ L'email n'a pas été envoyé.";
    }
} catch (Exception $e) {
    echo "❌ Erreur d'envoi : {$mail->ErrorInfo}";
}
?>
