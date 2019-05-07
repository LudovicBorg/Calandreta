<?php
include("architecture/connexion.php");
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
    <div class="container">
<?php
//On récupère id utilisateur connecté
$sql0 = $con->query("SELECT id_user FROM utilisateurs WHERE email='".$user."'");
$req0 = $sql0->fetch_row();
// echo $req0[0];
//On récupère nom et prénom des enfants
$sql1 = $con->query("SELECT id_enfant, prenom, nom, datenaissance, classe FROM enfants WHERE parent1='".$req0[0]."' OR parent2='".$req0[0]."'");
$req1 = $sql1->fetch_all();
$ligne = $sql1->num_rows;

?>
    	<h1>Vos enfants</h1>
    	<table class="table table-bordered table-condensed table-body-center">
            <thead>
                <tr>
                  <th style="width: 20%;"><center>Prénom</center></th>
                  <th style="width: 20%;"><center>Nom</center></th>
                  <th style="width: 20%;"><center>Date de naissance</center></th>
                  <th style="width: 20%;"><center>Classe</center></th>
                  <th style="width: 20%;"><center>Gestion</center></th>
                </tr>
            </thead>
            <tbody>
<?php

for($a = 0; $a < $ligne; $a++){
	echo '<tr id="';
  echo $req1[$a][0];
  echo '">';
	echo ' <td data-title="Prénom">';
	echo $req1[$a][1];
	echo '</td>';
	echo ' <td data-title="Nom">';
	echo $req1[$a][2];
	echo '</td>';
	echo ' <td data-title="Date de naissance">';
	echo $req1[$a][3];
	echo '</td>';
	// $sql2 = $con->query("SELECT classe FROM classe WHERE classe_id='".$req1[$a][3]."'");
	// $req2 = $sql2->fetch_row();
	echo ' <td data-title="Classe">';
	$sqlclasse = $con->query("SELECT classe FROM classe WHERE id_classe='".$req1[$a][4]."'");
	$reqclasse = $sqlclasse->fetch_row();
	echo $reqclasse[0];
	echo '</td>';
	echo ' <td data-title="Gestion">';
	echo '<button class="btn btn-dark" id="Modifier">Modifier</button>';
	echo '<button class="btn btn-dark" id="Supprimer" onclick="supprimerenfant(';
  echo $req1[$a][0];
  echo ');">Supprimer</button>';
	echo '</td>';
	echo '</tr>';
}   
?>       

            </tbody>
          </table>
          </div>
     <div class="container">
    	<h1>Ajouter un enfant</h1>
    		<form name="enfant" id="f_candidature" action="traitement_ajouter_enfant.php"  method="POST" >
        	<div class="form-row">
            	<div class="form-group col-md-6">
                	<label for="inputNom">Nom</label>
                	<input type="text" class="form-control" name="nom" id="inputNom" placeholder="Nom" required>
            	</div>
           		<div class="form-group col-md-6">
                	<label for="inputPrenom">Prénom</label>
                	<input type="text" class="form-control" name="prenom" id="inputPrenom" placeholder="Prénom" required>
            	</div>
        	</div>
        	<div class="form-row">
            	<div class="form-group col-md-6">
                	<label for="inputDate">Date de naissance</label>
                	<input type="date" class="form-control" name="datenaissance" id="inputDate" placeholder="Date de naissance" required>
            	</div>
           		<div class="form-group col-md-6">
                	<label for="inputClasse">Classe</label>
						<select class="form-control" name="classe" id="inputclasse">
              				<option value="" selected>Sélectionner une classe</option>
              				<option value="Toute petite section">Toute petite section</option>
              				<option value="Petite section">Petite section</option>
              				<option value="Moyenne section">Moyenne section</option>
              				<option value="Grande section">Grande section</option>
              				<option value="CP">CP</option>
              				<option value="CE1">CE1</option>
              				<option value="CE2">CE2</option>
              				<option value="CM1">CM1</option>
              				<option value="CM2">CM2</option>
                        </select>
          		</div>
            </div>
            <div id="boutons">
        <a href="accueil.php" class="btn btn-dark" id="Annuler">Annuler</a>
        <input type="submit" class="btn btn-dark" id="Ajouter" value="Ajouter">
    </div>
    	</form>
    </div>
    <script type="text/javascript" src="JS/supprimerenfant.js" charset="utf-8"></script>
</body>
</html>


