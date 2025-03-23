<?php require_once './app/Views/header.php'; ?>
<div class="ord-det">
    <div class="container">
        <h1>Détails de la commande #<?= $_POST['order_id']; ?></h1>
        <div class="order-details">
            <h2>Informations sur la commande :</h2>
            <p><strong>Date de commande :</strong> <?php echo $order['order_date']; ?></p>
            <p><strong>Adresse de livraison :</strong> <?php echo $order['address']; ?></p>
            <p><strong>Nombre d'articles :</strong> <?php echo $order['number_of_articles']; ?></p>
            <p><strong>Total TTC :</strong> <?php echo number_format($order['total_price_ttc'], 2); ?> €</p>

            <h2>Détails des articles :</h2>
            <div class="order-items">
                <?php foreach ($order_details as $detail) : ?>
                    <div class="order-item">
                        <p><strong>Titre :</strong> <?php echo htmlspecialchars($detail['title']); ?></p>
                        <p><strong>Quantité :</strong> <?php echo $detail['quantity']; ?></p>
                        <p><strong>Prix unitaire TTC :</strong> <?php echo number_format($detail['unit_price_ttc'], 2); ?> €</p>
                        <p><strong>TVA appliqué :</strong> <?php echo $detail['tva']; ?>%</p>
                    </div>
                    <br>
                    <br>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php require_once './app/Views/footer.php'; ?>