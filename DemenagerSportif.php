<?php
	$titre = "Déménager un sportif";
	include ('entete.php');
	$requete = ("
				with R1 as (
				select nombat, nlogement, count(nsportif) numloc from leslocataires group by nombat, nlogement
				) select distinct nombat from leslogements natural join R1 where capacite-numloc > 0 order by 1
				");
	$curseur1 = oci_parse($lien, $requete);
	$ok = @oci_execute($curseur1);
	if(!$ok)
	{
		$errormsg = oci_error($curseur1);
		echo "<p class=\"erreur\">{$errormsg['message']}</p>";
	}
	else
	{
		$res = oci_fetch ($curseur1);
		if (!$res) {
			// il n'y a aucun résultat
			echo "<p class=\"erreur\"><b>Aucune place disponible!</b></p>" ;
		}
		else {
			echo ("
				<form action=\"DemenagerSportifAction.php\" method=\"POST\">
				
				
				<label for=\"inp_num\">Veuillez saisir le numero du sportif :</label>
				<input type=\"text\" name=\"num\" />
				<br /><br />

				<label for=\"sel_batiment\">Sélectionnez un batiment :</label>
				<select id=\"sel_batiment\" name=\"nombat\">
				");
			do
			{
				$nombat = oci_result($curseur1, 1);
				echo ("<option value=\"$nombat\">$nombat</option>" );
			} while($res = oci_fetch($curseur1));
			echo ("
				</select>
				<br /><br />

				<input type=\"submit\" value=\"Valider\" />
				<input type=\"reset\" value=\"Annuler\" />
				</form>
			");
		}
	}
	
	include('pied.php');
?>
