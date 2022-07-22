<?php
// Namespace permet d'éviter les colisions entre deux éléments de même nom, les namespace seont chargé enssuite de manière automatique grace à un autoloding (qui ce trouve dans ce projet dans app/Autoloader.php)
namespace Model\Entities;

// Permet d'utiliser la classe Entity
use App\Entity;
use DateTime;

final class User extends Entity{

    private $id;
    private $pseudonyme;
    private $email;
    private $password;
    private $avatar;
    private $registrationDate;
    private $nbPosts;
    private $roles;

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



    // ----------------------------------- pseudonyme

    /**
     * Get the value of pseudonyme
     */ 
    public function getPseudonyme()
    {
        return $this->pseudonyme;
    }

    /**
     * Set the value of pseudonyme
     *
     * @return  self
     */ 
    public function setPseudonyme($pseudonyme)
    {
        $this->pseudonyme = $pseudonyme;

        return $this;
    }



    // ----------------------------------- email

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }



    // ----------------------------------- password

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

        /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }



    // ----------------------------------- avatar

       /**
     * Get the value of avatar
     */ 
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set the value of avatar
     *
     * @return  self
     */ 
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }


    
    // ----------------------------------- RegistrationDate

    /**
     * Get the value of registrationDate
     */ 
    public function getRegistrationDate()
    {
        $creationDate = $this -> registrationDate -> format("d/m/Y, H:i:s");
        return $creationDate;
    }

    /**
     * Set the value of registrationDate
     *
     * @return  self
     */ 
    public function setRegistrationDate($registrationDate)
    {
        $this -> registrationDate = new DateTime($registrationDate);
        return $this;
    }



    // ----------------------------------- role

    /**
     * Get the value of roles
     */ 
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set the value of roles
     *
     * @return  self
     */ 
    public function setRoles($roles)
    {
        $this->roles = json_decode($roles); // Récupère une chaîne encodée JSON et la convertit en une variable PHP.
        if(empty($this -> $roles)){
            $this -> $roles="ROLE_USER";
        }

        return $this;
    }

    public function hasRole($role){
        return in_array($role, $this -> getRoles()); //La fonction in_array() recherche dans un tableau une valeur spécifique. syntaxe => in_array(search, array, type(type est optionnel)) 
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

        
        return $this -> getId(). $this -> getPseudonyme(). $this -> getEmail(). $this -> getRegistrationDate();

    }



}