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
    $mail->Body    = nl2br("Nom: {$_POST['nom']}\nPrénom: {$_POST['prenom']}\nEmail: {$_POST['email']}\nPoste: {$_POST['poste']}\nMessage:\n{$_POST['message']}\nTéléphone:{$_POST['telephone']}");

    // Vérifier et traiter les fichiers joints
    if (!empty($_FILES['fichier']['name'][0])) {
        $uploadDir = __DIR__ . '/uploads/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0775, true);
        }

        foreach ($_FILES['fichier']['name'] as $index => $fileName) {
            if ($_FILES['fichier']['error'][$index] === 0) {
                $fileTmpPath = $_FILES['fichier']['tmp_name'][$index];
                $destination = $uploadDir . basename($fileName);

                if (move_uploaded_file($fileTmpPath, $destination)) {
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
        session_start();
        $_SESSION['flash_message'] = '✅ Message envoyé avec succès.';
        header('Location: ../Vue/candidature.php');
        exit;
    } else {
        echo "❌ L'email n'a pas été envoyé.";
    }
} catch (Exception $e) {
    echo "❌ Erreur d'envoi : {$mail->ErrorInfo}";
}
?>
