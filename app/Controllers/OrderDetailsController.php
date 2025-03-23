<?php

namespace App\Controllers;

use App\Models\OrderDetailsModel;

class OrderDetailsController extends Controller
{
    private $root_directory;

    public function __construct()
    {
        // Définir le chemin du répertoire racine du projet
        $this->root_directory = str_replace('\\', '/', dirname(dirname(__DIR__))); // C:/Users/Zyad/Dropbox/dev web/mvc_php

    }

    public function index()
    {
        if ($this->isConnected() && isset($_POST['order_id'])) {
            $orderDetailsModel = new OrderDetailsModel();
            $order = $orderDetailsModel->getOrders($_POST['order_id']);
            $order_details = $orderDetailsModel->getOrderDetails($_POST['order_id']);

            require_once $this->root_directory . '/app/Views/order_details.php';
        } else {
            $this->goToHome();
        }
    }
}
