<?php

namespace App\Models;

use PDO;

class UpdateMovieModel extends Model
{
    public function updateMovie()
    {
        $root_directory = str_replace('\\', '/', dirname(dirname(__DIR__)));

        // // Filtrer et trimer les valeurs de chaque champ du tableau $_POST
        // Vérifier si le formulaire a été soumis
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // Extraction des données du formulaire
            $movie_id = trim($_GET['id']);
            $adult = trim($_POST['adult']);
            $tmdb_id = trim($_POST['tmdb_id']);
            $imdb_id = trim($_POST['imdb_id']);
            $original_language = trim($_POST['original_language']);
            $title = trim($_POST['title']);
            $slug = trim($_POST['slug']);
            $original_title = trim($_POST['original_title']);
            $overview = trim($_POST['overview']);
            $release_date = trim($_POST['release_date']);
            $runtime = trim($_POST['runtime']);
            $vote_average = trim($_POST['vote_average']);
            $vote_count = trim($_POST['vote_count']);
            $genre = $_POST['genre']; // Un tableau d'ID de genre
            $trailer = trim($_POST['trailer']);
            $cast = $_POST['cast']; // Un tableau de noms d'acteurs
            $director = $_POST['director']; // Un tableau de noms de réalisateurs
            $producer = $_POST['producer']; // Un tableau de noms de producteurs
            $poster_path = trim($_POST['poster_path']);
            $backdrop_path = trim($_POST['backdrop_path']);
            $belongs_to_collection_id = trim($_POST['belongs_to_collection_id']);
            $belongs_to_collection_name = trim($_POST['belongs_to_collection_name']);
            $belongs_to_collection_poster_path = isset($_POST['belongs_to_collection_poster_path']) ? trim($_POST['belongs_to_collection_poster_path']) : null;
            $belongs_to_collection_backdrop_path = isset($_POST['belongs_to_collection_backdrop_path']) ? trim($_POST['belongs_to_collection_backdrop_path']) : null;
            $price = trim($_POST['price']);




            // ------------------------------ On récupère les info actuelle du film de la bdd pour pouvoir les comparer ------------------------------

            $query = $this->pdo->prepare("SELECT * FROM movies WHERE id = :id");
            $query->execute(['id' => $movie_id]);
            $moviebdd = $query->fetch(PDO::FETCH_ASSOC);




            // ------------------------------ telechargement des images ------------------------------

            // URL de l'image à télécharger
            $posterImageUrl = $poster_path;

            // Chemin où enregistrer l'image téléchargée
            $savePath = 'C:/xampp/htdocs/public/movies_images/';

            // Extraire le nom du fichier à partir de l'URL
            $PosterMovieFileName = basename($posterImageUrl);

            if ($PosterMovieFileName != $moviebdd['poster_path']) {

                if (file_exists("C:/xampp/htdocs/public/movies_images/" . $moviebdd['poster_path'])) {
                    unlink("C:/xampp/htdocs/public/movies_images/" . $moviebdd['poster_path']);
                }

                // Chemin complet du fichier dans le dossier de destination
                $filePath = $savePath . $PosterMovieFileName;

                // Télécharger et enregistrer l'image
                $imageContent = file_get_contents($posterImageUrl);
                file_put_contents($filePath, $imageContent);
            }

            //---------------------------

            // URL de l'image du backdrop à télécharger
            $backdropImageUrl = $backdrop_path;

            // Chemin où enregistrer l'image du backdrop téléchargée
            $backdropSavePath = 'C:/xampp/htdocs/public/movies_images/';

            // Extraire le nom du fichier à partir de l'URL du backdrop
            $backdropFileName = basename($backdropImageUrl);

            if ($backdropFileName != $moviebdd['backdrop_path']) {

                if (file_exists("C:/xampp/htdocs/public/movies_images/" . $moviebdd['backdrop_path'])) {
                    unlink("C:/xampp/htdocs/public/movies_images/" . $moviebdd['backdrop_path']);
                }

                // Chemin complet du fichier du backdrop dans le dossier de destination
                $backdropFilePath = $backdropSavePath . $backdropFileName;

                // Télécharger et enregistrer l'image du backdrop
                $backdropImageContent = file_get_contents($backdropImageUrl);
                file_put_contents($backdropFilePath, $backdropImageContent);
            }
            //---------------------------

            // URL de l'image à télécharger (si elle existe)
            $belongsPosterImageUrl = $belongs_to_collection_poster_path;

            // Chemin où enregistrer l'image téléchargée
            $savePath = 'C:/xampp/htdocs/public/movies_images/';

            // Si l'URL de l'image n'est pas vide, téléchargez et enregistrez l'image
            if (!empty($belongsPosterImageUrl)) {
                // Extraire le nom du fichier à partir de l'URL
                $belongsPosterFileName = basename($belongsPosterImageUrl);

                if ($belongsPosterFileName != $moviebdd['belongs_to_collection_poster_path']) {

                    if (file_exists("C:/xampp/htdocs/public/movies_images/" . $moviebdd['belongs_to_collection_poster_path'])) {
                        unlink("C:/xampp/htdocs/public/movies_images/" . $moviebdd['belongs_to_collection_poster_path']);
                    }
                    // Chemin complet du fichier dans le dossier de destination
                    $filePath = $savePath . $belongsPosterFileName;

                    // Télécharger et enregistrer l'image
                    $belongsPosterImageContent = file_get_contents($belongsPosterImageUrl);
                    file_put_contents($filePath, $belongsPosterImageContent);
                }
            } else {
                $belongsPosterFileName = null;
            }
            //---------------------------

            // URL de l'image du backdrop de la collection à télécharger
            $belongsBackdropImageUrl =  $belongs_to_collection_backdrop_path;

            // Chemin où enregistrer l'image téléchargée
            $savePath = 'C:/xampp/htdocs/public/movies_images/';

            // Si l'URL de l'image du fond n'est pas vide, téléchargez et enregistrez l'image
            if (!empty($belongsBackdropImageUrl)) {
                // Extraire le nom du fichier à partir de l'URL
                $belongsBackdropFileName = basename($belongsBackdropImageUrl);

                if ($belongsBackdropFileName != $moviebdd['belongs_to_collection_backdrop_path']) {

                    if (file_exists("C:/xampp/htdocs/public/movies_images/" . $moviebdd['belongs_to_collection_backdrop_path'])) {
                        unlink("C:/xampp/htdocs/public/movies_images/" . $moviebdd['belongs_to_collection_backdrop_path']);
                    }

                    // Chemin complet du fichier dans le dossier de destination
                    $filePath = $savePath . $belongsBackdropFileName;

                    // Télécharger et enregistrer l'image
                    $belongsBackdropImageContent = file_get_contents($belongsBackdropImageUrl);
                    file_put_contents($filePath, $belongsBackdropImageContent);
                }
            } else {
                $belongsBackdropFileName = null;
            }

            // ------------------------------ AJOUT DU FILM DANS LA BDD ------------------------------
            $updateQuery = "
            UPDATE movies SET 
                adult = :adult,
                tmdb_id = :tmdb_id,
                imdb_id = :imdb_id,
                original_language = :original_language,
                title = :title,
                slug = :slug,
                original_title = :original_title,
                overview = :overview,
                release_date = :release_date,
                runtime = :runtime,
                vote_average = :vote_average,
                vote_count = :vote_count,
                trailer = :trailer,
                poster_path = :poster_path,
                backdrop_path = :backdrop_path,
                belongs_to_collection_id = :belongs_to_collection_id,
                belongs_to_collection_name = :belongs_to_collection_name,
                belongs_to_collection_poster_path = :belongs_to_collection_poster_path,
                belongs_to_collection_backdrop_path = :belongs_to_collection_backdrop_path,
                price = :price
            WHERE
                id = :movie_id
        ";

            $statement = $this->pdo->prepare($updateQuery);
            $statement->execute([
                ':adult' => $adult,
                ':tmdb_id' => $tmdb_id,
                ':imdb_id' => $imdb_id,
                ':original_language' => $original_language,
                ':title' => $title,
                ':slug' => $slug,
                ':original_title' => $original_title,
                ':overview' => $overview,
                ':release_date' => $release_date,
                ':runtime' => $runtime,
                ':vote_average' => $vote_average,
                ':vote_count' => $vote_count,
                ':trailer' => $trailer,
                ':poster_path' => $PosterMovieFileName,
                ':backdrop_path' => $backdropFileName,
                ':belongs_to_collection_id' => $belongs_to_collection_id,
                ':belongs_to_collection_name' => $belongs_to_collection_name,
                ':belongs_to_collection_poster_path' =>  $belongsPosterFileName,
                ':belongs_to_collection_backdrop_path' => $belongsBackdropFileName,
                ':price' => $price,
                ':movie_id' => $movie_id
            ]);





            // ------------------------------ AJOUT DES PERSONNES DANS LA BDD S'ILS N'Y EXISTENT PAS ------------------------------
            // Préparation des requêtes
            $checkExistStarsQuery = $this->pdo->prepare("SELECT COUNT(*) FROM stars WHERE name = :name");
            $insertActorQuery = $this->pdo->prepare("INSERT INTO stars (name, slug) VALUES (:name, :slug)");

            // Fonction pour créer un slug à partir d'un nom
            function createSlug($name)
            {
                return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
            }

            // Fonction pour traiter les acteurs, réalisateurs et producteurs
            function processPeople($people, $pdo, $checkExistStarsQuery, $insertActorQuery)
            {
                foreach ($people as $person) {
                    // Vérification de l'existence de la personne
                    $checkExistStarsQuery->execute(['name' => $person]);
                    $exists = $checkExistStarsQuery->fetchColumn();

                    if ($exists == 0) {
                        // La personne n'existe pas, insérer dans la base de données
                        $slug = createSlug($person);
                        $insertActorQuery->execute(['name' => $person, 'slug' => $slug]);
                    }
                }
            }

            // Traitement des acteurs
            processPeople($_POST['cast'], $this->pdo, $checkExistStarsQuery, $insertActorQuery);

            // Traitement des réalisateurs
            processPeople($_POST['director'], $this->pdo, $checkExistStarsQuery, $insertActorQuery);

            // Traitement des producteurs
            processPeople($_POST['producer'], $this->pdo, $checkExistStarsQuery, $insertActorQuery);







            // ------------------------------ REMPLISSAGE DE LA TABLE DE JOINTURE ACTEURS ------------------------------
            // Tableau pour stocker les identifiants des acteurs
            $actorIds = array();

            // Requête pour récupérer l'ID de chaque acteur
            foreach ($cast as $actorName) {
                // Préparation de la requête SQL
                $query = $this->pdo->prepare("SELECT id FROM stars WHERE name = :name");

                // Exécution de la requête avec le nom de l'acteur en tant que paramètre
                $query->execute(['name' => $actorName]);

                // Récupération de l'ID de l'acteur
                $actorId = $query->fetchColumn();

                // Vérification si l'ID a été récupéré avec succès
                if ($actorId !== false) {
                    // Ajout de l'ID au tableau des IDs des acteurs
                    $actorIds[] = $actorId;
                } else {
                    // Gestion des erreurs si l'ID n'a pas été trouvé
                    echo "Impossible de trouver l'ID pour l'acteur : $actorName";
                }
            }

            // Construction de la chaîne d'IDs d'acteurs séparés par des virgules
            $actorsString = implode(',', $actorIds);

            // Mise à jour de la colonne 'actors' dans la table 'movies' pour le film spécifique
            $updateMovieQuery = $this->pdo->prepare("UPDATE movies SET actors = :actors WHERE id = :movie_id");

            // Exécution de la mise à jour pour le film spécifique
            $updateMovieQuery->execute([
                'actors' => $actorsString,
                'movie_id' => $movie_id
            ]);


            // ------------------------------ REMPLISSAGE DE LA TABLE DE JOINTURE REALISATEURS ------------------------------
            // Tableau pour stocker les identifiants des réalisateurs
            $directorIds = array();

            // Requête pour récupérer l'ID de chaque réalisateur
            foreach ($director as $directorName) {
                // Préparation de la requête SQL
                $query = $this->pdo->prepare("SELECT id FROM stars WHERE name = :name");

                // Exécution de la requête avec le nom du réalisateur en tant que paramètre
                $query->execute(['name' => $directorName]);

                // Récupération de l'ID du réalisateur
                $directorId = $query->fetchColumn();

                // Vérification si l'ID a été récupéré avec succès
                if ($directorId !== false) {
                    // Ajout de l'ID au tableau des IDs des réalisateurs
                    $directorIds[] = $directorId;
                } else {
                    // Gestion des erreurs si l'ID n'a pas été trouvé
                    echo "Impossible de trouver l'ID pour le réalisateur : $directorName";
                }
            }

            // Construction de la chaîne d'IDs des réalisateurs séparés par des virgules
            $directorsString = implode(',', $directorIds);

            // Mise à jour de la colonne 'directors' dans la table 'movies' pour le film spécifique
            $updateDirectorsQuery = $this->pdo->prepare("UPDATE movies SET directors = :directors WHERE id = :movie_id");

            // Exécution de la mise à jour pour le film spécifique
            $updateDirectorsQuery->execute([
                'directors' => $directorsString,
                'movie_id' => $movie_id
            ]);



            // ------------------------------ REMPLISSAGE DE LA TABLE DE JOINTURE PRODUCERS ------------------------------
            // Tableau pour stocker les IDs des producteurs
            $producerIds = array();

            // Requête pour récupérer l'ID de chaque producteur
            foreach ($producer as $producerName) {
                // Préparation de la requête SQL
                $query = $this->pdo->prepare("SELECT id FROM stars WHERE name = :name");

                // Exécution de la requête avec le nom du producteur en tant que paramètre
                $query->execute(['name' => $producerName]);

                // Récupération de l'ID du producteur
                $producerId = $query->fetchColumn();

                // Vérification si l'ID a été récupéré avec succès
                if ($producerId !== false) {
                    // Ajout de l'ID au tableau des IDs des producteurs
                    $producerIds[] = $producerId;
                } else {
                    // Gestion des erreurs si l'ID n'a pas été trouvé
                    echo "Impossible de trouver l'ID pour le producteur : $producerName";
                }
            }

            // Construction de la chaîne d'IDs des producteurs séparés par des virgules
            $producersString = implode(',', $producerIds);

            // Mise à jour de la colonne 'producers' dans la table 'movies' pour le film spécifique
            $updateProducersQuery = $this->pdo->prepare("UPDATE movies SET producers = :producers WHERE id = :movie_id");

            // Exécution de la mise à jour pour le film spécifique
            $updateProducersQuery->execute([
                'producers' => $producersString,
                'movie_id' => $movie_id
            ]);




            // --------------------------------- REMPLISSAGE DE LA TABLE DE JOINTURE GENRES ---------------------------------

            // Tableau pour stocker les IDs des genres correspondants
            $genreIds = array();

            // Requête SQL pour récupérer les IDs correspondants aux valeurs du tableau $genre
            $selectGenreIdsQuery = $this->pdo->prepare("SELECT id FROM genres WHERE tmdb_genre_id IN (" . implode(',', $genre) . ")");
            $selectGenreIdsQuery->execute();

            // Récupération des IDs et stockage dans le tableau $genreIds
            while ($row = $selectGenreIdsQuery->fetch(PDO::FETCH_ASSOC)) {
                $genreIds[] = $row['id'];
            }

            // Construction de la chaîne d'IDs des genres séparés par des virgules
            $genresString = implode(',', $genreIds);

            // Mise à jour de la colonne 'genres' dans la table 'movies' pour le film spécifique
            $updateGenresQuery = $this->pdo->prepare("UPDATE movies SET genres = :genres WHERE id = :movie_id");

            // Exécution de la mise à jour pour le film spécifique
            $updateGenresQuery->execute([
                'genres' => $genresString,
                'movie_id' => $movie_id
            ]);
        }
    }
}
