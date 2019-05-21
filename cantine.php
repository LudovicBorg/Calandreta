<?php
include("architecture/connexion.php");
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html>
<head>
    <?php include("architecture/head.html"); ?>
    <link href='CSS/cantine.css' rel='stylesheet' />
    <script src="js/demarrer_session.js" type="text/javascript"></script>
    <script src="js/semaine_cantine.js" type="text/javascript"></script>
</head>
<body id="body">
    <?php include("architecture/header.php"); ?>
    <?php 
$sqlrole = $con->query("SELECT role FROM 3il_utilisateurs WHERE email='".$user."'");
$reqrole = $sqlrole->fetch_row(); 
$role = $reqrole[0];
if ($role == 2 OR $role == 4){
  echo '<a href="responsable_cantine.php" class="btn btn-dark" id="Administration_cantine">Administration Repas</a>';
}
?>
  <script>
$(document).ready(function(){
  $("#semaine_but").click(function(){
    $("#semaine_container").show();
    $("#depot_container").hide();
    $("#soldes_container").hide();
  });
  $("#depot_but").click(function(){
    $("#soldes_container").hide();
    $("#semaine_container").hide();
    $("#depot_container").show();
    });
  $("#soldes_but").click(function(){
    $("#depot_container").hide();
    $("#semaine_container").hide();
    $("#soldes_container").show();
    });
});
</script>
<!--===== Fin du script =====-->
<!--===== Navigation =====-->
      <div id="choix">
        <div class="row" id="nav">
        <div class="col-sm-4">
          <label id="semaine_but">Modifier une semaine</label>
          <input type="radio" id="semaine_but" class="btn btn-dark">
        </div>
        <div class="col-sm-4">
          <label id="depot_but">Voir ses dépots</label>
          <input type="radio" id="depot_but" class="btn btn-dark">
        </div>
        <div class="col-sm-4">
          <label id="soldes_but">Evolution du solde</label>
          <input type="radio" id="soldes_but" class="btn btn-dark">
        </div>
      </div>
      </div>

    <br />
<?php 
//On récupère id utilisateur connecté
$sql0 = $con->query("SELECT id_user FROM 3il_utilisateurs WHERE email='".$user."'");
$req0 = $sql0->fetch_row();
// echo $req0[0];
$sqlcountnombre_union = $con->query("SELECT COUNT(id_union) FROM 3il_union_parents WHERE parent1='".$req0[0]."' OR parent2='".$req0[0]."'");
$reqcountnombre_union = $sqlcountnombre_union->fetch_row();
// echo $reqcountnombre_union[0];
if($reqcountnombre_union[0] == '1'){
?>
    <div class="container" id="solde">
          <h1>Solde :</h1>
<?php
// On récupère l'id union des parents
$sqlunionid = $con->query("SELECT id_union FROM 3il_union_parents WHERE parent1='".$req0[0]."' OR parent2='".$req0[0]."'");
$id_union = $sqlunionid->fetch_row();
//On récupère le montant du solde
$sqlsolde = $con->query("SELECT id_solde, montant FROM 3il_solde WHERE union_parents='".$id_union[0]."'");
$reqsolde = $sqlsolde->fetch_all();
if ($reqsolde[0][1]>0){
  echo '<div id="greensolde">';
  echo $reqsolde[0][1];
  echo ' €';
  echo '</div>';
} else {
  echo '<div id="redsolde">';
  echo $reqsolde[0][1];
  echo ' €';
  echo '</div>';
}
?>
<?php
} elseif ($reqcountnombre_union[0] == 2) {
?>
<div class="container" id="solde">
  <div class="row">
    <div class="col-sm-6">
        <h1>Solde :</h1>
<?php
// On récupère l'id union des parents
$sqlunionid = $con->query("SELECT id_union FROM 3il_union_parents WHERE parent1='".$req0[0]."' OR parent2='".$req0[0]."'");
$id_union = $sqlunionid->fetch_all();
// echo $id_union[0][0];
// echo $id_union[1][0];
//On récupère le montant du solde
$sqlsolde = $con->query("SELECT id_solde, montant FROM 3il_solde WHERE union_parents='".$id_union[0][0]."'");
$reqsolde = $sqlsolde->fetch_all();
if ($reqsolde[0][1]>0){
  echo '<div id="greensolde">';
  echo $reqsolde[0][1];
  echo ' €';
  echo '</div>';
} else {
  echo '<div id="redsolde">';
  echo $reqsolde[0][1];
  echo ' €';
  echo '</div>';
}
?>
    </div>
    <div class="col-sm-6">
        <h1>Solde :</h1>
<?php
//On récupère le montant du solde
$sqlsolde = $con->query("SELECT id_solde, montant FROM 3il_solde WHERE union_parents='".$id_union[1][0]."'");
$reqsolde = $sqlsolde->fetch_all();
if ($reqsolde[0][1]>0){
  echo '<div id="greensolde">';
  echo $reqsolde[0][1];
  echo ' €';
  echo '</div>';
} else {
  echo '<div id="redsolde">';
  echo $reqsolde[0][1];
  echo ' €';
  echo '</div>';
}
?>
    </div>
  </div>
</div>


<?php
}
?>
    </div>

   <div class="container" id="semaine_container">
        <h1>Enfant :</h1>
