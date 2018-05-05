<?php
$titre = "Pour chaque dossier, la date d'émission du dossier, et pour chaque billet associé, les épreuves associées, leur numéro, leur nom, et leur date (version avec deux curseurs)";
include('entete.php');

	// construction de la requete
 	$requete = ("
		select nDossier, dateEmission, nBillet, nEpreuve, nomE, dateEpreuve from LesDossiers_base natural join LesBillets natural join LesEpreuves order by 1, 3
	");
	
	// analyse de la requete et association au curseur
	$curseur = oci_parse ($lien, $requete) ;
	
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
			echo "<table><tr><th> Numéro dossier </th><th> Date d'émission </th><th> Numéro de billet </th><th> Numéro d'épreuve </th><th> Nom d'épreuve </th> <th> Date d'épreuve </th></tr>" ;
			// on affiche un résultat et on passe au suivant s'il existe
			do {
				$nDossier = oci_result($curseur, 1) ;
				$dateEmission = oci_result($curseur, 2) ;
				$nBillet = oci_result($curseur, 3) ;
				$nEpreuve = oci_result($curseur, 4) ;
				$nomE = oci_result($curseur, 5) ;
				$dateEpreueve = oci_result($curseur, 6) ;
				echo "<tr><td>$nDossier</td><td>$dateEmission</td><td>$nBillet</td><td>$nEpreuve</td><td>$nomE</td><td>$dateEpreueve</td></tr>";
			} while (oci_fetch ($curseur));
			echo "</table>";
		}
	}
   oci_free_statement($curseur);
          
include('pied.php');
?>
