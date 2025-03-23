<?php

namespace App\Controllers;

use App\Models\AccountModel;

class AccountController extends Controller
{
    private $root_directory;

    public function __construct()
    {
        // Définir le chemin du répertoire racine du projet
        $this->root_directory = str_replace('\\', '/', dirname(dirname(__DIR__))); // C:/Users/Zyad/Dropbox/dev web/mvc_php
    }

    public function index()
    {
        if ($this->isConnected()) {
            $model = new AccountModel();
            $orders = $model->getOrdersbyUserId();
            $addresses = $model->getAddressesbyUserId();

            // Inclure la vue pour afficher les données
            require_once $this->root_directory . '/app/Views/account.php';
        } else {
            $this->goToHome();
        }
    }

    public function disconnection()
    {
        if ($this->isConnected()) {
            session_destroy();
            $this->goToHome();
        } else {
            $this->goToHome();
        }
    }
}
