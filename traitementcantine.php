<?php
include("architecture/connexion.php");
?>


<?php
//Récupération des valeurs
$id_enfant = $_POST['nom_enfant'];
$week = $_POST['week'];
$date_lundi = $_POST['lundi'];
$date_vendredi = $_POST['vendredi'];
$lundi = $_POST['Lundi'];
$mardi = $_POST['Mardi'];
$jeudi = $_POST['Jeudi'];
$vendredi = $_POST['Vendredi'];
$annee = $_POST['annee'];

// echo $enfant;

if (!isset($lundi)){
    $lundi="NON";
}
if (!isset ($mardi)){
    $mardi="NON";
} 
if (!isset ($jeudi)){
    $jeudi="NON";
} 
if (!isset ($vendredi)){
    $vendredi="NON";
} 

/*=====Requêtes=====*/
/*===Partie semaine===*/
// Vérification si numéro de semaine existe
$sqlverifweek = $con->query("SELECT id_semaine FROM 3il_semaines WHERE numero='".$week."' AND annee='".$annee."'");
$id_semaine = $sqlverifweek->fetch_row();
// echo $id_semaine[0];
if (isset($id_semaine[0])){
    //On stock son id dans une variable
    $id_semaine = $id_semaine[0];
    // echo 'id semaine : '.$id_semaine;
} else {
    //On insere la date
$sqlinsertweek = ("INSERT INTO 3il_semaines (numero, lundi, vendredi, annee) VALUES ('$week', '$date_lundi', '$date_vendredi', '$annee')");
$reqinsertweek = mysqli_query($con, $sqlinsertweek) or die('Erreur SQL !<br>'.mysqli_error($con));
$sqlverifweek = $con->query("SELECT id_semaine FROM 3il_semaines WHERE numero='".$week."' AND annee='".$annee."'");
$id_semaine = $sqlverifweek->fetch_row();
$id_semaine = $id_semaine[0];
}
/*===Partie cantine===*/
// Vérification qu'il n'existe pas d'enregistrement pour cet enfant cette semaine
$sqlverifcantine = $con->query("SELECT id_cantine FROM 3il_cantine WHERE enfant='".$id_enfant."' AND semaine='".$id_semaine."'");
$reqverifcantine = $sqlverifcantine->fetch_row();
$enregistrementexite = $reqverifcantine[0];

if(empty($enregistrementexite)){
// Enregistrement de la cantine
$sqlinsertcantine = ("INSERT INTO 3il_cantine (lundi, mardi, jeudi, vendredi, enfant, semaine) VALUES ('$lundi', '$mardi', '$jeudi', '$vendredi', '$id_enfant', '$id_semaine')");
$reqinsertcantine = mysqli_query($con, $sqlinsertcantine) or die('Erreur SQL !<br>'.mysqli_error($con));
} else {
    //On la semaine deja prevue
    $sqlsemaine_deja_prevue = $con->query("SELECT lundi, mardi, jeudi, vendredi FROM 3il_cantine WHERE enfant='".$id_enfant."' AND semaine='".$id_semaine."'");
    $reqsemaine_deja_prevue = $sqlsemaine_deja_prevue->fetch_row();
    // Récupération des parents de l'enfant
    $sqlrecupparent = $con->query("SELECT parent1, parent2 FROM 3il_enfants WHERE id_enfant='".$id_enfant."'");
    $reqrecupparent = $sqlrecupparent->fetch_all();
    $parent1 = $reqrecupparent[0][0];
    $parent2 = $reqrecupparent[0][1];
    // echo $parent1;
    // echo $parent2;
    // Récupération du prix du repas
    $sqlprix = $con->query("SELECT montant FROM 3il_montant_cantine");
    $prix = $sqlprix->fetch_row();
    $prix = $prix[0];
    // On récupère l'id union des parents
    $sqlunionid = $con->query("SELECT id_union FROM 3il_union_parents WHERE parent1='".$parent1."' AND parent2='".$parent2."' OR parent1='".$parent2."' AND parent2='".$parent1."'");
    $id_union = $sqlunionid->fetch_row();
    //On récupère le montant du solde
    $sqlsolde = $con->query("SELECT id_solde, montant FROM 3il_solde WHERE union_parents='".$id_union[0]."'");
    $reqsolde = $sqlsolde->fetch_all();
    $id_solde = $reqsolde[0][0];
    $montant = $reqsolde[0][1];
    //si un jour a ete prevu on crédite le compte
    $semaine_prevue_lundi = $reqsemaine_deja_prevue[0];
    $semaine_prevue_mardi = $reqsemaine_deja_prevue[1];
    $semaine_prevue_jeudi = $reqsemaine_deja_prevue[2];
    $semaine_prevue_vendredi = $reqsemaine_deja_prevue[3];
}

    if($semaine_prevue_lundi == 'OUI'){
    $montant = $montant + $prix;
    $sqlsoldeajour = $con->query("UPDATE 3il_solde SET montant = '".$montant."' WHERE id_solde='".$id_solde."'");
    } if($semaine_prevue_mardi  == 'OUI'){
    $montant = $montant + $prix;
    $sqlsoldeajour = $con->query("UPDATE 3il_solde SET montant = '".$montant."' WHERE id_solde='".$id_solde."'");
    } if($semaine_prevue_jeudi  == 'OUI'){
    $montant = $montant + $prix;
    $sqlsoldeajour = $con->query("UPDATE 3il_solde SET montant = '".$montant."' WHERE id_solde='".$id_solde."'");
    } if($semaine_prevue_vendredi  == 'OUI'){
    $montant = $montant + $prix;
    $sqlsoldeajour = $con->query("UPDATE 3il_solde SET montant = '".$montant."' WHERE id_solde='".$id_solde."'");
    }

    $sqlupdatecantine = ("UPDATE 3il_cantine SET lundi='$lundi', mardi='$mardi', jeudi='$jeudi', vendredi='$vendredi' WHERE enfant='$id_enfant' AND semaine='$id_semaine'");
    $requpdatecantine = mysqli_query($con, $sqlupdatecantine) or die('Erreur SQL !<br>'.mysqli_error($con));
        // echo "<script language=\"javascript\">";
        // echo "alert('Cantine déjà prévue pour cet enfant sur cette semaine !')";
        // echo "</script>";
        // header('Refresh: 0.5; cantine.php');
        // exit;


