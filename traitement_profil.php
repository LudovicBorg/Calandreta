<?php
include("architecture/connexion.php");
// $user = $_SESSION['user'];
// $sqlrole = $con->query("SELECT role FROM utilisateurs WHERE email='".$user."'");
// $reqrole = $sqlrole->fetch_row(); 
// $role = $reqrole[0];
// if ($role != 2){
//   echo "<script language=\"javascript\">";
//   echo "alert('Vous n'avez pas les droits pour accéder à cette page !')";
//   echo "</script>";
//   header('Location: accueil.php');
//   exit();
// } else {
	// $nouveau_prix = $_POST['prix'];
	// $sql_nouveau_prix = $con->query("UPDATE montant_cantine SET montant='".$nouveau_prix."' WHERE montant_id='1'");
// }



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
