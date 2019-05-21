<?php
include("architecture/connexion.php");
$user = $_SESSION['user'];
$sqlrole = $con->query("SELECT role FROM 3il_utilisateurs WHERE email='".$user."'");
$reqrole = $sqlrole->fetch_row(); 
$role = $reqrole[0];
if ($role != 2 AND $role != 4){
  echo "<script language=\"javascript\">";
  echo "alert('Vous n'avez pas les droits pour accéder à cette page !')";
  echo "</script>";
  header('Location: accueil.php');
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <?php include("architecture/head.html"); ?>
  <link href='CSS/cantine.css' rel='stylesheet' />
  <script src="js/demarrer_session.js" type="text/javascript"></script>
  <script src="js/ajouter_un_cheque.js" type="text/javascript"></script>
  <script src='//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js'></script>
  <script src="js/incrementing.js"></script>
  <script src="js/modifier_prix.js"></script>
  <script src="js/semaine_cantine.js" type="text/javascript"></script>
</head>
<body id="body">
  <?php include("architecture/header.php"); ?>
  <!--===== Partie pour afficher différentes fonctionnalités =====-->
  <script>
    $(document).ready(function(){
      $("#repas_but").click(function(){
        $("#prix_container").hide();
        $("#cheque_container").hide();
        $("#soldes_container").hide();
        $("#ajouter_semaine_container").hide();
        $("#ferie_container").hide();
        $("#repas_container").show();
      });
      $("#cheque_but").click(function(){
        $("#prix_container").hide();
        $("#soldes_container").hide();
        $("#repas_container").hide();
        $("#ajouter_semaine_container").hide();
        $("#ferie_container").hide();
        $("#cheque_container").show();
      });
      $("#soldes_but").click(function(){
        $("#prix_container").hide();
        $("#cheque_container").hide();
        $("#repas_container").hide();
        $("#ajouter_semaine_container").hide();
        $("#ferie_container").hide();
        $("#soldes_container").show();
      });
      $("#prix_but").click(function(){
        $("#cheque_container").hide();
        $("#soldes_container").hide();
        $("#repas_container").hide();
        $("#ajouter_semaine_container").hide();
        $("#ferie_container").hide();
        $("#prix_container").show();
      });
      $("#ajouter_semaine_but").click(function(){
        $("#cheque_container").hide();
        $("#soldes_container").hide();
        $("#repas_container").hide();
        $("#prix_container").hide();
        $("#ferie_container").hide(); 
        $("#ajouter_semaine_container").show();
      });
      $("#ferie_but").click(function(){
        $("#cheque_container").hide();
        $("#soldes_container").hide();
        $("#repas_container").hide();
        $("#prix_container").hide();
        $("#ajouter_semaine_container").hide();
        $("#ferie_container").show();   
      });
    });
  </script>
  <!--===== Fin du script =====-->
  <a href="PHP/tache_planifiee_cantine.php" class="btn btn-dark" id="Administration_cantine">Génération manuelle de la semaine</a>
  <!--===== Navigation =====-->
  <div id="choix">
    <div class="row" id="nav">
      <div class="col-sm-2">
        <label id="repas_but">Repas à commander</label>
        <input type="radio" id="repas_but" class="btn btn-dark">
      </div>
      <div class="col-sm-2">
        <label id="cheque_but">Déposer un chèque</label>
        <input type="radio" id="cheque_but" class="btn btn-dark">
      </div>
      <div class="col-sm-2">
        <label id="ajouter_semaine_but">Ajouter une semaine</label>
        <input type="radio" id="ajouter_semaine_but" class="btn btn-dark">
      </div>
      <div class="col-sm-2">
        <label id="ferie_but">Déclarer jours fériés</label>
        <input type="radio" id="ferie_but" class="btn btn-dark">
      </div>
      <div class="col-sm-2">
        <label id="soldes_but">Voir les soldes</label>
        <input type="radio" id="soldes_but" class="btn btn-dark">
      </div>
      <div class="col-sm-2">
        <label id="prix_but">Modifier prix</label>
        <input type="radio" id="prix_but" class="btn btn-dark">
      </div>
    </div>
  </div>
  <br />


  <div class="container" id="repas_container">
    <div class="w3-content w3-display-container">
      <?php
// Numéro de la semaine
      $week = date('W');
      $week = $week + 1;
      $annee = date('Y');
// ON recupere les lundi et vendredi de la semaine 
      $sqlweek = $con->query("SELECT id_semaine, lundi, vendredi FROM 3il_semaines WHERE numero='".$week."' AND annee='".$annee."'");
      $reqweek = $sqlweek->fetch_row();
      $objdate1 = date_create($reqweek[1]);
      $date_lundi = $objdate1->format('d/m/Y');
      $objdate2 = date_create($reqweek[2]);
      $date_vendredi = $objdate2->format('d/m/Y');
// On recupere tous les enregistrements de la cantine pour une semaine
      $toutelacantine = $con->query("SELECT lundi, mardi, jeudi, vendredi, enfant FROM 3il_cantine WHERE semaine='".$reqweek[0]."'");
      $reqtoutelacantine = $toutelacantine->fetch_all();
      $ligne = $toutelacantine->num_rows;
      for ($a=0; $a<$ligne; $a++){
// On recupere les noms des enfants
        $sqlnomsenfants = $con->query("SELECT nom, prenom FROM 3il_enfants WHERE id_enfant='".$reqtoutelacantine[$a][4]."'");
        $reqnomsenfants = $sqlnomsenfants->fetch_row();
      }
      ?>
      <h1>
        Semaine du <?php echo $date_lundi; ?> au <?php echo $date_vendredi; ?> :
      </h1>
      <table class="table table-bordered table-condensed table-body-center">
        <thead>
          <tr>
            <th style="width: 20%;">Enfant</th>
            <th style="width: 20%;">Lundi</th>
            <th style="width: 20%;">Mardi</th>
            <th style="width: 20%;">Jeudi</th>
            <th style="width: 20%;">Vendredi</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th>Total</th>
            <td>
              <?php
//Requete pour compter le nombre de oui dans la colonne lundi
              $sommecantine_lundi = $con->query("SELECT COUNT(lundi) FROM 3il_cantine WHERE semaine='".$reqweek[0]."' AND lundi='OUI'");
              $reqsommecantine_lundi = $sommecantine_lundi->fetch_row();
              echo $reqsommecantine_lundi[0];
              ?>
            </td>
            <td>
              <?php
//Requete pour compter le nomnbre de oui dans la colonne mardi
              $sommecantine_mardi = $con->query("SELECT COUNT(mardi) FROM 3il_cantine WHERE semaine='".$reqweek[0]."' AND mardi='OUI'");
              $reqsommecantine_mardi = $sommecantine_mardi->fetch_row();
              echo $reqsommecantine_mardi[0];
              ?>
            </td>
            <td>
              <?php
//Requete pour compter le nomnbre de oui dans la colonne jeudi
              $sommecantine_jeudi = $con->query("SELECT COUNT(jeudi) FROM 3il_cantine WHERE semaine='".$reqweek[0]."' AND jeudi='OUI'");
              $reqsommecantine_jeudi = $sommecantine_jeudi->fetch_row();
              echo $reqsommecantine_jeudi[0];
              ?>
            </td>
            <td>
              <?php
//Requete pour compter le nomnbre de oui dans la colonne vendredi
              $sommecantine_vendredi = $con->query("SELECT COUNT(vendredi) FROM 3il_cantine WHERE semaine='".$reqweek[0]."' AND vendredi='OUI'");
              $reqsommecantine_vendredi = $sommecantine_vendredi->fetch_row();
              echo $reqsommecantine_vendredi[0];
              ?>
            </td>    
          </tr>

          <?php 
          for ($a=0; $a<$ligne; $a++){
            echo '<tr>';
            echo '<td data-title="Enfant">';
// On recupere les noms des enfants
            $sqlnomsenfants = $con->query("SELECT nom, prenom FROM 3il_enfants WHERE id_enfant='".$reqtoutelacantine[$a][4]."'");
            $reqnomsenfants = $sqlnomsenfants->fetch_row();
            echo $reqnomsenfants[0];
            echo ' ';
            echo $reqnomsenfants[1];
            echo '</td>';
            echo '<td data-title="Lundi">';
            $sqlreponsecantine = $con->query("SELECT lundi, mardi, jeudi, vendredi FROM 3il_cantine WHERE enfant='".$reqtoutelacantine[$a][4]."' AND semaine='".$reqweek[0]."'");
            $reqreponsecantine = $sqlreponsecantine->fetch_row();
            echo $reqreponsecantine[0];
            echo '</td>';
            echo '<td data-title="Mardi">';
            echo $reqreponsecantine[1];
            echo '</td>';
            echo '<td data-title="Jeudi">';
            echo $reqreponsecantine[2];
            echo '</td>';
            echo '<td data-title="Vendredi">';
            echo $reqreponsecantine[3];
            echo '</td>';
          }
          ?>
        </tbody>
      </table>
      <a href="PHP/imprimer_cantine.php" id="imprimer" class="btn btn-danger">Imprimer la liste</a>
    </div>
  </div>


  <div class="container" id="prix_container" style="display:none">
    <?php
// Récupération du prix du repas
    $sqlprix = $con->query("SELECT montant FROM 3il_montant_cantine");
    $prix = $sqlprix->fetch_row();
    $prix = $prix[0];
    ?>
    <div class="row">
      <div class="col-sm-6">
        <h1>Modifier le prix d'un repas :</h1>
      </div>
      <div class="col-sm-6">
        <div class="numbers-row">
          <span></span>
          <input type="text" name="prix" id="french-hens" value="<?php echo $prix; ?>">
        </div>
        <button class="btn btn-primary" id="Valider2" onclick="modifier_prix()">Modifier </button>
      </div>
    </div>
    <p>
      Pour un nombre à virgule, merci d'utiliser le point. Ex : 5.5
    </p>
  </div>

  <div class="container" id="cheque_container" style="display:none">
    <h1> Ajouter un chèque : </h1>
    <div class="form-row">
      <div class="form-group col-md-6">
        <label>Date du chèque :</label>
        <input type="date" class="form-control" name="date_cheque" required>
      </div>
      <div class="form-group col-md-6">
        <label>Numéro du chèque :</label>
        <input type="text" class="form-control" name="numero_cheque" required>
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-6">
        <label>Montant :</label>
        <input type="text" class="form-control" name="montant_cheque" required>
      </div>
      <div class="form-group col-md-6">
        <label>Parents :</label>
        <select class="form-control" name="parents" >
          <?php
//On récupère les id utilisateurs
          $sqlparents = $con->query("SELECT id_union, parent1, parent2 FROM 3il_union_parents");
          $reqparents = $sqlparents->fetch_all();
          $ligne = $sqlparents->num_rows;
// echo $ligne;
//On récupère ensuite les noms et on les affiches dans une liste
          for($a = 0; $a < $ligne; $a++){
            $sqlnoms = $con->query("SELECT prenom, nom FROM 3il_utilisateurs WHERE id_user='".$reqparents[$a][1]."'"); 
            $reqnoms = $sqlnoms->fetch_all();
            $sqlnoms2 = $con->query("SELECT prenom, nom FROM 3il_utilisateurs WHERE id_user='".$reqparents[$a][2]."'"); 
            $reqnoms2 = $sqlnoms2->fetch_all();
            echo '<option value="';
            echo $reqparents[$a][0];
            echo '" id=">';
            echo $reqparents[$a][0];
            echo '">';
            echo $reqnoms[0][0];
            echo ' ';
            echo $reqnoms[0][1];
            echo ' et ';
            echo $reqnoms2[0][0];
            echo ' ';
            echo $reqnoms2[0][1];
            echo '</option>';
          }
          ?>
        </select>
      </div>
    </div>
    <div id="ajouter">
      <button class="btn btn-dark" id="ajouter" onclick="ajouter_un_cheque()">Ajouter</button>
    </div>

  </div>

  <div class="container" id="soldes_container" style="display:none">
    <table class="table table-bordered table-condensed table-body-center">
      <thead>
        <tr>
          <th style="width: 80%;">Parents</th>
          <th style="width: 20%;">Solde</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        $sqlsoldes = $con->query("SELECT parent1, parent2, montant FROM 3il_solde, 3il_union_parents WHERE id_union = union_parents ORDER BY montant ASC"); 
        $reqsoldes = $sqlsoldes->fetch_all();
        $ligne = $sqlsoldes->num_rows;
        for($l=0; $l < $ligne; $l++)
        {
          $sqlnoms = $con->query("SELECT prenom, nom FROM 3il_utilisateurs WHERE id_user='".$reqsoldes[$l][0]."'"); 
          $reqnoms = $sqlnoms->fetch_all();
          $sqlnoms2 = $con->query("SELECT prenom, nom FROM 3il_utilisateurs WHERE id_user='".$reqsoldes[$l][1]."'"); 
          $reqnoms2 = $sqlnoms2->fetch_all();
          echo '<tr>';
          echo '<td data-title="Parents">';
          echo $reqnoms[0][0]; 
          echo ' ';  
          echo $reqnoms[0][1];  
          echo ' et '; 
          echo $reqnoms2[0][0];  
          echo ' ';  
          echo $reqnoms2[0][1];
          echo '</td>';
          echo '<td data-title="Solde">';
          echo $reqsoldes[$l][2]." €";
          echo '</td>';
          echo '</tr>';
        }
        ?>
      </tbody>
    </table>
  </div>

  <div class="container" id="ajouter_semaine_container" style="display:none">
   <h1>Enfant :</h1>
   <!--===== Code qui affiche les noms des différents enfants =====-->
   <form method="POST" action="traitementcantine.php">
    <select class="form-control" name="nom_enfant" id="id_enfant" onchange="update_week();">
      <?php
//On récupère nom et prénom des enfants
      $sql1 = $con->query("SELECT id_enfant, prenom, nom FROM 3il_enfants");
      $req1 = $sql1->fetch_all();
      $ligne = $sql1->num_rows;
      ?>
      <option selected="selected" disabled>Selectionner votre enfant</option>
      <?php
// echo $ligne;
      for ($a = 0; $a < $ligne; $a++){
        echo '<option value="';
        echo $req1[$a][0];
        echo '">';
        echo $req1[$a][1];
        echo ' ';
        echo $req1[$a][2];
        echo '</option>';
      }
      ?>
    </select>

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
    $date_lundi_formatsql = $objdate->format('Y-m-d');
    echo '<input name="lundi" type="hidden" value="'.$date_lundi_formatsql.'">';
// echo $date_lundi;
// Affiche la date du prochain vendredi
    $date = date('Y-m-d');
    $objdate = date_create($date . ' Next Monday');
    $date_lundi2 = $objdate->format('Y-m-d');
    $objdate = date_create($date_lundi2 . ' Next Friday');
    $date_vendredi = $objdate->format('d/m/Y');
    $date_vendredi_formatsql = $objdate->format('Y-m-d');
    echo '<input name="vendredi" type="hidden" value="'.$date_vendredi_formatsql.'">';
// echo $date_vendredi;
//Récupération de l'année
    $annee = date('Y');
    echo '<input name="annee" type="hidden" value="'.$annee.'">';
    ?>
    <div class="w3-content w3-display-container">
      <h1>
        Semaine du <?php echo $date_lundi; ?> au <?php echo $date_vendredi; ?> :
      </h1>
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
              <label class="switch"><input type="checkbox" id="lundi"  name="Lundi" value="OUI">
                <div class="slider round"></div>
              </label>              
            </td>
            <td data-title="Mardi">                     
              <label class="switch"><input type="checkbox" id="mardi"  name="Mardi" value="OUI">
                <div class="slider round"></div>
              </label>             
            </td>
            <td data-title="Jeudi">                     
             <label class="switch"><input type="checkbox" id="jeudi" name="Jeudi" value="OUI">
               <div class="slider round" ></div>
             </label>                               
           </td>
           <td data-title="Vendredi">                    
             <label class="switch"><input type="checkbox" id="vendredi" name="Vendredi" value="OUI">
               <div class="slider round"></div>  
             </label>                               
           </td> 
         </tr>
       </tbody>
     </table>
   </div>
   <input type="submit" class="btn btn-primary" value="Valider" id="Valider">
 </form>
</div>

<div class="container" id="ferie_container" style="display:none">
  <form action="PHP/modifier_periodes_conges.php" method="POST">
    <?php 
    $sql_periodes_conges = $con->query("SELECT * FROM 3il_periodes_conges"); 
    $req_periodes_conges = $sql_periodes_conges->fetch_all();
    $ligne = $sql_periodes_conges->num_rows;
    echo '<input type="hidden" name="nb_lignes_p" value="'.$ligne.'">';
    ?>
    <table class="table table-bordered table-condensed table-body-center">
      <thead>
        <tr>
          <th style="width: 10%;">#</th>
          <th style="width: 50%;">Libelle</th>
          <th style="width: 20%;">Date début</th>
          <th style="width: 20%;">Date fin</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        for($l = 0; $l < $ligne; $l++)
        {
          echo '<tr>';
          echo '<td data-title="id_periode">';
          echo $req_periodes_conges[$l][0];
          echo '</td>';
          echo '<td data-title="libelle_periode">';
          echo $req_periodes_conges[$l][1]; 
          echo '</td>';
          echo '<td data-title="date_debut">';
          echo '<input type="date" name="debut_'.$req_periodes_conges[$l][0].'" class="form-control" value="'.$req_periodes_conges[$l][2].'">';
          echo '</td>';
          echo '<td data-title="date_fin">';
          echo '<input type="date" name="fin_'.$req_periodes_conges[$l][0].'" class="form-control" value="'.$req_periodes_conges[$l][3].'">';
          echo '</td>';
          echo '</tr>';
        }
        ?>
      </tbody>
    </table>
    <?php 
    $sql_jours_conges = $con->query("SELECT * FROM 3il_jours_conges"); 
    $req_jours_conges = $sql_jours_conges->fetch_all();
    $ligne = $sql_jours_conges->num_rows;
    echo '<input type="hidden" name="nb_lignes_j" value="'.$ligne.'">';
    ?>
    <table class="table table-bordered table-condensed table-body-center">
      <thead>
        <tr>
          <th style="width: 10%;">#</th>
          <th style="width: 50%;">Libelle</th>
          <th style="width: 30%;">Date</th>
          <th style="width: 10%;">Supprimer</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        for($l = 0; $l < $ligne; $l++)
        {
          echo '<tr id="'.$req_jours_conges[$l][0].'">';
          echo '<td data-title="id_jour">';
          echo $req_jours_conges[$l][0];
          echo '</td>';
          echo '<td data-title="libelle_jour">';
          echo $req_jours_conges[$l][1]; 
          echo '</td>';
          echo '<td data-title="date">';
          echo '<input type="date" name="date_'.$req_jours_conges[$l][0].'" class="form-control" value="'.$req_jours_conges[$l][2].'">';
          echo '</td>';
          echo '<td data-title="supp">';
          echo '<button type="button" name="b_supp'.$req_jours_conges[$l][0].'" class="btn btn-danger" onclick=supprimer_jour('.$req_jours_conges[$l][0].')>Supprimer</button>';
          echo '</td>';
          echo '</tr>';
        }
        ?>
        <?php //Nouvelle date férié
        echo '<tr>';
        echo '<td data-title="new_id">';
        echo '#';
        echo '</td>';
        echo '<td data-title="new_libelle">';
        echo '<input type="text" name="new_libelle" class="form-control">';
        echo '</td>';
        echo '<td data-title="new_date">';
        echo '<input type="date" name="new_date" class="form-control">';
        echo '</td>';
        echo '</tr>';
        ?>
      </tbody>
    </table>
    <div id="b_valider_periodes">
    <input type="submit" name="b_valider_periodes" value="Valider" class="btn btn-dark">
  </div>
  </form>
</div>
</body>

<script type="text/javascript">
  function supprimer_jour(id)
  {
    var xmlhttp;
  console.log(id);
  xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function(){
    if(xmlhttp.readyState == 4){
      document.getElementById(id).remove();
      alert("La suppression a été effectuée.");
    } else {
    }
  }
  xmlhttp.open("POST", "PHP/supprimer_jour_conge.php", true);
  xmlhttp.setRequestHeader("Content-Type", 'application/x-www-form-urlencoded');
  xmlhttp.send("id=" + id);
  }
</script>