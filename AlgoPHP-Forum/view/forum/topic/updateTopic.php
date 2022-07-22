<h1> Modifier votre titre de topic </h1>

<?php
    $topic = $result["data"]["topic"];
?>


<form action="index.php?ctrl=forum&action=updateTopic&id=<?=$topic -> getId()?>" method="post">

    
    <label for="title">Saisissez votre titre</label>
    <textarea name="title" id="title" cols="30" rows="10"  ><?=$topic -> getTitle()?></textarea><br><br>

    <input type="submit" name="submit" >


</form>

<?php
    $title = "Modifier votre titre";
?>



<!-- <input type="text" name="title" required ><br><br> -->