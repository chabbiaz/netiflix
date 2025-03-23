<?php require_once './app/Views/header.php'; ?>

<div class="container">
    <h1 class="rem2">Votre panier</h1>
    <!-- si  $_SESSION['already_in_cart'] existe, on l'affiche et on la supprime de $_SESSION -->
    <p style="color: red;"><?php if (isset($_SESSION['already_in_cart'])) {
                                echo $_SESSION['already_in_cart'];
                                unset($_SESSION['already_in_cart']);
                            } ?></p>

    <div class="cart-items">
        <?php
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            // Afficher les produits du panier
            foreach ($products as $product) {
        ?>
                <div class="cart-item">
                    <img src="/public/movies_images/<?php echo htmlspecialchars($product['poster_path']); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>">
                    <p class=" cart-item-price-solo rem16">Prix : <?php echo htmlspecialchars(number_format($product['price'], 2)); ?>€</p>
                    <div class="item-details">
                        <h3 class="rem16"><?php echo htmlspecialchars($product['title']); ?></h3>
                        <p><?php echo htmlspecialchars($product['overview']); ?></p>

                        <p class="rem16">Prix hors taxe: <?php echo htmlspecialchars(number_format($product['price'], 2)); ?>€</p>
                        <p class="rem16">Prix hors taxe: <?php echo htmlspecialchars(number_format($product['price']*1.2, 2)); ?>€</p>
                    </div>
                    <form method="post" action="remove_from_cart">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <button type="submit" class="remove-btn">Supprimer</button>
                    </form>
                </div>
            <?php
            }

            // Calculer le total du panier
            $total = htmlspecialchars(array_sum(array_column($products, 'price'))) ?? 0;
            ?>
            <div class="total">
                <h3>Total HTC :</h3>
                <p><?php echo htmlspecialchars(number_format($total, 2)); ?> €</p>
            </div>
            <div class="total">
                <h3>Total TTC :</h3>
                <p><?php echo htmlspecialchars(number_format($total*1.2, 2)); ?> €</p>
            </div>
            <button class="checkout-btn"><a href="checkout">Valider la commande</a></button>

        <?php
        } else {
            if (isset($_SESSION['user_id'])) {
                echo '<p class="text-center">Votre panier est vide.</p>';
            } else {
                echo '<p class="text-center">Vous devez être connecté pour ajouter des articles au panier.</p>';
            }
        }
        ?>
    </div>
</div>
<?php require_once './app/Views/footer.php'; ?>