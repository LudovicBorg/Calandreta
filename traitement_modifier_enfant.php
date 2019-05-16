<?php
include("architecture/connexion.php");

	$id_enfant = $_POST['id_enfant'];
	$nom = $_POST["nom"];
	$prenom = $_POST["prenom"];
	$datenaissance = $_POST["datenaissance"];
	$classe = $_POST["classe"];
	$id_parent2 = $_POST["parent2"];

	$lundi = $_POST['Lundi'];
	$mardi = $_POST['Mardi'];
	$jeudi = $_POST['Jeudi'];
	$vendredi = $_POST['Vendredi'];


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

//On récupere id du parent 2

//Mise a jour des données de l'enfant
	$sqlmiseajour_nom = $con->query("UPDATE 3il_enfants SET nom = '$nom' WHERE id_enfant='".$id_enfant."'");
	$sqlmiseajour_prenom = $con->query("UPDATE 3il_enfants SET prenom = '$prenom' WHERE id_enfant='".$id_enfant."'");
	$sqlmiseajour_datenaissance = $con->query("UPDATE 3il_enfants SET datenaissance = '$datenaissance' WHERE id_enfant='".$id_enfant."'");
	$sqlmiseajour_classe = $con->query("UPDATE 3il_enfants SET classe = '$classe' WHERE id_enfant='".$id_enfant."'");
	$sqlmiseajour_parent2 = $con->query("UPDATE 3il_enfants SET parent2 = '$id_parent2' WHERE id_enfant='".$id_enfant."'");


//Mise a jour des données de la semaine type
	$sqlmiseajoursemainetype_lundi = $con->query("UPDATE 3il_cantine_type SET lundi = '$lundi' WHERE enfant='".$id_enfant."'");
	$sqlmiseajoursemainetype_mardi = $con->query("UPDATE 3il_cantine_type SET mardi = '$mardi' WHERE enfant='".$id_enfant."'");
	$sqlmiseajoursemainetype_lundi = $con->query("UPDATE 3il_cantine_type SET jeudi = '$jeudi' WHERE enfant='".$id_enfant."'");
	$sqlmiseajoursemainetype_lundi = $con->query("UPDATE 3il_cantine_type SET vendredi = '$vendredi' WHERE enfant='".$id_enfant."'");

//Fermeture de la connexion
mysqli_close($con);
?>
<!DOCTYPE html>
<html>
<head>
    <?php include("architecture/head.html"); ?>
    <link href='CSS/enfants.css' rel='stylesheet' />
	<link rel="stylesheet" type="text/css" href="CSS/redirection.css">
</head>
<body id="body">
    <?php include("architecture/header.php"); ?>
    <br />
    		<div class="d-flex justify-content-center"> Enfant mit à jour !<br /><br />
    			Vous allez être redirigé vers la page de gestion vos enfants.<br /><br />
		</div>
	  <?php header("refresh:1;url=enfants.php"); ?>