<?php 
include_once "../bdd.php";

if(isset($_POST['lastname']) && isset($_POST['name'])){
    $query=$bdd->prepare('SELECT * FROM inscriptions_db WHERE inscription_lastname = :a AND inscription_name = :b'); 
    $query->execute(array(
        ':a' => $_POST['lastname'],
        ':b' => $_POST['name']
    ));
    $rep = $query->fetch();
    if(isset($rep['inscription_id'])){                              //modifier
        $query=$bdd->prepare('UPDATE inscriptions_db SET  inscription_school = :a , inscription_choice = :b WHERE inscription_id = :d'); 
        $query->execute(array(
            ':a' => $_POST['school'],
            ':b' => $_POST['choice'],
            ':d' => $rep['inscription_id']
        ));
    } else {                                                        //enregistrer
        $query=$bdd->prepare('INSERT INTO inscriptions_db (inscription_lastname, inscription_name, inscription_school, inscription_choice) VALUES ( :a, :b, :c, :d)'); 
        $query->execute(array(
            ':a' => $_POST['lastname'],
            ':b' => $_POST['name'],
            ':c' => $_POST['school'],
            ':d' => $_POST['choice']
        ));
    }
} 

?>