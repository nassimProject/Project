<?php

use PHPMailer\PHPMailer\PHPMailer; // Importe la classe PHPMailer pour envoyer des e-mails
use PHPMailer\PHPMailer\SMTP; // Importe la classe SMTP de PHPMailer
use PHPMailer\PHPMailer\Exception; // Importe la classe Exception de PHPMailer

class EmailSender {
    
    // Méthode statique pour envoyer un e-mail de vérification
    public static function sendVerificationEmail($email, $subject, $message) {
        require 'PHPMailer/src/PHPMailer.php'; // Inclut le fichier PHPMailer.php nécessaire
        require 'PHPMailer/src/SMTP.php'; // Inclut le fichier SMTP.php nécessaire
        require 'PHPMailer/src/Exception.php'; // Inclut le fichier Exception.php nécessaire

        $mail = new PHPMailer(true); // Crée une nouvelle instance de PHPMailer

        try {
            // Paramètres du serveur SMTP
            $mail->isSMTP(); // Utilise SMTP pour envoyer l'e-mail
            $mail->Host = 'smtp.gmail.com'; // Adresse du serveur SMTP
            $mail->SMTPAuth = true; // Authentification SMTP activée
            $mail->Username = 'no.reply.perform.vision@gmail.com'; // Nom d'utilisateur SMTP
            $mail->Password = 'votre_mdp'; // Mot de passe SMTP
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Méthode de chiffrement TLS
            $mail->Port = 587; // Port SMTP

            // Expéditeur et destinataire
            $mail->setFrom('noreply.perform.vision@gmail.com', 'perform vision'); // Adresse de l'expéditeur
            $mail->addAddress($email); // Ajoute l'adresse e-mail du destinataire

            // Contenu de l'e-mail
            $mail->isHTML(true); // Définit le contenu comme HTML
            $mail->Subject = $subject; // Définit le sujet de l'e-mail
            $mail->Body = $message; // Définit le corps de l'e-mail

            // Envoyer l'e-mail
            $mail->send(); // Envoie l'e-mail
        } catch (Exception $e) {
            // Gérer les erreurs d'envoi d'e-mail
            echo '\n EmailSender: Erreur lors de l\'envoi de l\'e-mail : ', $mail->ErrorInfo ,'\n';
        }
    }
}
