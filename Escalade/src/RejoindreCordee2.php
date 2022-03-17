<?php
	session_start();
	include("connexion.inc.php");
	echo "<html>
			<head>
				<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"/>
				<title>Creer une cordee</title>
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
		
		$tmp = 0;
		$level = array("1", "2", "3", "4", "5a", "5b", "5c",
						"6a", "6b", "6c", "7a", "7b", "7c",
						"8a", "8b", "8c", "9a", "9b", "9c");
						
		echo "	<nav>
					<ul>
						<li class=\"Cordee\"><a>REJOINDRE CORDEE</a></li>
					</ul>
				</nav>";
		$resultat = $cnx->query("SELECT numcordee FROM cordee WHERE nomcordee=".$_GET['nomcordee']." ");
		foreach ($resultat as $valeur){
			$insert = $cnx->exec("INSERT INTO appartenir VALUES ('".$_SESSION['login']."', '".$valeur['numcordee']."')");
		}
		echo "Cordée rejoins, vous pourrez la quitter quand vous le souhaité <br>";
		echo "<a href=\"Profil.php\" style{text-decoration: none;}><b><i>Retourner sur la page du profil</i></b></a> ";
		echo "</body>
			</html>";
?>