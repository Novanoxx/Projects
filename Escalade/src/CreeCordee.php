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
						<li class=\"Cordee\"><a href = \"Profil.php\">PROFIL</a>
						<li class=\"Cordee\"><a>CREE CORDEE</a></li>
					</ul>
				</nav>";
		echo "<form action=\"\" method=\"POST\">
				<label>Nom de la cordee: </label><input type=\"text\" name=\"NCordee\" placeholder=\"Nom de la cordee\"/><br><br>";
		echo 	"Niveau minimum de la cordée:<select type=\"text\" name=\"niveau\">";
		for ($tmp = 0; $tmp < sizeof($level); $tmp++ ){
			printf("<option value=\"%s\"> %s </option>",$level[$tmp], $level[$tmp]);
		}
		echo "</select><br>";
		echo "<input type=\"submit\" name=\"submit\" value=\"Créer la cordée\"/><br>
			</form>";
		
		if (isset($_POST['NCordee']) && isset($_POST['niveau']) ){
			$resultat = $cnx->query("SELECT nomCordee FROM cordee WHERE nomCordee = '".$_POST['NCordee']."' ");
			$resultatBIS = $resultat->fetchAll();
			if ($resultatBIS <> Array())
				echo "<b>Le nom de cette cordée existe déjà, veuillez rentrer un autre nom</b>";
			else{
				$resultat = $cnx->query("SELECT notefr FROM Difficulte WHERE '".$_POST['niveau']."' > '".$_SESSION['Niveau']."' ");
				$resultatBIS = $resultat->fetchAll();
				if ($resultatBIS <> Array())
					echo "<b>Veuillez entrez un niveau inférieur ou égale au votre</b>";
				else{
					$insertA = $cnx->exec("INSERT INTO Cordee(nomcordee, nivMinCordee) VALUES ('".$_POST['NCordee']."', '".$_POST['niveau']."') ");
					$resultat = $cnx->query("SELECT numcordee FROM cordee WHERE nomcordee='".$_POST['NCordee']."' AND nivmincordee='".$_POST['niveau']."' ");
					foreach ($resultat as $valeur){
						$insertB = $cnx->exec("INSERT INTO appartenir VALUES ('".$_SESSION['login']."', '".$valeur['numcordee']."') ");
					}
					echo "<b>Cordée créée</b><br>";
					echo "<a href=\"Profil.php\" style{text-decoration: none;}><b><i>Retourner sur la page du profil</i></b></a> ";
				}
			}
		}
		echo "</body>
			</html>";
?>