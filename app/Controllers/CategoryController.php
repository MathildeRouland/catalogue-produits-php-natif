<?php

namespace App\Controllers;
use App\Models\Category;

class CategoryController extends CoreController
{
    public function list()
    {

        //  // Les utilisateurs qui ont le rôle admin et catalog-manager peuvent aller sur cette page
        //  $this->checkAuthorization(['admin', 'catalog-manager']);
         
         
        $categoryModel = new Category();
        $categoryList = $categoryModel->findAll();
        $dataToSend['categories'] = $categoryList;
        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller

        // Affichage du template (vue) list.tpl.php qui se trouve dans le dossier category
        $this->show('category/list', $dataToSend);

    }

    public function add()
    {
        // // Les utilisateurs qui ont le rôle admin et catalog-manager peuvent aller sur cette page
        // $this->checkAuthorization(['admin', 'catalog-manager']);
        // La ligne new Category permet de créer une variable $category dans le template car elle est utilisée lors de la validation du formulaire
        $this->show('category/add', [
            'category' => new Category()    // On ajoute cette ligne pour gérer les erreurs et avoir une catégorie vide par défaut
        ]);
        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $this->show('category/add');
    }

    

    public function edit($categoryId)
    {
        // // Les utilisateurs qui ont le rôle admin et catalog-manager peuvent aller sur cette page
        // $this->checkAuthorization(['admin', 'catalog-manager']);
        $categoryModel = new Category();
        $categoryId = $categoryModel->find($categoryId);
        $dataToSend['categoryId'] = $categoryId;

        $this->show('category/edit', $dataToSend);
    }

    public function create()
    {
        // // Les utilisateurs qui ont le rôle admin et catalog-manager peuvent aller sur cette page
        // $this->checkAuthorization(['admin', 'catalog-manager']);
        // 1. Récupération des données du formulaire
        $name = filter_input(INPUT_POST, 'name');
        $subtitle = filter_input(INPUT_POST, 'subtitle');
        $picture = filter_input(INPUT_POST, 'picture');


        // Création de la catégorie
        $category = new Category();
        $category->setName($name);
        $category->setSubtitle($subtitle);
        $category->setPicture($picture);
        // Contiendra les erreurs du formulaire
        $formErrors = [];

        // 1.5. Validation du formulaire

        // Si le champ name est vide
        if (empty($name)) {
            // On enregistre l'erreur
            $formErrors[] = "Le nom de la catégorie ne peut être vide";
        }
        if (empty($subtitle)) {
            $formErrors[] = "Le sous-titre de la catégorie ne peut être vide";
        }
        // S'il existe des erreurs dans le formulaire
        // => si $formErrors n'est pas vide
        if (!empty($formErrors)) {
            // On n'enregistre pas la catégorie
            // On affiche le formulaire de nouveau avec les messages d'erreur
            $this->show('/category/add', [
                'errors' => $formErrors,
                'category' => $category // Contient les données du formulaire
            ]);
        } else {
            // 2. Enregistrement de ces données dans la base de données (table des catégories) si le formulaire est valide

            $result = $category->insert();

            // 3. On redirige vers la page liste des catégories
            header('Location: /category/list');
            exit();
        }


        // $this->show('category/add', [
        //     'categoryCreate' => $categoryNew
        // ]);
        // $this->show('category/add');
    }
    public function modify($params)
    {
        // // Les utilisateurs qui ont le rôle admin et catalog-manager peuvent aller sur cette page
        // $this->checkAuthorization(['admin', 'catalog-manager']);
        // 1. Récupération des données du formulaire
        $name = htmlspecialchars(filter_input(INPUT_POST, 'name'));
        $subtitle = htmlspecialchars(filter_input(INPUT_POST, 'subtitle'));
        $picture = htmlspecialchars(filter_input(INPUT_POST, 'picture'));
        $id = $params;


        // Update de la catégorie
        $category = Category::find($id);
        $category->setName($name);
        $category->setSubtitle($subtitle);
        $category->setPicture($picture);
        // Contiendra les erreurs du formulaire
        $formErrors = [];

        // 1.5. Validation du formulaire

        // Si le champ name est vide
        if (empty($name)) {
            // On enregistre l'erreur
            $formErrors[] = "Le nom de la catégorie ne peut être vide";
        }
        if (empty($subtitle)) {
            $formErrors[] = "Le sous-titre de la catégorie ne peut être vide";
        }
        // S'il existe des erreurs dans le formulaire
        // => si $formErrors n'est pas vide
        if (!empty($formErrors)) {
            // On n'enregistre pas la catégorie
            // On affiche le formulaire de nouveau avec les messages d'erreur
            $this->show('/category/edit[i:categoryId]', [
                'errors' => $formErrors,
                'category' => $category // Contient les données du formulaire
            ]);
        } else {
            // 2. Enregistrement de ces données dans la base de données (table des catégories) si le formulaire est valide

            $result = $category->update();

            // 3. On redirige vers la page liste des catégories
            header('Location: /category/list');
            exit();
        }


        // $this->show('category/add', [
        //     'categoryCreate' => $categoryNew
        // ]);
        // $this->show('category/add');
    }

    /**
     * Affiche le formulaire de mise à jour des catégories en page d'accueil
     */
    public function select()
    {
        // Récupérer les catégories actuellement mises en avant
        $categoryHomePageList = Category::findAllHomepage();
        $dataToSend['categoriesHome'] = $categoryHomePageList;


        // TODO : Récupérer toutes les catégories du site (pour le menu déroulant)
        $categoryList = Category::findAll();
        $dataToSend['categories'] = $categoryList;
        // TODO : Ajouter également toutes les catégories
        
        
        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller

        // Affichage du template (vue) list.tpl.php qui se trouve dans le dossier category
        $this->show('category/select', $dataToSend);
    }

    /**
     * Met à jour l'ordre des catégories de la page d'accueil
     */
    public function updateHomeOrder()
    {
        // Liste de toutes les catégories à mettre à jour
        // Celles dont je dois changer la valeur du champ home_order
        $categoriesToUpdate = $_POST['emplacement'];
        
        // Mettre à jour les anciennes catégories de la page d'accueil
        Category::resetHomeOrder();

        // On affecte le nouvel emplacement aux catégories sélectionnées
        foreach ($categoriesToUpdate as $emplacement => $categoryId) {
            // $categoryId = le numéro de la catégorie qui va être modifiée
            // $emplacement + 1 = la nouvelle valeur de home_order
            Category::updateHomeOrder($categoryId, $emplacement + 1);
        }

        header('Location: /');
        exit();
    }
}