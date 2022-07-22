<h1> Modifier votre message </h1>

<?php
    $post = $result["data"]["post"];
?>


<form action="index.php?ctrl=forum&action=updatePost&id=<?=$post -> getId()?>" method="post">

    
    <label for="content">Saisissez votre message</label>
    <textarea name="content" id="content" cols="30" rows="10"  ><?=$post -> getContent()?></textarea><br><br>

    <input type="submit" name="submit" >


</form>

<?php
    $title = "Modifier votre message";
?>