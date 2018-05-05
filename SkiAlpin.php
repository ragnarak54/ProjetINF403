<?php

	$d = 'ski alpin';
	$titre = 'Les épreuves de la discipline '.$d;
	include('entete.php');

	// print_r($lien);

	// construction de la requete
 	$requete = ("
		SELECT nomE, forme, categorie, to_char(dateEpreuve,'Day, DD-Month-YYYY HH:MI') as daterep
		FROM JO_INF245.LesEpreuves
		WHERE lower(discipline) = lower(:d)
	");

	// analyse de la requete et association au curseur
	$curseur = oci_parse ($lien, $requete) ;
	// affectation de la variable
	oci_bind_by_name ($curseur,':d', $d);
	// execution de la requete
$ok = @oci_execute ($curseur) ;
	// on teste $ok pour voir si oci_execute s'est bien passé
	if (!$ok) {
		// oci_execute a échoué, on affiche l'erreur
		$error_message = oci_error($curseur);
		echo "<p class=\"erreur\">{$error_message['message']}</p>";
	}
	else {
		// oci_execute a réussi, on fetch sur le premier résultat
		$res = oci_fetch ($curseur);
		if (!$res) {
			// il n'y a aucun résultat
			echo "<p class=\"erreur\"><b> Discipline inconnue </b></p>" ;
		}
		else {
			// on affiche la table qui va servir a la mise en page du resultat
			echo "<table><tr><td>Nom épreuve</td><td>forme</td><td>catégorie</td><td>date</td></tr>" ;
			// on affiche un résultat et on passe au suivant s'il existe
			do {
				$nome = oci_result($curseur,1) ;
				$forme  = oci_result($curseur,2) ;
				$categorie = oci_result($curseur,3) ;
				$datee = oci_result($curseur,4) ;
				echo "<tr><td>".$nome."</td><td>".$forme."</td><td>".$categorie."</td><td>".$datee."</td></tr>";
			} while (oci_fetch ($curseur));
			echo "</table>";
		}
	}
	// on libère le curseur
	oci_free_statement($curseur);
	include('pied.php');
?>
