<?php

namespace App\Controllers;

use App\Models\LoginModel;

class LoginController extends Controller
{
    private $root_directory;

    public function __construct()
    {
        // Définir le chemin du répertoire racine du projet
        $this->root_directory = str_replace('\\', '/', dirname(dirname(__DIR__))); // C:/Users/Zyad/Dropbox/dev web/mvc_php
    }

    public function index()
    {
        // Si l'utilisateur est déjà connecté, le rediriger vers la page d'accueil.
        if ($this->isConnected()) {
            $this->goToHome();
        } else {
            $this->generateCsrfToken();
            require_once $this->root_directory . '/app/Views/login.php';   
        }
    }


    public function login()
    {
        $erreurs = [];

        // Vérifier si le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les valeurs du formulaire
            $email = trim($_POST['email']);
            $motdepasse = $_POST['motdepasse'];

            $verifEmail = $this->verifEmail($email);
            if (!$verifEmail) {
                $erreurs['email'] = 'Email non valide.';
            }
            $verifMotDePasse = $this->verifMotDePasse($motdepasse);
            if (!$verifMotDePasse) {
                $erreurs['motdepasse'] = 'Exigences du mot de passe non respectées.';
            }


            if ($verifEmail && $verifMotDePasse) {
                if (!$this->csrfValid()) {
                    $this->goToHome();
                }
                $loginModel = new LoginModel();
                $user = $loginModel->getUserByEmail($email);
            
                // Vérifiez si l'utilisateur existe
                if ($user) {
                    $passwordCorresponding = password_verify($motdepasse, $user['pass']);
            
                    // Vérifier si le mot de passe correspond
                    if ($passwordCorresponding) {
                        // Utilisateur authentifié avec succès
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['isAdmin'] = $user['isAdmin'];
                        $_SESSION['firstname'] = $user['firstname'];
                        header('Location: /');
                        exit();
                    } else {
                        // Mot de passe incorrect
                        $erreurs['connexion'] = 'Identifiants incorrects. Veuillez réessayer.';
                    }
                } else {
                    // Utilisateur non trouvé
                    $erreurs['connexion'] = 'Identifiants incorrects. Veuillez réessayer.';
                }
            }
            
        }

        // Afficher la vue avec les erreurs
        require_once $this->root_directory . '/app/Views/login.php';
    }
}
