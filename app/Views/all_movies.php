<?php require_once './app/Views/header.php';
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$currentSort = isset($_GET['sort']) ? $_GET['sort'] : 'id_desc';
?>

<!-- BOUTONS DE TRI -->
<div class="sort-div">
    <p class="rem2">trier les films par :</p>
    <form class="sort-button" action="" method="GET">
        <button type="submit" name="sort" value="id_desc">date d'ajout</button>
        <button type="submit" name="sort" value="release_date_desc">date de sortie (plus récents)</button>
        <button type="submit" name="sort" value="release_date_asc">date de sortie (plus anciens)</button>
        <button type="submit" name="sort" value="title_asc">A-Z</button>
        <button type="submit" name="sort" value="title_desc">Z-A</button>
    </form>

    <form class="sort-select-responsive" action="" method="GET">
        <select name="sort" onchange="this.form.submit()">
            <option value="id_desc" <?php echo $currentSort == 'id_desc' ? 'selected' : ''; ?>>Date d'ajout</option>
            <option value="release_date_desc" <?php echo $currentSort == 'release_date_desc' ? 'selected' : ''; ?>>Date de sortie (plus récents)</option>
            <option value="release_date_asc" <?php echo $currentSort == 'release_date_asc' ? 'selected' : ''; ?>>Date de sortie (plus anciens)</option>
            <option value="title_asc" <?php echo $currentSort == 'title_asc' ? 'selected' : ''; ?>>A-Z</option>
            <option value="title_desc" <?php echo $currentSort == 'title_desc' ? 'selected' : ''; ?>>Z-A</option>
        </select>
    </form>
</div>


<!-- -------------------  LIST  ------------------- -->
<?php foreach ($movies as $movie) : ?>
    <?php
    // Convertir la date de sortie au format français
    $releaseDate = new DateTime($movie['release_date']);
    $releaseDateFr = $releaseDate->format('d/m/Y');
    $releaseYear = $releaseDate->format('Y');
    ?>
    <div class="list-items">
        <div class="affiche">
            <a href="movie?id=<?= htmlspecialchars($movie['id']) ?>"><img src="/public/movies_images/<?= htmlspecialchars($movie['poster_path']) ?>" alt="<?= htmlspecialchars($movie['title']) ?> Poster"></a>
            <h2><?= htmlspecialchars($movie['title']) . " (" . $releaseYear . ")" ?></h2>
        </div>
        <div class="infos">
            <div class="title">
                <h2><?= htmlspecialchars($movie['title']) . " (" . $releaseYear . ")" ?></h2>
            </div>
            <div class="description">
                <p><?= htmlspecialchars($movie['overview']) ?></p>
            </div>
        </div>
    </div>
    <div class="hr-container">
        <hr>
    </div>

<?php endforeach; ?>

<!-- Affichage des liens de pagination -->
<?php if ($totalPages > 1) : ?>
    <div class="pagination">
        <?php for ($page = 1; $page <= $totalPages; $page++) : ?>
            <a href="?page=<?= $page ?>&sort=<?= isset($_GET['sort']) ? $_GET['sort'] : '' ?>" class="<?= ($page == $currentPage) ? 'active' : '' ?>"><?= $page ?></a>
        <?php endfor; ?>
    </div>
<?php endif; ?>

<?php require_once './app/Views/footer.php'; ?>