<!--===== Code qui affiche les noms des différents enfants =====-->
          <form method="POST" action="traitementcantine.php">
            <select class="form-control" name="nom_enfant" id="id_enfant" onchange="update_week();">
<?php
//On récupère nom et prénom des enfants
$sql1 = $con->query("SELECT id_enfant, prenom, nom FROM 3il_enfants WHERE parent1='".$req0[0]."' OR parent2='".$req0[0]."'");
$req1 = $sql1->fetch_all();
$ligne = $sql1->num_rows;
?>
            <option selected="selected" disabled>Selectionner votre enfant</option>
<?php
// echo $ligne;
for ($a = 0; $a < $ligne; $a++){
  echo '<option value="';
  echo $req1[$a][0];
  echo '">';
  echo $req1[$a][1];
  echo ' ';
  echo $req1[$a][2];
  echo '</option>';
}
?>
            </select>

<?php
// Numéro de la semaine
$week = date('W');
$week = $week + 1;
echo '<input name="week" type="hidden" value="'.$week.'">';
// echo $week;
// Affiche la date du prochain lundi
$date = date('Y-m-d');
$objdate = date_create($date . ' Next Monday');
$date_lundi = $objdate->format('d/m/Y');
$date_lundi_formatsql = $objdate->format('Y-m-d');
echo '<input name="lundi" type="hidden" value="'.$date_lundi_formatsql.'">';
// echo $date_lundi;
// Affiche la date du prochain vendredi
$date = date('Y-m-d');
$objdate = date_create($date . ' Next Monday');
$date_lundi2 = $objdate->format('Y-m-d');
$objdate = date_create($date_lundi2 . ' Next Friday');
$date_vendredi = $objdate->format('d/m/Y');
$date_vendredi_formatsql = $objdate->format('Y-m-d');
echo '<input name="vendredi" type="hidden" value="'.$date_vendredi_formatsql.'">';
// echo $date_vendredi;
//Récupération de l'année
$annee = date('Y');
echo '<input name="annee" type="hidden" value="'.$annee.'">';
?>
      <div class="w3-content w3-display-container">
          <h1>
            Semaine du <?php echo $date_lundi; ?> au <?php echo $date_vendredi; ?> :
          </h1>
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
                        <label class="switch"><input type="checkbox" id="lundi"  name="Lundi" value="OUI">
                        <div class="slider round"></div>
                        </label>              
                  </td>
                  <td data-title="Mardi">                     
                        <label class="switch"><input type="checkbox" id="mardi"  name="Mardi" value="OUI">
                        <div class="slider round"></div>
                        </label>             
                  </td>
                  <td data-title="Jeudi">                     
                       <label class="switch"><input type="checkbox" id="jeudi" name="Jeudi" value="OUI">
                       <div class="slider round" ></div>
                       </label>                               
                  </td>
                  <td data-title="Vendredi">                    
                       <label class="switch"><input type="checkbox" id="vendredi" name="Vendredi" value="OUI">
                       <div class="slider round"></div>  
                       </label>                               
                  </td> 
                  </tr>
            </tbody>
          </table>
          </div>
            <input type="submit" class="btn btn-primary" value="Valider" id="Valider">
    </form>
  </div>


<!-- <div class="container">
<h1>Prévisions du <?php //echo $date_lundi; ?> au <?php //echo $date_vendredi; ?> :</h1>
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
            <tbody> -->
<?php
// for ($a = 0; $a < $ligne; $a++){
//   echo '<tr id="'.$a.'">';
//   echo ' <td data-title="Enfant">';
//   echo $req1[$a][1];
//   echo '</td>';
//   // Récupération de l'id de l'enfant
// // $sqlid_enfant = $con->query("SELECT id_enfant FROM enfants WHERE prenom='".$req1[$a][0]."'");
// // $id_enfant = $sqlid_enfant->fetch_row();
// // $id_enfant = $id_enfant[0];
//   echo '<td data-title="Lundi">';
// $sqlsemaine = $con->query("SELECT id_semaine FROM 3il_semaines WHERE numero='".$week."'");
// $id_semaine = $sqlsemaine->fetch_row();
// $id_semaine = $id_semaine[0];
// $sqllecturecantine = $con->query("SELECT lundi, mardi, jeudi, vendredi FROM 3il_cantine WHERE enfant='".$req1[$a][0]."' AND semaine='".$id_semaine."'");
// $reqlecturecantine = $sqllecturecantine->fetch_all();
// echo $reqlecturecantine[0][0];
//   echo '</td>';
//   echo '<td data-title="Mardi">';
// echo $reqlecturecantine[0][1];
//   echo '</td>';
//   echo '<td data-title="Jeudi">';
// echo $reqlecturecantine[0][2];
//   echo '</td>';
//   echo '<td data-title="Vendredi">';
// echo $reqlecturecantine[0][3];
//   echo '</td>';
//   echo '</tr>';
// }
?>
<!--             </tbody>
          </table>
