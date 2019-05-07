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
    <script src='//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js'></script>
    <script src="js/incrementing.js"></script>
    <script src="js/modifier_prix.js"></script>
</head>
<body id="body">
    <?php include("architecture/header.php"); ?>
    <br />
<?php
// Récupération du prix du repas
$sqlprix = $con->query("SELECT montant FROM montant_cantine");
$prix = $sqlprix->fetch_row();
$prix = $prix[0];
?>
<!-- <form action="traitement_modifier_prix.php" method="POST"> -->
  <div class="container" id="repas">
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
<!-- </form> -->
  <div class="container">
    <h1> Ajouter un chèque : </h1>
      <form name="enfant" id="f_candidature" action="traitement_ajouter_enfant.php"  method="POST" >
        <div class="form-row">
              <div class="form-group col-md-6">
                  <label>Date du chèque :</label>
                  <input type="text" class="form-control" name="date_cheque" placeholder="Nom" required>
              </div>
              <div class="form-group col-md-6">
                  <label>Numéro du chèque :</label>
                  <input type="text" class="form-control" name="prenom" placeholder="Prénom" required>
              </div>
          </div>
          <div class="form-row">
              <div class="form-group col-md-6">
                  <label>Montant :</label>
                  <input type="text" class="form-control" name="montant_cheque"  placeholder="Montant" required>
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
$sqlcountligneuser = $con->query("SELECT id_user FROM utilisateurs");
$reqcountligneuser = $sqlcountligneuser->fetch_all();
$ligne2 = $reqcountligneuser->num_rows;

for ($a = 0; $a < $ligne2; $a++){
//On récupère les noms des utilisateurs
$sqlnoms = $con->query("SELECT nom, prenom FROM utilisateurs WHERE id_user = '".$reqparents[$a][0]."'");
$reqnoms = $sqlnoms->fetch_all();
}
for($a = 0; $a < $ligne; $a++){
    echo '<option value="';
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
<?php
echo $reqparents[0][0];
echo $reqnoms[0][0];
echo $reqnoms[0][1];
echo $reqnoms[1][0];
echo $reqnoms[1][1];
?>
          </div>
        </form>
  </div>
  
</body>