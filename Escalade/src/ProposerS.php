<?php
	session_start();
	include("connexion.inc.php");
	if (isset($_SESSION['login']) && isset($_SESSION['pwd']) ){
		echo "<html>
			<head>
				<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"/>
				<title>Proposer sortie</title>
				<link rel = \"stylesheet\" href = \"Accueil.css\"/>
			</head>
			<body>
				<a href = \"Accueil.php\"> <img src =\"logoFE.png\"></a>
				<p id = \"Perso\"><a href = \"Deco.php\"> DECONNEXION</a></p>";
		$resultat = $cnx->query("SELECT noma, prenom, age FROM adherent WHERE emaila = '".$_SESSION['login']."' ");
		foreach($resultat as $valeur){
			printf("<br><b>Identifié en tant que :</b> %s %s %sans <br>", $valeur['noma'], $valeur['prenom'], $valeur['age']);
		}

		$resultat = $cnx->query("SELECT exercer.notefr, noteen, noteus FROM exercer, difficulte WHERE exercer.notefr = difficulte.notefr AND exercer.emaila = '".$_SESSION['login']."' ");
		foreach($resultat as $valeur){
			printf("<b>NiveauFR:</b> %s <br>
					<b>NiveauEN:</b> %s <br>
					<b>NiveauUS:</b> %s", $valeur['notefr'], $valeur['noteen'], $valeur['noteus']);
		}
		$resultat->closeCursor();
		echo "	<nav>
					<ul>
						<li class=\"Menu\"><a>PROPOSER SORTIE</a></li>
						<li class=\"Cordee\"><a href=\"Profil.php\">MON PROFIL</a></li>
					</ul>
				</nav>";
				
		$tmp = 0;
		$level = array("1", "2", "3", "4", "5a", "5b", "5c",
						"6a", "6b", "6c", "7a", "7b", "7c",
						"8a", "8b", "8c", "9a", "9b", "9c");
						
		echo "<form action=\"ProposerSC.php\" method=\"POST\">
				<label>Nombre maximum de participant:</label><input type=\"number\" name=\"Max\" min=\"1\" placeholder=\"Nombre max de participant\" /><br>
				<label>Niveau minimum requis(<i>Votre niveau doit être inférieur ou égal au niveau choisi</i>):</label>
				<select type=\"text\" name=\"niveau\">";
		for ($tmp = 0; $tmp < sizeof($level); $tmp++ ){
			printf("<option value=\"%s\"> %s </option>",$level[$tmp], $level[$tmp]);
		}
		echo "</select><br>";
		echo "<p><u><b>Style d'escalade</b></u></p>";
		echo "<input type=\"radio\" name=\"style\" value=\"traditionnel\"/>Traditionnel<br>
			  <input type=\"radio\" name=\"style\" value=\"sportive\"/>Escalade sportive<br>
			  <input type=\"radio\" name=\"style\" value=\"artificielle\"/>Escalade artificielle<br>
			  <input type=\"radio\" name=\"style\" value=\"libre\"/>Escalade libre<br>
			  <input type=\"radio\" name=\"style\" value=\"solo\"/>Solo intégral<br>";
		echo "<p><u><b>Nom de la cordée pour la sortie:</b></u><br>";
		echo "<i>Si la cordée n'existe pas, cela va créer une nouvelle cordée</i></p>";
		echo "<input type=\"text\" size=\"50\" name=\"cord\"/><br><br>";
		echo "<u><b>Sélectionner la région cible de votre sortie:</b></u><br>";
		$resultat=$cnx->query("SELECT * FROM localite");
		echo "<select type=\"text\" name=\"region\">";
		foreach($resultat as $valeur){
			printf("<option value=\"%s\"> %s </option>", $valeur['region'], $valeur['region']);
		}
		echo "</select><br>";
		echo "<label>Date de la sortie: </label><input type=\"date\" name=\"Date\"/> ";
		echo "<label>Description de la sortie:(Veuillez remplacer les apostrophes <b>'</b> par un accent <b>`</b>)</label><input type=\"text\" size=\"200\" name=\"descr\"/><br><br> ";
		echo "<input type=\"submit\" name=\"submit\" value=\"Créer la sortie\"/><br>";
		echo "</form><br>";
		
		echo "</body>
			</html>";
	}
	else{
		echo "Vous devez être connecté pour accéder à cette page";
	}
?>