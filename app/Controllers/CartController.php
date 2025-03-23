<?php

namespace App\Controllers;

use App\Models\CartModel;

class CartController
{
    private $root_directory;
    private $pdo; // Propriété pour stocker la connexion PDO

    public function __construct()
    {
        // Définir le chemin du répertoire racine du projet
        $this->root_directory = str_replace('\\', '/', dirname(dirname(__DIR__))); // C:/Users/Zyad/Dropbox/dev web/mvc_php

    }

    public function index()
    {
        // Vérifier si le panier est défini dans la session et s'il contient des articles
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            // Instancier le modèle CartModel
            $model = new CartModel();
            // Appeler la méthode getCartProducts() du modèle CartModel
            $products = $model->getCart();
        } else {
            $cartProducts = [];
        }

        // Inclure la vue pour afficher les données
        require_once $this->root_directory . '/app/Views/cart.php';
    }


    public function add_to_cart()
    {

        // Vérification si le formulaire "ajouter au panier" a été soumis et que l'utilisateur est connecté
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {

            if (isset($_POST['movie_id'])) {
                $movieId = $_POST['movie_id']; // Récupération de l'ID du film à ajouter au panier

                // Vérifier si le panier est défini dans la session
                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = []; // Initialisation du panier s'il n'existe pas encore
                }

                // Vérifier si le film n'est pas déjà dans le panier
                $isAlreadyInCart = false;
                foreach ($_SESSION['cart'] as $item) {
                    if ($item['id'] == $movieId) {
                        $isAlreadyInCart = true;
                        break; // Sortir de la boucle dès qu'on trouve le film dans le panier
                    }
                }

                // Si le film n'est pas déjà dans le panier, on l'ajoute et on redirige l'utilisateur vers le panier
                if (!$isAlreadyInCart) {
                    $_SESSION['cart'][] = ['id' => $movieId];
                } else {
                    $_SESSION['already_in_cart'] = "Ce film est déjà dans votre panier.";
                }
                header('Location: cart');
                exit;
            }
        }
        // Rediriger l'utilisateur vers la page d'accueil
        header('Location: cart');
        exit();
    }




    public function remove_from_cart()
    {


        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {

            $productId = $_POST['product_id'];
            // Vérifier si le panier est défini dans la session et s'il contient des articles
            if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
                // Parcourir les articles du panier pour trouver celui à supprimer
                foreach ($_SESSION['cart'] as $key => $item) {
                    if ($item['id'] == $productId) {
                        // Supprimer l'article du panier en utilisant son indice dans le tableau
                        unset($_SESSION['cart'][$key]);
                        // Réindexer le tableau pour éviter les clés manquantes
                        $_SESSION['cart'] = array_values($_SESSION['cart']);
                        // Rediriger vers la page du panier avec un message de succès
                        header('Location: cart');
                        exit();
                    }
                }
            }
        } else {
            header('Location: cart');
            exit();
        }
    }

    public function checkout()
    {
        // Vérifier si l'utilisateur est connecté et s'il y a des articles dans le panier
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            header('Location: /');
            exit();
        }

        $model = new CartModel();
        $products = $model->getCart(); // On récupère les produits du panier depuis la BDD
        $addresses = $model->getAdressesById(); // On récupère les adresses de l'utilisateur depuis la BDD
        require_once $this->root_directory . '/app/Views/checkout.php';
    }

    public function addorder()
    {
        $model = new CartModel();
        $model->addOrder();

        // Redirection vers une page de confirmation de commande
        header('Location: /account');
        exit();
    }

}
