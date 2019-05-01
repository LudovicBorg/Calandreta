<?php
//on actualise la session
session_start();
// Désactiver le rapport d'erreurs
// error_reporting(0);
//On vérifie qu'elle soit bien définie
if(empty($_SESSION['user']) || empty($_SESSION['password']))
{
    header('Location: index.php');
    exit();
}
$con=mysqli_connect('localhost', 'root', 'Toto123', 'calandreta');
if(mysqli_connect_errno($con))
{
  echo "Erreur de connexion : ".mysqli_connect_error();
}
$user = $_SESSION['user'];
?>


<?php
//Récupération des valeurs
$enfant = $_POST['nom_enfant'];
$week = $_POST['week'];
$date_lundi = $_POST['lundi'];
$date_vendredi = $_POST['vendredi'];
$lundi = $_POST['Lundi'];
$mardi = $_POST['Mardi'];
$jeudi = $_POST['Jeudi'];
$vendredi = $_POST['Vendredi'];
$annee = $_POST['annee'];

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
$sqlverifweek = $con->query("SELECT id_semaine FROM semaines WHERE numero='".$week."' AND annee='".$annee."'");
$id_semaine = $sqlverifweek->fetch_row();
// echo $id_semaine[0];
if (isset($id_semaine[0])){
    //On stock son id dans une variable
    $id_semaine = $id_semaine[0];
    // echo 'id semaine : '.$id_semaine;
} else {
    //On insere la date
$sqlinsertweek = ("INSERT INTO semaines (numero, lundi, vendredi, annee) VALUES ('$week', '$date_lundi', '$date_vendredi', '$annee')");
$reqinsertweek = mysqli_query($con, $sqlinsertweek) or die('Erreur SQL !<br>'.mysqli_error($con));
$sqlverifweek = $con->query("SELECT id_semaine FROM semaines WHERE numero='".$week."' AND annee='".$annee."'");
$id_semaine = $sqlverifweek->fetch_row();
$id_semaine = $id_semaine[0];
}
/*===Partie cantine===*/
// Récupération de l'id de l'enfant
$sqlid_enfant = $con->query("SELECT id_enfant FROM enfants WHERE prenom='".$enfant."'");
$id_enfant = $sqlid_enfant->fetch_row();
$id_enfant = $id_enfant[0];

// Vérification qu'il n'existe pas d'enregistrement pour cet enfant cette semaine
$sqlverifcantine = $con->query("SELECT id_cantine FROM cantine WHERE enfant='".$id_enfant."' AND semaine='".$id_semaine."'");
$reqverifcantine = $sqlverifcantine->fetch_row();
$enregistrementexite = $reqverifcantine[0];

if(empty($enregistrementexite)){
// Enregistrement de la cantine
$sqlinsertcantine = ("INSERT INTO cantine (lundi, mardi, jeudi, vendredi, enfant, semaine) VALUES ('$lundi', '$mardi', '$jeudi', '$vendredi', '$id_enfant', '$id_semaine')");
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
$sqlrecupparent = $con->query("SELECT parent1, parent2 FROM enfants WHERE id_enfant='".$id_enfant."'");
$reqrecupparent = $sqlrecupparent->fetch_all();
$parent1 = $reqrecupparent[0][0];
$parent2 = $reqrecupparent[0][1];
echo $parent1;
echo $parent2;
// Récupération du solde
$sqlsolde = $con->query("SELECT id_solde, montant FROM solde WHERE parent1='".$parent1."' OR parent2='".$parent2."'");
$reqsolde = $sqlsolde->fetch_all();
$id_solde = $reqsolde[0][0];
$montant = $reqsolde[0][1];
if($lundi == 'OUI'){
    $montant = $montant - 4;
    $sqlsoldeajour = $con->query("UPDATE solde SET montant = '".$montant."' WHERE id_solde='".$id_solde."'");
} if($mardi == 'OUI'){
    $montant = $montant - 4;
    $sqlsoldeajour = $con->query("UPDATE solde SET montant = '".$montant."' WHERE id_solde='".$id_solde."'");
} if($jeudi == 'OUI'){
    $montant = $montant - 4;
    $sqlsoldeajour = $con->query("UPDATE solde SET montant = '".$montant."' WHERE id_solde='".$id_solde."'");
} if($vendredi == 'OUI'){
    $montant = $montant - 4;
    $sqlsoldeajour = $con->query("UPDATE solde SET montant = '".$montant."' WHERE id_solde='".$id_solde."'");
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