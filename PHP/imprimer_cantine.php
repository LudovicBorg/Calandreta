<!DOCTYPE html>
<html>
<head>
	<title>Impression</title>
	<?php include("../architecture/head.html"); ?>
</head>
<body>
	<?php
	include("../architecture/connexion.php");

// Numéro de la semaine
	$week = date('W');
	$week = $week + 1;
	$annee = date('Y');
// ON recupere les lundi et vendredi de la semaine 
	$sqlweek = $con->query("SELECT id_semaine, lundi, vendredi FROM 3il_semaines WHERE numero='".$week."' AND annee='".$annee."'");
	$reqweek = $sqlweek->fetch_row();
	$objdate1 = date_create($reqweek[1]);
	$date_lundi = $objdate1->format('d/m/Y');
	$objdate2 = date_create($reqweek[2]);
	$date_vendredi = $objdate2->format('d/m/Y');
// On recupere tous les enregistrements de la cantine pour une semaine
	$toutelacantine = $con->query("SELECT lundi, mardi, jeudi, vendredi, enfant FROM 3il_cantine WHERE semaine='".$reqweek[0]."'");
	$reqtoutelacantine = $toutelacantine->fetch_all();
	$ligne = $toutelacantine->num_rows;
	for ($a=0; $a<$ligne; $a++){
// On recupere les noms des enfants
		$sqlnomsenfants = $con->query("SELECT nom, prenom FROM 3il_enfants WHERE id_enfant='".$reqtoutelacantine[$a][4]."'");
		$reqnomsenfants = $sqlnomsenfants->fetch_row();
	}
	?>
	<h1>
		Semaine du <?php echo $date_lundi; ?> au <?php echo $date_vendredi; ?> :
	</h1>
	<table class="table table-bordered table-condensed table-body-center">
		<thead>
			<tr>
				<th style="width: 20%;">Enfant</th>
				<th style="width: 20%;">Lundi</th>
				<th style="width: 20%;">Mardi</th>
				<th style="width: 20%;">Jeudi</th>
				<th style="width: 20%;">Vendredi</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			for ($a=0; $a<$ligne; $a++){
				echo '<tr>';
				echo '<td data-title="Enfant">';
// On recupere les noms des enfants
				$sqlnomsenfants = $con->query("SELECT nom, prenom FROM 3il_enfants WHERE id_enfant='".$reqtoutelacantine[$a][4]."'");
				$reqnomsenfants = $sqlnomsenfants->fetch_row();
				echo $reqnomsenfants[0];
				echo ' ';
				echo $reqnomsenfants[1];
				echo '</td>';
				echo '<td data-title="Lundi">';
				$sqlreponsecantine = $con->query("SELECT lundi, mardi, jeudi, vendredi FROM 3il_cantine WHERE enfant='".$reqtoutelacantine[$a][4]."' AND semaine='".$reqweek[0]."'");
				$reqreponsecantine = $sqlreponsecantine->fetch_row();
				echo $reqreponsecantine[0];
				echo '</td>';
				echo '<td data-title="Mardi">';
				echo $reqreponsecantine[1];
				echo '</td>';
				echo '<td data-title="Jeudi">';
				echo $reqreponsecantine[2];
				echo '</td>';
				echo '<td data-title="Vendredi">';
				echo $reqreponsecantine[3];
				echo '</td>';
			}
			?>
		</tbody>
	</table>
</body>
</html>

<script type="text/javascript">
	window.onload = function() {
		window.print();
	}
</script>