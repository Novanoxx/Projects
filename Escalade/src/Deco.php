<?php
	session_start ();
	//On détruit les variables de la session
	session_unset ();
	//on détruit notre session
	session_destroy ();
	header ('location: Accueil.php');
?>