<?php
$con=mysqli_connect("localhost", 'root', 'Toto123' ,"calandreta");
if(mysqli_connect_errno($con))
{
	echo "Erreur de connexion : ".mysqli_connect_error();
}
else
{
	$email = $_POST["identifiant"];
	$password = $_POST["password"];
		//On sélectionne l'enregistrement correspondant aux identifiants
	$sql= "SELECT * FROM utilisateurs WHERE utilisateurs.email='$email' AND utilisateurs.password='$password'";
		//On envoie la requête
	$req = mysqli_query($con, $sql) or die('Erreur SQL !<br>'.mysqli_error($con));
	$row = $req->fetch_assoc();
	$cpt = mysqli_num_rows ($req);

	if($cpt == 1)
	{
		//On crée la session
		session_start();
		$_SESSION['user'] = $email;
		$_SESSION['password'] = $password;
		$_SESSION['id_user'] = $row['id_user'];
		$_SESSION['nom'] = $row['nom'];
		$_SESSION['prenom'] = $row['prenom'];
		$_SESSION['role'] = $row['role'];
		
		// echo "1";
		header('Location: ../accueil.php');
	}
	else
	{
		// echo "0";
		echo "<script language=\"javascript\">";
		echo "alert('Erreur de connexion, veuillez réessayer !')";
		echo "</script>";
		header('Refresh: 0.5; ../index.php');
	}
}

//Fermeture de la connexion
mysqli_close($con);
?>
