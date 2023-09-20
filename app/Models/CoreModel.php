<?php

namespace App\Models;

// Classe mère de tous les Models
// On centralise ici toutes les propriétés et méthodes utiles pour TOUS les Models
// On la déclare abstraite car elle n'a pas de raison d'être instanciée
abstract class CoreModel
{
    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $created_at;
    /**
     * @var string
     */
    protected $updated_at;


    /**
     * Get the value of id
     *
     * @return  int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of created_at
     *
     * @return  string
     */
    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }

    /**
     * Get the value of updated_at
     *
     * @return  string
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updated_at;
    }

    abstract public static function findAll();
    abstract public static function find($id);
    abstract public function insert();
    abstract public function update();
    abstract public function delete();

    /**
         * Ajoute ou modifie en fonction de si un id est présent
         *
         * @return bool
         */
    public function save()
    {
        if (empty($this->id)) {
            return $this->insert();
        } else {
            return $this->update();
        }

    }
}