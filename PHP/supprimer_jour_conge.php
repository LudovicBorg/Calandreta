<?php
include("../architecture/connexion.php");
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html>
<head>
    <?php include("architecture/head.html"); ?>
    <link href='CSS/enfants.css' rel='stylesheet' />
</head>
<body id="body">
    <?php include("architecture/header.php"); ?>
    <br />
<?php

$id = $_POST['id'];

$sql_delete = $con->query("DELETE FROM 3il_jours_conges WHERE id_jour='".$id."'");
?>
<br />
<br />

</body>
