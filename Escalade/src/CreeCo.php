<?php
	if (isset($_POST['genre']) && isset($_POST['Email']) && isset($_POST['Nom']) && isset($_POST['Prenom']) && isset($_POST['Age']) && isset($_POST['Mdp']) ) {
		session_start();
		include ("connexion.inc.php");
		$resultat=$cnx->query("SELECT emaila FROM adherent WHERE emaila='".$_POST['Email']."' ");
		$resultatBIS = $resultat ->fetchAll();
		if ($resultatBIS == Array()){
			$insert = $cnx->exec("INSERT INTO adherent(emaila, noma, prenom, genre, age, mdp)
				VALUES ('".$_POST['Email']."', UPPER('".$_POST['Nom']."'), '".$_POST['Prenom']."', '".$_POST['genre']."', '".$_POST['Age']."', md5('".$_POST['Mdp']."' ) );");
			if (isset($_POST['niveau'])){
				$insert = $cnx->exec("INSERT INTO exercer VALUES ('".$_POST['Email']."', '".$_POST['niveau']."')");
				$_SESSION['level']=$_POST['niveau'];
			}
			$_SESSION['login']=$_POST['Email'];
			$_SESSION['pwd']=$_POST['Mdp'];
			header('location: Profil.php ');
		}
		else{
			echo "L'email est déja utilisé, veuillez rentrer un autre email<br>";
			echo "<a href=\"Creeuncompte.php\">Retourner en arrière</a> ";
		}
	}
	else{
		echo "Veuillez remplir les champs obligatoires";
	}
?>