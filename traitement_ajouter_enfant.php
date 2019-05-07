<?php
include("architecture/connexion.php");
else
{
$user = $_SESSION['user'];
//On récupère id utilisateur connecté
$sql0 = $con->query("SELECT id_user FROM utilisateurs WHERE email='".$user."'");
$req0 = $sql0->fetch_row();

	$nom = $_POST["nom"];
	$prenom = $_POST["prenom"];
	$datenaissance = $_POST["datenaissance"];
	$classe = $_POST["classe"];

	//Récupération de l'id classe
	$sqlidclasse = $con->query("SELECT id_classe FROM classe WHERE classe='".$classe."'");
	$id_classe = $sqlidclasse->fetch_row();
	$id_classe = $id_classe[0];

	//Requête d'intégration dans BDD
	$sqlinsertenfant = ("INSERT INTO enfants (nom, prenom, datenaissance, classe, parent1) VALUES ('$nom', '$prenom', '$datenaissance', '$id_classe', '$req0[0]')");
	//On envoie la requête
	$reqinsertenfant = mysqli_query($con, $sqlinsertenfant) or die('Erreur SQL !<br>'.mysqli_error($con));

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