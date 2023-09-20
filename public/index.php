<?php

// POINT D'ENTRÉE UNIQUE :
// FrontController

// inclusion des dépendances via Composer
// autoload.php permet de charger d'un coup toutes les dépendances installées avec composer
// mais aussi d'activer le chargement automatique des classes (convention PSR-4)
require_once '../vendor/autoload.php';

// Démarrage de la session (avant tout affichage)
// On met cette instruction dans le point d'entrée de manière à ce qu'elle soit démarrée tout le temps
session_start ();
/* ------------
--- ROUTAGE ---
-------------*/


// création de l'objet router
// Cet objet va gérer les routes pour nous, et surtout il va
$router = new AltoRouter();

// le répertoire (après le nom de domaine) dans lequel on travaille est celui-ci
// Mais on pourrait travailler sans sous-répertoire
// Si il y a un sous-répertoire
if (array_key_exists('BASE_URI', $_SERVER)) {
    // Alors on définit le basePath d'AltoRouter
    $router->setBasePath($_SERVER['BASE_URI']);
    // ainsi, nos routes correspondront à l'URL, après la suite de sous-répertoire
} else { // sinon
    // On donne une valeur par défaut à $_SERVER['BASE_URI'] car c'est utilisé dans le CoreController
    $_SERVER['BASE_URI'] = '/';
}

// On doit déclarer toutes les "routes" à AltoRouter,

$router->map(
    'GET',
    '/',
    [
        'method' => 'home',
        'controller' => '\App\Controllers\MainController', // On indique le FQCN de la classe
        'acl' => ['admin', 'catalog-manager'],
    ],
    'main-home'
);

$router->map(
    'GET',
    '/category/list',
    [
        'method' => 'list',
        'controller' => '\App\Controllers\CategoryController',
        'acl' => ['admin', 'catalog-manager'],
    ],
    'category-list'
);

$router->map(
    'GET',
    '/product/list',
    [
        'method' => 'list',
        'controller' => '\App\Controllers\ProductController',
        'acl' => ['admin', 'catalog-manager'],
    ],
    'product-list'
);



// $router->map(
//     'GET',
//     '/category/add',
//     [
//         'method' => 'add',
//         'controller' => '\App\Controllers\CategoryController' // On indique le FQCN de la classe
//     ],
//     'category-add'
// );

$router->map(
    'GET',
    '/category/add',
    [
        'method' => 'add',
        'controller' => '\App\Controllers\CategoryController', // On indique le FQCN de la classe
        'acl' => ['admin', 'catalog-manager'], 
    ],
    'category-add'
);

$router->map(
    'POST',
    '/category/add',
    [
        'method' => 'create',
        'controller' => '\App\Controllers\CategoryController', // On indique le FQCN de la classe
        'acl' => ['admin', 'catalog-manager'], 
    ],
    'category-add-post'
);

$router->map(
    'GET',
    '/product/add',
    [
        'method' => 'add',
        'controller' => '\App\Controllers\ProductController', // On indique le FQCN de la classe
        'acl' => ['admin', 'catalog-manager'], 
    ],
    'product-add'
);

$router->map(
    'POST',
    '/product/add',
    [
        'method' => 'create',
        'controller' => '\App\Controllers\ProductController', // On indique le FQCN de la classe
        'acl' => ['admin', 'catalog-manager'], 
    ],
    'product-add-post'
);
$router->map(
    'GET',
    '/category/edit/[i:categoryId]',
    [
        'method' => 'edit',
        'controller' => '\App\Controllers\CategoryController', // On indique le FQCN de la classe
        'acl' => ['admin', 'catalog-manager'], 
    ],
    'category-edit'
);

$router->map(
    'POST',
    '/category/edit/[i:categoryId]',
    [
        'method' => 'modify',
        'controller' => '\App\Controllers\CategoryController', // On indique le FQCN de la classe
        'acl' => ['admin', 'catalog-manager'], 
    ],
    'category-edit-post'
);

$router->map(
    'GET',
    '/product/edit/[i:productId]',
    [
        'method' => 'edit',
        'controller' => '\App\Controllers\ProductController', // On indique le FQCN de la classe
        'acl' => ['admin', 'catalog-manager'], 
    ],
    'product-edit'
);

$router->map(
    'POST',
    '/product/edit/[i:productId]',
    [
        'method' => 'modify',
        'controller' => '\App\Controllers\ProductController', // On indique le FQCN de la classe
        'acl' => ['admin', 'catalog-manager'], 
    ],
    'product-edit-post'
);

$router->map(
    'GET',
    '/category/select',
    [
        'method' => 'select',
        'controller' => '\App\Controllers\CategoryController',
        'acl' => ['admin', 'catalog-manager'],
    ],
    'category-select'
);

$router->map(
    'POST',
    '/category/select',
    [
        'method' => 'updateHomeOrder',
        'controller' => '\App\Controllers\CategoryController', // On indique le FQCN de la classe
        'acl' => ['admin', 'catalog-manager'], 
    ],
    'category-select-post'
);

$router->map(
    'GET',
    '/brand/list',
    [
        'method' => 'list',
        'controller' => '\App\Controllers\BrandController',
        'acl' => ['admin', 'catalog-manager'],
    ],
    'brand-list'
);

$router->map(
    'GET',
    '/login',
    [
        'method' => 'login',
        'controller' => '\App\Controllers\AppUserController'
    ],
    'login'
);

$router->map(
    'POST',
    '/login',
    [
        'method' => 'authenticate',
        'controller' => '\App\Controllers\AppUserController'
    ],
    'authenticate'
);

$router->map(
    'GET',
    '/logout',
    [
        'method' => 'logout',
        'controller' => '\App\Controllers\AppUserController'
    ],
    'logout'
);

$router->map(
    'GET',
    '/user/list',
    [
        'method' => 'list',
        'controller' => '\App\Controllers\AppUserController',
        'acl' => ['admin'],
    ],
    'user-list'
);

$router->map(
    'GET',
    '/user/add',
    [
        'method' => 'add',
        'controller' => '\App\Controllers\AppUserController',
        'acl' => ['admin'],
    ],
    'user-add'
);

$router->map(
    'POST',
    '/user/add',
    [
        'method' => 'create',
        'controller' => '\App\Controllers\AppUserController',  // On indique le FQCN de la classe
        'acl' => ['admin'],
    ],
    'user-add-post'
);



/* -------------
--- DISPATCH ---
--------------*/

// On demande à AltoRouter de trouver une route qui correspond à l'URL courante
$match = $router->match();

// Ensuite, pour dispatcher le code dans la bonne méthode, du bon Controller
// On délègue à une librairie externe : https://packagist.org/packages/benoclock/alto-dispatcher
// 1er argument : la variable $match retournée par AltoRouter
// 2e argument : le "target" (controller & méthode) pour afficher la page 404
$dispatcher = new Dispatcher($match, '\App\Controllers\ErrorController::err404');
// Une fois le "dispatcher" configuré, on lance le dispatch qui va exécuter la méthode du controller
$dispatcher->dispatch();
