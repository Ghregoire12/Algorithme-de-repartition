<?php include_once "cd-includes/bdd.php";  

$nb_de_choix = 22;  //condition initiale.
$nb_max_par_projet = 4;
$score = 0; //permet d'avoir un temoin d'efficacité (ne fonctionne pas), plus c'est proche de 0, plus cela signifie que les gens ont leur premier choix (peut être rapporté sur le nombre d'étudiants placé pour avoir le choix moyen)
$niveau = 1; //de priorité, permet la comparaison avec ($choice_priority), on l'incrémente s'il n'y a plus le choix que de placer des étudiants de d'école déjà représenté


/*

Organisation des différents élements:

    Liste de Projets (array[nb_de_choix]) prenant des objets projet
    Liste d'étudiants, permet de récupérer des infos globales (comme le nb d'étudiant restant à placer) plus facilement
    ___________________________
    |        Projet           |
    |_________________________|
    |   ID                    | --> Permet de retrouver le numéro du projet (presque inutile car il correspond à l'indice dans la liste +1)
    |   Etudiants Potentiels  | --> Liste des indices des étudiants qui ont le projet dans leurs voeux 
    |   Etudiants Choisis     | --> Liste des indices des étudiants séléctionné sur le projet
    |   Projet Complet        | --> Temoin de remplissage du projet (initialiser à false et passe à true s'il y a 4 personnes sélectionnées)
    |_________________________|

    ___________________________ 
    |        Étudiant         |
    |_________________________|
    |   ID                    | --> ID de l'étudiant dans la BDD (nécessaire pour enregistrer les placements dans la BDD)
    |   ID de l'école         | --> ID de l'école (chiffre plutôt que String pour des comparaisons plus rapide dans le code)
    |   Liste des choix       | --> Liste (array[5]) prenant des objets choix
    |   Temoin de placement   | --> Initialisé à false, passe à true s'il est placé sur un projet
    |_________________________|


    Chaque étudiants fait 5 choix qui sont répertorié dans Liste des choix, l'objet choix est le suivant:
    ___________________________ 
    |        Choix            |
    |_________________________|
    |   ID du projet          | 
    |   N° du choix           | --> Donne une priorité
    |   Priorité du choix     | --> On l'incrémente si une personne de la même école à déjà été séléctionné sur le projet
    |_________________________|

Principe : 

L'objectif est de répartir les étudiants sur les 22 projets, en prenant en compte les écoles pour mixer les compétences au max
Pour cela, il faut prendre en compte que l'intérêt des projets ne sera pas forcément uniforme, certains font plus rever que d'autres.
Donc il est indispensable de traiter les projets les moins demandés en premier pour être sur de pouvoir les remplir.
Et si il n'y a plus de personnes d'autres écoles de dispo pour le remplir, on prend des étudiants de la même école demandeur sur le projet.
Cela permet aussi d'écremer au fur et à mesure les personnes intéréssées par les projets les plus demandé.


Reste à faire:

- Ajout des résultats dans la BDD.
- Revoir findBestFit pour augmenter son impartialité.
- Faire l'affichage via la BDD, sur une autre page.
- ...

*/


class choice { //descripteur de la classe choice                                 
    var $project_id;
    var $choice_number;
    var $choice_priority = 1;

    function __construct($project_id, $choice_number) //constructeur d'un choix, prend en paramêtre l'id du projet (NB[1:22]) et le numéro du choix (NB[0:4])
    {
        $this->project_id = $project_id;
        $this->choice_number = $choice_number;
    }

    function incPriority(){ //incrémente la priorité du choix sur le projet (rend donc l'étudiant parent du choix, moins prioritaire sur le projet)
        $this->choice_priority++;
    }
}

class student { //descripteur de la classe student 
    var $id;
    var $school_id;
    var $choices;
    var $placed = false;

    function __construct($school_id, $choices, $id) //constructeur 
    {
        $this->id = $id;
        $this->school_id = $school_id;
        $this->choices = $choices;
    }

    function placed(){  //actualise la valeur du temoin placed si l'étudiant se fait placé
        $this->placed = true;
    }

    function findChoiceNumber($project_id){ //permet de retrouver le n° du choix, pour donner un ordre de priorité
        for($i = 0; $i < 5; $i++){
            if ($this->choices[$i]->project_id == $project_id){
                return $i;
            }
        }
        return 5;
    }
} 


class project { //descripteur de la classe projet 
    var $id;
    var $students_pot = array();
    var $students = array();
    var $full = false;

    function __construct($id) //constructeur
    {
        $this->id = $id;
    }

    function addStudentPot($student_id) //ajoute l'indice de l'étudiant intéressé dans la liste des étudiants potentiels
    {
        $this->students_pot[] = $student_id;  //student_id est la position de l'étudiant dans la liste $list_students
    }

