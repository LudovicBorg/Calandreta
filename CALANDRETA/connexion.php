<?php
//on actualise la session
session_start();
//On vérifie qu'elle soit bien définie
if(!empty($_SESSION['user']) || !empty($_SESSION['password']))
{
    header('Location: accueil');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <?php include("head.html"); ?>
    <link rel="stylesheet" type="text/css" href="css/connexion_ss.css" media="screen" />
    <script src="js/demarrer_session.js" type="text/javascript"></script>
</head>


<body id="body">
    <?php include("header.php"); ?>
    <form id="f_connexion" action="" method="POST">

        <h1 class="h">Connexion</h1>

        <div class="form-group row">
            <label for="inputId" class="col-md-4 col-form-label text-md-right">Identifiant</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="id_con" name="identifiant" autocomplete="username" placeholder="Identifiant">
            </div>
        </div>
        <div class="form-group row">
            <label for="inputPassword" class="col-md-4 col-form-label text-md-right">Mot de passe</label>
            <div class="col-sm-4">
                <input type="password" class="form-control" id="pwd_con" name="password" autocomplete="new-password" placeholder="Mot de passe">
            </div>
        </div>
        <div class="col-md-6 offset-md-4">
            <a href="candidature" id="b_postuler" class="btn btn-dark">Inscription</a>
            <button id="b_connexion" onclick="demarrer_session()" class="btn btn-dark">Connexion</button>
            <a href="#" class="btn btn-link">Mot de Passe oublié?</a>
        </div>
        <div class="col-md-6 offset-md-4">
    </div>

    </form>

</body>

</html>
