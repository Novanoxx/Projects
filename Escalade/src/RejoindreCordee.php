<?php
	session_start();
	echo "<html>
			<head>
				<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"/>
				<title>Creer une cordee</title>
				<link rel = \"stylesheet\" href = \"Accueil.css\"/>
			</head>
			<body>
				<a href = \"Accueil.php\"> <img src =\"logoFE.png\"></a>
				<p id = \"Perso\"><a href = \"Deco.php\"> DECONNEXION</a></p>";
				
		include("connexion.inc.php");
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
						<li class=\"Cordee\"><a href = \"Profil.php\"> PROFIL</a>
						<li class=\"Cordee\"><a>REJOINDRE CORDEE</a></li>
					</ul>
				</nav>";
		echo "<form action=\"\" method=\"GET\">
				<label>Nom de la cordee: </label><input type=\"text\" name=\"NCordee\" placeholder=\"Nom de la cordee\"/><br><br>";
		echo 	"Niveau minimum de la cordée:<select type=\"text\" name=\"niveau\">";
		for ($tmp = 0; $tmp < sizeof($level); $tmp++ ){
			printf("<option value=\"%s\"> %s </option>",$level[$tmp], $level[$tmp]);
		}
		echo "</select><br>";
		echo "<input type=\"submit\" name=\"submit\" value=\"Chercher\"/><br>
			</form>";
		
		if (isset($_GET['NCordee']) || isset($_GET['niveau']) ){
			if (isset($_GET['NCordee'])){
				$resultat = $cnx->query("SELECT nomcordee FROM cordee WHERE nomCordee = '".$_GET['NCordee']."%' ");
				$resultatBIS = $resultat->fetchAll();
				if ($resultatBIS <> Array())
					echo "<b>Aucune cordée de ce nom ou proche de celui-ci, veuillez rentrer un autre nom</b>";
				else{
					if (isset($_GET['niveau'])){
						$resultat = $cnx->query("SELECT nomcordee, notefr, noteen, noteus
													FROM (SELECT nomcordee, nivmincordee FROM cordee WHERE nomCordee LIKE '".$_GET['NCordee']."%' AND nivmincordee >= '".$_GET['niveau']."') AS nom, difficulte
													WHERE nom.nivmincordee=difficulte.notefr ");
						foreach($resultat as $valeurs){
							printf("<label><b>Nom de la cordee:</b> %s <br><b>Difficulté FR: </b>%s <b>EN: </b>%s <b>US: </b>%s </label>", $valeurs['nomcordee'], $valeurs['notefr'], $valeurs['noteen'], $valeurs['noteus']);
							echo "<a href=\"RejoindreCordee2.php?nomcordee='".$valeurs['nomcordee']."'\"> <b>Rejoindre cette cordee</b></a>";
						}
					}
					else{
						$resultat = $cnx->query("SELECT nomcordee, notefr, noteen, noteus
													FROM (SELECT idv, nomcordee FROM cordee WHERE nomCordee = '".$_GET['NCordee']."%') AS nom, 
														((difficulte NATURAL JOIN avoir) AS diff NATURAL JOIN voie) AS dvoie
													WHERE nom.idv=dvoie.idv");
						foreach($resultat as $valeurs){
							printf("<li><a><b>Nom de la cordee:</b> %s <b>Difficulté FR: </b>%s <b>EN: </b>%s <b>US: </b>%s </a></li>", $valeurs['nomcordee'], $valeurs['notefr'], $valeurs['noteen'], $valeurs['noteus']);
						}
					}
				}
			}
			else{
				$resultat = $cnx->query("SELECT nomcordee, notefr, noteen, noteus
											FROM (avoir NATURAL JOIN difficulte) AS diff, voie
											WHERE diff.idv=voie.idv AND notefr >= '".$_SESSION['Niveau']."' ");
				$resultatBIS = $resultat->fetchAll();
				if ($resultatBIS <> Array())
					echo "<b>Aucune cordée avec un niveau supérieur ou égal à celui que vous voulez</b>";
				else{
					$resultat = $cnx->query("SELECT nomcordee, notefr, noteen, noteus
											FROM (avoir NATURAL JOIN difficulte) AS diff, voie
											WHERE diff.idv=voie.idv AND notefr >= '".$_SESSION['Niveau']."' ");
					foreach($resultat as $valeurs){
							printf("<li><a><b>Nom de la cordee:</b> %s <b>Difficulté FR: </b>%s <b>EN: </b>%s <b>US: </b>%s </a></li>", $valeurs['nomcordee'], $valeurs['notefr'], $valeurs['noteen'], $valeurs['noteus']);
					}
				}
			}
		}
		echo "</body>
			</html>";
?>