<?php 
	session_start();
	
	if (isset($_SESSION['login']) && isset($_SESSION['pwd'])){
		include("connexion.inc.php");
		echo "<html>";
		echo "<head>
				<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"/>
				<title>Espace personnel 1</title>
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
		$_SESSION['Niveau'] = $valeur['notefr'];
		$resultat->closeCursor();
		echo "	<nav>
					<ul>
						<li class=\"Menu\"><a> PROFIL </a></li>
						<li class=\"Menu\"><a>
						<div>
							<form action=\"\" method=\"GET\">
								<input name=\"recherche\" type=\"text\" placeholder=\"Rechercher adhérent\" />
								<input type=\"submit\" value=\"Rechercher\" />
							</form>
						</div>
						</a></li>
						<li class=\"Cordee\"><a href = \"RejoindreCordee.php\"> REJOINDRE UNE CORDEE</a>
						<li class=\"Cordee\"><a href = \"CreeCordee.php\"> CREE CORDEE</a></li>
						<li class=\"Cordee\"><a href = \"CreeGuide.php\">GUIDE</a></li>
					</ul>
				</nav>";
		if (isset($_GET['recherche'])){
				$resultat = $cnx->query("SELECT emaila, noma, prenom FROM adherent WHERE prenom LIKE '".$_GET['recherche']."%' OR noma LIKE UPPER('".$_GET['recherche']."%') ");
				echo "<ul>";
				foreach($resultat as $valeur){
					if ($valeur['emaila'] == $_SESSION['login'])
						continue;
					else{
						echo "<li class=\"recherche\" style{text-decoration: none;}><a href=\"ProfilA.php?nom='".$valeur['noma']."'&prenom='".$valeur['prenom']."'&emaila='".$valeur['emaila']."'\"> 
						<b>".$valeur['noma']." ".$valeur['prenom']."</b> ".$valeur['emaila']." </a></li><br>";
					}
				}
				echo "</ul>";
				$resultat->closeCursor();
		}
		echo "<h2>Voie Escaladées : <br></h2>";
		echo "<form action=\"\" method=\"POST\">
				<input type=\"text\" name=\"voie_esc\" placeholder=\"Voie à ajouter\" />
				<input type=\"submit\" value=\"Ajouter\" />";
		echo "</form>";

		if (isset($_POST['voie_esc'])){
			$resultatA = $cnx->query("SELECT nomv, idv FROM voie WHERE nomv = UPPER('".$_POST['voie_esc']."') ");
			$tmp = $resultatA -> fetchAll();
			if ($tmp == Array())
				echo "<b>La voie ".$_POST['voie_esc']." n'existe pas</b><br>";
			else{
				$resultatA = $cnx->query("SELECT nomv, idv FROM voie WHERE nomv = UPPER('".$_POST['voie_esc']."') ");
				foreach($resultatA as $valeurA){
					$resultatB = $cnx->query("SELECT emaila, idv FROM deja_esca WHERE idv = '".$valeurA['idv']."' AND emaila = '".$_SESSION['login']."' ");
					$resultatBB = $resultatB->fetchAll();
					if ($resultatBB == Array()){
						echo "<b>Voie ajouté</b><br>";
						$insert = $cnx->exec("INSERT INTO deja_esca VALUES ('".$_SESSION['login']."', '".$valeurA['idv']."')");
					}
					else{
						echo "<b>Vous avez déjà rentré cette voie</b><br>";
					}
				}
			}
		}
		$resultat = $cnx->query("SELECT nomv FROM deja_esca, voie WHERE deja_esca.idv=voie.idv AND emaila = '".$_SESSION['login']."' ");
		foreach($resultat as $valeur){
			printf("<li><i>%s</i></li><br>", $valeur['nomv']);
		}
		
		echo "<h2>Cordée auxquelles vous appartenez:</h2><br>";
		$resultat = $cnx->query("SELECT cordee.numcordee, nomcordee, nivmincordee
								 FROM cordee, (SELECT * FROM appartenir WHERE emaila='".$_SESSION['login']."') AS login
								 WHERE login.numcordee=Cordee.numcordee
								 ORDER BY cordee.numcordee");
		foreach ($resultat as $valeur){
			printf("<li><i>%s</i></li>", $valeur['nomcordee']);
			echo "<a class=\"bouton\" href=\"InfoCordee.php?numcordee='".$valeur['numcordee']."'&nomcordee='".$valeur['nomcordee']."'&min='".$valeur['nivmincordee']."' \">Détail de la cordée</a><br>";
			echo "<a class=\"bouton\" href=\"QuitterCordee.php?numcordee='".$valeur['numcordee']."'&nomcordee='".$valeur['nomcordee']."'\"><b>Quitter la cordée</b></a><br><br>";
		}
		echo "</body>
			</html>";
	}
	else{
		echo "Vous n'êtes pas connecté";
	}
?>