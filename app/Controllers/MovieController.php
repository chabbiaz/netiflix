<?php

namespace App\Controllers;

use App\Models\MovieModel;
use App\Models\UpdateMovieModel;

class MovieController extends Controller
{
    private $root_directory;

    public function __construct()
    {
        // Définir le chemin du répertoire racine du projet
        $this->root_directory = str_replace('\\', '/', dirname(dirname(__DIR__))); // C:/Users/Zyad/Dropbox/dev web/mvc_php

    }

    public function index()
    {
        $id = $_GET['id'];
        $model = new MovieModel();
        $movie = $model->getMovieById($id);


        // Si le film n'existe pas, on redirige l'utilisateur vers la page d'accueil
        if (empty($movie)) {
            $this->goToHome();
        }

        // Calculer le nombre d'heures
        $hours = floor($movie['runtime'] / 60);

        // Calculer le nombre de minutes restantes
        $minutes = $movie['runtime'] % 60;
        // Formater le temps en heures et minutes
        $timeHours = sprintf('%dh%d', $hours, $minutes);

        $this->generateCsrfToken();
        require_once $this->root_directory . '/app/Views/movie.php';

        // Appeler la méthode visitedMovie pour incrémenter le nombre de vues de la page du film
        $model->visitedMovie($id);
    }

    public function editMovie()
    {
        // Il faut être admin pour accéder à cette page et que l'id du film soit défini
        if ($this->isAdmin() && isset($_GET['id'])) {
            $movieModel = new MovieModel();
            $movie = $movieModel->getUpdateById($_GET['id']);

            // Si le film n'existe pas, on redirige l'utilisateur vers la page d'accueil
            if (!$movie) {
                $this->goToHome();
            }

            $this->generateCsrfToken();
            require_once $this->root_directory . '/app/Views/edit_movie.php';
        } else {
            $this->goToHome();
        }
    }

    public function updateMovie()
    {
        // Si l'utilisateur est admin et que le token CSRF est valide, on met à jour le film,
        // puis on supprime le jeton CSRF et on redirige l'utilisateur vers la page d'accueil
        if ($this->isAdmin() && $this->csrfValid()) {
            $movieModel = new UpdateMovieModel();
            $movieModel->updateMovie();
            $this->unsetCsrfToken();
            $this->goToHome();
        } else {
            $this->goToHome();
        }
    }

    public function deleteMovie()
    {
        // Si l'utilisateur est admin et que le token CSRF est valide, on supprime le film,
        // puis on supprime le jeton CSRF et on redirige l'utilisateur vers la page d'accueil
        if ($this->isAdmin() && $this->csrfValid() && isset($_POST['movie_id'])) {
            $movieModel = new MovieModel();
            $movieModel->deleteMovie($_POST['movie_id']);
            $this->unsetCsrfToken();
            $this->goToHome();
        } else {
            $this->goToHome();
        }
    }


    public function allMovies()
    {

        $movieModel = new MovieModel();
        $totalMovies = $movieModel->countMovies();


        // Définir le nombre de films par page
        $filmsParPage = 3;

        // Obtenir la page actuelle à partir de la requête GET, sinon par défaut à 1
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        // Calculer l'offset
        $offset = ($page - 1) * $filmsParPage;

        // Vérifier le type de tri demandé
        $orderBy = isset($_GET['sort']) ? $_GET['sort'] : 'id_desc';

        // Construire la requête SQL en fonction du type de tri
        switch ($orderBy) {
            case 'id_desc':
                $orderClause = 'ORDER BY id DESC';
                break;
            case 'release_date_asc':
                $orderClause = 'ORDER BY release_date ASC';
                break;
            case 'release_date_desc':
                $orderClause = 'ORDER BY release_date DESC';
                break;
            case 'title_asc':
                $orderClause = 'ORDER BY title ASC';
                break;
            case 'title_desc':
                $orderClause = 'ORDER BY title DESC';
                break;
            default:
                $orderClause = 'ORDER BY release_date DESC';
                break;
        }


        $movies = $movieModel->getMoviesCurrentPage($orderClause, $offset, $filmsParPage);

        $totalPages = ceil($totalMovies / $filmsParPage);

        require_once $this->root_directory . '/app/Views/all_movies.php';
    }
}