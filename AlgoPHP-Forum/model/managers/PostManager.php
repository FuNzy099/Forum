<?php

namespace Model\Managers;

use app\Manager;
use app\DAO;

class PostManager extends Manager{

    protected $className = "Model\Entities\Post";
    protected $tableName = "post";


    // ----------------------------------- Function qui permet de ce connecter à la base de donnée

    public function __construct()
    {
        
        parent::connect();

    }



    // ----------------------------------- Function qui permet de récupérer dans la base de donnée tous les posts d'un topic

    public function findPostsByTopic($id){

        // Requette SQL pour récuper l'enssemble des donnée de la table post concernant un id
        $sql = "SELECT p.id_post, p.user_id, p.topic_id, p.content, p.creationDate
                FROM ".$this->tableName." p
                WHERE p.topic_id = :id
            ";
        
        // Permet de retourner plusieur ligne de résultat fetchAll() ce référer à la function Select() dans app/DAO.php    
        return $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]), 
            $this->className
        );  

    }

    

    // ----------------------------------- Function qui permet de modifier un message dans un topic

    public function updatePost($id, $content){

        // requette SQL pour modifier un message 
        $sql = "UPDATE ".$this ->tableName." p
                SET content = :content
                WHERE p.id_post = :id
            ";
         
        // Permer d'injecte dans la base de donnée les nouvelles valeurs
        return DAO::update($sql, [
                                ':id' => $id,
                                ':content' => $content
                            ]);  

                             

    }

  
    
    // ----------------------------------- Function qui permet d'afficher tous les posts d'un utilisateur dans sont profil

    public function requestShowPostByUser($id){

        $sql = "SELECT p.user_id, p.content, p.creationDate, p.id_post, u.id_user,u.pseudonyme
                FROM post p
                INNER JOIN user u ON p.user_id = u.id_user  
                WHERE p.user_id = $id
                ORDER BY p.creationDate DESC
                ";

                return $this->getMultipleResults(
                        DAO::select($sql, [':id' => $id]), 
                        $this->className
            );  
    }
}

?>