<?php

namespace App\Models;

use PDO;

class OrderDetailsModel extends Model
{
    public function getOrders($order_id)
    {
        try {

            $sql = "SELECT * FROM orders WHERE id = ?";
            return $this->findOne($sql, [$order_id]);
        } catch (\PDOException $e) {
            require_once __DIR__ . '/../../reports.php';
        }
    }



    public function getOrderDetails($order_id)
    {

        try {

            // Récupérer les détails des articles de la commande depuis order_details
            $sql = "SELECT movies.title, order_details.quantity, order_details.unit_price_ttc, order_details.tva
                        FROM order_details
                        INNER JOIN movies ON order_details.movie_id = movies.id
                        WHERE order_details.order_id = ?";
            return $this->findAll($sql, [$order_id]);
        } catch (\PDOException $e) {
            require_once __DIR__ . '/../../reports.php';
        }
    }
}
