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
    <link href='CSS/cantine.css' rel='stylesheet' />
    <script src="js/demarrer_session.js" type="text/javascript"></script>
</head>
<body id="body">
    <?php include("architecture/header.php"); ?>
    <br />
    <div class="container" id="solde">
      <!-- <div class="col-sm-6"> -->
      <h1>Solde :</h1>
<?php
//On récupère id utilisateur connecté
$sql0 = $con->query("SELECT id_user FROM utilisateurs WHERE email='".$user."'");
$req0 = $sql0->fetch_row();
// echo $req0[0];
//On récupère le montant du solde
$sqlsolde = $con->query("SELECT id_solde, montant FROM solde WHERE parent1='".$req0[0]."' OR parent2='".$req0[0]."'");
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
      <!-- </div> -->
<!--       <div class="col-sm-6">
        <h1>Historique :</h1>
      </div> -->
    </div>
   <div class="container">
          <h1>Enfant :</h1>
<!--===== Code qui affiche les noms des différents enfants =====-->
          <form method="POST" action="traitementcantine.php">
            <select class="form-control" name="nom_enfant" >
<?php
//On récupère nom et prénom des enfants
$sql1 = $con->query("SELECT prenom, nom FROM enfants WHERE parent1='".$req0[0]."' OR parent2='".$req0[0]."'");
$req1 = $sql1->fetch_all();
$ligne = $sql1->num_rows;
// echo $ligne;
for ($a = 0; $a < $ligne; $a++){
  echo '<option>';
  echo $req1[$a][0];
  echo ' ';
  echo $req1[$a][1];
  echo '</option>';
}
?>
            </select>
          </div>

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
echo '<input name="lundi" type="hidden" value="'.$date_lundi.'">';
// echo $date_lundi;
// Affiche la date du prochain vendredi
$date = date('Y-m-d');
$objdate = date_create($date . ' Next Monday');
$date_lundi2 = $objdate->format('Y-m-d');
$objdate = date_create($date_lundi2 . ' Next Friday');
$date_vendredi = $objdate->format('d/m/Y');
echo '<input name="vendredi" type="hidden" value="'.$date_vendredi.'">';
// echo $date_vendredi;
//Récupération de l'année
$annee = date('Y');
echo '<input name="annee" type="hidden" value="'.$annee.'">';
?>
    <div class="container">
      <div class="w3-content w3-display-container">
          <h1>
            Semaine du <?php echo $date_lundi; ?> au <?php echo $date_vendredi; ?> :
          </h1>
          <table class="table table-bordered table-condensed table-body-center">
            <thead>
                <tr>
                  <th style="width: 25%;"><center>Lundi</center></th>
                  <th style="width: 25%;"><center>Mardi</center></th>
                  <th style="width: 25%;"><center>Jeudi</center></th>
                  <th style="width: 25%;"><center>Vendredi</center></th>
                </tr>
            </thead>
            <tbody>
                <tr id="tr_1">
                    <td data-title="Lundi">                     
                    <center>
                        <label class="switch"><input type="checkbox" id="togBtn"  name="Lundi" value="OUI">
                        <div class="slider round"></div>
                        </label>             
                    </center> 
                  </td>
                  <td data-title="Mardi">                     
                    <center>
                        <label class="switch"><input type="checkbox" id="togBtn"  name="Mardi" value="OUI">
                        <div class="slider round"></div>
                        </label>             
                    </center> 
                  </td>
                  <td data-title="Jeudi">                     
                    <center>
                       <label class="switch"><input type="checkbox" id="togBtn" name="Jeudi" value="OUI">
                       <div class="slider round" ></div>
                       </label>                               
                    </center>
                  </td>
                  <td data-title="Vendredi">                    
                    <center>
                       <label class="switch"><input type="checkbox" id="togBtn" name="Vendredi" value="OUI">
                       <div class="slider round"></div>  
                       </label>                               
                    </center> 
                  </td> 
                  </tr>
            </tbody>
          </table>
          </div>
            <input type="submit" class="btn btn-primary" value="Valider" id="Valider">
          </div>
      </form>
<div class="container">
<h1>Historique :</h1>
</div>