/*=====Partie Solde=====*/
// Récupération des parents de l'enfant
$sqlrecupparent = $con->query("SELECT parent1, parent2 FROM 3il_enfants WHERE id_enfant='".$id_enfant."'");
$reqrecupparent = $sqlrecupparent->fetch_all();
$parent1 = $reqrecupparent[0][0];
$parent2 = $reqrecupparent[0][1];
// echo $parent1;
// echo $parent2;
// Récupération du prix du repas
$sqlprix = $con->query("SELECT montant FROM 3il_montant_cantine");
$prix = $sqlprix->fetch_row();
$prix = $prix[0];
// On récupère l'id union des parents
$sqlunionid = $con->query("SELECT id_union FROM 3il_union_parents WHERE parent1='".$parent1."' AND parent2='".$parent2."' OR parent1='".$parent2."' AND parent2='".$parent1."'");
$id_union = $sqlunionid->fetch_row();
//On récupère le montant du solde
$sqlsolde = $con->query("SELECT id_solde, montant FROM 3il_solde WHERE union_parents='".$id_union[0]."'");
$reqsolde = $sqlsolde->fetch_all();
$id_solde = $reqsolde[0][0];
$montant = $reqsolde[0][1];
if($lundi == 'OUI'){
    $montant = $montant - $prix;
    $sqlsoldeajour = $con->query("UPDATE 3il_solde SET montant = '".$montant."' WHERE id_solde='".$id_solde."'");
} if($mardi == 'OUI'){
    $montant = $montant - $prix;
    $sqlsoldeajour = $con->query("UPDATE 3il_solde SET montant = '".$montant."' WHERE id_solde='".$id_solde."'");
} if($jeudi == 'OUI'){
    $montant = $montant - $prix;
    $sqlsoldeajour = $con->query("UPDATE 3il_solde SET montant = '".$montant."' WHERE id_solde='".$id_solde."'");
} if($vendredi == 'OUI'){
    $montant = $montant - $prix;
    $sqlsoldeajour = $con->query("UPDATE 3il_solde SET montant = '".$montant."' WHERE id_solde='".$id_solde."'");
}

