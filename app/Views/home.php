<?php require_once './app/Views/header.php'; ?>
<!-- BONJOUR XXX -->
<?php
//afficher le nom de l'utilisateur connecté s'il est connecté
if (isset($_SESSION['firstname'])) {
    echo '<p class="text-center bonjour">bonjour <span class="red">' . $_SESSION['firstname'] . '</span> !</p>';
}

// Vérifier si un message de succès a été défini
if (isset($_SESSION['successAddedMovie'])) {
    echo '<p style="color: black; text-align:center; border: 1px solid green; background-color:green; padding:1rem">' . $_SESSION['successAddedMovie'] . ' </p>';
    unset($_SESSION['successAddedMovie']);
}


// Vérifier si un message d'erreur existe'
if (isset($_SESSION['error'])) {
    echo '<p style="color: black; text-align:center; background-color:red; padding:1rem">' . $_SESSION['error'] . ' </p>';
    unset($_SESSION['error']);
}
?>


<!-- 5 DERNIERS FILMS AJOUTER -->
<div class="part part1">
    <h1 class="text-center rem2">Nos derniers films en vente</h1>
    <div class="last-five">

        <?php
        // Vérifier si des films ont été récupérés
        if (!empty($films)) {
            foreach ($films as $currentFilm) :
        ?>


                <div class="card-movie">
                    <a href="/movie?id=<?php echo htmlspecialchars($currentFilm['id']); ?>">
                        <img src="<?php echo '/public/movies_images/' . htmlspecialchars($currentFilm['poster_path']); ?>" alt="<?php echo htmlspecialchars($currentFilm['title']); ?> Poster" />
                    </a>
                    <p class="text-center padding1 movie-title"><?php echo htmlspecialchars($currentFilm['title']); ?></p>
                </div>
        <?php
            endforeach;
        } else {
            echo "Aucun film trouvé.";
        }
        ?>
    </div>
</div>


<!-- 5 DERNIERS FILMS plus visité -->
<div class="part part2">
    <h1 class="text-center rem2">Nos films les plus visités</h1>
    <div class="last-five">

        <?php
        // Vérifier si des films ont été récupérés
        if (!empty($popularMovies)) {
            foreach ($popularMovies as $currentFilm) :
        ?>


                <div class="card-movie">
                    <a href="/movie?id=<?php echo htmlspecialchars($currentFilm['id']); ?>">
                        <img src="<?php echo '/public/movies_images/' . htmlspecialchars($currentFilm['poster_path']); ?>" alt="<?php echo htmlspecialchars($currentFilm['title']); ?> Poster" />
                    </a>
                    <p class="text-center padding1"><?php echo htmlspecialchars($currentFilm['title']); ?></p>
                </div>
        <?php
            endforeach;
        } else {
            echo "Aucun film trouvé.";
        }
        ?>
    </div>
</div>

<?php require_once './app/Views/footer.php'; ?>