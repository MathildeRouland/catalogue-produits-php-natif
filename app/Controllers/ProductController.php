<?php

namespace App\Controllers;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Type;
use App\Models\Tag;

use App\Models\CoreModel;




class ProductController extends CoreController
{
    public function list()
    {
        // // Les utilisateurs qui ont le rôle admin et catalog-manager peuvent aller sur cette page
        // $this->checkAuthorization(['admin', 'catalog-manager']);
        $productModel = new Product();
        $productList = $productModel->findAll();
        $dataToSend['products'] = $productList;
        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $this->show('product/list', $dataToSend);

    }

    public function add()
    {
        // // Les utilisateurs qui ont le rôle admin et catalog-manager peuvent aller sur cette page
        // $this->checkAuthorization(['admin', 'catalog-manager']);
        $brandModel = new Brand();
        $brandList = $brandModel->findAll();

        $dataToSend['brands'] = $brandList;

        $categoryModel = new Category();
        $categoryList = $categoryModel->findAll();



        $dataToSend['categories'] = $categoryList;

        $typeModel = new Type();
        $typeList = $typeModel->findAll();

        $dataToSend['types'] = $typeList;

        $productModel = new Product();
        
        $dataToSend['product'] = $productModel;


        // dump($dataToSend);
        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $this->show('product/add', $dataToSend);

    }



    public function edit($productId)
    {
        // // Les utilisateurs qui ont le rôle admin et catalog-manager peuvent aller sur cette page
        // $this->checkAuthorization(['admin', 'catalog-manager']);
        $product = Product::find($productId);
        $categories = Category::findAll();
        $brands = Brand::findAll();
        $types = Type::findAll();
        
        // Récupération de tous les tags du produit
        $tags = Tag::findByProduct($productId);

        $this->show('product/edit', [
            'product' => $product,
            'categories' => $categories,
            'brands' => $brands,
            'types' => $types,
            'tags' => $tags
        ]);
       
    }

    public function create()
    {
        // // Les utilisateurs qui ont le rôle admin et catalog-manager peuvent aller sur cette page
        // $this->checkAuthorization(['admin', 'catalog-manager']);
        $name = filter_input(INPUT_POST, 'name');
        $description = filter_input(INPUT_POST, 'description');
        $picture = filter_input(INPUT_POST, 'picture');
        $rate = filter_input(INPUT_POST, 'rate');
        $price = filter_input(INPUT_POST, 'price');
        $status = filter_input(INPUT_POST, 'status');
        $category = filter_input(INPUT_POST, 'category');
        $brand = filter_input(INPUT_POST, 'brand');
        $type = filter_input(INPUT_POST, 'type');


        // Création de l'instance du produit
        $product = new Product();
        $product->setName($name);
        $product->setDescription($description);
        $product->setPicture($picture);
        $product->setPrice($price);
        $product->setRate($rate);
        $product->setStatus($status);
        $product->setCategoryId($category);
        $product->setBrandId($brand);
        $product->setTypeId($type);

        // Contiendra les erreurs du formulaire
        $formErrors = [];

        // 1.5. Validation du formulaire

        // Si le champ name est vide
        if (empty($name)) {
            // On enregistre l'erreur
            $formErrors[] = "Le nom du produit ne peut être vide";
        }
        if (empty($description)) {
            $formErrors[] = "La description du produit ne peut être vide";
        }

        if (empty($picture)) {
            $formErrors[] = "L'image' du produit ne peut être vide";
        }
        if (empty($price)) {
            $formErrors[] = "Le prix du produit ne peut être vide";
        }
        if (empty($status)) {
            $formErrors[] = "Le statut du produit ne peut être vide";
        }
        if (empty($categoryId)) {
            $formErrors[] = "L'id de la catégorie du produit ne peut être vide";
        }
        if (empty($brandId)) {
            $formErrors[] = "L'id de la marque du produit ne peut être vide";
        }
        if (empty($typeId)) {
            $formErrors[] = "L'id du type du produit ne peut être vide";
        }
        // S'il existe des erreurs dans le formulaire
        // => si $formErrors n'est pas vide
        if (!empty($formErrors)) {
            // On n'enregistre pas la catégorie
            // On affiche le formulaire de nouveau avec les messages d'erreur
            $this->show('/category/add', [
                'errors' => $formErrors,
                'product' => $product // Contient les données du formulaire
            ]);
        } else {
            // 2. Enregistrement de ces données dans la base de données (table des catégories) si le formulaire est valide

            $result = $product->insert();

            // 3. On redirige vers la page liste des catégories
            header('Location: /product/list');
            exit();
        }


        // $this->show('product/add');

    }

