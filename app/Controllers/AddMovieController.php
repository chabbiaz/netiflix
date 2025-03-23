<?php

namespace App\Controllers;

use App\Models\AddMovieModel;

class AddMovieController extends Controller
{
    private $root_directory;

    public function __construct()
    {
        // Définir le chemin du répertoire racine du projet
        $this->root_directory = str_replace('\\', '/', dirname(dirname(__DIR__))); // C:/Users/Zyad/Dropbox/dev web/mvc_php

    }

    public function index()
    {
        // si isAdmin n'est pas défini ou n'est pas égal à 1, on renvoi vers la page d'accueil
        if ($this->isAdmin()) {
            $this->generateCsrfToken();
            require_once $this->root_directory . '/app/Views/addmovie.php';
        } else {
            $this->goToHome();
        }
    }

    public function addMovie()
    {
        if ($this->isAdmin() &&  $this->csrfValid()) {
            $model = new AddMovieModel();
            $_SESSION['successAddedMovie'] = $model->insertNewMovie(); // Appeler la méthode insertNewMovie() du modèle AddMovieModel
            // Supprimer le token CSRF
            $this->unsetCsrfToken();
            // Rediriger vers la page d'accueil
            $this->goToHome();
        } else {
            $this->goToHome();
        }
    }
}
