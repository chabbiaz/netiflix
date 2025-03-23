<?php require_once './app/Views/header.php'; ?>
<div class="outer-container">
    <h2>Modifier un Film</h2>
    <form id="movieForm" method="post" action="updatemovie?id=<?= htmlspecialchars($movie['id']) ?>">
        <div class="inner-container">
            <div class="gauche">
                <div name="id" id="movie_id" value="<?= htmlspecialchars($movie['id']) ?>"></div>
                <div class="input-adult">
                    <label for="adult">Adulte :</label>
                    <input type="radio" id="adult_true" name="adult" value="true" <?= $movie['adult'] ? 'checked' : '' ?>> Oui
                    <input type="radio" id="adult_false" name="adult" value="false" <?= !$movie['adult'] ? 'checked' : '' ?>> Non
                </div>

                <div class="input-box">
                    <label for="movie_id">ID du film TMDB:</label>
                    <input type="text" name="tmdb_id" id="movie_id" value="<?= htmlspecialchars($movie['tmdb_id']) ?>" readonly>
                </div>

                <div class="input-box">
                    <label for="imdb_id">ID du film IMDB: <span id="search_imdb"><!-- lien de recherche dynamique --></span></label>
                    <input type="text" name="imdb_id" id="movie_imdb_id" value="<?= htmlspecialchars($movie['imdb_id']) ?>" readonly>
                </div>

                <div class="input-box">
                    <label for="original_language">langue d'origine du film:</label>
                    <input type="text" name="original_language" id="movie_original_language" value="<?= htmlspecialchars($movie['original_language']) ?>" readonly>
                </div>

                <div class="input-box">
                    <label for="title">Titre:</label>
                    <input type="text" name="title" id="movie_title" value="<?= htmlspecialchars($movie['title']) ?>">
                </div>

                <div class="input-box">
                    <label for="slug">Slug:</label>
                    <input type="text" name="slug" id="slug" value="<?= htmlspecialchars($movie['slug']) ?>">
                </div>

                <div class="input-box">
                    <label for="original_title">titre Original:</label>
                    <input type="text" name="original_title" id="movie_original_title" value="<?= htmlspecialchars($movie['original_title']) ?>">
                </div>

                <div class="input-box">
                    <label for="movie_overview">Synopsis:</label>
                    <textarea name="overview" id="movie_overview" class="textarea" required><?= htmlspecialchars($movie['overview']) ?></textarea>
                </div>

                <div class="input-box">
                    <label for="release_date">Date de sortie:</label>
                    <input type="date" name="release_date" id="movie_release_date" value="<?= htmlspecialchars($movie['release_date']) ?>">
                </div>

                <div class="input-box">
                    <label for="runtime">durée du film en minutes:</label>
                    <input type="number" name="runtime" id="movie_runtime" value="<?= htmlspecialchars($movie['runtime']) ?>">
                </div>

                <div class="input-box">
                    <label for="vote_average">moyenne des votes:</label>
                    <input type="number" name="vote_average" id="movie_vote_average" step="0.1" value="<?= htmlspecialchars($movie['vote_average']) ?>">
                </div>

                <div class="input-box">
                    <label for="vote_count">nombre total de vote:</label>
                    <input type="number" name="vote_count" id="movie_vote_count" value="<?= htmlspecialchars($movie['vote_count']) ?>">
                </div>

                <div class="input-box"><label for="genres">Genre</label>
                    <div class="input-checkbox">
                        <?php
                        $genres = [
                            28 => 'Action', 12 => 'Aventure', 16 => 'Animation', 35 => 'Comédie', 80 => 'Crime', 99 => 'Documentaire',
                            18 => 'Drame', 10751 => 'Familial', 14 => 'Fantastique', 36 => 'Histoire', 27 => 'Horreur',
                            10402 => 'Musique', 9648 => 'Mystère', 10749 => 'Romance', 878 => 'Science-Fiction',
                            10770 => 'Téléfilm', 53 => 'Thriller', 10752 => 'Guerre', 37 => 'Western'
                        ];
                        $movieGenres = explode(',', $movie['tmdb_genre_ids']);
                        foreach ($genres as $key => $value) {
                            $checked = in_array($key, $movieGenres) ? 'checked' : '';
                            echo '<div class="item-checkbox">';
                            echo "<label for='genre_$key'>$value</label>";
                            echo "<input type='checkbox' id='genre_$key' name='genre[]' value='$key' $checked>";
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>

                <div class="trailers-box">
                    <fieldset id="trailers">
                        <legend>Sélectionner un trailer</legend>
                    </fieldset>
                    <div class="input-box">
                        <label for="movie_trailer">lien youtube:</label>
                        <input type="text" name="trailer" id="movie_trailer" value="<?= htmlspecialchars($movie['trailer']) ?>" required>
                    </div>
                </div>

                <div class="div-actors">
                    <label for="actor-selector">Acteurs :</label>
                    <div class="div-actor-selector">
                        <select class="selector" name="cast[]" id="actor-selector" size="10" multiple>
                            <?php
                            $actors = explode(',', $movie['actors_names']);
                            foreach ($actors as $actor) {
                                echo "<option value='$actor'>$actor</option>";
                            }
                            ?>
                        </select>
                        <div class="inline-block">
                            <button type="button" id="deleteActor">Supprimer l'acteur selectionner</button>
                        </div>
                    </div>
                    <div class="div-add-actor">
                        <div class="media-selector">
                            <label for="new-actor">Ajouter un Acteur :</label>
                            <input type="text" id="new-actor">
                            <button type="button" id="addActor">Ajouter</button>
                        </div>
                    </div>
                </div>

                <div class="div-directors">
                    <label for="directors-selector">réalisateur(s):</label>
                    <div class="div-directors-selector">
                        <select class="selector" name="director[]" id="directors-selector" size="10" multiple>
                            <?php
                            $directors = explode(',', $movie['directors_names']);
                            foreach ($directors as $director) {
                                echo "<option value='$director'>$director</option>";
                            }
                            ?>
                        </select>
                        <div class="inline-block">
                            <button type="button" id="deleteDirector">Supprimer le réalisateur selectionner</button>
                        </div>
                    </div>
                    <div class="div-add-directors">
                        <div class="media-selector">
                            <label for="new-directors">Ajouter un réalisateur :</label>
                            <input type="text" id="new-directors">
                            <button type="button" id="addDirector">Ajouter</button>
                        </div>
                    </div>
                </div>

                <div class="div-producer">
                    <label for="producer-selector">producteur(s):</label>
                    <div class="div-producer-selector">
                        <select class="selector" name="producer[]" id="producer-selector" size="10" multiple>
                            <?php
                            $producers = explode(',', $movie['producers_names']);
                            foreach ($producers as $producer) {
                                echo "<option value='$producer'>$producer</option>";
                            }
                            ?>
                        </select>
                        <div class="inline-block">
                            <button type="button" id="deleteProducer">Supprimer le producteur selectionner</button>
                        </div>
                    </div>
                    <div class="div-add-producer">
                        <div class="media-selector">
                            <label for="new-producer">Ajouter un producteur :</label>
                            <input type="text" id="new-producer">
                            <button type="button" id="addProducer">Ajouter</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="droite">
                <div class="input-box">
                    <label for="poster_path">poster du film:</label>
                    <input type="text" name="poster_path" id="movie_poster_path" value="<?= htmlspecialchars("https://image.tmdb.org/t/p/w342/".$movie['poster_path']) ?>">
                    <button type="button" id="loadNewImage_movie_poster_path">Charger</button>
                    <img id="movie_poster_preview" class="image-preview" src="<?= htmlspecialchars("/public/movies_images/".$movie['poster_path']) ?>">
                </div>

                <div class="input-box">
                    <label for="backdrop_path">background du film :</label>
                    <input type="text" id="backdrop_path" name="backdrop_path" value="<?= htmlspecialchars("https://image.tmdb.org/t/p/w342/".$movie['backdrop_path']) ?>">
                    <button type="button" id="loadNewImage_movie_backdrop_path">Charger</button>
                    <img id="backdrop_path_preview" class="image-preview" src="<?= htmlspecialchars("/public/movies_images/".$movie['backdrop_path']) ?>">
                </div>

                <div class="input-box">
                    <label for="collection_id">ID de la Collection :</label>
                    <input type="text" id="collection_id" name="belongs_to_collection_id" value="<?= $movie['belongs_to_collection_id']!= 0 ? htmlspecialchars("https://image.tmdb.org/t/p/w342/" . $movie['belongs_to_collection_id']) : null ?>">
                </div>

                <div class="input-box">
                    <label for="collection_name">Nom de la Collection :</label>
                    <input type="text" id="collection_name" name="belongs_to_collection_name" value="<?= htmlspecialchars($movie['belongs_to_collection_name']) ?>">
                </div>

                <div class="input-box">
                    <label for="collection_poster_path">Poster de la Collection :</label>
                    <input type="text" id="collection_poster_path" name="belongs_to_collection_poster_path" value="<?= ($movie['belongs_to_collection_poster_path']!= NULL) ? htmlspecialchars("https://image.tmdb.org/t/p/w342/" . $movie['belongs_to_collection_poster_path']) : null ?>">
                    <button type="button" id="loadNewImage_collection_poster_path">Charger</button>
                    <img id="collection_poster_path_preview" class="image-preview" src="<?= htmlspecialchars("/public/movies_images/".$movie['belongs_to_collection_poster_path']) ?>">      
                </div>

                <div class="input-box">
                    <label for="collection_backdrop_path">background de la Collection :</label>
                    <input type="text" id="collection_backdrop_path" name="belongs_to_collection_backdrop_path" value="<?= ($movie['belongs_to_collection_backdrop_path']!= NULL) ? htmlspecialchars("https://image.tmdb.org/t/p/w342/" . $movie['belongs_to_collection_backdrop_path']) : null ?>">
                    <button type="button" id="loadNewImage_collection_backdrop_path">Charger</button>
                    <img id="collection_backdrop_path_preview" class="image-preview" src="<?= htmlspecialchars("/public/movies_images/".$movie['belongs_to_collection_backdrop_path']) ?>">
                </div>

                <div class="input-box price">
                    <label for="price">Prix de vente HT:</label>
                    <input type="number" name="price" id="price" value="<?= htmlspecialchars($movie['price']) ?>" required>
                </div>
            </div>
        </div>
        <div class="submit-btn">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
            <button id="send_button" type="submit" class="btn">envoyer</button>
        </div>
    </form>
</div>
<script src="public/js/updatemovie.js"></script>
<?php require_once './app/Views/footer.php'; ?>
