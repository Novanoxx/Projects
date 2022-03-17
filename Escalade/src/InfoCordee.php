<?php
	session_start();
	include("connexion.inc.php");
	echo "<html>
			<head>
				<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"/>
				<title>Info cordee</title>
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
						<li class=\"Menu\"><a>INFO CORDEE</a></li>
						<li class=\"Cordee\"><a href=\"Profil.php\">MON PROFIL</a></li>
					</ul>
				</nav>";
		echo "<h2><b>".$_GET['nomcordee']."</b></h2><br>";
		echo "<i><u>Niveau minimum pour rejoindre la cordée:</u></i> ".$_GET['min']." <br>";
		$resultat = $cnx->query("SELECT noma, prenom, adherent.emaila
								FROM (SELECT emaila FROM appartenir WHERE numcordee=".$_GET['numcordee'].") AS email, adherent
								WHERE adherent.emaila=email.emaila ");
		echo "<h2>Membres:</h2><br>";
		foreach($resultat as $valeurs){
			printf("<li><a href=\"ProfilA.php?nom='".$valeurs['noma']."'&prenom='".$valeurs['prenom']."'&emaila='".$valeurs['emaila']."'\"> %s %s <b><i>email:</i></b> %s</a></li>",
				$valeurs['noma'], $valeurs['prenom'], $valeurs['emaila']);
		}
		
		echo "<h2><b>Historique des ascensions:</b></h2>";
		$resultat = $cnx->query("SELECT nomv, dateascension, styleescalade FROM ascension, voie WHERE ascension.idv=voie.idv AND numcordee=".$_GET['numcordee']." ");
		foreach($resultat as $valeurs){
			printf("<li>Ascension de la voie: <b>%s</b> le <b>%s</b> de façon: <b>%s</b></li>", $valeurs['nomv'], $valeurs['dateascension'], $valeurs['styleescalade']);
		}
		echo "</body>
			</html>";
?>