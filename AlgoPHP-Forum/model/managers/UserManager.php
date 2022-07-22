<?php

namespace Model\Managers;

use app\Manager;
use app\DAO;

class UserManager extends Manager{

    protected $className = "Model\Entities\User";
    protected $tableName = "user";

    public function __construct()
    {
        
        parent::connect();


    }



    // Requette qui permet de récupérer toutes les informations de l'utilisateur

    public function findOneByPseudo($data){

        $sql = "SELECT u.id_user, u.pseudonyme, u.avatar, u.email, u.registrationDate, u.roles
        FROM ".$this->tableName." u
        WHERE u.pseudonyme = :pseudonyme
        ";

        return $this->getOneOrNullResult(
        DAO::select($sql, ['pseudonyme' => $data], false), 
        $this->className
        );

    }

    

    // requette qui permet de récupérer le mot de passe hashé de l'utilisateur dans la base de donnée dans le but de le comparer avec un verify_password lors de la connexion

    public function checkPass($pseudonyme){
        $sql = "SELECT u.password
        FROM ".$this->tableName." u
        WHERE u.pseudonyme = :pseudonyme
        ";

        return $this->getOneOrNullResult(
        DAO::select($sql, ['pseudonyme' => $pseudonyme], false), 
        $this->className
        );
    }



    // ----------------------------------- Requette qui permet de modifier le password de l'utilisateur

    public function requestModifyPassword($password, $idUser){

        
        // requette SQL pour modifier un message 
        $sql = "UPDATE ".$this -> tableName." u
                SET u.password = :password
                WHERE u.id_user = :idUser
                ";

                
        // Permer d'injecte dans la base de donnée les nouvelles valeurs
        return DAO::update($sql, [
                                ':password' => $password,
                                 ':idUser' => $idUser
                            ]);  
    }



    // ----------------------------------- Requette qui permet de modifier le profil de l'utilisateur (pseudo, email)

    public function requestModifyProfil($idUser, $pseudonyme, $email){

        $sql = "UPDATE ".$this -> tableName." u
                SET 	u.pseudonyme = :pseudonyme,
                        u.email = :email
                WHERE  u.id_user = :id
                ";

        return DAO::update($sql, [
                                ':id' => $idUser,
                                ':pseudonyme' => $pseudonyme,
                                ':email' => $email
                            ]);    
    }



    // ----------------------------------- Requette qui permet de modifier une photo de profil

    public function requestModifyAvatar($idUser, $avatar){

        $sql = "UPDATE ".$this -> tableName." u
                SET u.avatar = :avatar
                WHERE  u.id_user = :id
                ";

        return DAO::update($sql, [
                                ':id' => $idUser,
                                ':avatar' => $avatar
                            ]);        

  
    }



    // ----------------------------------- Function qui permet d'afficher le nombre de message posté par l'utilisateur

    public function requestNbPostByUser($id){

        $sql = "SELECT u.id_user, u.pseudonyme, u.email, u.avatar, u.roles, COUNT(p.id_post) AS nbPosts
                FROM ".$this -> tableName."  u
                LEFT JOIN post p ON p.user_id = u.id_user 
                WHERE u.id_user = :id
                GROUP BY u.id_user
                ";
    
                return $this->getMultipleResults(
                        DAO::select($sql, [':id' => $id]), 
                        $this->className
                );  
    }





}

?>