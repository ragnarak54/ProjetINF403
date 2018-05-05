<?php
	$titre = "Inscrire un sportif";
	include ('entete.php');
	$requete1 = ("
		SELECT nDossier
		FROM sowersc.LesDossiers
		ORDER BY nDossier
	");
	echo ("
		<form action=\"InscrireSportifAction.php\" method=\"POST\">
			
			
			<label for=\"inp_nom\">Nom :</label>
			<input type=\"text\" name=\"nom\" />
			<br /><br />
			
			<label for=\"inp_prenom\">Prénom :</label>
			<input type=\"text\" name=\"prenom\" />
			<br /><br />
			
			<label for=\"inp_pays\">Pays :</label>
			<input type=\"text\" name=\"pays\" />
			<br /><br />
			
			<label for=\"inp_categorie\">Categorie :</label>
			<br />
			<input type=\"radio\" name=\"categorie\" value=\"feminin\" />Féminin <br />
			<input type=\"radio\" name=\"categorie\" value=\"masculin\" />Masculin <br />
			<br />
			
			<label for=\"inp_date\">Date de naissance :</label>
			<input type=\"text\" name=\"dateNais\" />
			
			<br /><br />
			<input type=\"submit\" value=\"Valider\" />
			<input type=\"reset\" value=\"Annuler\" />
		</form>
	");
	
	
	include('pied.php');
?>
