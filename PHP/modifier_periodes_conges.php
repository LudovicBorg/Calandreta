<?php 
include("../architecture/connexion.php");

//Nouveau jour congé
$nb_lignes_j = $_POST["nb_lignes_j"];
//echo '<pre>';
//echo $nb_lignes_j;
//echo '</pre>';
$new_libelle = $_POST["new_libelle"];
$new_date = $_POST["new_date"];

for($l = 1; $l <= $nb_lignes_j; $l++)
{
	$date = $_POST["date_".$l];

	$con->query("UPDATE 3il_jours_conges SET date_conge='".$date."' WHERE id_jour='".$l."'");
}

if($_POST["new_libelle"] != "")
{
	$con->query("INSERT INTO 3il_jours_conges (libelle, date_conge) VALUES ('".$new_libelle."','".$new_date."')");
}

//Période de congé
$nb_lignes_p = $_POST["nb_lignes_p"];
//echo '<pre>';
//echo $nb_lignes_p;
//echo '</pre>';

for($l = 1; $l <= $nb_lignes_p; $l++)
{
	$date_debut = $_POST["debut_".$l];
	$date_fin = $_POST["fin_".$l];

	//echo '<pre>';
	//echo $date_debut." - ".$date_fin;
	//echo '</pre>';

	$con->query("UPDATE 3il_periodes_conges SET date_debut='".$date_debut."', date_fin='".$date_fin."' WHERE id_periode='".$l."'");
}

header("Location: ../responsable_cantine.php");
exit();

?>