<?php
$con=mysqli_connect("localhost", "MALET", "Malet@root81","calandreta");
if(mysqli_connect_errno($con))
{
	echo "Erreur de connexion : " . mysqli_connect_error();
}
else
{
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
}

//Fermeture de la connexion
mysqli_close($con);
?>
