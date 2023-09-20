<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class Category extends CoreModel
{

    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $subtitle;
    /**
     * @var string
     */
    private $picture;
    /**
     * @var int
     */
    private $home_order;

    /**
     * Get the value of name
     *
     * @return  string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param  string  $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * Get the value of subtitle
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * Set the value of subtitle
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;
    }

    /**
     * Get the value of picture
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set the value of picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    /**
     * Get the value of home_order
     */
    public function getHomeOrder()
    {
        return $this->home_order;
    }

    /**
     * Set the value of home_order
     */
    public function setHomeOrder($home_order)
    {
        $this->home_order = $home_order;
    }

    /**
     * Méthode permettant de récupérer un enregistrement de la table Category en fonction d'un id donné
     *
     * @param int $categoryId ID de la catégorie
     * @return Category
     */
    public static function find($categoryId)
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // écrire notre requête
        $sql = 'SELECT * FROM `category` WHERE `id` =' . $categoryId;

        // exécuter notre requête
        $pdoStatement = $pdo->query($sql);

        // un seul résultat => fetchObject
        $category = $pdoStatement->fetchObject('App\Models\Category');

        // retourner le résultat
        return $category;
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table category
     *
     * @return Category[]
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `category`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Category');

        return $results;
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table category en fonction du HomeOrder
     *
     * @return Category[]
     */
    // public static function findAllByHomeOrder()
    // {
    //     $pdo = Database::getPDO();
    //     $sql = 'SELECT * FROM `category` ORDER BY `home_order';
    //     $pdoStatement = $pdo->query($sql);
    //     $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Category');

    //     return $results;
    // }

    /**
     * Récupérer les 5 catégories mises en avant sur la home
     *
     * @return Category[]
     */
    public static function findAllHomepage()
    {
        $pdo = Database::getPDO();
        $sql = '
            SELECT *
            FROM category
            WHERE home_order > 0
            ORDER BY home_order ASC
        ';
        $pdoStatement = $pdo->query($sql);
        $categories = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Category');

        return $categories;
    }

        
    /**
     * Insère une nouvelle catégorie
     * 
     * @return bool
     */
    public function insert()
    {
        $pdo = Database::getPDO();
        /* Requête préparée */

        // On crée une requête SQL avec des données paramétrables (plus de données qui viennent de l'utilisateur dans la requête !)
        $sql = "INSERT INTO category (name, subtitle, picture) VALUES (:name, :subtitle, :picture)";

        // On appelle la méthode prepare qui pré-compile la requête (uniquement cette requête qui sera exécutée)
        $pdoStatement = $pdo->prepare($sql);

        // La méthode execute prend un tableau en paramètre
        // Les clés correspondent aux paramètres de notre requête préparée (ci-dessus), les valeurs correspondent aux données du formulaire qui vont les remplacer
        $insertedRows = $pdoStatement->execute([
            'name' => $this->name,
            'subtitle' => $this->subtitle,
            'picture' => $this->picture
        ]);

        // S'il y a au-moins une ligne insérée
        if ($insertedRows > 0) {
            // On récupère le dernier id inséré
            // et on met à jour la propriété id de notre catégorie
            $this->id = $pdo->lastInsertId();

            // On indique que tout s'est bien déroulé
            return true;
        }

        // On renvoie false s'il ne s'est rien passé
        return false;
    }

/**
     * Modifie une catégorie existante
     *
     * @return bool
     */
    public function update()
    {
        $pdo = Database::getPDO();

        // Requête update (avec les paramètres de la requête préparée)
        $sql = "UPDATE category SET name = :name, subtitle = :subtitle, picture = :picture WHERE id = :id";

        $pdoStatement = $pdo->prepare($sql);

        // Exécution de la requête (avec les paramètres remplacés par les bonnes valeurs)
        // NB : Bien vérifier que le nombre d'éléments dans le tableau correspond au nombre de paramètres dans la requête
        $pdoStatement->execute([
            'name' => $this->name,
            'subtitle' => $this->subtitle,
            'picture' => $this->picture,
            'id' => $this->id
        ]);

        // On renvoie true si au-moins une ligne a été modifiée
        return $pdoStatement->rowCount() > 0;
    }

    public function delete()
    {
        
    }

    /** 
     * Mettre à jour le champ home_order dans la base de données
     * 
     * @return bool
     */
    public static function updateHomeOrder($id, $homeOrder)
    {
        $pdo = Database::getPDO();

        // Requête update qui modifie home_order seulement
        $sql = "UPDATE category SET home_order = :home_order WHERE id = :id";

        $pdoStatement = $pdo->prepare($sql);

        // Exécution de la requête (avec les paramètres remplacés par les bonnes valeurs)
        // NB : Bien vérifier que le nombre d'éléments dans le tableau correspond au nombre de paramètres dans la requête
        $pdoStatement->execute([
            'home_order' => $homeOrder,
            'id' => $id
        ]);

        // On renvoie true si au-moins une ligne a été modifiée
        return $pdoStatement->rowCount() > 0;
    }

    /**
     * On passe la valeur home_order des catégories à 0
     *
     * @return bool
     */
    public static function resetHomeOrder()
    {
        $pdo = Database::getPDO();

        // Requête update qui modifie home_order seulement
        $sql = "UPDATE category SET home_order = 0 WHERE home_order > 0";

        $rows = $pdo->exec($sql);

        // On renvoie true si au-moins une ligne a été modifiée
        return $rows > 0;
    }
}

