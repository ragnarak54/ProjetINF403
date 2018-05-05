<?php
	$titre = 'Liste des épreuves associées au dossier 2 pour une discipline donnée, et nombre de billets pour chacune';
	include('entete.php');
	
	$requete = ("
		SELECT discipline
		FROM sowersc.LesDisciplines
	");
	
	// analyse de la requete et association au curseur
	$curseur = oci_parse ($lien, $requete) ;
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
			echo "<p class=\"erreur\"><b>Aucun dossier dans la base de données</b></p>" ;
		}
		else {
	
			echo ("
			  <form action=\"EpreuvesDiscipline_v2_action.php\" method=\"POST\">
			  <label for=\"inp_discipline\">Veuillez saisir une discipline :</label>
			  <select id=\"inp_discipline\" name=\"discipline\">
			  ");
			  
			  do
			  {
				  $discipline = oci_result($curseur, 1);
				  echo ("<option value=\"$discipline\">$discipline</option>");
			} while($res = oci_fetch ($curseur));
				echo ("
					</select>
					<br /><br />
			  <input type=\"submit\" value=\"Valider\" />
			  <input type=\"reset\" value=\"Annuler\" />
			  </form>
			  ");
		  }
	  }
  
   
   	oci_free_statement($curseur);

                                
	include('pied.php');
?>
