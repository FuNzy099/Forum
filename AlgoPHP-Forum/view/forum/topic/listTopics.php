 <link rel="stylesheet" href="public/css/styleAllList.css">
 <script src="https://kit.fontawesome.com/7d0ef989cc.js" crossorigin="anonymous"></script>

<body>
        <h1>Liste des topics</h1>
        <main>
               <?php

use Model\Entities\Topic;
use Model\Managers\TopicManager;

               echo 
               "<table class='table table-striped w-50 mx-auto text-center'",
                        "<thead>",
                                "<tr>",
                                       "<th scope='col'> Titre </th>",
                                       "<th scope='col'> Status </th>",
                                       "<th scope='col'> Nombre de message </th>",
                                       "<th scope='col'> Créateur </th>",
                                       "<th scope='col'> Posté le </th>";
                                        if(isset($_SESSION["user"])){
                                                echo "<th scope='col'> Action </th>";
                                        };
                                "</tr>";
                        "</thead>";
                        "<tbody>";
       
               $topics = $result["data"]["topics"];
       
               foreach($topics as $topic){
       
                       $id = $topic -> getId(); // Permet de récuperer l'id de la categories à l'aide de la class Category.php dans model/entities
                       $idUser = $topic -> getUser() -> getId();

                       echo 
                        "<tr>",
                                "<td><a href='index.php?ctrl=forum&action=listPostsByTopic&id=$id'>".$topic -> getTitle()."</a> </td>",
                                "<td>";
                                        if($topic -> getStatus() == 1){
                                                echo '<i class="fa-solid fa-lock-open" title="Ouvert"></i>';
                                        }else{
                                                echo '<i class="fa-solid fa-lock" title="Fermé"></i>';
                                        }
                                "</td>";
                                echo
                                "<td>".$topic -> getNbPosts()."</td>",
                                "<td> <a href='index.php?ctrl=forum&action=infosUser&id=$idUser'>".$topic -> getUser() -> getPseudonyme()."</a> </td>",
                                "<td>".$topic -> getCreationDate()."</td>";

                               // Si un utilisateur ce trouve en session
                                if(isset($_SESSION["user"])){

                                        // Permet de récupérer les infos de l'user en session
                                        $infoUser = $_SESSION["user"];

                                        // Permet de récupérer l'id de l'user en session
                                        $idUser = $infoUser -> getId();

                                        // Permet de récupérer l'id du topic a écrit le topic
                                        $idUserWriteTopic = $topic -> getUser() -> getId();
                                 
                                        
                                        // Si l'utilisateur en session est un admin
                                        if(app\Session::isAdmin()){

                                                echo
                                                "<td>
                                                        <a href='index.php?ctrl=forum&action=updateTopic&id=$id'>Modifier</a><br>
                                                        <a href='index.php?ctrl=forum&action=deleteTopic&id=$id'>supprimer</a><br>";
                                                        if($topic -> getStatus() == 1){
                                                                echo "<a href='index.php?ctrl=forum&action=lockTopic&id=$id'>Verrouiller</a>";

                                                        } else {
                                                                echo "<a href='index.php?ctrl=forum&action=unlockTopic&id=$id'>Déverrouiller</a>";
                                                        };
                                                echo "</td>";

                                        // Si l'id du créateur du topic est == à l'id de l'user en session
                                        }elseif((app\Session::getUser() -> getId()) == $idUserWriteTopic){

                                                echo
                                                "<td>
                                                        <a href='index.php?ctrl=forum&action=updateTopic&id=$id'>Modifier</a><br>";

                                                        
                                                        if($topic -> getStatus() == 1){
                                                                echo "<a href='index.php?ctrl=forum&action=lockTopic&id=$id'>Verrouiller</a>";
        
                                                        } else {
                                                                echo "<a href='index.php?ctrl=forum&action=unlockTopic&id=$id'>Déverrouiller</a>";
                                                        };
                                                echo "</td>";
                                     
                                        
                                        } 
                                }
                        "</tr>";
                        "</tbody>";
                "</table>";
               
               }
       
               $title = "Forum - Topic "; // Permet de mettre un titre dans l'onglet du navigateur
               ?>
              <?php 
              if(app\Session::getUser()){
        
                $id = $_GET["id"];
                ?>
                        <a href="index.php?ctrl=forum&action=addTopic&id=<?=$id?>"><button>Créer un topic</button></a>
                <?php
              }
              ?>


       </main>
</body>


<!-- Permet de récupérer l'id de la catégorie depuis l'URL dans le but de créer un bouton "créer un topic" lié à la catégorie-->
      




