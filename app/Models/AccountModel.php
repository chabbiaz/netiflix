<?php

namespace App\Models;

class AccountModel extends Model
{

    public function getOrdersbyUserId()
    {
        try {
            $id = $_SESSION['user_id'];
            $sql = "SELECT orders.*, status.name as status_name
        FROM orders
        INNER JOIN status ON orders.status_id = status.id
        WHERE orders.client_id = ?";
            return $this->findAll($sql, [$id]);
        } catch (\PDOException $e) {
            require_once __DIR__ . '/../../reports.php';
        }
    }

    public function getAddressesbyUserId()
    {
        try {
            $id = $_SESSION['user_id']; // Utiliser l'ID du client connecté
            // Récupération des adresses du client
            $sql = "SELECT * FROM addresses WHERE client_id = ?";
            return $this->findAll($sql, [$id]);
        } catch (\PDOException $e) {
            require_once __DIR__ . '/../../reports.php';
        }
    }

    public function getOrderDetails()
    {
        try {
            $id = $_POST['order_id'];
            // Récupérer les détails des articles de la commande depuis order_details
            $sql = "SELECT movies.title, order_details.quantity, order_details.unit_price_ttc, order_details.tva
                        FROM order_details
                        INNER JOIN movies ON order_details.movie_id = movies.id
                        WHERE order_details.order_id = ?";
            return $this->findAll($sql, [$id]);
        } catch (\PDOException $e) {
            require_once __DIR__ . '/../../reports.php';
        }
    }
}
