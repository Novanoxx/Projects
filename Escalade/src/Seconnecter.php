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
				<li><a> SE CONNECTER </a></li>
			</ul>
		</nav>
		
		<!-- L'utilisateur entre :
			Email .........
			Mdp ...........
		-->
		<?php
			echo "<form action=\" TestCo.php \" method=\"POST\">
					<label>Email: </label><br><input type=\"text\" name=\"Email\" size=\"100\"/><br>
					<label>Mot de passe: </label><br><input type=\"password\" name=\"Mdp\" size=\"40\"/><br>
					<input type=\"submit\" name=\"submit\" value=\"Se connecter\"/>
				</form>";
			?>

</body>
</html>