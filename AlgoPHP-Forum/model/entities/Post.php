<?php
// Namespace permet d'éviter les colisions entre deux éléments de même nom, les namespace seont chargé enssuite de manière automatique grace à un autoloding (qui ce trouve dans ce projet dans app/Autoloader.php)
namespace Model\Entities;

// Permet d'utiliser la classe Entity
use App\Entity;
use DateTime;

class Post extends Entity{

    private $id;
    private $user;
    private $topic;
    private $content;
    private $creationDate;

    public function __construct($data){

        $this -> hydrate($data); // Cette fonction hydrate($data) ce trouve dans app\Entity
        
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



    // ----------------------------------- topicId
    
    /**
     * Get the value of topic
     */ 
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * Set the value of topic
     *
     * @return  self
     */ 
    public function setTopic($topic)
    {
        $this->topic = $topic;

        return $this;
    }



    // ----------------------------------- Content

    /**
     * Get the value of content
     */ 
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @return  self
     */ 
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }



    // ----------------------------------- CreationDate

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



    // ----------------------------------- toString

    public function __toString(){

        return $this -> getId(). $this -> getContent(). $this -> getCreationDate();
        
    }
}



?>