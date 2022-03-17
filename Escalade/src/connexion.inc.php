<?php

/*
 * création d'objet PDO de la connexion qui sera représenté par la variable $cnx
 */
$user = "svong01";
$pass = "5duazayw3F";
try {
    $cnx = new PDO('pgsql:host = sqletud.u-pem.fr; dbname = svong01_db', $user, $pass );

}
catch (PDOException $e) {
    echo "ERREUR : La connexion a échouée <br>";

 /* Utiliser l'instruction suivante pour afficher le détail de erreur sur la
 * page html. Attention c'est utile pour débugger mais cela affiche des
 * informations potentiellement confidentielles donc éviter de le faire pour un
 * site en production.*/
	echo "Error: " . $e;	//Si on a une erreur, le nom d'utilisateur et le mot de passe est affiché.

}

?>

