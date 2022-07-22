<?php
// Namespace permet d'éviter les colisions entre deux éléments de même nom, les namespace seont chargé enssuite de manière automatique grace à un autoloding (qui ce trouve dans ce projet dans app/Autoloader.php)
namespace Model\Entities;

// Permet d'utiliser la class Entity
use App\Entity;

class Category extends Entity{

    private $id;
    private $name;
    private $picture;
    private $nbTopics;

    Public function __construct($data){

        $this -> hydrate($data);
        
    }

    // ----------------------------------- ID

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }  

    // ----------------------------------- Name

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    // ----------------------------------- ToString

    public function __toString()
    {
        return $this -> getName(). $this -> getId();
    }

    /**
     * Get the value of nbTopics
     */ 
    public function getNbTopics()
    {
        return $this->nbTopics;
    }

    /**
     * Set the value of nbTopics
     *
     * @return  self
     */ 
    public function setNbTopics($nbTopics)
    {
        $this->nbTopics = $nbTopics;

        return $this;
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
     *
     * @return  self
     */ 
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }
}


?>