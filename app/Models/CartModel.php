<?php

namespace App\Models;

class CartModel extends Model
{




    public function getCart()
    {

        // Vérifier si le panier existe et n'est pas vide
        if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {

            try {
                // Récupération des IDs du panier depuis la session
                $ids = array_column($_SESSION['cart'], 'id');

                // Générer la liste de placeholders pour la requête SQL
                $placeholders = implode(',', array_fill(0, count($ids), '?'));

                // Construction de la requête SQL pour récupérer les détails des produits du panier
                $sql = "SELECT id, title, overview, price, poster_path FROM movies WHERE id IN ($placeholders)";

                // Appeler findAll() avec la requête SQL et les IDs
                return $this->findAll($sql, $ids);
            } catch (\PDOException $e) {
                require_once __DIR__ . '/../../reports.php';
            }
        }

        // Retourner un tableau vide si le panier n'existe pas ou est vide
        return [];
    }





    public function addToCart($productId)
    {
        // Vérifier si le panier est défini dans la session
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        try {

            // Vérifier si le produit est déjà dans le panier
            $productIndex = array_search($productId, array_column($_SESSION['cart'], 'id'));

            // Si le produit n'est pas dans le panier, l'ajouter
            if ($productIndex === false) {
                $_SESSION['cart'][] = ['id' => $productId, 'quantity' => 1];
            } else {
                // Si le produit est déjà dans le panier, augmenter la quantité
                $_SESSION['cart'][$productIndex]['quantity']++;
            }
        } catch (\PDOException $e) {
            require_once __DIR__ . '/../../reports.php';
        }
    }




    public function getAdressesById()
    {
        try {

            // Récupération des adresses du client
            $id = $_SESSION['user_id'];
            $sql = "SELECT * FROM addresses WHERE client_id = ?";
            return $this->findAll($sql, [$id]);
        } catch (\PDOException $e) {
            require_once __DIR__ . '/../../reports.php';
        }
    }






    public function addOrder()
    {
        try {


            // Récupérer l'utilisateur actuel et le panier
            $client_id = $_SESSION['user_id'];
            $cart = $_SESSION['cart'];

            // Récupérer l'id de l'adresse à partir de $_POST["delivery_address"]
            $delivery_address_id = $_POST["delivery_address"];

            // Calculer le nombre total d'articles dans le panier
            $number_of_articles = count($cart);

            // Requête SQL pour récupérer les détails de l'adresse
            $stmt_address = $this->pdo->prepare("SELECT * FROM addresses WHERE id = ?");
            $stmt_address->execute([$delivery_address_id]);
            $address = $stmt_address->fetch();

            // Construction de la chaîne de caractères de l'adresse
            $full_address = $address['lastname'] . ' ' . $address['firstname'] . ', ' . $address['address_number'] . ' ' . $address['complement'] . ', ' . $address['address'] . ', ' . $address['postal_code'];

            // Calculer le total HT et le total TTC
            $total_price_htc = 0;
            foreach ($cart as $item) {
                // Récupérer le prix hors taxe de l'article depuis la base de données
                $stmt = $this->pdo->prepare("SELECT price FROM movies WHERE id = ?");
                $stmt->execute([$item['id']]);
                $product = $stmt->fetch();

                if ($product) {
                    $total_price_htc += $product['price'];
                }
            }

            // Récupérer le taux de TVA depuis la table tva (id 1)
            $stmt_tva = $this->pdo->prepare("SELECT rate FROM tva WHERE id = 1");
            $stmt_tva->execute();
            $tva_rate = $stmt_tva->fetchColumn();

            // Calculer le total TTC
            $total_price_ttc = $total_price_htc * (1 + ($tva_rate / 100));

            // Insérer la commande dans la table orders
            $order_date = date('Y-m-d');
            $status_id = 1; // ID du statut de la commande (en attente)

            $stmt_insert_order = $this->pdo->prepare("INSERT INTO orders (client_id, order_date, address, number_of_articles, total_price_htc, total_price_ttc, status_id) VALUES (?, NOW(), ?, ?, ?, ?, ?)");
            $stmt_insert_order->execute([$client_id, $full_address, $number_of_articles, $total_price_htc, $total_price_ttc, $status_id]);

            // Récupérer l'id de la commande insérée
            $order_id = $this->pdo->lastInsertId();

            // Insérer les détails de la commande dans la table order_details
            foreach ($cart as $item) {
                $movie_id = $item['id'];
                $quantity = 1; // Une seule quantité par article pour l'instant

                // Récupérer le prix hors taxe de l'article depuis la base de données
                $stmtprice2 = $this->pdo->prepare("SELECT price FROM movies WHERE id = ?");
                $stmtprice2->execute([$item['id']]);
                $price2 = $stmtprice2->fetchColumn(); // Récupérer le prix hors taxe


                // Calculer le prix unitaire TTC
                $unit_price_htc = $price2;

                $unit_price_ttc = $unit_price_htc * (1 + ($tva_rate / 100));

                // Insérer les détails de la commande dans la table order_details
                $stmt_insert_order_details = $this->pdo->prepare("INSERT INTO order_details (order_id, movie_id, quantity, unit_price_htc, tva, unit_price_ttc) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt_insert_order_details->execute([$order_id, $movie_id, $quantity, $unit_price_htc, $tva_rate, $unit_price_ttc]);
            }

            // Une fois la commande validée, vider le panier
            $_SESSION['cart'] = [];
        } catch (\PDOException $e) {
            require_once __DIR__ . '/../../reports.php';
        }
    }
}
