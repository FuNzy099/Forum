<?php

namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\CategoryManager;
use Model\Managers\PostManager;
use Model\Managers\TopicManager;
use Model\Managers\UserManager;

class SecurityController extends AbstractController implements ControllerInterface{

    public function index(){}


    //----------------------------------- Affiche la vue du formulaire d'inscription 

    public function registerForm(){

        return[
            "view" => VIEW_DIR."security/register.php",
            "data" => null
        ];

    }



    //----------------------------------- Function qui permet de s'inscrire au forum

    public function register(){

       if(!empty($_POST)){

            $nickname = filter_input(INPUT_POST, "pseudonyme", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            // $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS)
            // REGEX : expression reguliére : demander un tableau d'argument : //  minimum 8 et max 32 caractere avec minuscule/majuscules ainsi que des chiffres;
            $password = filter_input(INPUT_POST,'password',FILTER_VALIDATE_REGEXP,[ 
                "options"=> [ 
                    "regexp"=> '#[A-Za-z][A-Za-z0-9_]{7,32}$#'
                    ]
                ]); 
            $confirmPassword = filter_input(INPUT_POST, "confirmPassword", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL);
          
            if($nickname && $password && $email){
          
                if($password == $confirmPassword){
                   
                    $manager = new UserManager();
                    $user = $manager -> findOneByPseudo($nickname);
                    
                    if(!$user){
                      
                        $hash = password_hash($password, PASSWORD_DEFAULT);

                        if($manager -> add([
                            "pseudonyme" => $nickname,
                            "email" => $email,
                            "password" => $hash,
                            "roles" => json_encode(["ROLE_USER"]) //La fonction json_encode() est utilisée pour encoder une valeur au format JSON.
                        ])){

                            $this -> redirectTo("DEFAULT_CTRL", "Home");

                        }

                    }

                }
            } else {
                Session::addflash('error-1', 'Une erreur est survenue, veuillez réessayer !');
            }
        }
    }



    //----------------------------------- Affiche la vue du formulaire d'inscription 

    public function loginForm(){
        
        return[
            "view" => VIEW_DIR."security/login.php",
            "data" => null
        ];
    }



    //----------------------------------- Function qui permet de ce connecter au forum
    
    Public function login(){

        if(isset($_POST["submit"]) && !empty($_POST["pseudonyme"]) && !empty($_POST["password"])){

            //On filtre les données saisi par l'utilisateur avec un filter_input
            $pseudonyme = filter_input(INPUT_POST, "pseudonyme", FILTER_SANITIZE_FULL_SPECIAL_CHARS);  // Correspond au pseudonyme saisi par l'utilisateur à la connexion
            $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);      // Correspond au password saisi par l'utilisateur à la connexion

            // Si les données saisi sont filtrés on rentre dans le IF
            if($pseudonyme && $password){

                $manager = new UserManager();                               // Instanciation de UserManager
                $user = $manager -> findOneByPseudo($pseudonyme);           // On récupére findOneByPseudo dans la class UserManager.php
               
                // Si il y a un user on rentre dans le IF
                if($user){
                    
                    // var_dump($user);
                    // die;
                    
                    $passControle = $manager->checkPass($pseudonyme);       // On déclare $passeControle pour aller chercher la requette checkPass dans le UserManager
                    $hashedPassword = $passControle->getPassword();         // 
                    
                    //On verifie si l'empreinte numérique correspond au mot de passe saisi et si c'est le cas on mes l'utilisateur en session
                    if(password_verify($password, $hashedPassword)){
                        
                        $session = new Session();
                        
                        $user = $session -> setUser($user);
   
                        // $user = Session::setUser($pseudonyme); // :: => opérateur de porté
        
                        return[
                            $this -> redirectTo("DEFAULT_CTRL", "Home")
                            
                        ];
                    }
                    
                }
            }
        }

    }



    // ----------------------------------- Function qui permet de retirer l'user de la session (déconnecter)

    public function logout(){

        
        if(isset($_SESSION["user"])){                           // Si il hexiste un user en session

            unset($_SESSION["user"]);                           // On unset la session (détruit la variable) ce qui permet de retirer l'user de la session dans d'autre terme, le déconnecter

            $this -> redirectTo("DEFAULT_CTRL", "Home");       // Redirection vers le formulaire de connexion

        }
        
    }



    // ----------------------------------- Function qui permet de modifier le password de l'user

