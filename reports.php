<?php

// Enregistrer l'erreur dans le fichier reports.txt
$errorMessage = "[" . date('Y-m-d H:i:s') . "] " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine() . PHP_EOL;
file_put_contents('reports.txt', $errorMessage, FILE_APPEND);

// Définir la variable de session pour l'erreur
$_SESSION["error"] = "Une erreur est survenue";




// Envoi du mail
try {
    $to = 'chabbiaz@hotmail.fr';
    $fullSubject = "erreur sur netiflix";
    $email = "no-reply@netiflix.fr";
    $body = "nouvelle erreur sur site web.\n" .
        "Adresse email: $email\n\n" .
        "Message:\n$errorMessage";

    $headers = "From: netiflix@zyadchabbia.fr\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
    mail($to, $fullSubject, $body, $headers);
} catch (\PDOException $e) {
    var_dump($e);
}

// Rediriger vers la page d'accueil
header('Location: /');
exit();
