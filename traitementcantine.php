<?php
//on actualise la session
session_start();
// Désactiver le rapport d'erreurs
error_reporting(0);
//On vérifie qu'elle soit bien définie
if(empty($_SESSION['user']) || empty($_SESSION['password']))
{
    header('Location: index.php');
    exit();
}
$con=mysqli_connect("localhost", 'root', 'Toto123' ,"calandreta");
if(mysqli_connect_errno($con))
{
  echo "Erreur de connexion : ".mysqli_connect_error();
}
$user = $_SESSION['user'];
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

echo $annee;
echo $date_lundi;
echo $date_vendredi;
echo $week;

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
$sqlinsertweek = $con->query("INSERT INTO semaines (numéro, lundi, vendredi, annee) VALUES ('".$week."', '".$date_lundi."', '".$date_vendredi."', '".$annee."'");

/*===Partie semaine===*/
// Vérification si numéro de semaine existe
$sqlverifweek = $con->query("SELECT id_semaine FROM semaines WHERE numéro='".$week."' AND annee='".$annee."'");
$id_semaine = $sqlverifweek->fetch_row();
echo $id_semaine;
if (!isset($id_semaine)){
    //On stock son id dans une variable
    $id_semaine = $sqlverifweek->fetch_row();
    echo 'id semaine : '.$id_semaine[0];
} else {
    //On insere la date
    $sqlinsertweek = $con->query("INSERT INTO semaines(numéro, lundi, vendredi, annee) VALUES ('".$week."', '".$date_lundi."', '".$date_vendredi."', '".$annee."'");
    echo 'vide';
}

?>