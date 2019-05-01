<?php
$con=mysqli_connect("localhost", 'root', 'Toto123', "calandreta");
if(mysqli_connect_errno($con))
{
	echo "Erreur de connexion : ".mysqli_connect_error();
}
else
{
	$nom = $_POST["nom"];
	$prenom = $_POST["prenom"];
	$email = $_POST["email"];
	$password = $_POST["password"];
	$telephone1 = $_POST["phone1"];
	$telephone2 = $_POST["phone2"];
	$adresse1 = $_POST["adresse"];
	$adresse2 = $_POST["adresse2"];
	$ville = $_POST["ville"];
	$code_postal = $_POST["cp"];

	//Requête d'intégration dans BDD
	$sql = ("INSERT INTO utilisateurs (nom, prenom, email, password, telephone1, telephone2, adresse, adresse2, ville, code_postal, role) VALUES ('$nom', '$prenom', '$email', '$password', '$telephone1', '$telephone2', '$adresse1', '$adresse2', '$ville', '$code_postal', '0')");
	//On envoie la requête
	$req = mysqli_query($con, $sql) or die('Erreur SQL !<br>'.mysqli_error($con));

}

//Fermeture de la connexion
mysqli_close($con);
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../CSS/redirection.css">
	<title>Redirection</title>
</head>
<body>
	<form>
		<div class="d-flex justify-content-center"> Inscription terminée, un mail contenant vos identifiants vous a été envoyé.<br><br>Vous allez être redirigé vers la page de connexion.<br><br>Si la redirection ne se fait pas, cliquez
			<a href="../connexion">ici</a>.
		</div>
	</form>
	<?php header("refresh:5;url=../index.php"); ?>
</body>
</html>