<?php
//on actualise la session
session_start();
//On vérifie qu'elle soit bien définie
if(!empty($_SESSION['user']) || !empty($_SESSION['password']))
{
    header('Location: accueil.php');
    exit();
}
$con=mysqli_connect("localhost", 'root', 'Toto123', "calandreta");
if(mysqli_connect_errno($con))
{
    echo "Erreur de connexion : ".mysqli_connect_error();
}
?>
<!DOCTYPE html>
<html>
<head>
    <?php include("architecture/head.html"); ?>
    <link rel="stylesheet" type="text/css" href="css/connexion_ss.css" media="screen" />
    <script src="js/demarrer_session.js" type="text/javascript"></script>
</head>
<br />
<body id="body">
    <form id="f_connexion" action="PHP/demarrer_session.php" method="POST">

        <h1 class="h">Connexion</h1>

        <div class="form-group row">
            <label for="inputId" class="col-md-4 col-form-label text-md-right">Identifiant</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="id_con" name="identifiant" autocomplete="username" placeholder="Identifiant">
            </div>
        </div>
        <div class="form-group row">
            <label for="inputPassword" class="col-md-4 col-form-label text-md-right">Mot de passe</label>
            <div class="col-sm-6">
                <input type="password" class="form-control" id="pwd_con" name="password" autocomplete="new-password" placeholder="Mot de passe">
            </div>
        </div>
        <div class="col-md-6 offset-md-4">

            <a href="inscription.php" id="b_postuler" class="btn btn-dark">Inscription</a>
            <input class="btn btn-dark" type="submit" id="b_connexion" onclick="demarrer_session()" value="Connexion"/>
<!-- <input class="btn btn-dark" type="submit" id="b_connexion" value="Connexion"/> -->
            <a href="#" class="btn btn-link">Mot de Passe oublié?</a>
        </div>
        <div class="col-md-6 offset-md-4">
    </div>

    </form>

</body>

</html>
