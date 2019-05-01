<?php
//on actualise la session
session_start();
//On vérifie qu'elle soit bien définie
if(empty($_SESSION['user']) || empty($_SESSION['password']))
{
    header('Location: index.php');
    exit();
}
$con=mysqli_connect("localhost", 'root', 'Toto123' ,"calandreta");
if(mysqli_connect_errno($con))
{
  echo "Erreur de connexion : ".mysqli_connect_error();
}
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


// $sql_galerie_id = $db->query("SELECT image_id FROM ".$galerie."");
// $tableau = $sql_galerie_id->fetchAll(); //Stockage dans un tableau
// $nb_enregistrements = count($tableau);
/*Lors de la suppression d'un enregistrement, on modifie tous les ids suivant pour que les ids dans la bdd se suivent*/
$sql_delete = $db->query("DELETE FROM enfants WHERE id_enfant='".$id."'");
// $b = $id+1;
// for ($b; $b<=$nb_enregistrements; $b++){
//   $sql_modif_id = $db->query("UPDATE ".$galerie." SET image_id='".$id."' WHERE image_id='".$b."'");
//   $id++;
// }
// $sql_altertable = $db -> query("ALTER TABLE ".$galerie." AUTO_INCREMENT = 1");
?>
<br />
<br />

</body>
