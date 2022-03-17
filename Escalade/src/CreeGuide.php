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
						<li class=\"Menu\"><a>PROFIL DE GUIDE</a></li>
						<li class=\"Cordee\"><a href=\"Profil.php\"> RETOUR SUR MON PROFIL</a></li>
					</ul>
				</nav>";
		
		$resultat=$cnx->query("SELECT * FROM guide WHERE emailg='".$_SESSION['login']."' ");
		$resultatBIS = $resultat->fetch();
		if ($resultatBIS == Array()){
			echo "Voulez-vous être guide? (ceci est un choix modifiable à tout moment)";
			echo "<form action=\"\" method=\"POST\" >
				<input type=\"submit\" name =\"oui\" value=\"oui\"/> <input type=\"submit\" name=\"non\" value=\"non\"/>
				</form>";
			if (isset($_POST['oui'])){
				$insert=$cnx->exec("INSERT INTO Guide VALUES('".$_SESSION['login']."')");
				$resultat=$cnx->query("SELECT notefr FROM exercer WHERE emaila='".$_SESSION['login']."' ");
				foreach($resultat as $valeur){
					$insert=$cnx->exec("INSERT INTO encadrer VALUES('".$_SESSION['login']."', '".$valeur['notefr']."') ");
					echo "<b>Vous êtes maintenant un guide</b>";
					header('location: CreeGuide.php');
				}
			}
			if (isset($_POST['non']))
				header('location: Profil.php');
		}
		else{
			echo "<i>En tant que guide, vous ne pouvez enseigner que sur des voies déjà escaladées avec une difficulté inférieur ou égale au votre</i><br>";
			echo "<h2><b>Où voulez-vous exercer ?</b></h2>";
			echo "<form action=\"\" method=\"POST\" >";
			$resultat=$cnx->query("SELECT est_situe FROM (SELECT idv FROM deja_esca WHERE emaila='".$_SESSION['login']."') AS id, voie WHERE id.idv=voie.idv");
			echo 	"<select type=\"text\" name=\"local\">";
			foreach($resultat as $valeur){
				printf("<option value=\"%s\">%s</option>", $valeur['est_situe'], $valeur['est_situe']);
			}
			echo 	"</select><br>";
			echo "<input type=\"submit\" value=\"Ajouter cette région à encadrer\"> ";
			echo "</form>";
			
			if (isset($_POST['local']) ){
				$resultat=$cnx->query("SELECT * FROM pratiquer WHERE emailg='".$_SESSION['login']."' AND region='".$_POST['local']."' ");
				$resultatBIS=$resultat->fetchAll();
				if ($resultatBIS <> Array())
					echo "vous avez déjà rentré cette région";
				else{
					$insert=$cnx->exec("INSERT INTO pratiquer VALUES ('".$_SESSION['login']."', '".$_POST['local']."')");
					$resultat=$cnx->query("SELECT notefr
											FROM exercer
											WHERE emaila='".$_SESSION['login']."' ");
					foreach($resultat as $valeur){
						$insert=$cnx->exec("INSERT INTO encadrer VALUES ('".$_SESSION['login']."', '".$valeur['notefr']."') ");
					}
					echo "<b>Région ajoutée</b><br>";
				}
			}
		}
		
		echo "</body>
			</html>";
	}
	else{
		echo "Vous n'êtes pas connecté";
	}
?>