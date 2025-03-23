<?php

namespace App\Models;

use PDO;

class MovieModel extends Model
{
    public function getFiveLastMovies()
    {
        try {
            // Requête pour sélectionner tous les films à partir de $this->pdo
            $query = $this->pdo->query("SELECT * FROM movies ORDER BY id DESC LIMIT 5");

            // Récupération des résultats sous forme de tableau associatif
            return $query->fetchAll();
        } catch (\PDOException $e) {
            require_once __DIR__ . '/../../reports.php';
        }
    }


    public function getMoviebyId($id)
    {
        try {
            // $id = isset($_GET['id']) ? $_GET['id'] : null;
            $query = $this->pdo->prepare("
        SELECT 
        m.*,
        l.name_fr AS original_language_name,
        GROUP_CONCAT(DISTINCT s_actor.name ORDER BY s_actor.name ASC SEPARATOR ',') AS actors_names,
        s_director.name AS director_name,
        GROUP_CONCAT(DISTINCT s_producer.name ORDER BY s_producer.name ASC SEPARATOR ',') AS producers_names,
        GROUP_CONCAT(DISTINCT g.name_fr ORDER BY g.name_fr ASC SEPARATOR ',') AS genres_names
            FROM 
                movies m
            LEFT JOIN 
                stars s_actor ON FIND_IN_SET(s_actor.id, m.actors)
            LEFT JOIN 
                stars s_director ON s_director.id = m.directors
            LEFT JOIN 
                stars s_producer ON FIND_IN_SET(s_producer.id, m.producers)
            LEFT JOIN 
                genres g ON FIND_IN_SET(g.id, m.genres)
            LEFT JOIN
                languages l ON m.original_language = l.iso_639_1
            WHERE 
                m.ID = :id
            GROUP BY 
                m.ID
                ");

                
            // Liaison de la valeur du paramètre :id avec la valeur provenant de $id
            $query->bindValue(':id', $id, PDO::PARAM_INT);

            // Exécution de la requête préparée
            $query->execute();

            // Récupération du résultat sous forme de tableau associatif
            $movie = $query->fetch(PDO::FETCH_ASSOC);
            return $movie;
        } catch (\PDOException $e) {
            require_once __DIR__ . '/../../reports.php';
        }
    }

    public function getUpdateById($id)
    {
        try {
            $sql = "
        SELECT 
        m.*,
        GROUP_CONCAT(DISTINCT s_actor.name ORDER BY s_actor.name ASC SEPARATOR ',') AS actors_names,
        GROUP_CONCAT(DISTINCT s_director.name ORDER BY s_director.name ASC SEPARATOR ',') AS directors_names,
        GROUP_CONCAT(DISTINCT s_producer.name ORDER BY s_producer.name ASC SEPARATOR ',') AS producers_names,
        GROUP_CONCAT(DISTINCT g.tmdb_genre_id ORDER BY g.tmdb_genre_id ASC SEPARATOR ',') AS tmdb_genre_ids
    FROM movies m
    LEFT JOIN stars s_actor ON FIND_IN_SET(s_actor.id, m.actors)
    LEFT JOIN stars s_director ON FIND_IN_SET(s_director.id, m.directors)
    LEFT JOIN stars s_producer ON FIND_IN_SET(s_producer.id, m.producers)
    LEFT JOIN genres g ON FIND_IN_SET(g.id, m.genres)
    WHERE m.id = ?
    GROUP BY m.id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            $movie = $stmt->fetch(PDO::FETCH_ASSOC);
            return $movie;
        } catch (\PDOException $e) {
            require_once __DIR__ . '/../../reports.php';
        }
    }

    public function countMovies()
    {
        try {
            $query = $this->pdo->query("SELECT COUNT(*) FROM movies");
            $totalMovies = $query->fetchColumn();
            return $totalMovies;
        } catch (\PDOException $e) {
            require_once __DIR__ . '/../../reports.php';
        }
    }

    public function getMoviesCurrentPage($orderClause, $offset, $filmsParPage)
    {

        try {

            $sql = 'SELECT * FROM movies ' . $orderClause . ' LIMIT :offset, :filmsParPage';
            $query = $this->pdo->prepare($sql);
            $query->bindValue(':offset', $offset, PDO::PARAM_INT);
            $query->bindValue(':filmsParPage', $filmsParPage, PDO::PARAM_INT);
            $query->execute();
            $movies = $query->fetchAll(PDO::FETCH_ASSOC);
            return $movies;
        } catch (\PDOException $e) {
            require_once __DIR__ . '/../../reports.php';
        }
    }

    // public function deleteMovie($id)
    // {
    //     $query = $this->pdo->prepare("DELETE FROM movies WHERE id = :id");
    //     $query->bindValue(':id', $id, PDO::PARAM_INT);
    //     $query->execute();
    // }


    public function deleteMovie($id)
    {

        try {

            // Commencez une transaction
            $this->pdo->beginTransaction();

            try {
                // Supprimez les correspondances dans la table de jointure
                $query = $this->pdo->prepare("DELETE FROM movies_stars_roles WHERE movie_id = :id");
                $query->bindValue(':id', $id, PDO::PARAM_INT);
                $query->execute();

                // Supprimez le film de la table movies
                $query = $this->pdo->prepare("DELETE FROM movies WHERE id = :id");
                $query->bindValue(':id', $id, PDO::PARAM_INT);
                $query->execute();

                // Validez la transaction
                $this->pdo->commit();
            } catch (\Exception $e) {
                // En cas d'erreur, annulez la transaction
                $this->pdo->rollBack();
                throw $e;
            }
        } catch (\PDOException $e) {
            require_once __DIR__ . '/../../reports.php';
        }
    }


    public function visitedMovie($movie_id)
    {
        try {
            $updateQuery = 'UPDATE movies SET visited = visited + 1 WHERE id = :id';
            $statement = $this->pdo->prepare($updateQuery);
            $statement->execute(['id' => $movie_id]);
        } catch (\PDOException $e) {
            require_once __DIR__ . '/../../reports.php';
        }
    }

    public function getMoviesByPopularity()
    {
        try {
            $sql = "SELECT * FROM movies ORDER BY visited DESC LIMIT 5";
            $query = $this->pdo->query($sql);
            $movies = $query->fetchAll(PDO::FETCH_ASSOC);
            return $movies;
        } catch (\PDOException $e) {
            require_once __DIR__ . '/../../reports.php';
        }
    }

    public function getMoviesByGenre($genre_id)
    {
        try {
            $sql = "SELECT * FROM movies WHERE genres LIKE :genre_id";
            $query = $this->pdo->prepare($sql);
            $query->bindValue(':genre_id', '%' . $genre_id . '%', PDO::PARAM_STR);
            $query->execute();
            $movies = $query->fetchAll(PDO::FETCH_ASSOC);
            return $movies;
        } catch (\PDOException $e) {
            require_once __DIR__ . '/../../reports.php';
        }
    }

    public function getMoviesByActor($actor_id)
    {
        try {
            $sql = "SELECT * FROM movies WHERE actors LIKE :actor_id";
            $query = $this->pdo->prepare($sql);
            $query->bindValue(':actor_id', '%' . $actor_id . '%', PDO::PARAM_STR);
            $query->execute();
            $movies = $query->fetchAll(PDO::FETCH_ASSOC);
            return $movies;
        } catch (\PDOException $e) {
            require_once __DIR__ . '/../../reports.php';
        }
    }
}
