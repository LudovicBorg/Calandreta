<?php  
$con=mysqli_connect("localhost", "root", "Toto123", "calandreta");
if(mysqli_connect_errno($con))
{
	echo "Erreur de connexion : ".mysqli_connect_error();
}
else
{
	// Récupération du prix du repas
	$sqlprix = $con->query("SELECT montant FROM 3il_montant_cantine");
	$reqprix = $sqlprix->fetch_row();
	$prix = $reqprix[0];
	// echo '<pre>';
	// echo 'prix = '.$prix;
	// echo '</pre>';
	//Insérer la nouvelle semaine
	
	// Récupération du numéro de la semaine
	$sql_semaine = $con->query("SELECT MAX(id_semaine) FROM 3il_semaines");
	$req_semaine = $sql_semaine->fetch_row();
	$semaine = $req_semaine[0];
	// echo '<pre>';
	// echo 'semaine = '.$semaine;
	// echo '</pre>';
	//Liste des semaines types
	$sql_liste_semaines_types = $con->query("SELECT * FROM 3il_cantine_type");
	$req_liste_semaines_types = $sql_liste_semaines_types->fetch_all();
	// echo '<pre>';
	// print_r($req_liste_semaines_types);
	// echo '</pre>';
	$lignes = $sql_liste_semaines_types->num_rows;
	// echo '<pre>';
	// echo 'nbr semaines types = '.$lignes;
	// echo '<pre>';
	for($l = 0; $l < $lignes; $l++) //Pour chaque semaines types
	{
		$sql_semaines_cantine = $con->query("SELECT * FROM 3il_cantine WHERE semaine ='".$semaine."' AND enfant ='".$req_liste_semaines_types[$l][5]."'");
		$req_semaines_cantine = $sql_semaines_cantine->fetch_all();
		// echo '<pre>';
		// print_r($req_semaines_cantine);
		// echo 'nb lignes cantine = '.$sql_semaines_cantine->num_rows;
		// echo '</pre>';
		// On récupère l'id union des parents
		$sql_parents = $con->query("SELECT parent1, parent2 FROM 3il_enfants WHERE id_enfant ='".$req_liste_semaines_types[$l][5]."'");
		$parents = $sql_parents->fetch_row();
		// echo '<pre>';
		// echo 'p1 = '.$parents[0].' - p2 = '.$parents[1];
		// echo '<pre>';
		$sql_idunion = $con->query("SELECT id_union FROM 3il_union_parents WHERE (parent1='".$parents[0]."' AND parent2='".$parents[1]."') OR (parent1='".$parents[1]."' AND parent2='".$parents[0]."')");
		$id_union = $sql_idunion->fetch_row();
		// echo '<pre>';
		// echo 'id union = '.$id_union[0];
		// echo '<pre>';

			//On récupère le montant du solde
		$sqlsolde = $con->query("SELECT montant FROM 3il_solde WHERE union_parents='".$id_union[0]."'");
		$reqsolde = $sqlsolde->fetch_all();
		$solde_parents = $reqsolde[0];
		// echo '<pre>';
		// echo 'solde parents = '.$solde_parents[0];
		// echo '<pre>';
		$nb_ligne_cantine = $sql_semaines_cantine->num_rows;
		if($nb_ligne_cantine == 0) //Si l'enfant n'a pas déjà une semaine planifiée on décompte seulement son solde
		{
			$sql_nouvelle_semaine = $con->query("INSERT INTO 3il_cantine (lundi, mardi, jeudi, vendredi, enfant, semaine) VALUES ('".$req_liste_semaines_types[$l][1]."', '".$req_liste_semaines_types[$l][2]."' ,'".$req_liste_semaines_types[$l][3]."','".$req_liste_semaines_types[$l][4]."', '".$req_liste_semaines_types[$l][5]."', '".$semaine."')");

			//Pour chaque jour on vérifie si l'enfant est inscrit
		for($c = 1; $c < 5; $c++)
		{
			echo $req_semaines_cantine[0][$c];
			if($req_semaines_cantine[0][$c] == "OUI") //Si l'enfant est inscrit au jour de la semaine on change son solde
			{
				$nouveau_solde = $solde_parents[0] - $prix;
				$sql_nouveau_solde = $con->query("UPDATE 3il_solde SET montant='".$nouveau_solde."' WHERE union_parents='".$id_union[0]."'");
			}
		}
		}
	}
}
?>
<!DOCTYPE html>
<html>
<body id="body">
    <br />
    		<div class="d-flex justify-content-center"> Tâche effectuée !<br /><br />
    			Vous allez être redirigé vers la page d'administration.<br /><br />
		</div>
		<?php
header("refresh:1;url=../responsable_cantine.php");
?>