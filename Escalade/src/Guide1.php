 	
<!--BLOC pour la partie recherche de voie par l'utilisateur 
			Nom Guide:.......
			Localité :........
			Niveau Max Guide :........
			TABLEAU DES DIFFICULTE
			..........
			FAIRE LA RECHERCHE EN FONCTION DES INFO DONNER
			-->
 <?php
	include("connexion.inc.php");
	echo "<html>";
	echo "<head>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"/>
		<title>Liste guide</title>
		<link rel = \"stylesheet\" href = \"Accueil.css\"/>
	</head>";
	echo"<body>	
			<a href = \"Accueil.php\"> <img src =\"logoFE.png\"></a>
			<nav>
				<ul>
					<li><a> GUIDE </a></li>
					<li><a> <form action=\"\" method=\"POST\">
						<input id=\"search\" name=\"rechercheG\" type=\"text\" placeholder=\"Guide(rentrer son email)\" />
						<input id=\"search-btn\" type=\"submit\" value=\"Rechercher\" />
					</form></a></li>
				</ul>
			</nav>";

	if (isset($_POST['rechercheG'])){
		$resultat = $cnx->query("SELECT notefr, encadrer.emailg, region
									FROM encadrer, pratiquer
									WHERE encadrer.emailg=pratiquer.emailg 
										AND (encadrer.emailg LIKE '".$_POST['rechercheG']."%'
										OR region LIKE '".$_POST['rechercheG']."%')");
		$resultatBIS = $resultat->fetchAll();
		echo "<ul>";
		if ($resultatBIS == Array())
			echo "Aucun guide ne correspond a ce que vous avez rentrer";
		else{
			$resultat = $cnx->query("SELECT notefr, encadrer.emailg, region
									FROM encadrer, pratiquer
									WHERE encadrer.emailg=pratiquer.emailg 
										AND (encadrer.emailg LIKE '".$_POST['rechercheG']."%'
										OR region LIKE '".$_POST['rechercheG']."%')");
			foreach($resultat as $valeur){
				echo "<li class=\"rechercheG\">
					<p><b>Email : </b>".$valeur['emailg']."<br>
					<b>Niveau encadré : </b>".$valeur['notefr']."<br>
					<b>Region d'encadrement : </b>".$valeur['region']."</p></li>";
				$resultat2 =  $cnx->query("SELECT * FROM voie,pratiquer WHERE region = est_situe");
				$resultatBIS2 = $resultat2->fetchAll();
				if ($resultatBIS2 == Array())
					echo "Aucune voies";
				else{
					$resultat2 =  $cnx->query("SELECT *
												FROM voie,pratiquer,avoir,encadrer,guide
												WHERE guide.emailg = encadrer.emailg
													AND avoir.notefr = encadrer.notefr
													AND region = est_situe ");
					echo"<p><b>Voie enseigné : </b></p>";
					foreach ($resultat2 as $valeur2) {
					echo"<li class=\"rechercheG\">
					 ".$valeur2['nomv']."</li>";
					}
					$resultat2->closeCursor();
				}
			}
			echo "</ul>";
		}
	$resultat->closeCursor();
	}
	
	echo"<TABLE BORDER=\"1\">
	<tr>
	<CAPTION><h2>Liste des guides </h2></CAPTION>
	<th> <b><u>Nom guide</u></b>";
		echo"<h4>";
		$resultat = $cnx->query("SELECT noma, prenom FROM adherent, guide WHERE adherent.emaila=guide.emailg");
		foreach($resultat as $valeurs){
			echo "";
			echo " ".$valeurs['noma']." ".$valeurs['prenom']." <br>";
		}
		$resultat->closeCursor();	
		echo"</h4>";
	echo"</th>";
	
	echo"<th> <b><u>Email guide</u></b>";
		echo"<h4>";
			$resultat = $cnx->query("SELECT * FROM Guide");
			while ($donnees = $resultat->fetch()){
				echo " ";
				echo " $donnees[0] <br>";
			}	
			$resultat->closeCursor();	
		echo"</h4>";
	echo"</th>";
	
	echo"<th><b><u>Niveau encadré</u></b>";
		echo"<h4>";
			$resultat = $cnx->query("SELECT * FROM encadrer");
			while ($donnees = $resultat->fetch())
			{
				echo " ";
				echo " $donnees[1] <br>";
			}	
			$resultat->closeCursor();
		echo"</h4>";
	echo"</th>";
	
	echo"<th> <b><u>Region d'encadrement</u></b>";
		echo"<h4>";
			$resultat = $cnx->query("SELECT * FROM pratiquer");
			while ($donnees = $resultat->fetch()){
				echo " ";
				echo " $donnees[1] <br>";
			}	
			$resultat->closeCursor();			
		echo"</h4>";
	echo"</th>";

	echo"</tr>";
	echo"</TABLE";

	echo"</body>";
	echo"</html>";
?>