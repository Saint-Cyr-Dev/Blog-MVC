<?php

require __DIR__ . '/app/db/conDB.php';

//Autoload
require __DIR__ . '/vendor/autoload.php';

//debug
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

//Router
$router = new AltoRouter();

//Map routes
$router->map('GET', '/', 'index', 'index');
$router->map('GET', '/contact', 'contact', 'contact');
$router->map('GET', '/404', '404', '404');

// Match routes
$match = $router->match();

// Vérifiez si la route a été trouvée
if (is_array($match)) {
    if (is_callable($match['target'])) {
        // Si la cible est une fonction, appelez-la avec les paramètres
        call_user_func_array($match['target'], $match['params']);
    } else {
        ob_start();
        // Si la cible est une vue, incluez-la avec les paramètres
        $params = $match['params'];
        include __DIR__ . "/app/views/{$match['target']}.view.php";
        $pageContent = ob_get_clean();
    }
} else {
    // Aucune route n'a été trouvée, incluez la vue 404
    include __DIR__ . "/app/views/404.view.php";
    $pageContent = ob_get_clean();

}

// Récupérer les articles de la base de données (remplacez cela par votre logique)
$articles = $pdo->query("SELECT * FROM posts")->fetchAll(PDO::FETCH_ASSOC);

//Select Layout
include __DIR__ .  '/app/views/layout/default.view.php';