<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<title>Espace personnel 1</title>
	<link rel = "stylesheet" href = "Accueil.css"/>
</head>
<body>
		
	<a href = "Accueil.php"> <img src ="logoFE.png"> </a>
		<nav>
			<ul>
				<li><a> CREE UN COMPTE </a></li>
			</ul>
		</nav>
		
		<?php
			$tmp = 0;
			$level = array("1", "2", "3", "4", "5a", "5b", "5c",
						"6a", "6b", "6c", "7a", "7b", "7c",
						"8a", "8b", "8c", "9a", "9b", "9c");
			echo "<form action=\"CreeCo.php\" method=\"POST\"><br>
					<p><input type=\"radio\" name=\"genre\" value=\"1\"\>Femme</p>
					<p><input type=\"radio\" name=\"genre\" value=\"2\"\>Homme</p>
					<label>Nom: </label><input type=\"text\" name=\"Nom\" size=\"40\" placeholder=\"Nom\" /><br>
					<label>Prenom: </label><input type=\"text\" name=\"Prenom\" size=\"20\" placeholder=\"Prenom\" /><br>
					<label>Email: </label><input type=\"text\" name=\"Email\" size=\"100\" placeholder=\"Email\" /><br>
					<label>Age: </label><input type=\"text\" name=\"Age\" size=\"3\" placeholder=\"Age\" /><br>
					<label>Mot de passe: </label><input type=\"password\" name=\"Mdp\" size=\"40\" placeholder=\"Mot de passe\" /><br>";
			echo "<h1>Information complémentaire : <br></h1>";
			echo "Niveau Max (en FR): ";
			echo 	"<select type=\"text\" name=\"niveau\">";
			for ($tmp = 0; $tmp < sizeof($level); $tmp++ ){
				printf("<option value=\"%s\"> %s </option>",$level[$tmp], $level[$tmp]);
			}
			echo "</select><br>";
			echo "<input type=\"submit\" name=\"submit\" value=\"Créer le compte\"/><br>";
			echo "</form><br>";
		?>

</body>
</html>
