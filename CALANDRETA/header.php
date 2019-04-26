<!-- Ceci est le header des pages, il contient la navigation-->
<header>

	<nav id="nav" class="navbar navbar-light bg-light">

		<a href="accueil"><img src="images/logo_calandreta.png" id="logo"/></a>

		<ul id="list_b_nav" class="nav justify-content-center">
			<li class="nav-item"><a href="accueil" id="b_nav" class="btn btn-light">Accueil</a></li>
			<li class="nav-item"><a href="utilisateurs" id="b_nav" class="btn btn-light">Utilisateurs</a></li>
			<?php
			//Permet d'afficher ou masquer le bouton Candidats s'il y a un utilisateur connecté et s'il a les droits admin
			if((!empty($_SESSION['user']) || !empty($_SESSION['password'])) && $_SESSION['role'] == 5)
			{
				echo('<li class="nav-item"><a href="candidats" id="b_nav" class="btn btn-light">Candidats</a></li>');
			}
			?>
			<li class="nav-item"><a href="sites" id="b_nav" class="btn btn-light">Sites</a></li>
			<li class="nav-item"><a href="vehicules" id="b_nav" class="btn btn-light">Véhicules</a></li>
			<li class="nav-item"><a href="profil" id="b_nav" class="btn btn-light">Profil</a></li>
			<?php
			//Permet d'afficher ou masquer le bouton déconnexion s'il y a un utilisateur connecté.
			if(!empty($_SESSION['user']) || !empty($_SESSION['password']))
			{
				echo('<li class="nav-item"><button type="button" tittle="Déconnexion" id="b_deconnexion"class="btn btn-light" onclick="deconnexion()"></button></li>');
			}
			?>
		</ul>
		
	</nav> 

</header>

<script type="text/javascript">
	function deconnexion(){
		document.location.href="../PHP/vider_session.php";
	}
</script>