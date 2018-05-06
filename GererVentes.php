<?php
	session_start();
	include('entete.php');
	$requete = ("
			select nepreuve from lesepreuves
		");
	$curseur = oci_parse($lien, $requete);
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
			echo "<p class=\"erreur\"><b> Erreur grave </b></p>" ;
		}
		else {
			// on affiche la table qui va servir a la mise en page du resultat
			echo ("
				<form action=\"GererVentesAction.php\" method=\"POST\">
				<label for=\"inp_epreuve\">Veuillez saisir une epreuve :</label>
				<input type=\"text\" name = \"nepreuve\" />
				<br /><br />
				<input type=\"submit\" value=\"Valider\" />
				<input type=\"reset\" value=\"Annuler\" />
				</form>


				");
			
			// on affiche un résultat et on passe au suivant s'il existe
			
		}
	}
	include('pied.php');
?>
