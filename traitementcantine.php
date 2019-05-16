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
        echo "<script language=\"javascript\">";
        echo "alert('Cantine déjà prévue pour cet enfant sur cette semaine !')";
        echo "</script>";
        header('Refresh: 0.5; cantine.php');
        exit;
}

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

?>

<!DOCTYPE html>
<html>
<head>
    <?php include("architecture/head.html"); ?>
    <link href='CSS/cantine.css' rel='stylesheet' />
    <script src="js/demarrer_session.js" type="text/javascript"></script>
</head>
<body id="body">
    <br />
    <?php include("architecture/header.php"); ?>
        <div class="d-flex justify-content-center"> Enregistrement effectué.<br><br>Vous allez être redirigé vers la page cantine.
        </div>
    <?php header("refresh:1;url=cantine.php"); ?>
</body>
</html>
