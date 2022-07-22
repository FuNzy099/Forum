<h1>Publier une question</h1>



<form action="index.php?ctrl=forum&action=addTopic&id=<?= $id ?>" method="post">
    <label for="title">Le titre de votre topic</label>
    <input type="text" name="title" required ><br><br>

    <label for="firstMessage">Description</label>
    <textarea name="firstMessage"  cols="30" rows="7" required></textarea> <br><br>

    <input type="submit" name="submit" value="Valider">
</form>



<?php
$title = "Formulaire création d'un topic";
// var_dump($id); 

    
?>

