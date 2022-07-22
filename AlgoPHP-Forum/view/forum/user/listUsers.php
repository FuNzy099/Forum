<h1>Liste des utilisateurs du forum</h1>

<?php

    use Model\Entities\User;

    $users = $result["data"]["users"];

    foreach($users as $user){
        echo
        $user -> getId()." ) ",
        $user -> getPseudonyme()." <br> ",
        $user -> getEmail()." <br><br>";
   }



?>