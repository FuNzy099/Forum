<?php
// Namespace permet d'éviter les colisions entre deux éléments de même nom, les namespace seont chargé enssuite de manière automatique grace à un autoloding (qui ce trouve dans ce projet dans app/Autoloader.php)
namespace Controller;

// DAO => Data Access Objects, permet de ce connecter à la base de donnée et d'y faire des requettes,
// le controller communiquera avec lui et transmettra les informations recus a la view.

use App\AbstractController;
use App\ControllerInterface;
Use App\Session;
use Model\Entities\Category;
use Model\Entities\User;
use Model\Managers\CategoryManager;
use Model\Managers\PostManager;
use Model\Managers\TopicManager;
use Model\Managers\UserManager;


// implements => permet de déclarer à la class ForumController qu'elle doit avoir les méthodes de ControllerInterface (index()) c'est ce qu'on apelle le polymorphisme
class ForumController extends AbstractController implements ControllerInterface{

    public function index(){
        
        
    }



    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ FONCTION LIST

    //----------------------------------- Fonction qui permet d'afficher la liste des topics sur le forum

    public function listTopics(){

        $topicManager = new TopicManager; // instanciation de la class TopicManager qui ce trouve dans model/manager
        
        return [
            "view" => VIEW_DIR."forum/listTopics.php", // VIEW_DIRE indique la direction de la view
            "data" => ["topics" => $topicManager -> findAll(["creationDate", "DESC"])]
        ];

    }



    //----------------------------------- Fonction qui permet d'afficher la liste des messages au sein du topic
    
    public function listPostsByTopic($id){

        $postManager = new PostManager(); // instanciation de la class TopicManager qui ce trouve dans model/manager
        $topicManager = new TopicManager();
        // var_dump($id);
        // die;

        return [
            "view" => VIEW_DIR."forum/post/listPosts.php",
            "data" => [
                "posts" => $postManager -> findPostsByTopic($id),
                // "topics" => $topicManager -> requestFindTopicsByCategory($id)        
            ]
        ];

    }



    //----------------------------------- Fonction qui permet d'afficher la liste des topics dans une categorie

    public function listTopicsByCategory($id){

        $topicManager = new TopicManager;

        return [
            "view" => VIEW_DIR."forum/topic/listTopics.php",
            "data" => ["topics" => $topicManager -> requestFindTopicsByCategory($id) ]
        ];
        
    }



    //----------------------------------- Fonction qui permet d'afficher la liste des utilisateurs sur le forum
    
    public function listUsers(){

        $userManager = new UserManager;
        
        return [
            "view" => VIEW_DIR."forum/user/listUsers.php",
            "data" => ["users" => $userManager -> findAll([])]
        ];

    }


    //----------------------------------- Fonction qui permet d'afficher les infos d'un utilisateur

    public function infosUser($id){

        $userManager = new UserManager;
        $postManager = new PostManager();
        
        return [
            "view" => VIEW_DIR."forum/user/infosUser.php",
            "data" => [
                "user" => $userManager -> requestNbPostByUser($id),
                "post" => $postManager -> requestShowPostByUser($id)
        ]
            
            
        ];
    }

    
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ FONCTION ADD

    //----------------------------------- Fonction qui permet de créer une catégorie

    public function addCategory(){
        $this -> restrictTo("ROLE_ADMIN");
        $categoryManager = new CategoryManager();

        if (isset($_POST["submit"]) && !empty($_POST["name"])){

            $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $categoryManager -> add([
                                        "name" => $name,
                                    ]);

            $this -> redirectTo('DEFAULT_CTRL', 'Home');
        }

        return[
            "view" => VIEW_DIR."forum/category/addCategory.php",
        ];
    }



    //----------------------------------- Fonction qui permet de créer un topic dans une catégorie 

    public function addTopic($id){

        
        // $this -> restrictTo("ROLE_USER"); //todo: Permet d'autoriser uniquement les USER et ADMIN à poster un topic 
        
        // instanciation de TopicManager 
        $topicManager = new TopicManager();

        // Instanciation de PostManager
        $postManager = new PostManager();

        // instanciation de UserManager
        $userManager = new UserManager;
    
        if(isset($_POST["submit"])){

            $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // On déclare $infoUser dans le but de récupérer les informations de l'user en session
            $infoUser = $_SESSION["user"];

            // On déclare $idUser pour récupérer uniquement l'id de l'user en session
            $idUser = $infoUser -> getId();

            // Vue que j'ai instancier TopicManager qui extends lui même de Manager.php j'ai accès à la methode ADD qui ce trouve dans cette derniere
            $idTopic = $topicManager -> add([
                                    "title" => $title,
                                    "category_id" => $id,
                                    'user_id' => $idUser                           
                                ]);

            // On filtre content
            $content = htmlspecialchars($_POST["firstMessage"]);

            // Permet d'ajouter un post à la création d'un topic
            $postManager -> add([
                        "content" => $content,
                        "user_id" => $idUser,
                        "topic_id" => $idTopic
                    ]);

            // Une fois le formulaire validé une redirection s'effectue vers la liste des topics
            $this -> redirectTo("forum", "listTopicsByCategory", $id);              
        }

        return[
                "view" => VIEW_DIR."forum/topic/addTopic.php",
        ];

    }



    //----------------------------------- Fonction qui permet de créer un message dans un topic

