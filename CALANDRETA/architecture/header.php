<!-- Ceci est le header des pages, il contient la navigation-->
<header>

	<nav id="nav" class="navbar navbar-light bg-light">

		<a href="accueil"><img src="images/logo_calandreta.png" id="logo"/></a>

		<ul id="list_b_nav" class="nav justify-content-center">
			<li class="nav-item"><a href="accueil.php" id="b_nav" class="btn btn-light">Accueil</a></li>
			<li class="nav-item"><a href="enfants.php" id="b_nav" class="btn btn-light">Enfants</a></li>
			<li class="nav-item"><a href="planning.php" id="b_nav" class="btn btn-light">Planning</a></li>
			<li class="nav-item"><a href="cantine.php" id="b_nav" class="btn btn-light">Cantine</a></li>
			<li class="nav-item"><a href="admin.php" id="b_nav" class="btn btn-light">Admin</a></li>
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
		document.location.href="PHP/vider_session.php";
	}
</script>