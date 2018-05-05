<?php
$titre = 'Affichage des épreuves sans billets vendus';
include('entete.php');

	// construction de la requete
 	$requete = ("
		select nepreuve from lesepreuves
			minus
		select distinct nepreuve from lesbillets
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
			echo "<table><tr><td>Épreuve</td></tr>" ;
			// on affiche un résultat et on passe au suivant s'il existe
			do {
				$nepreuve = oci_result($curseur,1) ;
				echo "<tr><td>".$nepreuve."</td></tr>";
			} while (oci_fetch ($curseur));
			echo "</table>";
		}
	}
   
          
include('pied.php');
?>
