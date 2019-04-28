<?php
//on actualise la session
session_start();
//On vérifie qu'elle soit bien définie
if(empty($_SESSION['user']) || empty($_SESSION['password']))
{
    header('Location: index.php');
    exit();
}
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

    <h1>Ajouter un enfant</h1></form>
    <form name="enfant" id="f_candidature" action="PHP/traitementenfants.php"  method="POST" >
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
        <a href="accueil.php" class="btn btn-dark">Annuler</a>
        <input type="submit" class="btn btn-dark" value="Ajouter">

    </form>
