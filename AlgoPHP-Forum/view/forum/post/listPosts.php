<?php  $title = "Forum - Messages "?> <!-- Permet de mettre un titre dans l'onglet du navigateur  -->

<link rel="stylesheet" href="./public/css/stylePost.css">
<body>
    <h1>Liste des messages</h1>
    <main>

        <?php
            $listPost = $result["data"]["posts"];
            foreach($listPost as $post){
                $idPost = $post -> getId();    
                                
                $idUser = $post -> getUser() -> getId();
        ?>
             
            <div class="row d-flex justify-content-center mt-100 mb-100">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="comment-widgets">
                            <!-- Comment Row -->
                            <div class="d-flex flex-row comment-row m-t-0">
                                <div class="avatar-container">
                                        <img src="./public/img/avatar/<?= $post -> getUser() -> getAvatar()?>" alt="Photo de profil de l'utilisateur" width="50" >
                                </div>
                                <div class="comment-text">
                                    <h6 class="font-medium"><?=$post -> getUser() -> getPseudonyme()?></h6> 
                                    <span class="m-b-15 d-block"><?=$post -> getContent()?></span>
                                        <div class="comment-footer"> 
                                            <?php
                                            if(isset($_SESSION["user"])){
                        
                                                // Permet de récupérer les infos de l'user en session
                                                $infoUser = $_SESSION["user"];

                                                // Permet de récupérer l'id de l'user en session
                                                $idUser = $infoUser -> getId();                       
                                                
                                                // Permet de récupérer l'id de l'user qui a ecrit le post
                                                $idUserWritePost = $post -> getUser() -> getId();     

                                                // Si l'utilisateur en session est un admin
                                                if((app\Session::isAdmin())){

                                                ?>
                                                    <a href="index.php?ctrl=forum&action=updatePost&id=<?=$idPost?>"><button type="button" class="btn btn-cyan btn-sm">Modifier</button></a>
                                                    <a href="index.php?ctrl=forum&action=deletePost&id=<?=$idPost?>"><button type="button" class="btn btn-danger btn-sm">Supprimer</button></a>
                                                <?php
                                            

                                                // Si l'id du créateur du post est == à l'id de l'utilisateur en session
                                                }else if((app\Session::getUser() -> getId()) == $idUserWritePost ){

                                                    ?>
                                                    <a href="index.php?ctrl=forum&action=updatePost&id=<?=$idPost?>"><button type="button" class="btn btn-cyan btn-sm">Modifier</button></a>
                                                    <?php
                                                        
                                                } 
                                                    
                                            }
                                            ?>
                                            <span class="text-muted float-right"><?=$post -> getCreationDate()?></span> 

                                        </div>
                                </div>
                            </div> <!-- Comment Row -->
                        </div><hr> <!-- Card -->
                    </div>
                </div>
            </div>
        <?php } ?>
        
        <?php 

        // todo formulaire d'envoi d'une réponse à un topic
        // Si il y a un utilisateur en session on lui offre la possibilité de poster un message dans le topic 
        if(app\Session::getUser()){ 

            // Si le status du post est égale à 1 l'utilisateur peut poster un message
            if($post -> getTopic() -> getStatus() == 1){ ?>

            <div class="col-md-offset-3 col-md-6 col-xs-12 form">
        
                <form action="index.php?ctrl=forum&action=addPost&id=<?=$id?>" method="post">
                
                        <textarea name="content" class="form-control" placeholder="Vous voulez réagire à ce topic ? Postez donc un message"></textarea>

                        <input type="submit" name="submit" value="valider" class='btn btn-primary btn-xs'>
                </form>

            </div>
            
            <?php
            // Sinon on affiche un message pour informer que le topic est fermé
            }else{
                ?>
                <div class="topicClosed">
                        <p> Le topic est fermé, vous ne pouvez pas poster de nouveau message !</p>
                </div>
                <?php
            }
        }
        ?>

    </main>
</body>