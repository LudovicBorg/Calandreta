<?php
include("architecture/connexion.php");

$user = $_SESSION['user'];
//On récupère id utilisateur connecté
$sql0 = $con->query("SELECT id_user FROM 3il_utilisateurs WHERE email='".$user."'");
$req0 = $sql0->fetch_row();

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

	//Récupération de l'id classe
	$sqlidclasse = $con->query("SELECT id_classe FROM 3il_classe WHERE classe='".$classe."'");
	$id_classe = $sqlidclasse->fetch_row();
	$id_classe = $id_classe[0];

	//Requête d'intégration dans BDD
	$sqlinsertenfant = ("INSERT INTO 3il_enfants (nom, prenom, datenaissance, classe, parent1, parent2) VALUES ('$nom', '$prenom', '$datenaissance', '$id_classe', '$req0[0]', '$id_parent2')");
	//On envoie la requête
	$reqinsertenfant = mysqli_query($con, $sqlinsertenfant) or die('Erreur SQL !<br>'.mysqli_error($con));
	//On regarde si id de l'union existe sinon on l'insere
	$sqlidunion = $con->query("SELECT id_union FROM 3il_union_parents WHERE parent1='".$req0[0]."' AND parent2='".$id_parent2."' OR parent1='".$id_parent2."' AND parent2='".$req0[0]."'");
	$reqidunion = $sqlidunion->fetch_row();
	// echo $reqidunion[0];
	if(empty($reqidunion[0])){
		$sqlinsertunion = $con->query("INSERT INTO 3il_union_parents (parent1, parent2) VALUES ('$req0[0]', '$id_parent2')");
		$recupidunion = $con->query("SELECT id_union FROM 3il_union_parents WHERE parent1='$req0[0]' AND parent2='$id_parent2'");
		$id_union = $recupidunion->fetch_row();
		$id_union = $id_union[0];
		$sqlinsertsolde0 = $con->query("INSERT INTO 3il_solde (montant, union_parents) VALUES ('0', '$id_union')");
	} 
	//Récupération de l'id de l'enfant
	$sqlidenfant = $con->query("SELECT id_enfant FROM 3il_enfants WHERE nom='$nom' AND prenom='$prenom'");
	$id_enfant = $sqlidenfant->fetch_row();
	$id_enfant = $id_enfant[0];

	//On insert la semaine type
	$sqlinsertsemainetype = $con->query("INSERT INTO 3il_cantine_type (lundi, mardi, jeudi, vendredi, enfant) VALUES ('$lundi', '$mardi', '$jeudi', '$vendredi', '$id_enfant')");


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
    		<div class="d-flex justify-content-center"> Enfant ajouté !<br /><br />
    			Vous allez être redirigé vers la page de gestion vos enfants.<br /><br />
		</div>
	<?php header("refresh:1;url=enfants.php"); ?>