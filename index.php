<?php
session_start();




require_once __DIR__ . '/autoload.php';             // autoload des classes
require_once __DIR__ . '/database_connection.php';  // constantes de connexion à la base de données

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$route = $_GET['route'] ?? 'home';

switch ($route) {
    case '':
    case '/':
    case 'home':
        $controller = new \App\Controllers\HomeController();
        $controller->index();
        break;

    case 'addmoviepage':
        $controller = new \App\Controllers\AddMovieController();
        $controller->index();
        break;


    case 'addmovie':
        $controller = new \App\Controllers\AddMovieController();
        $controller->addMovie();
        break;


    case 'editmovie':
        $controller = new \App\Controllers\MovieController();
        $controller->editMovie();
        break;


    case 'updatemovie':
        $controller = new \App\Controllers\MovieController();
        $controller->updateMovie();
        break;


    case 'deletemovie':
        $controller = new \App\Controllers\MovieController();
        $controller->deleteMovie();
        break;


    case 'login':
        $controller = new \App\Controllers\LoginController();
        $controller->index();
        break;


    case 'process_login':
        $controller = new \App\Controllers\LoginController();
        $controller->login();
        break;


    case 'register':
        $controller = new \App\Controllers\RegisterController();
        $controller->index();
        break;


    case 'process_register':
        $controller = new \App\Controllers\RegisterController();
        $controller->registerNew();
        break;


    case 'deconnexion':
        $controller = new \App\Controllers\AccountController();
        $controller->disconnection();
        break;


    case 'movie':
        $controller = new \App\Controllers\MovieController();
        $controller->index();
        break;


    case 'all_movies':
        $controller = new \App\Controllers\MovieController();
        $controller->allMovies();
        break;

    case 'cart':
        $controller = new \App\Controllers\CartController();
        $controller->index();
        break;


    case 'add_to_cart':
        $controller = new \App\Controllers\CartController();
        $controller->add_to_cart();
        break;


    case 'remove_from_cart':
        $controller = new \App\Controllers\CartController();
        $controller->remove_from_cart();
        break;


    case 'account':
        $controller = new \App\Controllers\AccountController();
        $controller->index();
        break;


    case 'address':
        $controller = new \App\Controllers\AddressController();
        $controller->index();
        break;


    case 'add_address':
        $controller = new \App\Controllers\AddressController();
        $controller->addAddress();
        break;


    case 'checkout':
        $controller = new \App\Controllers\CartController();
        $controller->checkout();
        break;


    case 'process_checkout':
        $controller = new \App\Controllers\CartController();
        $controller->addOrder();
        break;


    case 'order_details':
        $controller = new \App\Controllers\OrderDetailsController();
        $controller->index();
        break;

    case 'contact':
        $controller = new \App\Controllers\ContactController();
        $controller->index();
        break;

    case 'sendEmail':
        $controller = new \App\Controllers\ContactController();
        $controller->sendEmail();

    case 'documents':
        require_once 'app/Views/documents.php';
        break;

    case 'cgv':
        require_once 'app/Views/cgv.php';
        break;

    case 'mentions-legales':
        require_once 'app/Views/mentions-legales.php';
        break;

    case 'robots.txt':
        echo 'User-agent: * Disallow: /';
        break;


    default:
        header('Location: /');
        exit;
        break;
}
