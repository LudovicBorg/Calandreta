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
	//Insérer la nouvelle semaine
	
	// Récupération du numéro de la semaine
	$sql_semaine = $con->query("SELECT id_semaine FROM 3il_semaines WHERE id_semaine = MAX(id_semaine)");
	$req_semaine = $sql_semaine->fetch_all();
	$semaine = $req_semaine[0];

	//Liste des semaines types
	$sql_liste_semaines_types = $con->query("SELECT * FROM 3il_cantine_type");
	$req_liste_semaines_types = $sql_liste_semaines_types->fetch_all();
	$lignes = $sql_liste_semaines_types->num_rows;

	for($l = 0; $l < $lignes; $l++) //Pour chaque semaines types
	{
		$sql_semaines_cantine = $con->query("SELECT * FROM 3il_cantine WHERE semaine ='".$semaine."' AND enfant ='".$sql_liste_semaines_types[$l][5]."'");
		$req_semaines_cantine = $req_semaines_cantine->fetch_all();

		// On récupère l'id union des parents
		$sqlunionid = $con->query("SELECT id_union FROM 3il_union_parents WHERE enfant ='".$sql_liste_semaines_types[$l][5]."'");
		$id_union = $sqlunionid->fetch_row();
			//On récupère le montant du solde
		$sqlsolde = $con->query("SELECT montant FROM 3il_solde WHERE union_parents='".$id_union[0]."'");
		$reqsolde = $sqlsolde->fetch_all();
		$solde_parents = $reqsolde[0];

		if($sql_semaines_cantine->num_rows != 1) //Si l'enfant n'a pas déjà une semaine planifiée on décompte seulement son solde
		{
			$sql_nouvelle_semaine = $con->query("INSERT INTO 3il_cantine (lundi, mardi, jeudi, vendredi, enfant) VALUES ('".$req_liste_semaines_types[$l][1]."', '".$req_liste_semaines_types[$l][2]."','".$req_liste_semaines_types[$l][3]."','".$req_liste_semaines_types[$l][4]."')");
		}

		//Pour chaque jour on vérifie si l'enfant est inscrit
		for($c = 1; $c < 5; $c++)
		{
			if($req_semaines_cantine[0][$c] == "OUI") //Si l'enfant est inscrit au jour de la semaine on change son solde
			{
				$nouveau_solde = $solde_parents - $prix;
				$sql_nouveau_solde = $con->query("UPDATE 3il_solde SET montant='".$nouveau_prix."' WHERE union_parents='".$id_union[0]."'");
			}
		}
	}

}


?>