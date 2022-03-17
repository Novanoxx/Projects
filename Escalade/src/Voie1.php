			<!--BLOC pour la partie recherche de voie par l'utilisateur 
			Nom:.......
			Localité :........
			Difficulté :........
			TABLEAU DES DIFFICULTE
			..........
			LONGUEUR:........
			TYPE:.........
			FAIRE LA RECHERCHE EN FONCTION DES INFO DONNER
			-->

<?php
	include("connexion.inc.php");
	echo "<html>";
	echo "<head>
			<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"/>
			<title>Voie</title>
			<link rel = \"stylesheet\" href = \"Accueil.css\"/>
		</head>";
	echo"<body>
			<a href = \"Accueil.php\"> <img src =\"logoFE.png\"></a>
			<nav>
				<ul>
					<li><a> VOIES </a></li>
					<li><a> <form action=\"\" method=\"POST\">
							<input id=\"search\" name=\"recherche\" type=\"text\" placeholder=\"Recherche voie\" />
							<input id=\"search-btn\" type=\"submit\" value=\"Rechercher\" />
					</form> </a></li>
				</ul>
			</nav>";

	if (isset($_POST['recherche'])){
		$resultat = $cnx->query("SELECT * FROM voie WHERE nomv LIKE UPPER('".$_POST['recherche']."%') OR typev LIKE UPPER('".$_POST['recherche']."%') OR est_situe LIKE UPPER('".$_POST['recherche']."%')");
		$resultatBIS = $resultat->fetchAll();
		if ($resultatBIS == Array())
			echo "Aucune voie ne ressemble a ce que vous avez rentrer";
		else{
			$resultat = $cnx->query("SELECT * FROM voie WHERE nomv LIKE UPPER('".$_POST['recherche']."%') OR typev LIKE UPPER('".$_POST['recherche']."%') OR est_situe LIKE UPPER('".$_POST['recherche']."%')");
			echo "<ul>";
			foreach($resultat as $valeur){
				echo "<li class=\"recherche\" style=\"color: #008000;\"><a> <b><u><h3>id de la voie : </u></b>".$valeur['idv']."</h3></li>
							<p><b>Nom : </b>".$valeur['nomv']."<br>
							<b>Longueur : </b>".$valeur['longueur']."<br>
							<b>Type de voie : </b>".$valeur['typev']."<br>
							<b>Localité: </b>".$valeur['est_situe']." <br>
							<b>Date ouverture : </b>".$valeur['date_ouv']." 
							<br></a></p>";
			}
			echo "</ul>";
		}
		$resultat->closeCursor();
	}

	echo"<TABLE BORDER=\"1\">
		<tr>
			<CAPTION><h2><u>Liste des voies</u></h2></CAPTION>
			<th> ID Voie";
		echo"<h3>";
			$resultat = $cnx->query("SELECT * FROM Voie");
			while ($donnees = $resultat->fetch()){
				echo "";
				echo " $donnees[0] <br>";
			}
			$resultat->closeCursor();	
		echo"</h3>";
		echo"</th>";
		echo"<th><u>Nom voie</u>";
			echo"<h3>";
				$resultat = $cnx->query("SELECT * FROM Voie");
				while ($donnees = $resultat->fetch()){
					echo " ";
					echo " $donnees[1] <br>";
				}	
				$resultat->closeCursor();	
			echo"</h3>";
		
		echo"</th>";
		echo"<th> <u>Longueur voie</u>";
			echo"<h3>";
				$resultat = $cnx->query("SELECT * FROM Voie");
				while ($donnees = $resultat->fetch()){
					echo " ";
					echo " $donnees[2] <br>";
				}	
				$resultat->closeCursor();	
			echo"</h3>";
		echo"</th>";

		echo"<th><u>Type voie</u>";
			echo"<h3>";
				$resultat = $cnx->query("SELECT * FROM Voie");
				while ($donnees = $resultat->fetch()){
					echo " ";
					echo " $donnees[3] <br>";
				}
				$resultat->closeCursor();
			echo"</h3>";
		echo"</th>";

		echo"<th><u>Localité</u>";
			echo"<h3>";
				$resultat = $cnx->query("SELECT * FROM Voie");
				while ($donnees = $resultat->fetch()){
					echo " ";
					echo " $donnees[4] <br>";
				}	
				$resultat->closeCursor();	
			echo"</h3>";
		echo"</th>";

		echo"<th><u>Niveau voie</u>";
			echo"<h3>";
				$resultat = $cnx->query("SELECT notefr FROM avoir");
				while ($donnees = $resultat->fetch()){
					echo " ";
					echo " $donnees[0] <br>";
				}	
				$resultat->closeCursor();
			echo"</h3>";
		echo"</th>";

	echo"</tr>";
	echo"</TABLE>";
echo"</body>";
echo"</html>";
?>
