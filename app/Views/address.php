<?php require_once './app/Views/header.php'; ?>
<div class="address">

    <!-- si l'utilisateur n'a pas saisi tout les champs -->
    <?php
    if (isset($_SESSION['emptyForm'])) {
        echo "<p class='text-center mb-3 red rem16'>" . htmlspecialchars($_SESSION['emptyForm']) . "</p>";
        unset($_SESSION['emptyForm']);
    }
    ?>

    <div class="container">
        <h1>Ajouter une Adresse</h1>
        <form class="adress-form" method="post" action="add_address">
            <label for="lastname">Nom :</label>
            <input type="text" id="lastname" name="lastname" required>

            <label for="firstname">Prénom :</label>
            <input type="text" id="firstname" name="firstname" required>

            <label for="numero">numéro de rue :</label>
            <input type="text" id="numero" name="numero" required>

            <label for="complement">Complément du numéro :</label>
            <input type="text" id="complement" name="complement" placeholder="BIS, TER...">

            <label for="address">Adresse :</label>
            <input type="text" id="address" name="address" required>

            <label for="postal_code">Code postal :</label>
            <input type="text" id="postal_code" name="postal_code" required>

            <label for="town">Ville :</label>
            <input type="text" id="town" name="town" required>

            <label for="type">Type d'Adresse :</label>
            <input type="text" id="type" name="type" required placeholder="Maison, Travail..." required>

            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
            <div class="button-form">

                <button type="submit">Ajouter cette adresse</button>
            </div>
        </form>
    </div>
</div>

<?php require_once './app/Views/footer.php'; ?>