<?php
include("architecture/connexion.php");
$user = $_SESSION['user'];
$sqlrole = $con->query("SELECT role FROM 3il_utilisateurs WHERE email='".$user."'");
$reqrole = $sqlrole->fetch_row(); 
$role = $reqrole[0];
if ($role != 4){
  echo "<script language=\"javascript\">";
  echo "alert('Vous n'avez pas les droits pour accéder à cette page !')";
  echo "</script>";
  header('Refresh: 0.5; accueil.php');
  exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <?php include("architecture/head.html"); ?>
    <link href='CSS/admin.css' rel='stylesheet' />
</head>
<body id="body">  
  <?php include("architecture/header.php"); ?>
  <br />
  <div class="container">
    <h1>Ajouter un parent :</h1>
    <form name="candidature" id="f_candidature" action="PHP/creer_session.php" onsubmit="return verifier_format_email(document.candidature.email)" method="POST" >
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
                <label for="inputEmail">Email</label>
                <input type="email" class="form-control" name="email" id="inputEmail" onblur="verifier_email()" placeholder="Email" required>
            </div>
            <div class="form-group col-md-6">
                <label for="inputPassword">Mot de passe</label>
                <input type="password" class="form-control" name="password" id="inputPassword" placeholder="Mot de passe" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputPhone1">Téléphone 1</label>
                <input type="text" class="form-control" name="phone1" id="inputPhone1"  placeholder="05 06 07 08 09" required>
            </div>
            <div class="form-group col-md-6">
                <label for="inputPhone2">Téléphone 2</label>
                <input type="text" class="form-control" name="phone2" id="inputPhone2" placeholder="06 07 08 09 10" required>
            </div>
        </div>
        <div class="form-group">
            <label for="inputAdresse">Adresse</label>
            <input type="text" class="form-control" name="adresse" id="inputAdresse" placeholder="1 rue Dupont" required>
        </div>
        <div class="form-group">
            <label for="inputAdresse2">Adrese 2</label>
            <input type="text" class="form-control" name="adresse2" id="inputAdresse2" placeholder="Apartement, bâtiment, étage">
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputVille">Ville</label>
              <input type="text" class="form-control" name="ville" id="inputVille" required>
          </div>
          <div class="form-group col-md-2">
              <label for="inputCp">Code postal</label>
              <input type="text" class="form-control" name="cp" id="inputCp" required>
          </div>
        </div>
        <div id="Inscription">
        <input type="submit" class="btn btn-dark" value="Inscription">
      </div>
    </form>

<script type="text/javascript">

    function verifier_format_email(mail) {
      var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
      if(mail.value.match(mailformat))
      {
        return true;
      }
      else
      {
        alert("Adresse mail non valide !");
        return false;
      }
    }
</script>

  </div>
  <div class="container">
    <h1>Attribuer un role :</h1>
      <form name="candidature" id="f_candidature" method="POST" action="traitement_profil.php">
        <div class="form-group">
          <label>Utilisateur : </label>
            <select class="form-control" name="utilisateur" >
<?php
//On récupère les utilisateurs
$sql0 = $con->query("SELECT id_user, prenom, nom FROM 3il_utilisateurs");
$req0 = $sql0->fetch_all();
$ligne = $sql0->num_rows;
// echo $ligne;
for ($a = 0; $a < $ligne; $a++){
  echo '<option value="';
  echo $req0[$a][0];
  echo '">';
  echo $req0[$a][1];
  echo ' ';
  echo $req0[$a][2];
  echo '</option>';
}
?>
            </select>
          </div>
        <div class="form-group">
          <label>Profil :</label>
            <select class="form-control" name="profils" >
<?php
//On récupère les utilisateurs
$sql1 = $con->query("SELECT id_roles, nom FROM 3il_roles");
$req1 = $sql1->fetch_all();
$ligne = $sql1->num_rows;
// echo $ligne;
for ($a = 0; $a < $ligne; $a++){
  echo '<option value="';
  echo $req1[$a][0];
  echo '">';
  echo $req1[$a][1];
  echo '</option>';
}
?>
          </select>
        </div>
        <div id="Inscription">
        <input type="submit" class="btn btn-dark" value="Attribuer">
      </div>


    </body>
    </html>