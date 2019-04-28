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
   <div class="container">
          <h1>Enfant :</h1>
<!--===== Code qui affiche les noms des différents enfants =====-->
          <form method="POST" action="traitementcantine.php">
            <select class="form-control" name="nom_enfant" >
              <option value="" selected>Sélectionner un enfant</option>
<?php
//On récupère id utilisateur connecté
$sql0 = $con->query("SELECT id_user FROM utilisateurs WHERE email='".$user."'");
$req0 = $sql0->fetch_row();
// echo $req0[0];
//On récupère nom et prénom des enfants
$sql1 = $con->query("SELECT prenom, nom FROM enfants WHERE parent='".$req0[0]."'");
$req1 = $sql1->fetch_all();
$ligne = $sql1->num_rows;
// echo $ligne;
// for ($a = 0; $a < $ligne; $a++){
//   echo '<option>'.$req1["'".$a."'"][0].'</option>';
// }
echo '<option>'.$req1[0][0].'</option>';
echo '<option>'.$req1[1][0].'</option>';
echo '<option>'.$req1[2][0].'</option>';

?>
            </select>
          </div>

     <div class="col-sm-12 table-responsive">
      <div class="w3-content w3-display-container">
          <h1>
            Semaine du    au  :
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
      </form>
<h1>Historique :</h1>