    function addStudent($list_students,$list_projects)    //séléction de l'étudiant puis placement dans la liste des étudiant du projet
    {
        if(!$this->full){ //si le projet n'est pas plein
            $student_id = $this->findBestFit($list_students); //on cherche l'étudiant qui a le plus haut niveau de priorité (le plus proche de 0)
            if($student_id == 1000){ //si l'indice est 1000 c'est qu'il n'y en a pas
                return false; //donc on ne peut pas en ajouter
            } else {    // sinon on le place
                $this->students[] = $student_id;    //ajout de son indice dans la liste des étudiants sélectionné sur le projet
                $list_students[$student_id]->placed();  //actualisation de son statut, il devient placé
                for($i = 0; $i < 5; $i++){  //on le supprime alors de toutes les listes d'étudiants potentiels dans lequel il apparait (des projets qu'il a choisit)
                    $proj_id = (int)$list_students[$student_id]->choices[$i]->project_id - 1;
                    $list_projects[$proj_id]->unsetStudent($student_id);
                }
                $score = $score + $list_students[$student_id]->findChoiceNumber($this->id); //temoin de performance (donne la distance par rapport à son premier choix) mais pas fonctionnel
                $students_nb = count($this->students_pot);    //le nombre d'étudiants potentiels restant 
                for($i = 0; $i < $students_nb; $i++){     //tous les étudiants intéresser par le même projet provenant de la même école voient leur priorité réduire sur ce projet (on incrémente la variable choice_priority du choix)
                    if($list_students[$this->students_pot[$i]]->school_id == $list_students[$student_id]->school_id){
                        $list_students[$this->students_pot[$i]]->choices[$list_students[$this->students_pot[$i]]->findChoiceNumber($this->id)]->incPriority();
                    }
                }
                if(count($this->students) == $nb_max_par_projet){ //si le projet est plein, on actualise son temoiin
                    $this->full = true;
                }
                return true;    //return true permet de temoigner qu'un étudiant à bien été placé.
            }
        } else {
            return false;  //si on arrive ici, c'est que le projet est plein, donc on ne peut placer personne.
        }
    }

    function unsetStudent($id){ //permet de supprimer un élément de la liste des étudiants potentiels
        unset($this->students_pot[array_search($id, $this->students_pot)]); //on le supprime (on supprime son indice)
        sort($this->students_pot); //on trie la liste pour ne pas laisser de trou dans les indices
    }

    function nbOfNPriorityChoices($n,$list_students){ //permet de récuperer le nb d'étudiants potentiels dont les écoles ne sont pas déjà représenté sur le projet
        $valRen = 0;
        for($i = 0; $i < count($this->students_pot); $i++){
            if($list_students[$this->students_pot[$i]]->choices[$list_students[$this->students_pot[$i]]->findChoiceNumber($this->id)]->choice_priority == $n){
                $valRen++;
            }
        }
        return $valRen;
    }

    function findBestFit($list_students){ //permet de trouver le premier étudiant qui à la priorité maximale. Peut être améliorer facilement 
        $id = 1000;                       //en placant les étudiants de priorité maximale dans une liste et en prendre un au hasard (manque d'impartialité pour le moment)
        $prio = 100;
        for($i = 0; $i < count($this->students_pot); $i++){
            $student_choice = $list_students[$this->students_pot[$i]]->choices[$list_students[$this->students_pot[$i]]->findChoiceNumber($this->id)];

            // FORMULE DETERMINANT LA PRIORIT2 EN FONCTION DU POIDS DES PARAMÈTRES

            $val = $student_choice->choice_number + ($student_choice->choice_priority)*5;
            if($val < $prio){
                $id = $this->students_pot[$i];
                $prio = $val;
            }
        }
        return $id;
    }
    
} 



/*---------------------------------------------- Travail hors classes-------------------------------------------------*/


function fillStudentList($bdd){ //Récupère les infos de tous les étudiants inscrits (BDD) et les répartis dans la liste d'étudiant 
    $list = array();
    $query=$bdd->prepare('SELECT * FROM inscriptions_db'); 
    $query->execute();
    while($rep = $query->fetch()){
        $listChoices = array();
        $json = json_decode($rep['inscription_choice']);
        for($i = 0; $i < 5; $i++){  //construit la liste des choix qui sont stocké dans la BDD sous le format JSON
            $listChoices[]=new choice($json->$i->project_id, $json->$i->choice_number);
        }
        $list[] = new student($rep['inscription_school'], $listChoices, $rep['inscription_id'] );
    }
    return $list;
}

$list_students = fillStudentList($bdd); //Liste de référence des étudiants

function fillProjectList($bdd,$nb_de_choix, $list_students){
    $list = array();
    $nb_students = count($list_students);   
    for($i = 0; $i < $nb_de_choix; $i++){   //on crée une liste des projets (ici 22 projets)
        $list[] = new project($i+1);
        for ($j = 0; $j < $nb_students; $j++){
            if($list_students[$j]->findChoiceNumber($i+1) != 5){  //on place les éléments intéressé par le projet dans la liste des étudiants potentiels
                $list[$i]->addStudentPot($j);
            }
        }
    }
    return $list;
}

$list_projects = fillProjectList($bdd, $nb_de_choix, $list_students); //Liste des projets 

