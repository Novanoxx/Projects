<?php
	if (isset($_POST['Email']) && isset($_POST['Mdp'])){
		include "connexion.inc.php";
			$resultat = $cnx->query("SELECT adherent.emaila, mdp, notefr
									FROM adherent, exercer
									WHERE adherent.emaila=exercer.emaila
										AND EXISTS(SELECT adherent.emaila, mdp, notefr
													FROM adherent, exercer
													WHERE adherent.emaila=exercer.emaila
														AND adherent.emaila = '".$_POST['Email']."'
														AND mdp = md5('".$_POST['Mdp']."'))
										AND adherent.emaila = '".$_POST['Email']."' AND mdp = md5('".$_POST['Mdp']."')");
			foreach ($resultat as $valeur){
				session_start();
				$_SESSION['login'] = $valeur['emaila'];
				$_SESSION['pwd'] = $valeur['mdp'];
				$_SESSION['Niveau'] = $valeur['notefr'];
				echo "Identification réussie";
				$resultat->closeCursor();
				header('location: Profil.php');
			}
			echo "L'email ou le mot de passe est faux, veuillez réessayer";
	}
	else{
		echo "Les champs de connexion n'ont pas été rempli";
	}
?>