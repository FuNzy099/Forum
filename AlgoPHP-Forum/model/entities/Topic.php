<?php
// Namespace permet d'éviter les colisions entre deux éléments de même nom, les namespace seont chargé enssuite de manière automatique grace à un autoloding (qui ce trouve dans ce projet dans app/Autoloader.php)
namespace Model\Entities;

// Permet d'utiliser la classe Entity
use App\Entity;
use DateTime;

final class Topic extends Entity{

    private $id;
    private $user;
    private $category;
    private $title;
    private $creationDate;
    private $status;
    private $nbPosts;

    public function __construct($data){
        
        $this -> hydrate($data); // Cette fonction hydrate($data) ce trouve dans app\Entity 

    }



    // -----------------------------------ID

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



    // ----------------------------------- userId

        /**
     * Get the value of user
     */ 
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the value of user
     *
     * @return  self
     */ 
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }



    // ----------------------------------- categoryId

        /**
     * Get the value of category
     */ 
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set the value of category
     *
     * @return  self
     */ 
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }



    // ----------------------------------- title

    /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }



    // ----------------------------------- creationDate

    /**
     * Get the value of creationDate
     */ 
    public function getCreationDate()
    {
        $formatDate = $this -> creationDate -> format("d/m/Y, H:i:s");
        return $formatDate;
    }

    /**
     * Set the value of creationDate
     *
     * @return  self
     */ 
    public function setCreationDate($creationDate)
    {
        $this -> creationDate = new DateTime($creationDate);
        return $this;
    }



    // ----------------------------------- status

    /**
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */ 
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }



    // ----------------------------------- nbPosts

        /**
     * Get the value of nbPosts
     */ 
    public function getNbPosts()
    {
        return $this->nbPosts;
    }

    /**
     * Set the value of nbPosts
     *
     * @return  self
     */ 
    public function setNbPosts($nbPosts)
    {
        $this->nbPosts = $nbPosts;

        return $this;
    }

    

    // ----------------------------------- toString

    public function __toString(){
        
        return $this -> getId(). $this -> getTitle(). $this -> getCreationDate(). $this -> getStatus();

    }
}

?>