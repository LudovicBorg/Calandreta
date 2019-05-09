<?php
include("architecture/connexion.php");

$user = $_SESSION['user'];
//On récupère id utilisateur connecté
$sql0 = $con->query("SELECT id_user FROM utilisateurs WHERE email='".$user."'");
$req0 = $sql0->fetch_row();

	$nom = $_POST["nom"];
	$prenom = $_POST["prenom"];
	$datenaissance = $_POST["datenaissance"];
	$classe = $_POST["classe"];
	$id_parent2 = $_POST["parent2"];

	//Récupération de l'id classe
	$sqlidclasse = $con->query("SELECT id_classe FROM classe WHERE classe='".$classe."'");
	$id_classe = $sqlidclasse->fetch_row();
	$id_classe = $id_classe[0];

	//Requête d'intégration dans BDD
	$sqlinsertenfant = ("INSERT INTO enfants (nom, prenom, datenaissance, classe, parent1, parent2) VALUES ('$nom', '$prenom', '$datenaissance', '$id_classe', '$req0[0]', '$id_parent2')");
	//On envoie la requête
	$reqinsertenfant = mysqli_query($con, $sqlinsertenfant) or die('Erreur SQL !<br>'.mysqli_error($con));
	//On regarde si id de l'union existe sinon on l'insere
	$sqlidunion = query("SELECT id_union FROM union_parents WHERE parent1='".$req0[0]."' AND parent2='".$id_parent2."' OR parent1='".$id_parent2."' AND parent2='".$req0[0]."'");
	$reqidunion = $sqlidunion->fetch_row();
	if(empty($reqidunion[0])){
		$sqlinsertunion = ("INSERT INTO union_parents (parent1, parent2) VALUES ('$req0[0]', '$id_parent2')");

	}


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