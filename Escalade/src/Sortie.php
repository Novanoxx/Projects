<?php
	session_start();
	include("connexion.inc.php");
	if (isset($_SESSION['login']) && isset($_SESSION['pwd']) ){
		echo "<html>
			<head>
				<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"/>
				<title> Sortie</title>
				<link rel = \"stylesheet\" href = \"Accueil.css\"/>
			</head>
			<body>
				<a href = \"Accueil.php\"> <img src =\"logoFE.png\"></a>
				<p id = \"Perso\"><a href = \"Deco.php\"> DECONNEXION</a></p>";
		$resultat = $cnx->query("SELECT noma, prenom, age FROM adherent WHERE emaila = '".$_SESSION['login']."' ");
		foreach($resultat as $valeur){
			printf("<br><b>Identifié en tant que :</b> %s %s %sans <br>", $valeur['noma'], $valeur['prenom'], $valeur['age']);
		}
		$resultat->closeCursor();

		$resultat = $cnx->query("SELECT exercer.notefr, noteen, noteus FROM exercer, difficulte WHERE exercer.notefr = difficulte.notefr AND exercer.emaila = '".$_SESSION['login']."' ");
		foreach($resultat as $valeur){
			printf("<b>NiveauFR:</b> %s <br>
					<b>NiveauEN:</b> %s <br>
					<b>NiveauUS:</b> %s", $valeur['notefr'], $valeur['noteen'], $valeur['noteus']);
		}
		$resultat->closeCursor();
		echo "	<nav>
					<ul>
						<li class=\"Menu\"><a>SORTIE</a></li>
						<li class=\"Cordee\"><a href=\"Profil.php\">MON PROFIL</a></li>
						<li class=\"Cordee\"><a href=\"ProposerS.php\">PROPOSER UNE SORTIE</a></li>
					</ul>
				</nav>";

		echo "<h3>Mes sorties:</h3>";
		$resultat = $cnx->query("SELECT invitemax, nivmin, dates, psortie.nums
										FROM (sortie NATURAL JOIN proposer) AS psortie, adherent
										WHERE psortie.emaila = adherent.emaila AND adherent.emaila='".$_SESSION['login']."' ");
		echo "<form method=\"GET\" >";
		foreach ($resultat as $valeur){
			echo "<div class=\"Sortie\">";
			printf("<p><u><b>Date de la sortie:</u> %s </b><br>
						Niveau minimum: %s <br>
						Invitation maximum: %s <br></p>",$valeur['dates'],
														$valeur['nivmin'],
														$valeur['invitemax']);
			echo "<b></u>Description de la sortie:</u></b><br>";
			$resultatB = $cnx->query("SELECT description FROM proposer WHERE emaila='".$_SESSION['login']."' AND nums='".$valeur['nums']."' ");
			foreach ($resultatB as $valeurB){
				printf("<p>%s</p>", $valeurB['description']);
			}
			echo "</div>";
			echo "<a href=\"AnnuleS.php?nums='".$valeur['nums']."' \" class=\"bouton\">Annuler la sortie</a><br>";
			echo "<a href=\"ClosS.php?nums='".$valeur['nums']."' \" class=\"bouton\">Clôturer la sortie</a><br>";
		}
		echo "</form>";
		
		echo "<h3>Autre sorties:</h3>";
		$resultat = $cnx->query("SELECT noma, prenom, invitemax, nivmin, dates, psortie.emaila, psortie.nums
									FROM (sortie NATURAL JOIN proposer) AS psortie, adherent
									WHERE psortie.emaila = adherent.emaila");
		foreach ($resultat as $valeur){
			if ($valeur['emaila'] <> $_SESSION['login']){
				echo "<div class=\"Sortie\">";
				printf("<b>Auteur de la sortie: %s %s</b>	%s<br>
						Date de la sortie: %s <br>
						Niveau minimum: %s <br>
						Invitation maximum: %s <br>", $valeur['noma'],
														$valeur['prenom'],
														$valeur['emaila'],
														$valeur['dates'],
														$valeur['nivmin'],
														$valeur['invitemax']);
				echo "</div>";
				echo "<a class=\"bouton\" href=\"RejoindreS.php?niv='".$valeur['nivmin']."'&nums='".$valeur['nums']."'\">Rejoindre</a> ";
			}
		}
		$resultat->closeCursor();
		
		echo "</body>
			</html>";
	}
	else{
		echo "Vous devez être connecté pour accéder à cette page";
	}
?>