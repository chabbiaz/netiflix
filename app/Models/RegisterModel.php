<?php

namespace App\Models;

use PDO;

class RegisterModel extends Model
{    
    public function addUser()
    {
      try {

      // Récupération des données du formulaire
      $firstname = $_POST['firstname'];
      $lastname = $_POST['lastname'];
      $dateOfBirth = $_POST['date_of_birth'];
      $email = $_POST['email'];
      $password = password_hash($_POST['motdepasse'], PASSWORD_DEFAULT); // Hachage du mot de passe

      // Insertion des données dans la table clients
      $sql = "INSERT INTO clients (firstname, lastname, date_of_birth, email, pass) VALUES (?, ?, ?, ?, ?)";
      $stmt = $this->pdo->prepare($sql);
      $stmt->execute([$firstname, $lastname, $dateOfBirth, $email, $password]);

      $_SESSION["registeredOk"] = 'Vous avez bien été inscrit. Vous pouvez maintenant vous connecter.';


      } catch (\PDOException $e) {require_once __DIR__ . '/../../reports.php';}


    }
}