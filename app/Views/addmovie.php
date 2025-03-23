<?php require_once './app/Views/header.php'; ?>
<div class="outer-container">
    <h2>Ajouter un Film</h2>
    <div class="search">

        <input type="text" id="movieId" placeholder="ID du Film TMDB" autofocus value="<?= isset($_POST['id']) ? htmlspecialchars($_POST['id']) : "" ?>">
        <button id="fetchMovieData">Rechercher</button>
        <button id="resetFields">Effacer les champs</button>

    </div>
    <form id="movieForm" method="post" action="addmovie">
        <div class="inner-container">

            <div class="gauche">

                <div class="input-adult">
                    <label for="adult">Adulte :</label>
                    <input type="radio" id="adult_true" name="adult" value="true"> Oui
                    <input type="radio" id="adult_false" name="adult" value="false" checked> Non
                </div>


                <div class="input-box">
                    <label for="movie_id">ID du film TMDB:</label>
                    <input type="text" name="tmdb_id" id="movie_id" readonly>
                </div>

                <div class="input-box">
                    <label for="imdb_id">ID du film IMDB: <span id="search_imdb"><!-- lien de recherche dynamique --></span></label>
                    <input type="text" name="imdb_id" id="movie_imdb_id" readonly>
                </div>

                <div class="input-box">
                    <label for="imdb_id">langue d'origine du film:</label>
                    <input type="text" name="original_language" id="movie_original_language" readonly>
                </div>
                <div class="input-box">
                    <label for="title">Titre:</label>
                    <input type="text" name="title" id="movie_title">
                    <div class="inline-block"><button type="button" id="addCross">❌</button> <button type="button" id="addCheck">✅</button> </div>

                </div>
                <div class="input-box">
                    <label for="slug">Slug:</label>
                    <input type="text" name="slug" id="slug">
                </div>
                <div class="input-box">
                    <label for="original_title">titre Original:</label>
                    <input type="text" name="original_title" id="movie_original_title">
                </div>
                <div class="input-box">
                    <label for="movie_overview">Synopsis:</label>
                    <textarea name="overview" id="movie_overview" class="textarea" required></textarea>
                    <div class="inline-block">
                        <button type="button" id="fetchOverviewFromEnglish">Synopsis en anglais</button>
                        <button type="button" id="translateButton">Traduire</button>
                        <button type="button" id="copyPasteButton">Remplacer par le texte copier</button>
                    </div>
                </div>
                <div class="input-box">
                    <label for="release_date">Date de sortie:</label>
                    <input type="date" name="release_date" id="movie_release_date">
                </div>
                <div class="input-box">
                    <label for="runtime">durée du film en minutes:</label>
                    <input type="number" name="runtime" id="movie_runtime">
                </div>
                <div class="input-box">
                    <label for="vote_average">moyenne des votes:</label>
                    <input type="number" name="vote_average" id="movie_vote_average" step="0.1">
                </div>

                <div class="input-box">
                    <label for="vote_count">nombre total de vote:</label>
                    <input type="number" name="vote_count" id="movie_vote_count">
                </div>
                <div class="input-box"><label for="genres">Genre</label>

                    <div class="input-checkbox">
                        <div class="item-checkbox">
                            <label for="genre_28">Action</label>
                            <input type="checkbox" id="genre_28" name="genre[]" value="28">
                        </div>
                        <div class="item-checkbox">
                            <label for="genre_12">Aventure</label>
                            <input type="checkbox" id="genre_12" name="genre[]" value="12">
                        </div>
                        <div class="item-checkbox">
                            <label for="genre_16">Animation</label>
                            <input type="checkbox" id="genre_16" name="genre[]" value="16">
                        </div>
                        <div class="item-checkbox">
                            <label for="genre_35">Comédie</label>
                            <input type="checkbox" id="genre_35" name="genre[]" value="35">
                        </div>
                        <div class="item-checkbox">
                            <label for="genre_80">Crime</label>
                            <input type="checkbox" id="genre_80" name="genre[]" value="80">
                        </div>
                        <div class="item-checkbox">
                            <label for="genre_99">Documentaire</label>
                            <input type="checkbox" id="genre_99" name="genre[]" value="99">
                        </div>
                        <div class="item-checkbox">
                            <label for="genre_18">Drame</label>
                            <input type="checkbox" id="genre_18" name="genre[]" value="18">
                        </div>
                        <div class="item-checkbox">
                            <label for="genre_10751">Familial</label>
                            <input type="checkbox" id="genre_10751" name="genre[]" value="10751">
                        </div>
                        <div class="item-checkbox">
                            <label for="genre_14">Fantastique</label>
                            <input type="checkbox" id="genre_14" name="genre[]" value="14">
                        </div>
                        <div class="item-checkbox">
                            <label for="genre_36">Histoire</label>
                            <input type="checkbox" id="genre_36" name="genre[]" value="36">
                        </div>
                        <div class="item-checkbox">
                            <label for="genre_27">Horreur</label>
                            <input type="checkbox" id="genre_27" name="genre[]" value="27">
                        </div>
                        <div class="item-checkbox">
                            <label for="genre_10402">Musique</label>
                            <input type="checkbox" id="genre_10402" name="genre[]" value="10402">
                        </div>
                        <div class="item-checkbox">
                            <label for="genre_9648">Mystère</label>
                            <input type="checkbox" id="genre_9648" name="genre[]" value="9648">
                        </div>
                        <div class="item-checkbox">
                            <label for="genre_10749">Romance</label>
                            <input type="checkbox" id="genre_10749" name="genre[]" value="10749">
                        </div>
                        <div class="item-checkbox">
                            <label for="genre_878">Science-Fiction</label>
                            <input type="checkbox" id="genre_878" name="genre[]" value="878">
                        </div>
                        <div class="item-checkbox">
                            <label for="genre_10770">Téléfilm</label>
                            <input type="checkbox" id="genre_10770" name="genre[]" value="10770">
                        </div>
                        <div class="item-checkbox">
                            <label for="genre_53">Thriller</label>
                            <input type="checkbox" id="genre_53" name="genre[]" value="53">
                        </div>
                        <div class="item-checkbox">
                            <label for="genre_10752">Guerre</label>
                            <input type="checkbox" id="genre_10752" name="genre[]" value="10752">
                        </div>
                        <div class="item-checkbox">
                            <label for="genre_37">Western</label>
                            <input type="checkbox" id="genre_37" name="genre[]" value="37">
                        </div>
                    </div>
                </div>

                <br>

                <div class="trailers-box">
                    <fieldset id="trailers">
                        <legend>Sélectionner un trailer</legend>
                    </fieldset>
                    <div class="input-box">
                        <span id="search_trailer"><!-- lien de recherche dynamique --></span>
                        <label for="movie_trailer">code vidéo youtube:</label>
                        <input type="text" name="trailer" id="movie_trailer" required>
                    </div>
                </div>

                <br>

                <div class="div-actors">


                    <label for="actor-selector">Acteurs :</label>
                    <div class="div-actor-selector">
                        <select class="selector" name="cast[]" id="actor-selector" size="10" multiple></select>
                        <div class="inline-block">
                            <button type="button" id="deleteActor">Supprimer l'acteur
                                selectionner</button>
                        </div>
                    </div>



                    <div class="div-add-actor">
                        <div class="media-selector">
                            <label for="new-actor">Ajouter acteur(s) (1 par ligne) :</label>
                            <textarea id="new-actor" rows="4" cols="50"></textarea>
                            <button type="button" id="addActor">Ajouter</button>
                        </div>
                    </div>

                </div>

                <div class="div-directors">

                    <label for="directors-selector">réalisateur(s):</label>
                    <div class="div-directors-selector">
                        <select class="selector" name="director[]" id="directors-selector" size="10" multiple></select>
                        <div class="inline-block">
                            <button type="button" id="deleteDirector">Supprimer le réalisateur
                                selectionner</button>
                        </div>
                    </div>



                    <div class="div-add-directors">
                        <div class="media-selector">
                            <label for="new-directors">Ajouter réalisateur(s) (1 par ligne) :</label>
                            <textarea id="new-directors" rows="4" cols="50"></textarea>
                            <button type="button" id="addDirector">Ajouter</button>
                        </div>
                    </div>
                </div>

                <div class="div-producer">

                    <label for="producer-selector">producteur(s):</label>
                    <div class="div-producer-selector">
                        <select class="selector" name="producer[]" id="producer-selector" size="10" multiple></select>
                        <div class="inline-block">
                            <button type="button" id="deleteProducer">Supprimer le producteur
                                selectionner</button>
                        </div>
                    </div>



                    <div class="div-add-producer">
                        <div class="media-selector">
                            <label for="new-producer">Ajouter producteur(s) (1 par ligne) :</label>
                            <textarea id="new-producer" rows="4" cols="50"></textarea>
                            <button type="button" id="addProducer">Ajouter</button>
                        </div>
                    </div>
                </div>

            </div>

            <div class="droite">
                <div class="input-box">
                    <label for="poster_path">poster du film:</label>
                    <input type="text" name="poster_path" id="movie_poster_path">
                    <button type="button" id="loadNewImage_movie_poster_path">Charger</button>
                    <img id="movie_poster_preview" class="image-preview">
                </div>
                <div class="input-box">
                    <label for="backdrop_path">background du film :</label>
                    <input type="text" id="backdrop_path" name="backdrop_path">
                    <button type="button" id="loadNewImage_movie_backdrop_path">Charger</button>
                    <img id="backdrop_path_preview" class="image-preview">
                </div>
                <div class="input-box">
                    <label for="collection_id">ID de la Collection :</label>
                    <input type="text" id="collection_id" name="belongs_to_collection_id">
                </div>
                <div class="input-box">
                    <label for="collection_name">Nom de la Collection :</label>
                    <input type="text" id="collection_name" name="belongs_to_collection_name">
                </div>
                <div class="input-box">
                    <label for="collection_poster_path">Poster de la Collection :</label>
                    <input type="text" id="collection_poster_path" name="belongs_to_collection_poster_path">
                    <button type="button" id="loadNewImage_collection_poster_path">Charger</button>
                    <img id="collection_poster_path_preview" class="image-preview">
                </div>
                <div class="input-box">
                    <label for="collection_backdrop_path">background de la Collection :</label>
                    <input type="text" id="collection_backdrop_path" name="belongs_to_collection_backdrop_path">
                    <button type="button" id="loadNewImage_collection_backdrop_path">Charger</button>
                    <img id="collection_backdrop_path_preview" class="image-preview">
                </div>
                <div class="input-box price">
                    <label for="price">Prix de vent HT:</label>
                    <input type="number" name="price" id="price" required>
                </div>

            </div>

        </div>
        <div class="submit-btn">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
            <button id="send_button" type="submit" class="btn">envoyer</button>
        </div>
    </form>
</div>
<script src="public/js/addmovie.js"></script>
<?php require_once './app/Views/footer.php'; ?>