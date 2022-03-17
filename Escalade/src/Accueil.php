<?php
	session_start();
	if (isset($_SESSION['login']) && isset($_SESSION['pwd'])){
		include("connexion.inc.php");
		echo "<html>
				<head>
					<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"/>
					<title>Accueil</title>
					<link rel = \"stylesheet\" href = \"Accueil.css\"/>
				</head>";
		echo "<body>
				<p id = \"Perso\"><a href = \"Profil.php\"> ESPACE PERSONNEL</a></p>
				<h1><img src =\"logoFE.png\"></h1>
				<nav>
					<ul>
						<li><a class = \"Accueil\" href = \"Voie1.php\"> VOIE </a></li>
						<li><a class = \"Accueil\" href = \"Guide1.php\">LISTE DES GUIDES </a></li>
						<li><a class = \"Accueil\" href = \"Sortie.php\"> SORTIE </a></li>
					</ul>
				</nav>
				<div>
					<h2>Bienvenue sur France ESCALADE !</h2>
						<article>
							<p>
								France ESCALADE est une base de données regroupant des informations concernant l'escalade.<br />
								Vous pouvez retrouver sur ce site de nombreuses données, comme les voies, les guides, ou encore les sortie organisées.<br />
								Bonne visite !
							</p>
						</article>
				</div>";
		$resultat = $cnx->query("SELECT noma, prenom, invitemax, nivmin, dates
									FROM (sortie NATURAL JOIN proposer) AS psortie, adherent
									WHERE psortie.emaila = adherent.emaila");
		foreach ($resultat as $valeur){
			echo "<div class=\"Sortie\">";
			printf("<b>Auteur de la sortie: %s %s</b><br>
					Date de la sortie: %s <br>
					Niveau minimum: %s <br>
					Invitation maximum: %s <br>", $valeur['noma'],
													$valeur['prenom'],
													$valeur['dates'],
													$valeur['nivmin'],
													$valeur['invitemax']);
			echo "</div>";
		}
		$resultat->closeCursor();
		echo "</body>";
		echo "</html>";
	}
	
	else{
		include("connexion.inc.php");
		echo "<html>
				<head>
					<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"/>
					<title>Accueil</title>
					<link rel = \"stylesheet\" href = \"Accueil.css\"/>
				</head>";
	
		echo "<body>
				<p id = \"Perso\"><a href = \"EspacePersonnel1.html\"> ESPACE PERSONNEL</a></p>
				<h1><img src =\"logoFE.png\"></h1>
				<nav>
					<ul>
						<li><a class = \"Accueil\" href = \"Voie1.php\"> VOIE </a></li>
						<li><a class = \"Accueil\" href = \"Guide1.php\"> GUIDE </a></li>
						<li><a class = \"Accueil\" href = \"Sortie.php\"> SORTIE </a></li>
					</ul>
				</nav>";
		echo "<div>
				<h2>Bienvenue sur France ESCALADE !</h2>
				<article>
					<p>
						France ESCALADE est une base de données regroupant des informations concernant l'escalade.<br />
						Vous pouvez retrouver sur ce site de nombreuses données, comme les voies, les guides, ou encore les sortie organisées.<br />
						Bonne visite !
					</p>
				</article>";
		echo "</div>";
		$resultat = $cnx->query("SELECT noma, prenom, invitemax, nivmin, dates
									FROM (sortie NATURAL JOIN proposer) AS psortie, adherent
									WHERE psortie.emaila = adherent.emaila");
		foreach ($resultat as $valeur){
			echo "<div class=\"Sortie\">";
			printf("<b>Auteur de la sortie: %s %s</b><br>
						Date de la sortie: %s <br>
						Niveau minimum: %s <br>
						Invitation maximum: %s <br>", $valeur['noma'],
														$valeur['prenom'],
														$valeur['dates'],
														$valeur['nivmin'],
														$valeur['invitemax']);
			echo "</div>";
		}
		$resultat->closeCursor();
		echo "</body>";
		echo "</html>";
	}
?>