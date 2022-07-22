<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="public/css/styleLayout.css"> 
        <title> <?= $title ?> </title>
    </head>

    
    
    <body>
        <!-- <style> .avatar{
            vertical-align: middle;
            width: 70px;
            height: 70px;
            border-radius: 70%;
        }  -->
        </style>
        <header>
            <nav>
                <?php
                // Si il y a un user en session
                if(isset($_SESSION["user"])){
                    $user = $_SESSION["user"];
                    $idUser = $user -> getId();
                ?>
                    <div id="userSession">
                        <?php
                            $infoUser = $_SESSION["user"];
                            $nameUser = $infoUser -> getPseudonyme();   // On affiche le pseudo de l'user en session dans la nav
                            $avatarUser = $infoUser -> getAvatar();
                            echo '<img src="public/img/avatar/'.$infoUser -> getAvatar().'" class="avatar">';
                            echo $nameUser;
                        ?>
                    </div>

                    <div class="userSession">
                        <a href='index.php' class="linkHeaderNav">HOME</a>
                        
                        <!-- Menu dropdown du profil -->
                        <div class="dropdown">
                            <button class="dropbtn">Profil</button>
                            <div class="dropdown-content">
                                <a href='index.php?ctrl=forum&action=infosUser&id=<?= $idUser ?>' class="linkHeaderNav" id="deco">Afficher profil</a>
                                <a href='index.php?ctrl=security&action=modifyProfil' class="linkHeaderNav">Modifier profil</a>
                                <a href='index.php?ctrl=security&action=modifyPassword' class="linkHeaderNav" id="deco">Modifier password</a>
                            </div>
                        </div>

                        <?php 
                            // Si l'utilisateur à le role admin un onglet Dashboard s'affiche dans la nav 
                            if(app\Session::isAdmin()){
                                ?>
                                    <div class="dropdown">
                                        <button class="dropbtn">DashBoard</button>
                                        <div class="dropdown-content">
                                            <a href='index.php?ctrl=security&action=loginForm' class='linkHeaderNav'>DashBoard</a>
                                        </div>
                                    </div>
                                <?php
                            }
                        ?>
                        <a href='index.php?ctrl=security&action=logout' class="linkHeaderNav" id="deco">Déconnexion</a>
                    </div>
                    
                    <?php
                    //  Si personne est en session un onglet "Inscription", "Connexion" s'affiche dans la nav
                }else{
                    ?>
                    <div class="userSession">
                        <a href='index.php' class="linkHeaderNav">HOME</a>
                        <a href='index.php?ctrl=security&action=registerForm' class="linkHeaderNav">Inscription</a>
                        <a href='index.php?ctrl=security&action=loginForm' class="linkHeaderNav">Connexion</a>
                    </div>
                        
            </nav>
            <?php
                }
            ?>
        </header>

        <body>
            <?php
                if(isset($_SESSION['error'])){?>

                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Holy guacamole!</strong> <?= App\Session::getFlash('error')?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                

               <?php
                }?>
<?php
                if(isset($_SESSION['success'])){?>

                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Holy guacamole!</strong> <?= App\Session::getFlash('error')?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                

               <?php
                }?>

                
           
            <?= $page ?>
        </body>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>
</html>