<?php
include("../architecture/connexion.php");
//On récupère la semaine type de l'enfant
$id_enfant = $_POST['id'];

  $sqlsemainetype = $con->query("SELECT id_cantine_type, lundi, mardi, jeudi, vendredi FROM cantine_type WHERE enfant='$id_enfant'");
  $reqsemainetype = $sqlsemainetype->fetch_all();

  echo json_encode($reqsemainetype[0]);
  //print_r($reqsemainetype[0]);
  ?>