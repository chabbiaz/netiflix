<?php require_once './app/Views/header.php'; 
echo ("<pre>");
var_dump($movie);
echo ("</pre>");
?>
<!-- -------------------  MOVIE  ------------------- -->

<div class="container">
    <h1 class="text-center rem2 mb-3"><?php echo htmlspecialchars($movie['title']); ?></h1>
    <div class="poster-trailer">
        <img src="/public/movies_images/<?php echo htmlspecialchars($movie['poster_path']); ?>" alt="Movie Poster">
        <iframe width="100%" height="300rem" src="https://www.youtube.com/embed/<?= $movie['trailer'] ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
    </div>

    <div class="movie-button">
        <div class="price-cart">
            <p><?php echo htmlspecialchars($movie['price']); ?> €</p>


            <!-- Bouton "Ajouter au panier" -->
            <form method="post" action="add_to_cart">
                <input type="hidden" name="movie_id" value="<?php echo htmlspecialchars($movie['id']); ?>">
                <?php
                if (!isset($_SESSION['user_id'])) {
                    echo "<p id='mustConnected'>Vous devez être connecté pour ajouter un film au panier.</p>";
                } else {
                    echo "<button type='submit' name='add_to_cart'>Ajouter au panier</button>";
                }
                ?>
            </form>
        </div>

        <div class="delete-modify">
            <?php
            if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1) {
                echo "<a href='editmovie?id=" . htmlspecialchars($movie['id'] ?? '') . "'><button name='editmovie'>Modifier la fiche</button></a>";
            }
            ?>

            <form method="post" action="deletemovie">
                <input type="hidden" name="movie_id" value="<?php echo htmlspecialchars($movie['id'] ?? ''); ?>">
                <?php if (isset($_SESSION['csrf_token'])) { ?>
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
                <?php } ?>
                <?php
                if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1) {
                    echo "<button type='submit' name='remove'>Supprimer ce film</button>";
                }
                ?>
            </form>
        </div>

    </div>


    <h2 id="description-title">Description</h2>

    <div class="movie-details">

        <h3>Titre original du film: </h3>
        <p><?php echo htmlspecialchars($movie['original_title']); ?></p>

        <h3>Date de sortie :</h3>
        <p><?php echo htmlspecialchars($movie['release_date']); ?></p>

        <h3>Langue d'origine :</h3>
        <p><?php echo htmlspecialchars($movie['original_language_name']); ?></p>

        <h3>Durée du film :</h3>
        <p><?= $timeHours ?> (<?php echo htmlspecialchars($movie['runtime']); ?> min)</p>

        <h3>Note moyenne :</h3>
        <p><?php echo htmlspecialchars($movie['vote_average']); ?></p>

        <h3>Nombre de vote :</h3>
        <p><?php echo htmlspecialchars($movie['vote_count']); ?></p>

        <h3>Synopsys :</h3>
        <p><?php echo htmlspecialchars($movie['overview']); ?></p>

        <h3>Genres:</h3>
        <p><?php echo htmlspecialchars($movie['genres_names']); ?></p>

        <h3>Acteurs :</h3>
        <p><?php echo htmlspecialchars($movie['actors_names']); ?></p>

        <h3>Réalisateurs:</h3>
        <p><?php echo htmlspecialchars($movie['director_name']); ?></p>

        <h3>Producteurs:</h3>
        <p><?php echo htmlspecialchars($movie['producers_names']); ?></p>
    </div>
</div>
<?php require_once './app/Views/footer.php'; ?>