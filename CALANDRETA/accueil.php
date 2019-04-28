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
    <link rel="stylesheet" type="text/css" href="css/accueil_ss.css" media="screen" />
</head>

<body id="body">  

    <?php include("architecture/header.php"); ?>

    <form class="form-inline" id="f_recherche">
        <div>
            <input class="form-control mr-sm-2" type="search" placeholder="Rechercher un véhicule">
            <button class="btn btn-danger" type="submit" id="search">Recherche</button>
        </div>
    </form>

    <form id="f_bienvenue">
        <div>
            Bienvenue sur le site de la CALANDRETA.<br><br>
            <pre>
              _____________
            < Oh la vache !>
              -------------
                     \   ^__^ 
                      \  (oo)\_______
                         (__)\       )\/\
                             ||----w |
                             ||     ||
  </pre>
        </div>
    </form>

    </body>
    </html>