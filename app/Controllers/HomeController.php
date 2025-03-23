<?php

namespace App\Controllers;

use App\Models\MovieModel;

class HomeController
{
    private $root_directory;

    public function __construct()
    {
        // Définir le chemin du répertoire racine du projet
        $this->root_directory = str_replace('\\', '/', dirname(dirname(__DIR__))); // C:/Users/Zyad/Dropbox/dev web/mvc_php
    }

    public function index()
    {
        $model = new MovieModel(); // Instancier le modèle HomeModel
        $films = $model->getFiveLastMovies(); // Appeler la méthode getFiveLastMovies() du modèle HomeModel
        
        $popularMovies = $model->getMoviesByPopularity();
        require_once $this->root_directory . '/app/Views/home.php';
    }
}
