<?php
	if (isset($_POST['Max']) && isset($_POST['niveau']) && isset($_POST['region']) && isset($_POST['descr']) && isset($_POST['Date']) && isset($_POST['cord']) && isset($_POST['style']) ) {
		session_start();
		include ("connexion.inc.php");
		if ($_SESSION['Niveau'] < $_POST['niveau']){
			echo "Votre niveau est inférieur au niveau choisi, veuillez retourner en arrière";
		}
		else{
			$insert = $cnx->exec("INSERT INTO sortie(invitemax, nivmin, dates) VALUES ('".$_POST['Max']."', '".$_POST['niveau']."', '".$_POST['Date']."')");
		
			$resultat = $cnx->query("SELECT nums FROM sortie WHERE invitemax='".$_POST['Max']."' AND nivmin='".$_POST['niveau']."' AND dates='".$_POST['Date']."' ORDER BY nums DESC");
			$resultatBB = $resultat ->fetch();
			$insert = $cnx->exec("INSERT INTO proposer VALUES ('".$_SESSION['login']."', $resultatBB[0], '".$_POST['descr']."' )");
			
			$resultat = $cnx->query("SELECT nomcordee FROM cordee WHERE nomcordee='".$_POST['cord']."' ");
			$resultatBIS=$resultat->fetchAll();
			if ($resultatBIS == Array()){
				$insert=$cnx->exec("INSERT INTO cordee(nomcordee, nivmincordee) VALUES ('".$_POST['cord']."', '".$_POST['niveau']."') ");
				$resultat=$cnx->query("SELECT numcordee FROM cordee WHERE nomcordee='".$_POST['cord']."' AND nivmincordee='".$_POST['niveau']."' ");
				foreach($resultat as $valeur){
					$insert=$cnx->exec("INSERT INTO appartenir VALUES ('".$_SESSION['login']."', '".$valeur['numcordee']."')");
				}
				
			}
			
			$resultat =$cnx->query("SELECT DISTINCT voie.idv, numcordee
									FROM voie, avoir, cordee
									WHERE est_situe='".$_POST['region']."' AND notefr <= '".$_POST['niveau']."' AND nomcordee='".$_POST['cord']."'");
			foreach($resultat as $valeurs){
				$insert = $cnx->exec("INSERT INTO ascension VALUES ('".$valeurs['idv']."', '".$valeurs['numcordee']."', '".$_POST['Date']."', '".$_POST['style']."') ");
				$resultat = $cnx->query("SELECT nums FROM sortie WHERE invitemax='".$_POST['Max']."' AND nivmin='".$_POST['niveau']."' AND dates='".$_POST['Date']."' ");
				foreach($resultat as $valeur){
					$insert = $cnx->exec("INSERT INTO contenir VALUES ('".$valeurs['idv']."', '".$valeur['nums']."' )");
				}
			}
			header('location: Sortie.php');
		}
		
	}
	else{
		echo "Veuillez remplir les champs obligatoires";
	}
?>