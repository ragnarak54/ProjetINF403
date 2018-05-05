<?php

	
	
	$titre = 'Liste des épreuves associées au dossier 2 pour une discipline donnée, et nombre de billets pour chacune';
	include('entete.php');

    echo ("
			<form action=\"EpreuvesDiscipline_v1_action.php\" method=\"POST\">
	
			<label for=\"inp_discipline\">Veuillez saisir une discipline 
			:</label>
		  
			<br />
	  

			<input type=\"radio\" name=\"discipline\" value=\"Bobsleigh\" />Bobsleigh <br />
			<input type=\"radio\" name=\"discipline\" value=\"Combine nordique\" />Combine nordique <br />
			<input type=\"radio\" name=\"discipline\" value=\"Curling\" />Curling <br />
			<input type=\"radio\" name=\"discipline\" value=\"Hockey sur glace\" />Hockey sur glace <br />
			<input type=\"radio\" name=\"discipline\" value=\"Luge\" />Luge <br />
			<input type=\"radio\" name=\"discipline\" value=\"Patinage artistique\" />Patinage artistique <br />
			<input type=\"radio\" name=\"discipline\" value=\"Patinage de vitesse\" />Patinage de vitesse <br />
			<input type=\"radio\" name=\"discipline\" value=\"\" />Saut a ski <br />
			<input type=\"radio\" name=\"discipline\" value=\"Saut a ski\" />Skeleton <br />
			<input type=\"radio\" name=\"discipline\" value=\"Ski alpin\" />Ski alpin <br />
			<input type=\"radio\" name=\"discipline\" value=\"Ski de fond\" />Ski de fond <br />
			<input type=\"radio\" name=\"discipline\" value=\"Snowboard\" />Snowboard <br />
			<input type=\"radio\" name=\"discipline\" value=\"Sports de glace\" />Sports de glace <br />


			<br /><br />
          
			<input type=\"submit\" value=\"Valider\" />
			<input type=\"reset\" value=\"Annuler\" />
			</form>
			");
	// travail à réaliser
	echo ("
		<p class=\"work\">
			Améliorez l'interface utilisateur en proposant, à la place du champ de saisie libre, un choix dans une liste contenant toutes les disciplines (sous forme de boite de sélection ou de boutons radio).<br />Cette liste sera codée \"en dur\".
		</p>
	");

	include('pied.php');

?>
