<?php

namespace Model\Managers;

use app\Manager;
use app\DAO;

class CategoryManager extends Manager{

    protected $className = "Model\Entities\Category";
    protected $tableName = "category";



    // ----------------------------------- Function qui permet de ce connecter à la base de donnée

    public function __construct()
    {
        
        parent::connect();
    }



    // ----------------------------------- Function qui permet de récupérer dans la base de donnée toutes les catégories des topics


    public function findAllInTopicsByCategories(){

        //todo Pour lister les enregistrement de la table1 (category), même s’il n’y a pas de correspondance avec la table2(topic), il convient d’effectuer une requête SQL
        //todo en utilisant la syntaxe suivante. Si d'aventure on aurais fait la requette avec un INNER JOIN les catégories avec 0 topics ne serait pas affichées
        $sql = "SELECT c.id_category, c.name, c.picture, COUNT(t.category_id) AS nbTopics
                FROM " .$this ->tableName." c
                LEFT JOIN topic t ON c.id_category = t.category_id 
                GROUP BY c.id_category
        ";

        return  $this -> getMultipleResults(
                DAO::select($sql),
                $this -> className
        );
    }
}

?>