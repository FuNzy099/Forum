

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./public/css/styleHome.css">
    <title>Document</title>
</head>


<body>

    <h1>Liste des categories</h1>

    <main>
     
        <?php 
        //! var_dump($_SESSION["user"]);
        $categories = $result["data"]["categories"];

        foreach($categories as $category){ 
                
                $id = $category -> getId(); // Permet de récuperer l'id de la categories à l'aide de la class Category.php dans model/entities
        ?>



    <section class="py-5 w-25" id="test">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <div class="col mb-5">
                        <div class="col mb-5">
                    <div class="card h-100 testaze">
                        <!-- Product image-->
                        <?php echo "<img class='card-img-top imageCateg' src='public/img/".$category -> getPicture()."'/>" ?>
                        <!-- Product details-->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <!--Topic name-->
                                <h5 class="fw-bolder"><?=$category -> getName()?><br></h5>
                                <!-- Product reviews-->
                                <div class="d-flex justify-content-center small text-warning mb-2">
                                    <div class="bi-star-fill"></div>
                                    <div class="bi-star-fill"></div>
                                    <div class="bi-star-fill"></div>
                                    <div class="bi-star-fill"></div>
                                    <div class="bi-star-fill"></div>
                                </div>
                                <!-- Product price-->
                                Nombre de topic : <?=$category->getNbTopics()?>
                            </div>
                        </div>
                        <!-- Product actions-->
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?=$id?>">Consulter</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

        
        
    <!-- Si l'user est un admin on affiche le boutton pour ajouter une catégorie  -->
    <?php } 
        if(app\Session::isAdmin()){
               
            echo '<a href="index.php?ctrl=forum&action=addCategory"><button>Ajouter une catégorie</button> </a> ';
      
        }

    ?>
    </main>
</body>
