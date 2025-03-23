<?php

namespace App\Models;

class AddressModel extends Model
{
    public function addAddressToUserId()
    {
        try {
            $client_id = $_SESSION['user_id'];

            $lastname = isset($_POST['lastname']) ? $_POST['lastname'] : '';
            $firstname = isset($_POST['firstname']) ? $_POST['firstname'] : '';
            $address_number = isset($_POST['numero']) ? $_POST['numero'] : '';
            $address_complement = isset($_POST['complement']) ? $_POST['complement'] : '';
            $address = isset($_POST['address']) ? $_POST['address'] : '';
            $postal_code = isset($_POST['postal_code']) ? $_POST['postal_code'] : '';
            $town = isset($_POST['town']) ? $_POST['town'] : '';
            $type_of_address = isset($_POST['type']) ? $_POST['type'] : '';

            // Préparer et exécuter la requête d'insertion
            $sql = "INSERT INTO addresses (client_id, firstname, lastname, address_number, complement, address, postal_code, town, type_of_address) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$client_id, $firstname, $lastname, $address_number, $address_complement, $address, $postal_code, $town, $type_of_address]);
        
        } catch (\PDOException $e) {
            require_once __DIR__ . '/../../reports.php';
        }
    }
}
