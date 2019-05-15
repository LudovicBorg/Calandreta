<?php
include("architecture/connexion.php");
$user = $_SESSION['user'];
$sqlrole = $con->query("SELECT role FROM utilisateurs WHERE email='".$user."'");
$reqrole = $sqlrole->fetch_row(); 
$role = $reqrole[0];
if ($role != 2 AND $role != 4){
  echo "<script language=\"javascript\">";
  echo "alert('Vous n'avez pas les droits pour accéder à cette page !')";
  echo "</script>";
  header('Location: accueil.php');
  exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <?php include("architecture/head.html"); ?>
    <link href='CSS/cantine.css' rel='stylesheet' />
    <script src="js/demarrer_session.js" type="text/javascript"></script>
    <script src="js/ajouter_un_cheque.js" type="text/javascript"></script>
    <script src='//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js'></script>
    <script src="js/incrementing.js"></script>
    <script src="js/modifier_prix.js"></script>
</head>
<body id="body">
    <?php include("architecture/header.php"); ?>
    <!--===== Partie pour afficher différentes fonctionnalités =====-->
<script>
$(document).ready(function(){
  $("#repas_but").click(function(){
    $("#prix_container").hide();
    $("#cheque_container").hide();
    $("#soldes_container").hide();
    $("#repas_container").show();
  });
  $("#cheque_but").click(function(){
    $("#prix_container").hide();
    $("#soldes_container").hide();
    $("#repas_container").hide();
    $("#cheque_container").show();
    });
  $("#soldes_but").click(function(){
    $("#prix_container").hide();
    $("#cheque_container").hide();
    $("#repas_container").hide();
    $("#soldes_container").show();
    });
  $("#prix_but").click(function(){
    $("#cheque_container").hide();
    $("#soldes_container").hide();
    $("#repas_container").hide();
    $("#prix_container").show();
    });
});
</script>
<!--===== Fin du script =====-->
<!--===== Navigation =====-->
      <div id="choix">
        <div class="row" id="nav">
        <div class="col-sm-3">
          <label id="repas_but">Repas à commander</label>
          <input type="radio" id="repas_but" class="btn btn-dark">
        </div>
        <div class="col-sm-3">
          <label id="cheque_but">Déposer un chèque</label>
          <input type="radio" id="cheque_but" class="btn btn-dark">
        </div>
        <div class="col-sm-3">
          <label id="soldes_but">Voir les soldes</label>
          <input type="radio" id="soldes_but" class="btn btn-dark">
        </div>
        <div class="col-sm-3">
          <label id="prix_but">Modifier prix</label>
          <input type="radio" id="prix_but" class="btn btn-dark">
        </div>
      </div>
      </div>
    <br />

<div class="container" id="repas_container">
      <div class="w3-content w3-display-container">
<?php
// Numéro de la semaine
$week = date('W');
$week = $week + 1;
$annee = date('Y');
// ON recupere les lundi et vendredi de la semaine 
$sqlweek = $con->query("SELECT id_semaine, lundi, vendredi FROM semaines WHERE numero='".$week."' AND annee='".$annee."'");
$reqweek = $sqlweek->fetch_row();
$objdate1 = date_create($reqweek[1]);
$date_lundi = $objdate1->format('d/m/Y');
$objdate2 = date_create($reqweek[2]);
$date_vendredi = $objdate2->format('d/m/Y');
// On recupere tous les enregistrements de la cantine pour une semaine
$toutelacantine = $con->query("SELECT lundi, mardi, jeudi, vendredi, enfant FROM cantine WHERE semaine='".$reqweek[0]."'");
$reqtoutelacantine = $toutelacantine->fetch_all();
$ligne = $toutelacantine->num_rows;


for ($a=0; $a<$ligne; $a++){
// On recupere les noms des enfants
$sqlnomsenfants = $con->query("SELECT nom, prenom FROM enfants WHERE id_enfant='".$reqtoutelacantine[$a][4]."'");
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
$sqlnomsenfants = $con->query("SELECT nom, prenom FROM enfants WHERE id_enfant='".$reqtoutelacantine[$a][4]."'");
$reqnomsenfants = $sqlnomsenfants->fetch_row();
  echo $reqnomsenfants[0];
  echo ' ';
  echo $reqnomsenfants[1];
  echo '</td>';
  echo '<td data-title="Lundi">';
$sqlreponsecantine = $con->query("SELECT lundi, mardi, jeudi, vendredi FROM cantine WHERE enfant='".$reqtoutelacantine[$a][4]."' AND semaine='".$reqweek[0]."'");
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
          </div>
        </div>


  <div class="container" id="prix_container" style="display:none">
<?php
// Récupération du prix du repas
$sqlprix = $con->query("SELECT montant FROM montant_cantine");
$prix = $sqlprix->fetch_row();
$prix = $prix[0];
?>
    <div class="row">
      <div class="col-sm-6">
        <h1>Modifier le prix d'un repas :</h1>
      </div>
      <div class="col-sm-6">
        <div class="numbers-row">
          <span></span>
          <input type="text" name="prix" id="french-hens" value="<?php echo $prix; ?>">
        </div>
          <button class="btn btn-primary" id="Valider2" onclick="modifier_prix()">Modifier </button>
      </div>
    </div>
  </div>

  <div class="container" id="cheque_container" style="display:none">
    <h1> Ajouter un chèque : </h1>
        <div class="form-row">
              <div class="form-group col-md-6">
                  <label>Date du chèque :</label>
                  <input type="date" class="form-control" name="date_cheque" required>
              </div>
              <div class="form-group col-md-6">
                  <label>Numéro du chèque :</label>
                  <input type="text" class="form-control" name="numero_cheque" required>
              </div>
          </div>
          <div class="form-row">
              <div class="form-group col-md-6">
                  <label>Montant :</label>
                  <input type="text" class="form-control" name="montant_cheque" required>
              </div>
              <div class="form-group col-md-6">
                  <label>Parents :</label>
                  <select class="form-control" name="parents" >
<?php
//On récupère les id utilisateurs
$sqlparents = $con->query("SELECT id_union, parent1, parent2 FROM union_parents");
$reqparents = $sqlparents->fetch_all();
$ligne = $sqlparents->num_rows;
// echo $ligne;
//On récupère ensuite les noms et on les affiches dans une liste
for($a = 0; $a < $ligne; $a++){
$sqlnoms = $con->query("SELECT prenom, nom FROM utilisateurs WHERE id_user='".$reqparents[$a][1]."' OR id_user='".$reqparents[$a][2]."'"); 
$reqnoms = $sqlnoms->fetch_all();
    echo '<option value="';
  echo $reqparents[$a][0];
  echo '" id=">';
    echo $reqparents[$a][0];
  echo '">';
  echo $reqnoms[$a][0];
  echo ' ';
  echo $reqnoms[$a][1];
  echo ' et ';
  echo $reqnoms[$a+1][0];
  echo ' ';
  echo $reqnoms[$a+1][1];
  echo '</option>';
}
?>
            </select>
          </div>
          </div>
          <div id="ajouter">
        <button class="btn btn-dark" id="ajouter" onclick="ajouter_un_cheque()">Ajouter</button>
      </div>

  </div>

  <div class="container" id="soldes_container" style="display:none">
    toto
  </div>
  
</body>