    public function addPost($id){

        // instanciation de TopicManager 
        $postManager = new PostManager;

        // instanciation de UserManager
        $userManager = new UserManager;
        
        if(isset($_POST["submit"]) && !empty($_POST["content"])){

            // On filtre le message posté
            $content = htmlspecialchars($_POST["content"]);

            // On déclare $infoUser dans le but de récupérer les informations de l'user en session
            $infoUser = $_SESSION["user"];

            // On déclare $idUser pour récupérer uniquement l'id de l'user en session
            $idUser = $infoUser -> getId();

            $postManager -> add([
                                    "content" => $content,
                                    "topic_id" => $id,
                                    "user_id" => $idUser
                                ]);

            header("Location:index.php?ctrl=forum&action=listPostsByTopic&id=$id");
          
        }

    }



    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ FONCTION UPDATE

    //----------------------------------- Fonction qui permet de modifier un message dans un topic

    public function updateTopic($id){

        $topicManager = new TopicManager();

        $topic = $topicManager -> findOneById($id);

        if(isset($_POST["submit"])){

            $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $topicManager -> updateTopic($id, $title);

            header("Location:index.php?ctrl=forum&action=listTopics");

        }

        return[
            "view" => VIEW_DIR."forum/topic/updateTopic.php",
            "data" => ["topic" => $topic]
        ];

    }



    //----------------------------------- Fonction qui permet de modifier un message dans un topic

    public function updatePost($id){

        $postManager = new PostManager;
       
        // On déclare $post dans le but de faire du chainage pour récupérer la fonction findOneById qui ce trouve dans le Manager.php
        // $post est utilisé dans view/updatePost.php
        $post = $postManager -> findOneById($id);

        if(isset($_POST["submit"])){

            $content = filter_input(INPUT_POST,"content",FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $postManager -> updatePost($id, $content);

            header("Location:index.php?ctrl=forum&action=listPostsByTopic&id=".$post -> getTopic() -> getId());
        }

        return[
            "view" => VIEW_DIR."forum/post/updatePost.php",
            "data" => ["post" => $post]
        ];
    }



    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ FONCTION DELETE

    // ----------------------------------- Fonction qui permet de suprimer un message dans un topic

    public function deletePost($id){

        // Instanciation de PostManager qui nous permettra de ce connecter à la base de donnée et d'acceder à Manager.php
        $postManager = new PostManager();

        // On récupére la fonction findOneById($id) qui ce trouve dans le Manager.php
        $post = $postManager->findOneById($id);

        // On déclare idTopic dans le but de le mettre dans le lien de redirection
        $idTopic = $post -> getTopic() -> getId(); 

        // On récupére la fonction delete($id) qui ce trouve dans le Manager.php
        $postManager -> delete($id);

        // Redirection
        header("Location:index.php?ctrl=forum&action=listPostsByTopic&id=".$idTopic);
        die;

    }


    
    // ----------------------------------- Fonction qui permet de suprimer un topic

    public function deleteTopic($id){

        // Instanciation de TopicManager qui nous permettra de ce connecter à la base de donnée et d'acceder à Manager.php
        $topicManager = new TopicManager();

        // On récupére la fonction findOnById($id) qui ce trouve dans le Manager.php
        $topic = $topicManager -> findOneById($id);

        // On déclare idCatégory dans le but de le mettre dans le lien de redirection
        $idCategory = $topic -> getCategory() -> getId();

        // On récupére la fonction delete($id) qui ce trouve dans le Manager.php
        $topicManager -> delete($id);

        // Redirection
        header("Location:index.php?ctrl=forum&action=listTopicsByCategory&id=".$idCategory);
        die;

    }



    // ----------------------------------- Fonction qui permet de vérrouiller un topic

    public function lockTopic($id){


        // Instanciation de TopicManager qui nous permettra de ce connecter à la base de donnée et d'acceder à Manager.php
        $topicManager = new TopicManager();

        // On récupére la fonction findOnById($id) qui ce trouve dans le Manager.php
        $topic = $topicManager -> findOneById($id);

        // On déclare idTopic dans le but de récupérer l'id du topic pour l'utilisaer dans la fonction requestLockTopic
        $idTopic = $topic -> getId();
        
        // On utilise la fonction requestLockTopic qui ce trouve dans TopicManager
        $topicManager -> requestLockTopic($idTopic);

        // Redirection
        $idCategory = $topic -> getCategory() -> getId();

        header("Location:index.php?ctrl=forum&action=listTopicsByCategory&id=".$idCategory);
        die;
    }



    // ----------------------------------- Fonction qui permet de déverrouiller un topic

    public function unlockTopic($id){

        // Instanciation de TopicManager qui nous permettra de ce connecter à la base de donnée et d'acceder à Manager.php
        $topicManager = new TopicManager();

        // On récupére la fonction findOnById($id) qui ce trouve dans le Manager.php
        $topic = $topicManager -> findOneById($id);

        // On déclare idTopic dans le but de récupérer l'id du topic pour l'utilisaer dans la fonction requestLockTopic
        $idTopic = $topic -> getId();
        
        // On utilise la fonction requestLockTopic qui ce trouve dans TopicManager
        $topicManager -> requestUnlockTopic($idTopic);

        // Redirection
        $idCategory = $topic -> getCategory() -> getId();

        header("Location:index.php?ctrl=forum&action=listTopicsByCategory&id=".$idCategory);
        die;
    }




 



}