<?php 
	session_start();
	include("connexion.inc.php");

	if (isset($_SESSION['login']) && isset($_SESSION['pwd'])){
		echo "<html>";
		echo "<head>
				<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"/>
				<title>Espace personnel 2</title>
				<link rel = \"stylesheet\" href = \"Accueil.css\"/>
			</head>";
		echo "<body>
				<a href = \"Accueil.php\"> <img src =\"logoFE.png\"></a>
				<p id = \"Perso\"><a href = \"Deco.php\"> DECONNEXION</a></p>";
		$resultat = $cnx->query("SELECT emaila, noma, prenom, age FROM adherent WHERE noma = ".$_GET['nom']." AND prenom = ".$_GET['prenom']." ");
		foreach($resultat as $valeur){
			printf("<br><b>Profil de: </b> %s %s %sans , <b>Email:</b><i>%s</i><br>", $valeur['noma'], $valeur['prenom'], $valeur['age'], $valeur['emaila']);
		}

		$resultat = $cnx->query("SELECT exercer.notefr, noteen, noteus FROM exercer, difficulte WHERE exercer.notefr = difficulte.notefr AND exercer.emaila = ".$_GET['emaila']." ");
		foreach($resultat as $valeur){
			printf("<b>NiveauFR:</b> %s <br>
					<b>NiveauEN:</b> %s <br>
					<b>NiveauUS:</b> %s", $valeur['notefr'], $valeur['noteen'], $valeur['noteus']);
		}
		$resultat->closeCursor();

		echo "	<nav>
					<ul>
						<li class=\"Menu\"><a> PROFIL D'UN ADHERENT</a></li>
						<li class=\"Cordee\"><a href=\"Profil.php\"> RETOUR SUR MON PROFIL</a></li>
					</ul>
				</nav>";
		
		echo "<h2>Voie Escaladées : <br></h2>";

		$resultat = $cnx->query("SELECT nomv FROM deja_esca, voie WHERE deja_esca.idv=voie.idv AND emaila = ".$_GET['emaila']." ");
		foreach($resultat as $valeur){
			printf("<li><i>%s</i></li><br>", $valeur['nomv']);
		}
		
		echo "<h2>Cordée auxquelles il/elle appartient:</h2><br>";
		$resultat = $cnx->query("SELECT cordee.numcordee, nomcordee, nivmincordee
								FROM cordee, (SELECT * FROM appartenir WHERE emaila=".$_GET['emaila'].") AS login
								WHERE login.numcordee=cordee.numcordee ");
		foreach ($resultat as $valeur){
			printf("<li><i>%s</i></li><br>", $valeur['nomcordee']);
			echo "<a class=\"bouton\" href=\"InfoCordee.php?numcordee='".$valeur['numcordee']."'&nomcordee='".$valeur['nomcordee']."'&min='".$valeur['nivmincordee']."' \">Détail de la cordée</a><br>";
		}
		echo "</body>
			</html>";
	}
	else{
		echo "Vous n'êtes pas connecté";
	}
?>