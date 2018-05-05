<?php

	
	// récupération des variables
	$discipline = $_POST['discipline'];
	
	
	$titre = "Détails du dossier numéro 2 et $discipline";
	include('entete.php');
	
	$requete = ("
		select nepreuve, count(nbillet) from lesepreuves natural join lesbillets
		where discipline = :d and ndossier=2
		group by nepreuve
		");
		

	// analyse de la requete et association au curseur
	$curseur = oci_parse ($lien, $requete) ;
	
	// affectation de la variable
	oci_bind_by_name ($curseur,':d', $discipline);

	// execution de la requete
	$ok = @oci_execute ($curseur);
	
	if (!$ok) {
		// oci_execute a échoué, on affiche l'erreur
		$error_message = oci_error($curseur);
		echo "lol wtf";
		echo "<p class=\"erreur\">{$error_message['message']}</p>";
	}
	
	else {
		
			
		// oci_execute a réussi, on fetch sur le premier résultat
		$res = oci_fetch ($curseur);

		if (!$res) {

			// il n'y a aucun résultat
			echo "<p class=\"erreur\"><b>idk fam</b></p>" ;

		}
		else {
			//afficher la table
			echo "<h3> Les epreuves pour la discipline $discipline : </h3>" ;
			echo "<table><tr><th>Numéro épreuve</th><th> nombre de billets </th></tr>" ;
			
			//on affice un résultat et on passe au suivant s'il existe
			do {
                $numE = oci_result($curseur, 1) ;
                $sumB = oci_result($curseur, 2) ;
                echo "<tr><td>$numE</td><td>$sumB</td></tr>";

			} while (oci_fetch ($curseur));
		
			echo "</table>";
			// */
		}
		}
	// on libère le curseur
	
	oci_free_statement($curseur);
	
	include('pied.php');

?>