    public function modifyPassword(){
        
        if(isset($_POST["submit"])){
            
            $password = filter_input(INPUT_POST,'password',FILTER_VALIDATE_REGEXP,[ 
                "options"=> [ 
                    "regexp"=> '#[A-Za-z][A-Za-z0-9_]{7,32}$#'
                ]
            ]); 

            $confirmPassword = filter_input(INPUT_POST, "confirmPassword", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                
            

            // Si le password et $confirmPassword sont filtré et si le password et le confirmPassword sont identique
            if(($password && $confirmPassword) && ($password == $confirmPassword)){
                
                // On instancie UserManager
                $userManager = new UserManager();

                // Si il existe en session un user
                if(isset($_SESSION["user"])){
                
                    // On déclare $pseudonyme comme celui etant en session
                    $userSession = $_SESSION["user"];

                    $pseudonyme = $userSession -> getPseudonyme();
    
                    // On déclare $infoUser dans le but de récupérer les informations de l'user en session (pseudo, id) à l'aide de findOnByPseudo()
                    $infoUser = $userManager -> findOneByPseudo($pseudonyme);
    
                    // On déclare $idUser pour récupérer uniquement l'id de l'user en session
                    $idUser = $infoUser -> getId();
                
                    // On déclare $hash dans le but d'utiliser la function native de PHP password_hash ! Cette function aura pour but d'hasher le nouveau MDP
                    $hash = password_hash($password,PASSWORD_DEFAULT);
    
                    // On utiliser la function requestModifyPassword qui ce trouve dans le UserManager. Cette function mettra le nouveau MDP dans la base de donnée
                    $hash = $userManager -> requestModifyPassword($hash, $idUser);
    
                    // Permet de rediriger vers la liste des catégories du forum une fois le nouveau MDP enregistré dans la base de donnée
                    $this -> redirectTo("DEFAULT_CTRL", "Home");        
                }

            }  
        }

        return[
            "view" => VIEW_DIR."security/modifyPassword.php",
            "data" => [],
        ];
    }



    //----------------------------------- Function qui permet de modifier le profil (Pseudo, email) de l'user

    public function modifyProfil(){

        // Permet de récupérer toutes les infos de l'utilisateur en session
        $user = $_SESSION["user"];

        // On instancie UserManager();
        $userManager  = new UserManager();  

        // todo Partie pour modifier les information (pseudo, email) de l'user en session

        // Si il existe en session un user
        if(isset($_SESSION["user"])){

            $idUser = $user -> getId(); // On récupére l'id de l'user en session
            
            // Si il existe en methode post "submit"
            if(isset($_POST["submit"])){
                
                //On filtre pseudonyme et email
                $pseudonyme = filter_input(INPUT_POST, "pseudonyme", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
                $confirmEmail = filter_input(INPUT_POST, "confirmEmail", FILTER_VALIDATE_EMAIL);
                
                // Si pseudonyme ou email sont filtré et $email == $confirmEmail
                if(($pseudonyme || $email) && $email == $confirmEmail){
                    
                    // Si $email et $confirmEmail est different de vide
                    if(!empty($email && $confirmEmail)){

                        // Exécution de la requette  => requestModifyProfil qui ce trouve dans UserManager
                        $userManager -> requestModifyProfil($idUser, $pseudonyme, $email);

                        // Si l'éxecution de la requette => requestModifyprofil a eu lieu
                        if($userManager -> requestModifyProfil($idUser, $pseudonyme, $email)){

                            // On set $pseudonyme et/ou $email
                            $user -> setPseudonyme($pseudonyme);

                            $user -> setEmail($email);

                            // todo Partie pour modifier l'avatar de l'user en session

                            // Si il existe en methode post "avatar" qui est different de vide
                            if(!empty($_FILES["avatar"])){

                                $name = $_FILES["avatar"]["name"];
                                $tmpName = $_FILES["avatar"]["tmp_name"];
                                $size = $_FILES["avatar"]["size"];

                                // explode permets de découper une chaîne de caractère en plusieurs morceaux à partir d’un délimiteur ! exemple: explode(".", "image.jpg") 
                                // Ce qui nous donne un tableau avec 2 éléments, comme ceci [« image », « jpg »].
                                $tabExtension = explode('.',$name);

                                // strtolower => met en minuscule tout une chaine de caractère // end() => Recupere le dernier élément du tableau de explode à savoir jpg dans l'exemple
                                $extension = strtolower(end($tabExtension));

                                // Tableau des extenssions que l'on accepte !
                                $extensions = ["jpg", "png", "jpeg", "gif", "webp", "avif"];

                                // Taille max que lon accepte !
                                $maxSize = 400000;

                                if(in_array($extension, $extensions)){
                                    
                                    // todo demander a Stephane uniqID ou hash ?
                                    $uniqueName = md5(uniqid("", true));
                                    $file = $uniqueName.".".$extension;

                                    move_uploaded_file($tmpName, "./public/img/avatar/".$file);


                                    $userManager -> requestModifyAvatar($idUser, $file);

                                    if( $userManager -> requestModifyAvatar($idUser, $file)){
    
                                        $user -> setAvatar($file);

                                        $this -> redirectTo("DEFAULT_CTRL", "Home");
                                       
                                    }else {
                                        Session::addflash("error", "Une erreur inconnue s'est produite, veuillez réessayer !");
                                    }
                                }else {
                                    Session::addflash("error", "Le format de l'image n'est pas pris en compte, veuillez réessayer !");
                                }
                            }
                        }
                    }
                } else {
                    Session::addflash('error', 'Une erreur est survenue, veuillez réessayer !');
                }
            }
        } 

        $pseudonyme = $user -> getPseudonyme();

        return[
            "view" => VIEW_DIR."security/modifyProfil.php",
            "data" => ["user" => $userManager -> findOneByPseudo($pseudonyme)]
        ];
    } 



    public function addAvatar(){

    }
    
}



?>