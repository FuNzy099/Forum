
//!  A supprimer car la liste des catégories est afficher dans le home



<link rel="stylesheet" href="public/css/styleAllList.css">


<body>
        <h1>Liste des categories</h1>
        <main>
               <?php
       
               echo "<table class='table table-striped w-50 mx-auto text-center'",
                       "<thead>",
                               "<tr>",
                                       "<th scope='col'> Catégorie </th>",
                                       "<th scope='col'> Nombre de topic </th>",
                               "</tr>",
                       "</thead>",
                       "<tbody>";
       
               $categorys = $result["data"]["categorys"];
       
               foreach($categorys as $category){
       
                       $id = $category -> getId(); // Permet de récuperer l'id de la categories à l'aide de la class Category.php dans model/entities
                       
                       echo "<tr>",
                               "<td><a href='index.php?ctrl=forum&action=listTopicsByCategory&id=$id'>".$category -> getName()."<br> </a> </td>",
                               "<td></td>",
                       "</tr>";
                       "</tbody>";
                       "</table>";
               
               }
       
               $title = "Forum - categories "; // Permet de mettre un titre dans l'onglet du navigateur
               ?>
               
               <?php
               if(app\Session::isAdmin()){
               
                        echo '<a href="index.php?ctrl=forum&action=addCategory"><button>Ajouter une catégorie</button> </a> ';
               
               }
               ?>
       </main>
</body>










<!-- Boutton pour ajouter une catégorie -->



