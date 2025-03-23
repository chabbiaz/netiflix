<?php

namespace App\Controllers;

use App\Models\LoginModel;
use App\Models\RegisterModel;

class RegisterController extends Controller
{
    private $root_directory;

    public function __construct()
    {
        // Définir le chemin du répertoire racine du projet
        $this->root_directory = str_replace('\\', '/', dirname(dirname(__DIR__)));
    }

    public function index()
    {
        // Si l'utilisateur est déjà connecté, le rediriger vers la page d'accueil.
        if ($this->isConnected()) {
            $this->goToHome();
        } else {
            $this->generateCsrfToken();
            require_once $this->root_directory . '/app/Views/register.php';
        }


       
    }


    public function registerNew()
    {
        $erreurs = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $this->csrfValid()) {


            // on vérifie que tout les champs sont bien remplis
            $requiredFields = ['firstname', 'lastname', 'date_of_birth', 'email', 'motdepasse'];

            foreach ($requiredFields as $field) {
                if (empty($_POST[$field])) {
                    $_SESSION['emptyForm'] = 'Tous les champs sont obligatoires.';
                    header('Location: register');
                    exit();
                }
            }

            $email = trim($_POST['email']);
            $motdepasse = $_POST['motdepasse'];

            // On vérifie que l'email réponde aux exigences
            $verifEmail=$this->verifEmail($email);
            if ($verifEmail) { $erreurs['email'] = 'Email non valide.'; }
            
            // On vérifie que le mot de passe réponde aux exigences
            $verifMotDePasse=$this->verifMotDePasse($motdepasse);
            if (!$verifMotDePasse) {
                $erreurs['motdepasse'] = 'Exigences du mot de passe non respectées.';
            }
            

            // S'ils répondent aux exigences, on vérifie si l'email est déjà utilisé
            // Si non, on ajoute l'utilisateur à la BDD.
            if ($verifEmail && $verifMotDePasse) {

                $loginModel = new LoginModel();
                $registerModel = new RegisterModel();
                $user = $loginModel->getUserByEmail($email);

                if ($user) {
                    $erreurs['email'] = 'Cet email est déjà utilisé.';
                } else {
                    $addedOk= $registerModel->addUser();
                    header('Location: login');
                    exit();
                }
            }
        }

        require_once $this->root_directory . '/app/Views/register.php';
    }
}