</div> -->
          <div class="container" id="depot_container" style="display:none">
        <h1>Historique :</h1>
<?php
//On récupère l'union de deux parents
$sqlunion = $con->query("SELECT id_union FROM 3il_union_parents WHERE parent1='".$req0[0]."' OR parent2='".$req0[0]."'");
$requnion = $sqlunion->fetch_row();

//On récupère le montant du solde
$sqlcheque = $con->query("SELECT montant_cheque, date_cheque FROM 3il_cheques WHERE union_parents ='".$requnion[0]."' ORDER BY date_cheque DESC");
$reqcheque = $sqlcheque->fetch_all();
$ligne = $sqlcheque->num_rows;
?>
<table class="table table-bordered table-condensed table-body-center">
            <thead>
                <tr>
                  <th style="width: 50%;">Date</th>
                  <th style="width: 50%;">Montant</th>
                </tr>
            </thead>
            <tbody>
<?php
// if ($ligne > 3){
//   $ligne = 3;
// }
for ($a = 0; $a < $ligne; $a++){
  echo '<tr id="'.$a.'">';
  echo ' <td data-title="Date">';
  echo $reqcheque[$a][1];
  echo '</td>';
  echo '<td data-title="Montant">';
  echo $reqcheque[$a][0];
  echo '</td>';
  echo '</tr>';
}
?>
            </tbody>
          </table>
        </div>

      <div class="container" id="soldes_container" style="display:none">
<?php
// $date2 = date('m-Y');
// echo '<input name="week" type="hidden" value="'.$date2.'">';


if ($reqsolde[0][1]>0){
  ?>
        <table class="table table-bordered table-condensed table-body-center">
            <thead>
                <tr>
                  <th style="width: 50%;">Date</th>
                  <th style="width: 50%;">Soldes</th>
                </tr>
            </thead>
            <tbody>
<?php
//On récupère les montants du solde
$sqlhistorique = $con->query("SELECT mois, montant FROM 3il_soldes_historique WHERE union_parents ='".$requnion[0]."'");
$reqhistorique = $sqlhistorique->fetch_all();
$ligne2 = $sqlhistorique->num_rows;
for ($a = 0; $a < $ligne2; $a++){
  $sqldate = $con->query("SELECT mois_annee FROM 3il_mois_annee WHERE id_mois_annee = '".$reqhistorique[$a][0]."'");
  $reqdate = $sqldate->fetch_row();
  echo '<tr id="'.$a.'">';
  echo ' <td data-title="Date">';
  echo $reqdate[0];
  echo '</td>';
  echo '<td data-title="Montant">';
  echo $reqhistorique[$a][1];
  echo '</td>';
  echo '</tr>';
}
?>
            </tbody>
          </table>
<?php 
} else {
?>
<div class="row">
<div class="col-sm-6">
        <table class="table table-bordered table-condensed table-body-center">
            <thead>
                <tr>
                  <th style="width: 50%;">Date</th>
                  <th style="width: 50%;">Soldes</th>
                </tr>
            </thead>
            <tbody>
<?php
//On récupère les montants du solde
$sqlhistorique = $con->query("SELECT mois, montant FROM 3il_soldes_historique WHERE union_parents ='".$id_union[0][0]."'");
$reqhistorique = $sqlhistorique->fetch_all();
$ligne2 = $sqlhistorique->num_rows;
for ($a = 0; $a < $ligne2; $a++){
  $sqldate = $con->query("SELECT mois_annee FROM 3il_mois_annee WHERE id_mois_annee = '".$reqhistorique[$a][0]."'");
  $reqdate = $sqldate->fetch_row();
  echo '<tr id="'.$a.'">';
  echo ' <td data-title="Date">';
  echo $reqdate[0];
  echo '</td>';
  echo '<td data-title="Montant">';
  echo $reqhistorique[$a][1];
  echo '</td>';
  echo '</tr>';
}
?>
            </tbody>
          </table>
        </div>
<div class="col-sm-6">
        <table class="table table-bordered table-condensed table-body-center">
            <thead>
                <tr>
                  <th style="width: 50%;">Date</th>
                  <th style="width: 50%;">Soldes</th>
                </tr>
            </thead>
            <tbody>
<?php
//On récupère les montants du solde
$sqlhistorique = $con->query("SELECT mois, montant FROM 3il_soldes_historique WHERE union_parents ='".$id_union[1][0]."'");
$reqhistorique = $sqlhistorique->fetch_all();
$ligne2 = $sqlhistorique->num_rows;
for ($a = 0; $a < $ligne2; $a++){
  $sqldate = $con->query("SELECT mois_annee FROM 3il_mois_annee WHERE id_mois_annee = '".$reqhistorique[$a][0]."'");
  $reqdate = $sqldate->fetch_row();
  echo '<tr id="'.$a.'">';
  echo ' <td data-title="Date">';
  echo $reqdate[0];
  echo '</td>';
  echo '<td data-title="Montant">';
  echo $reqhistorique[$a][1];
  echo '</td>';
  echo '</tr>';
}
?>
            </tbody>
          </table>
        </div>
      </div>
<?php
}
?>
      </div>
    </body>
    </html>
  