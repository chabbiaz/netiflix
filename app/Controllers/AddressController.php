<?php

namespace App\Controllers;

use App\Models\AddressModel;

class AddressController extends Controller
{
    private $root_directory;

    public function __construct()
    {
        // Définir le chemin du répertoire racine du projet
        $this->root_directory = str_replace('\\', '/', dirname(dirname(__DIR__))); // C:/Users/Zyad/Dropbox/dev web/mvc_php

    }


    // Si l'utilisateur n'est pas connecté, on le redirige à la page d'acceuil
    // sinon, on génère un jeton csrf et on affiche la page d'ajout d'adresse
    public function index()
    {
        if (!$this->isConnected()) {
            $this->goToHome();
        }
        $this->generateCsrfToken();
        require_once $this->root_directory . '/app/Views/address.php';
    }

    // Si l'utilisateur est connecté et que le jeton csrf est valide,
    // on ajoute l'adresse saisie dans la bdd, on supprime le jeton csrf et on redirige vers la page du compte
    public function addAddress()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $this->isConnected() && $this->csrfValid()) {

            // on vérifie que tout les champs sont bien remplis
            $requiredFields = ['firstname', 'lastname', 'numero', 'address', 'postal_code', 'town', 'type'];

            foreach ($requiredFields as $field) {
                if (empty($_POST[$field])) {
                    $_SESSION['emptyForm'] = 'Tous les champs sont obligatoires, sauf "complement".';
                    header('Location: address');
                    exit();
                }
            }

                $model = new AddressModel();
                $model->addAddressToUserId();
                $this->unsetCsrfToken();
                $this->goToAccount();
        }else {
                $this->goToHome();
            }
    }
}
