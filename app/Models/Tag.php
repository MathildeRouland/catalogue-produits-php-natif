<?php

namespace App\Models;

use PDO;
use App\Utils\Database;
use App\Models\CoreModel;

/**
 * Représente la table SQL tag
 * et les enregistrements de cette table
 */

class Tag extends CoreModel
{
    /**
     * @var string Nom du tag
     */
    private $name;

    /**
     * Méthode permettant de récupérer un enregistrement de la table tag en fonction d'un id donné
     * 
     * @param int $tagId ID dutag
     * @return Tag
     */
    public static function find($tagId)
    {
        $pdo = Database::getPDO();
        $sql = '
            SELECT *
            FROM `tag`
            WHERE id = :id
        ';
        $pdoStatement = $pdo->prepare($sql);
        
        $success = $pdoStatement->execute([
            'id' => $tagId
        ]);

        if($success) {
            return $pdoStatement->fetchObject(self::class);
        }
        
        return false;
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table tag
     * 
     * @return Tag[]
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `tag`';
        $pdoStatement = $pdo->query($sql);
        return $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Tag');
    }

    /**
     * Récupère tous les tags d'un produit
     *
     * @param int $productId
     * @return Tag[]
     */
    public static function findByProduct($productId)
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT product.name, tag.name
        FROM product_has_tag
        INNER JOIN product ON product.id = product_has_tag.product_id
        INNER JOIN tag ON tag.id = product_has_tag.tag_id
        WHERE product.id = :productId';

        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->execute([
            'productId' => $productId
        ]);

        return $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Tag');
    } 

    public function insert()
    {
        //@TODO

    }

    public function update()
    {
        //@TODO
    }

    public function delete()
    {
        //@TODO
    }

    /**
     * Get nom du tag
     *
     * @return  string
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set nom du tag
     *
     * @param  string  $name  Nom du tag
     */ 
    public function setName(string $name)
    {
        $this->name = $name;
    }
}