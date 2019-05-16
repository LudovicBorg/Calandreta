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

<?php
  $id_enfant = $_POST['id_enfant'];

//On récupère nom et prénom des enfants
$sql1 = $con->query("SELECT prenom, nom, datenaissance, classe FROM 3il_enfants WHERE id_enfant='$id_enfant'");
$req1 = $sql1->fetch_all();

//On récupère la semaine type de l'enfant
  $sqlsemainetype = $con->query("SELECT id_cantine_type, lundi, mardi, jeudi, vendredi FROM 3il_cantine_type WHERE enfant='$id_enfant'");
  $reqsemainetype = $sqlsemainetype->fetch_all();

//On récupère l'id du parent 2
  $sqlparent2 = $con->query("SELECT parent2 FROM 3il_enfants WHERE id_enfant='$id_enfant'");
  $id_parent2 = $sqlparent2->fetch_row();

//On récupère nom et prénom
  $sqlparent2nom = $con->query("SELECT nom, prenom FROM 3il_utilisateurs WHERE id_user='$id_parent2[0]'");
  $reqparent2 = $sqlparent2nom->fetch_row();

?>

 <div class="container" id="ajouter_un_enfant">
      <h1>Modifier l'enfant <?php echo $req1[0][0];?></h1>
        <form  id="f_candidature" action="traitement_modifier_enfant.php"  method="POST" >
          <input type="hidden" name="id_enfant" value="<?php echo $id_enfant;?>">
          <div class="form-row">
              <div class="form-group col-md-6">
                  <label for="inputNom">Nom</label>
                  <input type="text" class="form-control" name="nom" id="inputNom" value="<?php echo $req1[0][1];?>" required>
              </div>
              <div class="form-group col-md-6">
                  <label for="inputPrenom">Prénom</label>
                  <input type="text" class="form-control" name="prenom" id="inputPrenom" value="<?php echo $req1[0][0];?>" required>
              </div>
          </div>
          <div class="form-row">
              <div class="form-group col-md-6">
                  <label for="inputDate">Date de naissance</label>
                  <input type="date" class="form-control" name="datenaissance" id="inputDate" value="<?php echo $req1[0][2];?>" required>
              </div>
              <div class="form-group col-md-6">
                  <label for="inputClasse">Classe</label>
            <select class="form-control" name="classe" id="inputclasse">
                      <option value="1" <?php if($req1[0][3] == '1'){echo 'selected';}?>>Toute petite section</option>
                      <option value="2" <?php if($req1[0][3] == '2'){echo 'selected';}?>>Petite section</option>
                      <option value="3" <?php if($req1[0][3] == '3'){echo 'selected';}?>>Moyenne section</option>
                      <option value="4" <?php if($req1[0][3] == '4'){echo 'selected';}?>>Grande section</option>
                      <option value="5" <?php if($req1[0][3] == '5'){echo 'selected';}?>>CP</option>
                      <option value="6" <?php if($req1[0][3] == '6'){echo 'selected';}?>>CE1</option>
                      <option value="7" <?php if($req1[0][3] == '7'){echo 'selected';}?>>CE2</option>
                      <option value="8" <?php if($req1[0][3] == '8'){echo 'selected';}?>>CM1</option>
                      <option value="9" <?php if($req1[0][3] == '9'){echo 'selected';}?>>CM2</option>
                        </select>
              </div>
              <div class="form-group col-md-12">
                <label for="inputparent2">Second parent</label>
            <select class="form-control" name="parent2" id="inputparent2">
                      <option value="<?php echo $id_parent2[0];?>" selected><?php echo $reqparent2[0]; echo ' '; echo $reqparent2[1];?></option>
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
                        <label class="switch"><input type="checkbox" id="togBtn"  name="Lundi" value="OUI" <?php if($reqsemainetype[0][1] == "OUI"){echo "checked";} ?>>
                        <div class="slider round"></div>
                        </label>              
                  </td>
                  <td data-title="Mardi">                     
                        <label class="switch"><input type="checkbox" id="togBtn"  name="Mardi" value="OUI" <?php if($reqsemainetype[0][2] == "OUI"){echo "checked";} ?>>
                        <div class="slider round"></div>
                        </label>             
                  </td>
                  <td data-title="Jeudi">                     
                       <label class="switch"><input type="checkbox" id="togBtn" name="Jeudi" value="OUI" <?php if($reqsemainetype[0][3] == "OUI"){echo "checked";} ?>>
                       <div class="slider round" ></div>
                       </label>                               
                  </td>
                  <td data-title="Vendredi">                    
                       <label class="switch"><input type="checkbox" id="togBtn" name="Vendredi" value="OUI" <?php if($reqsemainetype[0][4] == "OUI"){echo "checked";} ?>>
                       <div class="slider round"></div>  
                       </label>                               
                  </td> 
                  </tr>
            </tbody>
          </table>
            </div>
          </div>
            <div id="boutons">
        <input type="submit" class="btn btn-dark" id="Modifier" value="Modifier">
    </div>
      </form>
    </div>
  </body>
  </html>