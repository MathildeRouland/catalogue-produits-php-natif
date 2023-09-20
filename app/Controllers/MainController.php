<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\Category;

// Si j'ai besoin du Model Category
// use App\Models\Category;

class MainController extends CoreController
{
    /**
     * Méthode s'occupant de la page d'accueil
     *
     * @return void
     */
    public function home()
    {
        // // Les utilisateurs qui ont le rôle admin et catalog-manager peuvent aller sur cette page
        // $this->checkAuthorization(['admin', 'catalog-manager']);
        // dump($_SESSION);

        $categoryModel = new Category();
        $categoryList = $categoryModel->findAllHomepage();
        $dataToSend['categories'] = $categoryList;

        $productModel = new Product();
        $productList = $productModel->findAllHomepage();
        $dataToSend['products'] = $productList;
        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $this->show('main/home', $dataToSend);
    }
}
