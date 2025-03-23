<?php

// a chaque fois que l'on instancie un objet, et que la classe n'est pas encore définie, cette fonction est appelée
spl_autoload_register(function ($class) {

    // on définit un préfixe de namespace quui est le début du namespace que nous voulons autoloader,
    // et on définit un répertoire de base qui est le répertoire où se trouvent nos fichiers de classes.
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/app/';

    // On veut seulement autoloader les classes qui utilisent notre préfixe de namespace (App\\)
    // Si la classe n'utilise pas le namespace prefixé, on sort de la fonction.
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    // Si la classe utilise le préfixe de namespace,
    // on obtient le nom de la classe relative en supprimant le préfixe du namespace.
    $relative_class = substr($class, $len);


    // Remplacer le namespace prefixé par le répertoire de base, remplacer les séparateurs de namespace par des séparateurs de répertoire dans le nom relatif de la classe, et ajouter l'extension .php
    // On construit le chemin complet du fichier de classe, on remplace les "\" par des "/", et on rajoute ".php"
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    // Si le fichier existe, on l'inclut en utilisant require.
    if (file_exists($file)) {
        require $file;
    }
});
