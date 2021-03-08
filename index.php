<?php include_once "cd-includes/bdd.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<?php
// On include le header avec le chargement des css / scripts
$title = 'Home'; // Titre de la page
$active_link = 'home';
include_once "cd-includes/header.php";
// On include la barre de navigation public PC (mobile plus tard)
?>

<style>
.triangle{
 display : inline-block;
 height : 0;
 width : 0;
 border-right : 40px solid transparent;
 border-bottom : 40px solid green;
 color: white;
 font-size: 20px;
 padding-left: 8px;
 padding-top: 20px;
}
</style>

<body>
<div class="container d-flex flex-column justify-content-center">
    <div id="header" class="m-5">
        <div class="float-end">
            <h4>Nb d'inscrits  <?php 
                $query=$bdd->prepare('SELECT COUNT(*) AS total FROM inscriptions_db'); 
                $query->execute();
                $rep = $query->fetch();
                echo $rep["total"];
                ?>
            </h4>
        </div>
        <div class="mb-3 d-flex flex-row">
            <div class="d-flex flex-row w-75 justify-content-between">
                <img style="height:6vh;" src="media/Logo_EMLyon.jpg">
                <h1>Inscription au Projet Innovation</h1>
            </div>
        </div>
    </div>
    <div class="border rounded p-5 mb-5">
        <button class="btn btn-primary float-end mb-5" onclick="submit()">Envoyer</button>
        <h4 class="mb-5">Identité</h4>
        <p>Pour modifier votre inscription, il suffit de re-remplir vos informations avec le même nom et prénom (même orthographe)</p>
        <div class="mb-3 d-flex flex-row justify-content-center">
            <div class="input-group m-3">
                <label for="nom" class="input-group-text">Nom</label>
                <input type="text" class="form-control" id="nom" aria-describedby="emailHelp">
            </div>
            <div class="input-group m-3">
                <label for="prenom" class="input-group-text">Prénom</label>
                <input type="text" class="form-control" id="prenom">
            </div>
            <div class="input-group m-3">
                <label class="input-group-text" for="ecole">Ecole</label>
                <select class="form-select" id="ecole">
                    <option selected>Ecole</option>
                    <option value="1">CPE</option>
                    <option value="2">ISARA</option>
                    <option value="3">ITECH</option>
                    <option value="4">ESTP</option>
                    <option value="5">EMSE</option>
                    <option value="6">EM LYON</option>
                </select>
            </div>
        </div>

        <h4 class="mb-5">Projets</h4>
        <div class="d-flex flex-row justify-content-around flex-wrap mb-5">
            <div class="card mb-3" id="p1" style="width: 18rem;" onclick="select(this)">
                <img class="card-img-top" src="media/Blanchon.jpg" alt="Card image cap" height="200">
                <div class="card-body">
                    <h5 class="card-title">P1 - Blanchon</h5>
                    <p class="card-text">Quelle valorisation en fin de vie des produits du groupe Blanchon ?</p>
                </div>
            </div>
            <div class="card mb-3" id="p2" style="width: 18rem;" onclick="select(this)">
                <img class="card-img-top" src="media/Elkem.jpg" alt="Card image cap" height="200">
                <div class="card-body">
                    <h5 class="card-title">P2 - Elkem Silicones</h5>
                    <p class="card-text">Comment favoriser l’adhésion au projet d’économie circulaire de l’entreprise ?</p>
                </div>
            </div>
            <div class="card mb-3" id="p3" style="width: 18rem;" onclick="select(this)">
                <img class="card-img-top" src="media/Les_toques_blanches.jpg" alt="Card image cap" height="200">
                <div class="card-body">
                    <h5 class="card-title">P3 - Les Toques Blanches du Monde</h5>
                    <p class="card-text">Comment ré-enchanter l’expérience client en GMS (grandes et moyennes surfaces) ?</p>
                </div>
            </div>
            <div class="card mb-3" id="p4" style="width: 18rem;" onclick="select(this)">
                <img class="card-img-top" src="media/Givaudan.jpg" alt="Card image cap" height="200">
                <div class="card-body">
                    <h5 class="card-title">P4 - Givaudan</h5>
                    <p class="card-text">Comment réinventer la manière de tester un parfum demain ?</p>
                </div>
            </div>
            <div class="card mb-3" id="p5" style="width: 18rem;" onclick="select(this)">
                <img class="card-img-top" src="media/Chrysalead.jpg" alt="Card image cap" height="200">
                <div class="card-body">
                    <h5 class="card-title">P5 - Chrysalead</h5>
                    <p class="card-text">Comment la transformation des organisations, des hommes et du monde du travail invite le monde de l’aménagement tertiaire à se réinventer ?</p>
                </div>
            </div>
            <div class="card mb-3" id="p6" style="width: 18rem;" onclick="select(this)">
                <img class="card-img-top" src="media/Gamifly.jpg" alt="Card image cap" height="200">
                <div class="card-body">
                    <h5 class="card-title">P6 - Gamifly</h5>
                    <p class="card-text">Comment repenser l’expérience de fan grâce à l’Esport lors des JO 2024 ?</p>
                </div>
            </div>
            <div class="card mb-3" id="p7" style="width: 18rem;" onclick="select(this)">
                <img class="card-img-top" src="media/Sytral.jpg" alt="Card image cap" height="200">
                <div class="card-body">
                    <h5 class="card-title">P7 - Sytral</h5>
                    <p class="card-text">Comment gérer l'intermodalité entre les transports collectifs (TCL) et les mobilités alternatives (covoiturage, marche, vélo, trottinette…) ?</p>
                </div>
            </div>
            <div class="card mb-3" id="p8" style="width: 18rem;" onclick="select(this)">
                <img class="card-img-top" src="media/Chanel.jpg" alt="Card image cap" height="200">
                <div class="card-body">
                    <h5 class="card-title">P8 - Chanel</h5>
                    <p class="card-text">Une nouvelle forme de présentation pour le fond de teint fluide ?!</p>
                </div>
            </div>
            <div class="card mb-3" id="p9" style="width: 18rem;" onclick="select(this)">
                <img class="card-img-top" src="media/Effency.jpg" alt="Card image cap" height="200">
                <div class="card-body">
                    <h5 class="card-title">P9 - Effency</h5>
                    <p class="card-text">Le management à l’heure du travail à distance : quel équilibre entre digital et humain ?</p>
                </div>
            </div>
            <div class="card mb-3" id="p10" style="width: 18rem;" onclick="select(this)">
                <img class="card-img-top" src="media/Ninkasi.jpg" alt="Card image cap" height="200">
                <div class="card-body">
                    <h5 class="card-title">P10 - Ninkasi</h5>
                    <p class="card-text">Ninkasi Demain : Quelle nouvelle expérience utilisateur ? Quel nouveau type de point de vente ? Quel nouveau métier de service ?</p>
                </div>
            </div>
            <div class="card mb-3" id="p11" style="width: 18rem;" onclick="select(this)">
                <img class="card-img-top" src="media/Hexatrans.jpg" alt="Card image cap" height="200">
                <div class="card-body">
                    <h5 class="card-title">P11 - Hexatrans</h5>
                    <p class="card-text">Quels nouveaux services et usages pour le transport routier de marchandises (livraison de produits en B to B) et pour quels clients ?</p>
                </div>
            </div>
            <div class="card mb-3" id="p12" style="width: 18rem;" onclick="select(this)">
                <img class="card-img-top" src="media/Play_International.jpg" alt="Card image cap" height="200">
                <div class="card-body">
                    <h5 class="card-title">P12 - Play International</h5>
                    <p class="card-text">Comment développer des modèles innovants et des activités lucratives à partir de l’expertise développée sur les métiers traditionnels, non lucratifs,  de l’association ?</p>
                </div>
            </div>
            <div class="card mb-3" id="p13" style="width: 18rem;" onclick="select(this)">
                <img class="card-img-top" src="media/Foods_International.jpg" alt="Card image cap" height="200">
                <div class="card-body">
                    <h5 class="card-title">P13 - Foods International</h5>
                    <p class="card-text">Quels nouveaux concept et positionnement pour la marque Ovomaltine auprès des 11-20 ans ?</p>
                </div>
            </div>
            <div class="card mb-3" id="p14" style="width: 18rem;" onclick="select(this)">
                <img class="card-img-top" src="media/Metropole_du_Grand_Paris.jpg" alt="Card image cap" height="200">
                <div class="card-body">
                    <h5 class="card-title">P14 - Métropole du Grand Paris</h5>
                    <p class="card-text">Comment intégrer et sensibiliser à la pratique sportive dans les nouveaux projets de quartiers ?</p>
                </div>
            </div>
            <div class="card mb-3" id="p15" style="width: 18rem;" onclick="select(this)">
                <img class="card-img-top" src="media/Groupe_Seb.jpg" alt="Card image cap" height="200">
                <div class="card-body">
                    <h5 class="card-title">P15 - Groupe Seb</h5>
                    <p class="card-text">Comment faciliter l’organisation et la planification des repas à travers une offre de service internationale du groupe SEB ?</p>
                </div>
            </div>
            <div class="card mb-3" id="p16" style="width: 18rem;" onclick="select(this)">
                <img class="card-img-top" src="media/Manifesta.jpg" alt="Card image cap" height="200">
                <div class="card-body">
                    <h5 class="card-title">P16 - Manifesta</h5>
                    <p class="card-text">Comment réinventer la mission d’un lieu dédié à l’art contemporain auprès des entreprises et assurer son développement commercial et sa pérennité dans le contexte sanitaire actuel ? </p>
                </div>
            </div>
            <div class="card mb-3" id="p17" style="width: 18rem;" onclick="select(this)">
                <img class="card-img-top" src="media/Mobility.jpg" alt="Card image cap" height="200">
                <div class="card-body">
                    <h5 class="card-title">P17 - Mobility</h5>
                    <p class="card-text">Comment identifier les softskills de nos équipes pour ensuite réinventer le recrutement en fonction de nos recherches ? </p>
                </div>
            </div>
            <div class="card mb-3" id="p18" style="width: 18rem;" onclick="select(this)">
                <img class="card-img-top" src="media/Sotexpro.jpg" alt="Card image cap" height="200">
                <div class="card-body">
                    <h5 class="card-title">P18 - Sotexpro</h5>
                    <p class="card-text">Quel relai de croissance pour Sotexpro, l'activité spécialiste des textiles d'ameublement non feu ?</p>
                </div>
            </div>
            <div class="card mb-3" id="p19" style="width: 18rem;" onclick="select(this)">
                <img class="card-img-top" src="media/Wurth.jpg" alt="Card image cap" height="200">
                <div class="card-body">
                    <h5 class="card-title">P19 - Wurth</h5>
                    <p class="card-text">Comment définir et réduire l’impact carbone d’une commande Würth ?</p>
                </div>
            </div>
            <div class="card mb-3" id="p20" style="width: 18rem;" onclick="select(this)">
                <img class="card-img-top" src="media/Alstom.jpg" alt="Card image cap" height="200">
                <div class="card-body">
                    <h5 class="card-title">P20 - Alstom</h5>
                    <p class="card-text">Comment changer les esprits, les habitudes et les usages autour de l’occupation des espaces de travail pour envisager le bureau de demain tout en permettant aux employé de retrouver leur confort de travail au quotidien où qu’ils soient ?</p>
                </div>
            </div>
            <div class="card mb-3" id="p21" style="width: 18rem;" onclick="select(this)">
                <img class="card-img-top" src="media/Veolia.jpg" alt="Card image cap" height="200" >
                <div class="card-body">
                    <h5 class="card-title">P21 - Veolia</h5>
                    <p class="card-text">Quelles pistes d'innovation pour une tarification plus agile de l'eau ?</p>
                </div>
            </div>
            <div class="card mb-3" id="p22" style="width: 18rem;" onclick="select(this)">
                <img class="card-img-top" src="media/Paredes.jpg" alt="Card image cap" height="200">
                <div class="card-body">
                    <h5 class="card-title">P22 - Paredes</h5>
                    <p class="card-text">Hygiène professionnelle : comment valoriser objets connectés et data et quelle valeur pour le client ?</p>
                </div>
            </div>
        </div>
        <button class="btn btn-primary float-end mb-2" onclick="submit()">Envoyer</button>
    </div>
