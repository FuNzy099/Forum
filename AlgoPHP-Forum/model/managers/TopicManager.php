<?php

namespace Model\Managers;

use app\Manager;
use app\DAO;

class TopicManager extends Manager{

    protected $className = "Model\Entities\Topic";
    protected $tableName = "topic";

    public function __construct()
    {
        
        parent::connect();


    }



    // ----------------------------------- Function qui permet de récupérer dans la base de donnée tous les topics dans une catégorie

    public function requestFindTopicsByCategory($id){

        // Requette SQL pour récuper l'enssemble des donnée de la table post concernant un id
        $sql = "SELECT t.id_topic, t.title, t.creationDate , t.status, t.user_id, COUNT(p.topic_id) AS nbPosts
                FROM ".$this->tableName." t
                LEFT JOIN post p ON p.topic_id = t.id_topic
                WHERE t.category_id = :id
                GROUP BY t.id_topic
                ORDER BY t.creationDate DESC
            ";
            //   ORDER BY creationDate DESC
        // Permet de retourner plusieur ligne de résultat fetchAll() ce référer à la function Select() dans app/DAO.php    
        return $this->getMultipleResults(
            DAO::select($sql, [':id' => $id]), 
            $this->className
        );  

    }


     // ----------------------------------- Function qui permet de modifier le titre d'un topic

    public function updateTopic($id, $title){

        // requette SQL pour modifier un message 
        $sql = "UPDATE ".$this ->tableName." t
                SET title = :title
                WHERE t.id_topic = :id
            ";

        // Permer d'injecte dans la base de donnée les nouvelles valeurs
        return DAO::update($sql, [
                                ':id' => $id,
                                ':title' => $title
                            ]);  
    }



    // ----------------------------------- Function qui permet de verrouiller un topic

    public function requestLockTopic($id){

        $sql = "UPDATE ".$this -> tableName." t
                SET t.status = 0
                WHERE t.id_topic = :id
                ";

        return DAO::update($sql, [
                        ':id' => $id,
                ]);  
    } 



    // ----------------------------------- Function qui permet de déverrouiller un topic

    public function requestUnlockTopic($id){

        $sql = "UPDATE ".$this -> tableName." t
                SET t.status = 1
                WHERE t.id_topic = :id
                ";

        return DAO::update($sql, [
                        ':id' => $id,
                ]);  
    } 





}

?>