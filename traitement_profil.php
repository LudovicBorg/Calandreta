<?php
include("architecture/connexion.php");
$user = $_SESSION['user'];
$sqlrole = $con->query("SELECT role FROM utilisateurs WHERE email='".$user."'");
$reqrole = $sqlrole->fetch_row(); 
$role = $reqrole[0];
if ($role != 4){
  echo "<script language=\"javascript\">";
  echo "alert('Vous n'avez pas les droits pour accéder à cette page !')";
  echo "</script>";
  header('Location: accueil.php');
  exit();
} else {
	$id_user = $_POST['utilisateur'];
	$id_role = $_POST['profils'];
	// echo $id_user;
	// echo $id_role;

 $sqlmiseajourprofil = $con->query("UPDATE utilisateurs SET role = '".$id_role."' WHERE id_user='".$id_user."'");
}

?>
<!DOCTYPE html>
<html>
<head>
    <?php include("architecture/head.html"); ?>
	<link rel="stylesheet" type="text/css" href="CSS/redirection.css">
</head>
<body id="body">
    <?php include("architecture/header.php"); ?>
    <br />
        <div class="d-flex justify-content-center"> Changement de profil effectué.
        	<br />
        	Vous allez être redirigé vers la page admin.
        </div>
    <?php header("refresh:1;url=admin.php"); ?>
</body>
</html>
