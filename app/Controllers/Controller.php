<?php

namespace App\Controllers;

class Controller
{
    // Vérifier si l'utilisateur est connecté
    protected function isConnected()
    {
        return isset($_SESSION['user_id']);
    }

    // Vérifier si l'utilisateur est un administrateur
    protected function isAdmin()
    {
        return isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] === 1;
    }

    // Rediriger vers la page d'accueil
    protected function goToHome()
    {
        header('Location: /');
        exit();
    }

    // Rediriger vers la page de connexion
    protected function goToAccount()
    {
        header('Location: account');
        exit();
    }

    // Générer un token CSRF
    function generateCsrfToken() {
        $_SESSION['csrf_token'] =bin2hex(random_bytes(32));
    }
    
    // Obtenir le token CSRF
    function getCsrfToken() {
        return $_SESSION['csrf_token'];
    }

    // Vérifier si le token CSRF est valide
    protected function csrfValid(){
        return isset($_POST['csrf_token']) && ($_POST['csrf_token'] === $_SESSION['csrf_token']);
    }

    // Supprimer le token CSRF
    protected function unsetCsrfToken(){
        unset($_SESSION['csrf_token']);
    }


// ------------------------- VERIFICATION DE L'EMAIL ET DU MOT DE PASSE -------------------------

    protected function verifMotDePasse($motDePasse)
    {
        // Vérifie si le mot de passe a au moins 8 caractères
        if (strlen($motDePasse) < 8) {
            return false;
        }

        // Vérifie s'il contient au moins une majuscule
        if (!preg_match("/[A-Z]/", $motDePasse)) {
            return false;
        }

        // Vérifie s'il contient au moins une minuscule
        if (!preg_match("/[a-z]/", $motDePasse)) {
            return false;
        }

        // Vérifie s'il contient au moins un chiffre
        if (!preg_match("/[0-9]/", $motDePasse)) {
            return false;
        }

        // Vérifie s'il contient au moins un caractère spécial
        if (!preg_match("/[^a-zA-Z0-9]/", $motDePasse)) {
            return false;
        }
        
        // Si toutes les conditions sont remplies, le mot de passe est valide
        return true;
    }




// ------------------------- VERIFICATION DE L'EMAIL -------------------------

    protected function verifEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}
