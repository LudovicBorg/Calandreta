<?php
include("architecture/connexion.php");
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html>
<head>
    <?php include("architecture/head.html"); ?>
    <link href='CSS/enfants.css' rel='stylesheet' />
    <script type="text/javascript" src="JS/supprimerenfant.js" charset="utf-8"></script>
</head>
<body id="body">
    <?php include("architecture/header.php"); ?>

<!--===== Partie pour afficher l'ajout d'un enfant ou les enfants déjà présents =====-->
<script>
$(document).ready(function(){
  $("#hide").click(function(){
    $("#ajouter_un_enfant").hide();
    $("#enfants").show();
  });
  $("#show").click(function(){
    $("#ajouter_un_enfant").show();
    $("#enfants").hide();
    });
});
</script>
<!--===== Fin du script =====-->
<!--===== Navigation entre les enfants déjà présent et l'ajout d'un nouvel enfant =====-->
      <div id="choix">
        <div class="row">
        <div class="col-sm-6">
          <label id="hide">Vos enfants</label>
          <input type="radio" id="hide" class="btn btn-dark">
        </div>
        <div class="col-sm-6">
          <label id="show">Ajouter un enfant</label>
          <input type="radio" id="show" class="btn btn-dark">
        </div>
      </div>
      </div>
   
    <div class="container" id="enfants">
<?php
//On récupère id utilisateur connecté
$sql0 = $con->query("SELECT id_user FROM 3il_utilisateurs WHERE email='".$user."'");
$req0 = $sql0->fetch_row();
// echo $req0[0];
//On récupère nom et prénom des enfants
$sql1 = $con->query("SELECT id_enfant, prenom, nom, datenaissance, classe FROM 3il_enfants WHERE parent1='".$req0[0]."' OR parent2='".$req0[0]."'");
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
  echo '<form action="modifier_enfant.php" method="POST">';
	echo '<tr id="';
  echo $req1[$a][0];
  echo '">';
  echo '<input type="hidden" name="id_enfant" value="';
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
	$sqlclasse = $con->query("SELECT classe FROM 3il_classe WHERE id_classe='".$req1[$a][4]."'");
	$reqclasse = $sqlclasse->fetch_row();
	echo $reqclasse[0];
	echo '</td>';
	echo ' <td data-title="Gestion">';
	echo '<input type="submit" class="btn btn-dark" id="Modifier" value="Modifier">';
  echo '</form>';
	echo '<button class="btn btn-danger" id="Supprimer" onclick="supprimerenfant(';
  echo $req1[$a][0];
  echo ');">Supprimer</button>';
	echo '</td>';
	echo '</tr>';
}   
?>       

            </tbody>
          </table>
          </div>
     <div class="container" id="ajouter_un_enfant" style="display:none">
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
              <div class="form-group col-md-12">
                <label for="inputparent2">Second parent</label>
            <select class="form-control" name="parent2" id="inputparent2">
                      <option value="" selected>Sélectionner un parent</option>
<?php
$sqlnomsparents = $con->query("SELECT id_user, nom, prenom FROM 3il_utilisateurs");
$reqnomsparents = $sqlnomsparents->fetch_all();
$ligne2 = $sqlnomsparents->num_rows;
for ($a=0; $a<$ligne2; $a++){
  echo '<option value="';
  echo $reqnomsparents[$a][0];
  echo '">';
  echo $reqnomsparents[$a][1];
  echo ' ';
  echo $reqnomsparents[$a][2];
}
?>
                        </select>
              </div>
              <div class="form-group col-md-12">
                <label for="inputparent2">Semaine type pour la cantine</label>
              <table class="table table-bordered table-condensed table-body-center">
            <thead>
                <tr>
                  <th style="width: 25%;">Lundi</th>
                  <th style="width: 25%;">Mardi</th>
                  <th style="width: 25%;">Jeudi</th>
                  <th style="width: 25%;">Vendredi</th>
                </tr>
            </thead>
            <tbody>
                <tr id="tr_1">
                    <td data-title="Lundi">                     
                        <label class="switch"><input type="checkbox" id="togBtn"  name="Lundi" value="OUI">
                        <div class="slider round"></div>
                        </label>              
                  </td>
                  <td data-title="Mardi">                     
                        <label class="switch"><input type="checkbox" id="togBtn"  name="Mardi" value="OUI">
                        <div class="slider round"></div>
                        </label>             
                  </td>
                  <td data-title="Jeudi">                     
                       <label class="switch"><input type="checkbox" id="togBtn" name="Jeudi" value="OUI">
                       <div class="slider round" ></div>
                       </label>                               
                  </td>
                  <td data-title="Vendredi">                    
                       <label class="switch"><input type="checkbox" id="togBtn" name="Vendredi" value="OUI">
                       <div class="slider round"></div>  
                       </label>                               
                  </td> 
                  </tr>
            </tbody>
          </table>
            </div>
          </div>
            <div id="boutons">
        <input type="submit" class="btn btn-dark" id="Ajouter" value="Ajouter">
    </div>
    	</form>
    </div>
    
</body>
</html>