    public function modify($params)
    {
        // // Les utilisateurs qui ont le rôle admin et catalog-manager peuvent aller sur cette page
        // $this->checkAuthorization(['admin', 'catalog-manager']);
        // 1. Récupération des données du formulaire
        $name = htmlspecialchars(filter_input(INPUT_POST, 'name'));
        $description = htmlspecialchars(filter_input(INPUT_POST, 'description'));
        $picture = htmlspecialchars(filter_input(INPUT_POST, 'picture'));
        $price = htmlspecialchars(filter_input(INPUT_POST, 'price'));
        $rate = htmlspecialchars(filter_input(INPUT_POST, 'rate'));
        $status = htmlspecialchars(filter_input(INPUT_POST, 'status'));
        $categoryId = htmlspecialchars(filter_input(INPUT_POST, 'categoryId'));
        $brandId = htmlspecialchars(filter_input(INPUT_POST, 'brandId'));
        $typeId = htmlspecialchars(filter_input(INPUT_POST, 'typeId'));
        $id = $params;


        // Update du produit
        $product = Product::find($id);
        $product->setName($name);
        $product->setDescription($description);
        $product->setPicture($picture);
        $product->setPrice($price);
        $product->setRate($rate);
        $product->setStatus($status);
        $product->setCategoryId($categoryId);
        $product->setBrandId($brandId);
        $product->setTypeId($typeId);

        //
        $brands = Brand::find($brandId);
        $brandsList = [];

        // $typesList = [];
        foreach($brands as $brand){
            $brandsList[$brand->getId()]=$brand;
        }

        

        // Contiendra les erreurs du formulaire
        $formErrors = [];

        // 1.5. Validation du formulaire

        // Si le champ name est vide
        if (empty($name)) {
            // On enregistre l'erreur
            $formErrors[] = "Le nom du produit ne peut être vide";
        }
        if (empty($description)) {
            $formErrors[] = "La description du produit ne peut être vide";
        }

        if (empty($picture)) {
            $formErrors[] = "L'image' du produit ne peut être vide";
        }
        if (empty($price)) {
            $formErrors[] = "Le prix du produit ne peut être vide";
        }
        if (empty($status)) {
            $formErrors[] = "Le statut du produit ne peut être vide";
        }
        if (empty($categoryId)) {
            $formErrors[] = "L'id de la catégorie du produit ne peut être vide";
        }
        if (empty($brandId)) {
            $formErrors[] = "L'id de la marque du produit ne peut être vide";
        }
        if (empty($typeId)) {
            $formErrors[] = "L'id du type du produit ne peut être vide";
            // S'il existe des erreurs dans le formulaire
            // => si $formErrors n'est pas vide
            if (!empty($formErrors)) {
                // On n'enregistre pas le produit
                // On affiche le formulaire de nouveau avec les messages d'erreur
                $this->show('/product/edit[i:productId]', [
                    'errors' => $formErrors,
                    'product' => $product // Contient les données du formulaire
                ]);
            } else {
                // 2. Enregistrement de ces données dans la base de données (table des catégories) si le formulaire est valide

                $result = $product->update();
                $dataToSend['product'] = $result;
                $dataToSend['brandsList'] = $brandsList; 
                $this->show('product/edit/[i:productId]', $dataToSend);

                // // 3. On redirige vers la page liste des catégories
                // header('Location: /product/list');
                // exit();
            }
        }
    }
}