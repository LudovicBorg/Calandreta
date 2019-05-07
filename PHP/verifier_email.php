<?php
include("../architecture/connexion.php");

	$email = $_POST["email"];
	
		//On sélectionne l'enregistrement correspondant aux identifiants
	$sql= "SELECT * FROM utilisateurs WHERE sessions.email='$email'";
		//On envoie la requête
	$req = mysqli_query($con, $sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysqli_error($con));

	$cpt = mysqli_num_rows ($req);

	if($cpt == 1)
	{
			//l'adresse existe déjà		
		echo "0";
	}
	else
	{
			//l'adresse n'existe pas encore
		echo "1";
	}

//Fermeture de la connexion
mysqli_close($con);
?>
