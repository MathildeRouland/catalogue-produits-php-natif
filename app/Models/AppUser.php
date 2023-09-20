<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class AppUser extends CoreModel
{
    /** @var string */
    private $email;

    /** @var string */
    private $password;

    /** @var string */
    private $firstname;

    /** @var string */
    private $lastname;

    /** @var string */
    private $role;

    /** @var int */
    private $status;

    

    /** 
     * Récupère un utilisateur à partir de son id
     * 
     * @return AppUser
     */
    public static function find($userId)
    {
        $pdo = Database::getPDO();

        $sql = '
      SELECT *
      FROM `app_user`
      WHERE id = :userId';

        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->execute([
            'userId' => $userId
        ]);

        $result = $pdoStatement->fetchObject('App\Models\AppUser');

        return $result;
    }

    public static function findAll()
    {
        $pdo = Database::getPDO();

        $sql = '
      SELECT *
      FROM `app_user`';

      $pdoStatement = $pdo->query($sql);
      $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\AppUser');

      return $results;
    }

    /** 
     * Récupère un utilisateur à partir de son email
     * 
     * @return AppUser
     */
    public static function findByEmail($email)
    {
        $pdo = Database::getPDO();

        $sql = '
      SELECT *
      FROM `app_user`
      WHERE email = :email';

        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->execute([
            'email' => $email
        ]);

        $result = $pdoStatement->fetchObject('App\Models\AppUser');

        return $result;
    }


    /**
     * Insère un nouvel utilisateur
     */
    public function insert()
    {
        $pdo = Database::getPDO();

        $sql = "
            INSERT INTO `app_user` (
              email,
              password,
              firstname,
              lastname,
              role,
              status
            )
            VALUES (
              :email,
              :password,
              :firstname,
              :lastname,
              :role,
              :status
            )
        ";

        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->execute([
            'email' => $this->email,
            'password' => $this->password,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'role' => $this->role,
            'status' => $this->status
        ]);

        if ($pdoStatement->rowCount() > 0) {
            // Mettre à jour l'id
            $this->id = $pdo->lastInsertId();

            return true;
        }

        return false;
    }


    public function update()
    {
    }


    public function delete()
    {
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }


    /**
     * Set the value of password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }


    /**
     * Get the value of firstname
     */
    public function getFirstname()
    {
        return $this->firstname;
    }


    /**
     * Set the value of firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }


    /**
     * Get the value of lastname
     */
    public function getLastname()
    {
        return $this->lastname;
    }


    /**
     * Set the value of lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }


    /**
     * Get the value of role
     */
    public function getRole()
    {
        return $this->role;
    }


    /**
     * Set the value of role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }


    /**
     * Get the value of status
     */
    public function getStatus()
    {
        return $this->status;
    }


    /**
     * Set the value of status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
}