</div>
</body>

<?php include_once "cd-includes/footer.php"; ?>

<script>
    var compteur = 0;   
    var countDownDate = new Date("Mar 5, 2021 10:00:00").getTime(); //date de fin du compte à rebours
    var json = {};

    $(document).ready(function() { //pour le compte à rebours
        $( "#header" ).append("<div class='alert alert-warning' role='alert'> <p class='fs-3'>Il reste       <label id='countdown' class='fs-3'></label>      pour vous inscrire</p></div>");
        var now = new Date().getTime();
    });

    function select(element){ //permet d'afficher graphiquement que le projet element a été sélectionner.
        array = element.childNodes;
        if(array.length == 5 && compteur < 5){
            element.classList.toggle("border");
            element.classList.toggle("border-success");
            compteur++;
            var div = document.createElement("div");
            div.classList.add("triangle");
            div.id = "choice"+compteur;
            div.appendChild(document.createTextNode(compteur));
            div.style.zIndex = "2";
            element.appendChild(div);
            console.log($("#choice"+compteur).parent().attr('id'));
        } else if (compteur < 6 && array.length == 6){
            element.classList.toggle("border");
            element.classList.toggle("border-success");
            element.removeChild(element.lastChild);
            compteur--;
        }
        //à refaire (j'ai pas eu le temps), permet de renuméroter les projets sélectionné si on en désélectionne un.
        /*var index = 6; 
        for(var i = 1; i <= compteur + 1; i++){
            var parent = document.getElementById("choice"+i).parentNode;
            if(typeof parent != 'undefined'){
                if(i > index){
                    parent.removeChild(parent.lastChild);
                    var div = document.createElement("div");
                    div.classList.add("triangle");
                    div.id = "choice"+i-1;
                    div.appendChild(document.createTextNode(i-1));
                    div.style.zIndex = "2";
                    parent.appendChild(div);
                } else {
                    parent.removeChild(parent.lastChild);
                    var div = document.createElement("div");
                    div.classList.add("triangle");
                    div.id = "choice"+i;
                    div.appendChild(document.createTextNode(i));
                    div.style.zIndex = "2";
                    parent.appendChild(div);
                }
            } else {
                index = i;
            }
        }*/
    }

    var x = setInterval(function() { //compte à rebours (inutile)
        var now = new Date().getTime();
        var distance = countDownDate - now;
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        document.getElementById("countdown").innerHTML = days + "d " + hours + "h "
        + minutes + "m " + seconds + "s ";
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("countdown").innerHTML = "EXPIRED";
        }
    }, 1000);

    function toggleInscrits(){ //permet de masquer/afficher la liste des inscrits
        if($('#inscrits').is(":hidden")){
            $('#inscrits').show();
        } else {
            $('#inscrits').hide();
        }
    }

    function submit(){  //envoi des données dans la BDD permet une requête AJAX, alert si les champs sont pas remplis
        var state = 0;
        var lastname = $("#nom").val();
        if(lastname.localeCompare('') == 0){
            $("#nom").addClass("border-danger");
            state = 1;
        }
        var name = $("#prenom").val();
        if(name.localeCompare('') == 0){
            $("#prenom").addClass("border-danger");
            state = 1;
        }
        var school = $("#ecole").val();
        if(school.localeCompare('Ecole') == 0){
            $("#ecole").addClass("border-danger");
            state = 1;
        }

        if(compteur !=5){
            state = 1;
        }

        if (state == 1){
            $( "#header" ).append("<div class='alert alert-danger' role='alert'>Remplissez au moins Nom - Prénom - École et assurez vous d'avoir 5 choix</div>");
            return;
        }

        for(var i = 0;  i < 5; i++){
            var id = $("#choice"+(i+1)).parent().attr('id');
            id = id.split("p");
            id = id[1];
            json[i] = {project_id: id , choice_number: i};
        }

        json = JSON.stringify(json);
        $.ajax({
            type: "POST",
            url: 'cd-includes/ajax/inscription.php',
            data: 'lastname=' + lastname.toUpperCase() + '&name=' + name + '&school=' + school + '&choice=' + json,
            dataType : "html",
            success : function(code_html, statut){
                $( "#header" ).append("<div class='alert alert-success' role='alert'> Votre inscription a bien été prise en compte </div>");
            },
            error : function(resultat, statut, erreur){
                $( "#header" ).append("<div class='alert alert-danger' role='alert'>Votre inscription a eu un problème, contactez Grégoire DI FERRO sur Messenger</div>");
            },
        });
        json = {};
    }
</script>    