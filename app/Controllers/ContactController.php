<?php

namespace App\Controllers;

class ContactController extends Controller
{
    private $root_directory;

    public function __construct()
    {
        // Définir le chemin du répertoire racine du projet
        $this->root_directory = str_replace('\\', '/', dirname(dirname(__DIR__)));
    }


    public function index()
    {
        $this->generateCsrfToken();
        require_once $this->root_directory . '/app/Views/contact.php';
    }

    public function sendEmail()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $this->csrfValid()) {


          
            // On vérifie que tous les champs sont bien remplis
            $requiredFields = ['nom', 'prenom', 'email', 'subject', 'message'];

            foreach ($requiredFields as $field) {
                if (empty($_POST[$field])) {
                    $_SESSION['emptyForm'] = 'Tous les champs sont obligatoires.';
                    header('Location: contact');
                    exit();
                }
            }

            // On purge
            $nom = htmlspecialchars($_POST['nom']);
            $prenom = htmlspecialchars($_POST['prenom']);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $subject = htmlspecialchars($_POST['subject']);
            $message = htmlspecialchars($_POST['message']);

            // Validation de l'email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['invalidEmail'] = 'Adresse email invalide.';
                header('Location: contact');
                exit();
            }

            // Si les vérifications sont valides, on envoie le mail
            $to = 'chabbiaz@hotmail.fr'; 
            $fullSubject = "Nouveau message de netiflix: $subject";
            $body = "Vous avez recu un nouveau message de la part de $nom $prenom.\n" .
                "Adresse email: $email\n\n" .
                "Message:\n$message";

            $headers = "From: no-reply@zyadchabbia.fr\r\n"; // Adaptez selon le domaine
            $headers .= "Reply-To: $email\r\n";
            $headers .= "X-Mailer: PHP/" . phpversion();

            if (mail($to, $fullSubject, $body, $headers)) {
                $_SESSION['messageSend'] = "Votre message a été envoyé.";
                unset($_SESSION['csrf_token']);
                header('Location: contact');
                exit();
            } else {
                $_SESSION['messageNotSend'] = "Erreur d'envoi du message.";
                header('Location: contact');
                exit();
            }
        } else {
            header('Location: contact');
                exit();
        }
    }
}