//Pour la partie historique
//Insertion de la date ou recupération de l'id
$date2 = date('m-Y');
$sql_mois = $con->query("SELECT id_mois_annee FROM 3il_mois_annee WHERE mois_annee = '".$date2."'");
$req_mois = $sql_mois->fetch_row();
if (empty($req_mois[0])){
    $sqlinsert_mois = $con->query("INSERT INTO 3il_mois_annee (mois_annee) VALUES ('$date2')");
    $sql_mois = $con->query("SELECT id_mois_annee FROM 3il_mois_annee WHERE mois_annee = '".$date2."'");
    $req_mois = $sql_mois->fetch_row();
}


    //Si un jour a deja été prevu on soustrait le prix du repas sur le montant pour l'historique
    $sql_solde_historique = $con->query("SELECT id_solde_historique, montant FROM 3il_soldes_historique WHERE union_parents='$id_union[0]' AND mois='$req_mois[0]'");
    $req_solde_historique = $sql_solde_historique->fetch_all();
    // echo $req_solde_historique[0][0];
    // echo $req_solde_historique[0][1];
    $montant2 = $req_solde_historique[0][1];
    //Pour historique
    if($lundi == "NON" AND $semaine_prevue_lundi == "OUI"){
        $montant2 = $montant2 - $prix;
        $sqlmontant2 = $con->query("UPDATE 3il_soldes_historique SET montant = '".$montant2."' WHERE id_solde_historique='".$req_solde_historique[0][0]."'");
    } if ($mardi == "NON" AND $semaine_prevue_mardi == "OUI"){
        $montant2 = $montant2 - $prix;
        $sqlmontant2 = $con->query("UPDATE 3il_soldes_historique SET montant = '".$montant2."' WHERE id_solde_historique='".$req_solde_historique[0][0]."'");
    } if ($jeudi == "NON"  AND $semaine_prevue_jeudi == "OUI"){
        $montant2 = $montant2 - $prix;
        $sqlmontant2 = $con->query("UPDATE 3il_soldes_historique SET montant = '".$montant2."' WHERE id_solde_historique='".$req_solde_historique[0][0]."'");
    } if ($vendredi == "NON"  AND $semaine_prevue_vendredi == "OUI"){
        $montant2 = $montant2 - $prix;
        $sqlmontant2 = $con->query("UPDATE 3il_soldes_historique SET montant = '".$montant2."' WHERE id_solde_historique='".$req_solde_historique[0][0]."'");
    }



//Partie historique du solde

//Insertion du solde ou mise a jour du solde
$sql_mise_a_jour_solde_mois = $con->query("SELECT id_solde_historique FROM 3il_soldes_historique WHERE mois='$req_mois[0]' AND union_parents='$id_union[0]'");
$req_mise_a_jour_solde = $sql_mise_a_jour_solde_mois->fetch_row();
if (empty($req_mise_a_jour_solde)){
    $sqlinsert_solde_mois = $con->query("INSERT INTO 3il_soldes_historique (mois, montant, union_parents) VALUES ('".$req_mois[0]."', '0', '".$id_union[0]."')");
}
    $sql_id_solde_mis_a_jour = $con->query("SELECT id_solde_historique, montant FROM 3il_soldes_historique WHERE mois='$req_mois[0]' AND union_parents='$id_union[0]'");
    $req_id_solde_mis_a_jour = $sql_id_solde_mis_a_jour->fetch_all();
    $montant3 = $req_id_solde_mis_a_jour[0][1];
if($lundi == 'OUI'){
    $montant3 = $montant3 + $prix;
    $sqlsoldeajour = $con->query("UPDATE 3il_soldes_historique SET montant = '".$montant3."' WHERE id_solde_historique ='".$req_id_solde_mis_a_jour[0][0]."'");
} if($mardi == 'OUI'){
    $montant3 = $montant3 + $prix;
    $sqlsoldeajour = $con->query("UPDATE 3il_soldes_historique SET montant = '".$montant3."' WHERE id_solde_historique ='".$req_id_solde_mis_a_jour[0][0]."'");
} if($jeudi == 'OUI'){
    $montant3 = $montant3 + $prix;
    $sqlsoldeajour = $con->query("UPDATE 3il_soldes_historique SET montant = '".$montant3."' WHERE id_solde_historique ='".$req_id_solde_mis_a_jour[0][0]."'");
} if($vendredi == 'OUI'){
    $montant3 = $montant3 + $prix;
    $sqlsoldeajour = $con->query("UPDATE 3il_soldes_historique SET montant = '".$montant3."' WHERE id_solde_historique ='".$req_id_solde_mis_a_jour[0][0]."'");
}

?>

<!DOCTYPE html>
<html>
<head>
    <?php include("architecture/head.html"); ?>
    <link href='CSS/cantine.css' rel='stylesheet' />
    <script src="js/demarrer_session.js" type="text/javascript"></script>
</head>
<body id="body">
    <?php include("architecture/header.php"); ?>
    <br />
        <div class="d-flex justify-content-center"> Enregistrement effectué.<br><br>Vous allez être redirigé vers la page repas.
        </div>
    <?php  header("refresh:1;url=cantine.php"); ?>
</body>
</html>
