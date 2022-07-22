<h1> Modifier votre mot de passe </h1>

<form action="index.php?ctrl=security&action=modifyPassword" method="post" enctype="multipart">

    <label for="password">Saisissez votre nouveau mot de passe</label>
    <input type="password" name="password" required/>

    <label for="confirmPassword">Confirmer votre nouveau mot de pass</label>
    <input type="password" name="confirmPassword" required/>
    
    <button type="submit" name="submit">Valider</button>


</form>


<?php
    $title = "Modifier votre mot de passe";


?> 