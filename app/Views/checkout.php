<?php require_once './app/Views/header.php'; ?>
<div class="checkout">
    <div class="container">
        <h1>Validation de commande</h1>

        <!-- Affichage des articles du panier -->
        <div class="cart-items">
            <h2>Articles du panier</h2>
            <?php foreach ($products as $product) : ?>
                <div class="cart-item">
                    <img src="/public/movies_images/<?php echo htmlspecialchars($product['poster_path']); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>">
                    <div class="item-details">
                        <h3><?php echo htmlspecialchars($product['title']); ?></h3>
                        <p><?php echo htmlspecialchars($product['overview']); ?></p>
                        <p>Prix : <?php echo htmlspecialchars(number_format($product['price']), 2); ?> €</p>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- Affichage du total -->
            <?php
            $total = htmlspecialchars(array_sum(array_column($products, 'price'))) ?? 0;
            ?>
            <div class="total">
                <h3>Total :</h3>
                <p><?php echo htmlspecialchars(number_format($total, 2)); ?> €</p>
            </div>
        </div>

        <!-- Sélection de l'adresse de livraison -->
        <div class="delivery-addresses">
            <h2>Adresses de livraison</h2>
            <?php if (!empty($addresses)) : ?>
                <form action="process_checkout" method="post">
                    <?php foreach ($addresses as $address) : ?>
                        <label>
                            <input type="radio" name="delivery_address" value="<?php echo htmlspecialchars($address['id']); ?>">
                            <?php echo htmlspecialchars($address['firstname']) . ' ' . htmlspecialchars($address['lastname']) . ' ' . htmlspecialchars($address['address_number']) . ' ' . htmlspecialchars($address['complement']) . ', ' . htmlspecialchars($address['address']) . ' ' . htmlspecialchars($address['postal_code']); ?> (<?php echo htmlspecialchars($address['type_of_address']); ?>)
                        </label>
                        <br>
                    <?php endforeach; ?>
                    <button type="submit">Valider la commande</button>
                </form>
            <?php else : ?>
                <p>Aucune adresse enregistrée. Veuillez en ajouter une.</p>
                <a href="address" class="btn">Ajouter une adresse</a>
            <?php endif; ?>
        </div>
    </div>
</div>


<?php require_once './app/Views/footer.php'; ?>