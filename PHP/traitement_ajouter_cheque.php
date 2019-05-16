<?php
include("../architecture/connexion.php");

	$date_cheque = $_POST['date_cheque'];
	$numero_cheque = $_POST['numero_cheque'];
	$montant_cheque = $_POST['montant_cheque'];
	$parents = $_POST['parents'];

	$sqlinsertcheque = $con->query("INSERT INTO 3il_cheques (montant_cheque, numero_cheque, date_cheque, union_parents) VALUES ('$montant_cheque', '$numero_cheque', '$date_cheque', '$parents')");

	$montant_cantine = $con->query("SELECT id_solde, montant FROM 3il_solde WHERE union_parents='".$parents."'");
	$reqmontant_cantine = $montant_cantine->fetch_all();
	$old_montant = $reqmontant_cantine[0][1];

	$new_montant_cantine = $old_montant + $montant_cheque;

	$sql_nouveau_montant = $con->query("UPDATE 3il_solde SET montant='".$new_montant_cantine."' WHERE union_parents='$parents'");

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
