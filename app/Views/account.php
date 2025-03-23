<?php require_once './app/Views/header.php';?>
<div class="account-container">
    <h1>Mes Commandes</h1>
    
    <?php if (empty($orders)) : ?>
        <p class="text-center my-2">Aucune commande n'a été trouvé</p>

    <?php else : ?>
    
    <?php foreach ($orders as $order) : ?>
        <div class="order-details">
            <h2>Informations sur la commande #<?php echo htmlspecialchars($order['id']); ?></h2>
            <p><strong>Date de commande :</strong> <?php echo htmlspecialchars($order['order_date']); ?></p>
            <p><strong>Nombre d'articles :</strong> <?php echo htmlspecialchars($order['number_of_articles']); ?></p>
            <p><strong>Prix total TTC :</strong> <?php echo htmlspecialchars(number_format($order['total_price_ttc'], 2)); ?> €</p>
            <p><strong>Statut :</strong> <?php echo htmlspecialchars($order['status_name']); ?></p>

            <!-- Formulaire pour envoyer l'id de la commande à order_details.php -->
            <form method="POST" action="order_details">
                <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['id']); ?>">
                <button type="submit">Voir les détails</button>
                <?php if ($order['status_id'] == 1) : ?>
                    <a href="payment?order_id=<?php echo htmlspecialchars($order['id']); ?>" class="btn">Procéder au paiement</a>
                <?php endif; ?>
            </form>
        </div>
    <?php endforeach; ?>

    <?php endif; ?>

    <!-- Affichage des adresses du client -->
    <h2>Mes Adresses de Livraison</h2>
    <ul>
        <?php foreach ($addresses as $address) : ?>
            <li>
                Adresse : (<?php echo htmlspecialchars($address['type_of_address']); ?>)
                <br><?php echo htmlspecialchars($address['firstname'] . " " . $address['lastname'] . " " . $address['address_number'] . " " . $address['complement'] . " " . $address['address'] . " " . $address['postal_code'] . " " . $address['town']); ?><br>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="address" class="btn">Ajouter une adresse</a>
</div>

<?php require_once './app/Views/footer.php'; ?>