<h1> Modifier votre profil </h1>

<?php
    $user= $_SESSION['user'];

    $pseudonyme = $user -> getPseudonyme();

    $email = $user -> getEmail();

?>



<form action="index.php?ctrl=security&action=modifyProfil" method="post" enctype="multipart/form-data">

    <label for="pseudonyme">Saisissez votre nouveau pseudo</label>
    <input type="text" name="pseudonyme" value="<?=$pseudonyme?>"  />

    <label for="email">Confirmer votre nouveau Email</label>
    <input type="email" name="email" value="<?=$email?>"/>

    <label for="confirmEmail">Confirmer votre nouveauEmail</label>
    <input type="email" name="confirmEmail" value="<?=$email?>"/>

    <label for="avatar"> Choisissez votre avatar</label>
    <input type="file" name="avatar"/> <br>


    <button type="submit" name="submit">Valider</button>
</form>


<!-- <form action="index.php?ctrl=security&action=modifyAvatar" method="post" enctype="multipart"> 

    <label for="avatar"> Choisissez votre avatar</label>
    <input type="file" name="avatar"/> <br>

    <button type="submit" name="submit">Valider</button>

</form> -->


<?php
    $title = "Modifier votre profile";


?> 