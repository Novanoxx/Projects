<?php
	session_start();
	include("connexion.inc.php");
	if (isset($_SESSION['login']) && isset($_SESSION['pwd']) ){
		echo "<html>
			<head>
				<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"/>
				<title>Clos sortie</title>
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
						<li class=\"Menu\"><a>CLOS SORTIE</a></li>
					</ul>
				</nav>";
		echo "En êtes-vous sûr? <br>";
		echo "<form action=\"\" method=\"POST\" ";
		echo "<li></li>";
		echo "<input type=\"submit\" name=\"oui\" value=\"oui\" /> <input type=\"submit\" name=\"non\" value=\"non\" />
			</form>";
		if (isset($_POST['oui']) || isset($_POST['non'])){
			if (isset($_POST['oui'])){
				$insert = $cnx->exec("DELETE FROM proposer WHERE emaila='".$_SESSION['login']."' AND nums=".$_GET['nums']." ");
				$resultat = $cnx->query("SELECT emaila FROM rejoindre_sortie WHERE nums= ".$_GET['nums']." ");
				foreach($resultat as $valeurs){
					$resultatB=$cnx->query("SELECT DISTINCT numcordee
											FROM ascension, contenir, sortie
											WHERE sortie.nums= ".$_GET['nums']." ");
					foreach($resultatB as $valeurB){
						$insert=$cnx->exec("INSERT INTO appartenir VALUES ('".$valeurs['emaila']."', '".$valeurB['numcordee']."') ");	
					}
				}
				header('location: Sortie.php');
			}
			else{
				header('location: Sortie.php');
			}
		}	
	}
?>