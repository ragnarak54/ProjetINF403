<?php
	$titre = "Gérer les épreuves";
	include ('entete.php');
	
	
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
	else
	{
		echo ("
			  <form action=\"GererEpreuvesAction.php\" method=\"POST\">
			  <label for=\"inp_discipline\">Veuillez saisir une discipline :</label>
			  <select id=\"inp_discipline\" name=\"discipline\">
			  "); 
		do
			  {
				  $discipline = oci_result($curseur, 1);
				  echo ("<option value=\"$discipline\">$discipline</option>");
			} while($res = oci_fetch ($curseur));
	echo (" </select>
		  
			<br />
	  
			<br />
			
			<label for=\"inp_nom\">Veuillez saisir un nom
			:</label>
			<input type=\"text\" name=\"name\" />
			
			<br /><br />
			
			<label for=\"inp_categorie\">Veuillez saisir une catégorie 
			:</label>
			<br />
			<input type=\"radio\" name=\"categorie\" value=\"feminin\" />Féminin <br />
			<input type=\"radio\" name=\"categorie\" value=\"masculin\" />Masculin <br />
			<input type=\"radio\" name=\"categorie\" value=\"mixte\" />Mixte <br />
			
			<br />
          
			<label for=\"inp_forme\">Veuillez saisir une forme 
			:</label>
			<br />
			<input type=\"radio\" name=\"forme\" value=\"individuelle\" />Individuelle <br />
			<input type=\"radio\" name=\"forme\" value=\"par equipe\" />Par équipe <br />
			<input type=\"radio\" name=\"forme\" value=\"par couple\" />Par couple <br />
			

			<br />
			
			<label for=\"inp_nbs\">Veuillez saisir une nbs
			:</label>
			<input type=\"text\" name=\"nbs\" />
			
			<br />

			<br />
			
			<label for=\"inp_date\">Veuillez saisir une date
			:</label>
			<input type=\"text\" name=\"dateEpreuve\" />
			
			<br />
			<br />
			
			<label for=\"inp_prix\">Veuillez saisir un prix
			:</label>
			<input type=\"text\" name=\"prix\" />
			
			<br />
			<br /><br />
			<input type=\"submit\" value=\"Valider\" />
			<input type=\"reset\" value=\"Annuler\" />
			</form>
			");
	}
	
	
	include('pied.php');
?>
