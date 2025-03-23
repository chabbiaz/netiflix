<?php

namespace App\Models;

use PDO;

class LoginModel extends Model
{
    public function getUserByEmail($email)
    {
        try {
            // Requête pour vérifier l'utilisateur dans la base de données
            $sql = "SELECT id, firstname, email, pass, isAdmin FROM clients WHERE email = ?";
            return $this->findOne($sql, [$email]);
        } catch (\PDOException $e) {
            require_once __DIR__ . '/../../reports.php';
        }
    }
}
