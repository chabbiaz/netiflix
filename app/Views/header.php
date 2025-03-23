<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="DVD films indiens vente">
    <link rel="stylesheet" href="/public/css/reset.css" />
    <link rel="stylesheet" href="/public/css/style.css" />
    <title>Netiflix</title>
</head>

<body>
    <header>
        <!-- -------------------  NAVBAR  ------------------- -->
        <div class="navbar">
            <div class="navbar-left">
                <ul>
                    <li><a href="/">accueil</a></li>
                    <li><a href="all_movies">Tout nos films</a></li>
                    <li><a href="cart">panier</a></li>
                </ul>
            </div>

            <div class="logo-container">
                <img src="/public/netiflix.png" alt="Netiflix Logo" />
            </div>

            <div class="navbar-right">
                <ul>
                    <?php if (isset($_SESSION['user_id'])) {
                        if ($_SESSION['isAdmin'] === 1) { ?>
                            <li><a href="addmoviepage">Ajouter un film</a></li>
                        <?php } ?>

                        <li><a href="account">mon compte</a></li>
                        <li><a href="deconnexion">déconnexion</a></li>
                    <?php } else { ?>
                        <li><a href="login">connexion</a></li>
                        <li><a href="register">inscription</a></li>
                    <?php } ?>

                </ul>
            </div>
        </div>


        <div class="navbar2">
            <div id="mySidenav" class="sidenav">
                <a id="closeBtn" href="#" class="close">&times;</a>
                <ul>
                    <li><a href="/">accueil</a></li>
                    <li><a href="all_movies">Tout nos films</a></li>
                    <li><a href="cart">panier</a></li>
                    <?php if (isset($_SESSION['user_id'])) {
                        if ($_SESSION['isAdmin'] === 1) { ?>
                            <li><a href="addmoviepage">Ajouter un film</a></li>
                        <?php } ?>

                        <li><a href="account">mon compte</a></li>
                        <li><a href="deconnexion">déconnexion</a></li>
                    <?php } else { ?>
                        <li><a href="login">connexion</a></li>
                        <li><a href="register">inscription</a></li>
                    <?php } ?>
                </ul>
            </div>

            <a href="#" id="openBtn">
                <span class="burger-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>
            <div class="logo-container">
                <img src="/public/netiflix.png" alt="Netiflix Logo" />
            </div>
        </div>

        <p style="text-align: center; color: red;">
            Ce site est un projet de fin d'étude présenté en juin 2026
        </p>
    </header>


    <script>
        var sidenav = document.getElementById("mySidenav");
        var openBtn = document.getElementById("openBtn");
        var closeBtn = document.getElementById("closeBtn");

        openBtn.onclick = openNav;
        closeBtn.onclick = closeNav;

        /* Set the width of the side navigation to 250px */
        function openNav() {
            sidenav.classList.add("active");
        }

        /* Set the width of the side navigation to 0 */
        function closeNav() {
            sidenav.classList.remove("active");
        }
    </script>

    <div class="contenu">