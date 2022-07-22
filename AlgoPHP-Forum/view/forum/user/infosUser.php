<?php
use Model\Entities\User;
use Model\Managers\UserManager;
$title = "Information";


$infos = $result["data"]["user"];
$posts = $result["data"]["post"];
foreach($infos as $info){ 
?>

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="./public/css/styleInfosUser.css">
<div class="container">
<div class="profile-wrapper">
    <div class="profile-section-user">
        <div class="profile-cover-img"><img src="./public/img/fond.webp" alt=""></div>
        <div class="profile-info-brief p-3"><img src="./public/img/avatar/<?= $info -> getAvatar()?>" class="img-fluid user-profile-avatar"  alt="Photo de profil de l'utilisateur">
            <div class="text-center">
                <h5 class="text-uppercase mb-4"> <?= $info -> getPseudonyme()?> </h5>
                <!-- <p class="text-muted fz-base">I'm John Doe a web developer and software engineer. I studied computer science and software engineering.</p> -->
            </div>
        </div>
        <!-- /.profile-info-brief -->
        <hr class="m-0">
        <div class="hidden-sm-down">
            <hr class="m-0">
            <div class="profile-info-contact p-4">
                <h6 class="mb-3">Information</h6>
                
                <table class="table">

               
         
                    <tbody>
                        <!-- Affichage du numéro de l'identifiant de l'utilisateur  -->
                        <tr>
                            <td><strong>Identifiant:</strong></td>
                            <td>
                                <p class="text-muted mb-0"><?= $info -> getId() ?></p>
                            </td>
                        </tr>

                        <!-- Affichage de l'adresse email de l'utilisateur-->
                        <?php
                        $user = $_SESSION["user"];
                        $userEmail = $user -> getEmail();
                        if(app\Session::isAdmin() || $info -> getEmail() == $user -> getEmail()){
                        ?>
                            <tr>
                                <td><strong>Email :</strong></td>
                                <td>
                                    <p class="text-muted mb-0"><?= $info -> getEmail() ?></p>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>

                        <!-- Affichage du nombre total de post posté sur le forum de l'utilisateur -->
                        <tr>
                            <td><strong>Nombre de post :</strong></td>
                            <td>
                                <p class="text-muted mb-0"><?= $info -> getNbPosts() ?></p>
                            </td>
                        </tr>    
                    </tbody>

           
                </table>
            </div>
<?php
}
?>
            <!-- /.profile-info-contact -->
            <hr class="m-0">

            <!-- /.profile-info-general -->
            <hr class="m-0">
        </div>
        <!-- /.hidden-sm-down -->
    </div>
    <!-- /.profile-section-user -->
    <div class="profile-section-main">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs profile-tabs" role="tablist">
            <li class="nav-item "><a class="nav-link active" data-toggle="tab" href="#profile-overview" role="tab">Historique des posts</a></li>
        </ul>
        <!-- /.nav-tabs -->
        <!-- Tab panes -->
        <?php foreach($posts as $post ) { ?>
        <div class="tab-content profile-tabs-content">
            <div class="tab-pane active" id="profile-overview" role="tabpanel"> 
                <!-- /.post-editor -->
                <div class="stream-posts">
                    <div class="stream-post">
                        <div class="sp-author">
                            <!-- Affiche la photo de profil de l'utilisateur -->
                            <a href="#" class="sp-author-avatar"><img src="./public/img/avatar/<?= $info -> getAvatar()?>" alt="Photo de profil de l'utilisateur"></a>

                            <!-- Affiche le pseudonyme de l'utilisateur -->
                            <h6 class="sp-author-name"><?= $post->getUser()->getPseudonyme() ?></h6>
                        </div>
    
                        <div class="sp-content">
                            <!-- Permet d'afficheer la date de création du post -->
                            <div class="sp-info"><?= $post->getCreationDate() ?></div> 

                            <!-- Permet d'afficher le contenu du message -->
                            <p class="sp-paragraph mb-0"><?= $post->getContent() ?></p>
                        </div>
                      
                        <!-- /.sp-content -->
                    </div>
                    
                    <!-- /.stream-post -->
                </div>
                <!-- /.stream-posts -->
            </div>
        </div>
        <?php } ?>
        <!-- /.tab-content -->
    </div>
   
    <!-- /.profile-section-main -->
</div>
</div>

<?php
