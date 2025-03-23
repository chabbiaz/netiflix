<?php
session_start();

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['code'] === 'h3campus_dwwm2024') {
        $_SESSION['code_secret'] = $_POST['code'];
        header('Location: /');
        exit;
    } else {
        $message = "Code incorrect";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification du Code Secret</title>
    <style>
        .div-secret {
            margin: 20px;
        }

        .message {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <form action="" method="POST">
        <div class="div-secret">
            <h1>CODE SECRET :</h1>
            <input type="text" id="code" name="code">
            <button type="submit">Envoyer</button>
            <?php if ($message): ?>
                <p class="message"><?= htmlspecialchars($message) ?></p>
            <?php endif; ?>
        </div>
    </form>
</body>
</html>
