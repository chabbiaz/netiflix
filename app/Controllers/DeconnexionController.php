<?php

namespace App\Controllers;

class DeconnexionController extends Controller
{
    private $root_directory;

    public function __construct()
    {
        // Définir le chemin du répertoire racine du projet
        $this->root_directory = str_replace('\\', '/', dirname(dirname(__DIR__))); // C:/Users/Zyad/Dropbox/dev web/mvc_php

    }

    public function index()
    {
        session_destroy();
        $this->goToHome();
    }


}