function sortByMinDemand($list_projects, $niveau, $nb_de_choix, $list_students){ //permet de créer une liste des projets par ordre de demande, ne prends pas en compte les projets plein.
    $list = array();
    $listRen = array();
    for($i = 0; $i < $nb_de_choix; $i++){
        $list[] = $i;
    }
    for($i = 0; $i < $nb_de_choix; $i++){
        $id = 100;
        $min = 1000;
        for ($j = 0; $j < count($list); $j++){
            $val = $list_projects[$list[$j]]->nbOfNPriorityChoices($niveau, $list_students);
            if($val < $min && $val > 0){
                $id = $list[$j];
                $min = $val;
            }
        }
        if($id < 100){
            $listRen[] = $id;
            unset($list[array_search($id, $list)]);
            sort($list);
        }
    }
    if(count($listRen) == 0){
        $niveau ++;
    }
    return $listRen;
}














function numberOfUnplacedStudents($list_students){  //donne le nombre d'étudiants non placé
    $counter = count($list_students);

    $valRen = 0;
    for($i = 0; $i < $counter; $i++){
        if(!$list_students[$i]->placed){
            $valRen++;
        }
    }
    return $valRen;
}











/*-----------------------------------------------BOUCLE PRINCIPALE----------------------------------------------------------*/





while(numberOfUnplacedStudents($list_students) > 0){ //tant qu'il reste des étudiants à placer
    $sorted_list_projects = sortByMinDemand($list_projects, $niveau, $nb_de_choix, $list_students); //on crée une liste d'indices de projet dans l'ordre croissant de demandes
    $counter = 0; //counter pour arreter la boucle while suivante si on arrive pas à placer d'étudiants
    while($counter < count($sorted_list_projects) && !($list_projects[$sorted_list_projects[$counter]]->addStudent($list_students,$list_projects))){ //tant que le counter dépasse la taille de la liste d'indice
        $counter++;                                                                                                                                             //et tant qu'il n'y a pas d'étudiant placé.
    }   
}
?>




<!---------------------------------------------- AFFICHAGE DES RESULTATS --------------------------------------------------->







<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<?php
// On include le header avec le chargement des css / scripts
$title = 'Resultats'; // Titre de la page
include_once "cd-includes/header.php";
// On include la barre de navigation public PC (mobile plus tard)

?>
<body>
    <div class="container mt-2 mb-2">

        <a href="results.csv" class="button" download="repartition_projet_innovation.csv">Télécharger les résultats sous format csv</a>
        <h1>Score = <?php echo $score;?></h1>

        <table class="table">
            <thead>
                <tr>
                <th scope="col"># de projet</th>
                <th scope="col">Nom</th>
                <th scope="col">Prénom</th>
                <th scope="col">Ecole</th>
                </tr>
            </thead>
            <tbody>
    <?php 
    $nb_place = 0;
    $fp = fopen('results.csv', 'w');
    fputs($fp, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
    fputcsv($fp,array('PROJET', 'NOM','PRÉNOM', 'ÉCOLE'));
    for($i = 0; $i<count($list_projects); $i++){
        for($j = 0; $j< count($list_projects[$i]->students); $j++){
            $nb_place++;
            $query=$bdd->prepare('SELECT * FROM inscriptions_db WHERE inscription_id = :a'); 
            $query->execute(array(
                ':a' => $list_students[$list_projects[$i]->students[$j]]->id
            ));
            $rep = $query->fetch();
            echo "
            <tr>
                <th scope='row'>".$list_projects[$i]->id."</th>
                <td>".$rep['inscription_lastname']."</td>
                <td>".$rep['inscription_name']."</td>
            ";
            switch($rep['inscription_school']){
                case 1:
                    echo "<td>CPE</td>
                    </tr>";
                    fputcsv($fp,array($list_projects[$i]->id, $rep['inscription_lastname'], $rep['inscription_name'], 'CPE'));
                    break;
                case 2:
                    echo "<td>ISARA</td>
                    </tr>";
                    fputcsv($fp,array($list_projects[$i]->id, $rep['inscription_lastname'], $rep['inscription_name'], 'ISARA'));
                    break;
                case 3:
                    echo "<td>ITECH</td>
                    </tr>";
                    fputcsv($fp,array($list_projects[$i]->id, $rep['inscription_lastname'], $rep['inscription_name'], 'ITECH'));
                    break;
                case 4:
                    echo "<td>ESTP</td>
                    </tr>";
                    fputcsv($fp,array($list_projects[$i]->id, $rep['inscription_lastname'], $rep['inscription_name'], 'ESTP'));
                    break;
                case 5:
                    echo "<td>EMSE</td>
                    </tr>";
                    fputcsv($fp,array($list_projects[$i]->id, $rep['inscription_lastname'], $rep['inscription_name'], 'EMSE'));
                    break;
                case 6:
                    echo "<td>EM LYON</td>
                    </tr>";
                    fputcsv($fp,array($list_projects[$i]->id, $rep['inscription_lastname'], $rep['inscription_name'], 'EM LYON'));
                    break;
            }
        }
    }
    fclose($fp);
    
    ?>
            </tbody>
        </table>
        <?php echo "<p>Nombre de personnes placées : ".$nb_place."</p>"?>
    </div>
</body>

<?php include_once "cd-includes/footer.php"; ?>













