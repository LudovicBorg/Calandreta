<?php
//on actualise la session
session_start();
//On vérifie qu'elle soit bien définie
if(!empty($_SESSION['user']) || !empty($_SESSION['password']))
{
	//Rediriger sur la page accueil
    header('Location: accueil.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <?php include("architecture/head.html"); ?>
    <link rel="stylesheet" type="text/css" href="css/inscription_ss.css" media="screen" />
    <script src="js/verifier_non_duplicat.js" type="text/javascript"></script>
</head>

<body id="body">

    

    <form id="form_titre"><h1 class="h" id="titre_form">INSCRIPTION</h1></form>

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
        <a href="index.php" class="btn btn-dark">Annuler</a>
        <input type="submit" class="btn btn-dark" value="Inscription">

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
</body>
</html>