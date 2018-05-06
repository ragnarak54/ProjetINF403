<?php
	session_start();
	$discipline = $_POST['discipline'];
	$ndossier = $_SESSION['ndossier'];
	$titre = "Résultat pour le dossier";
	include ('entete.php');
   $requete = ("
	   	select nepreuve, count(nbillet) from lesepreuves natural join lesbillets
	   	where discipline = :disc and ndossier=:doss
	   	group by nepreuve
	");
	
	// analyse de la requete et association au curseur
	$curseur = oci_parse ($lien, $requete) ;
	// affectation des variables
	$bind1 = oci_bind_by_name ($curseur,':doss', $ndossier);
	$bind2 = oci_bind_by_name ($curseur,':disc', $discipline);
	// execution de la requete
	$ok = @oci_execute ($curseur) ;
	if(!$bind1 or !$bind2)
	{
		echo "hohohoholy shit!";
	}
	else
	{
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
			echo "$ndossier $discipline";
			echo "<p class=\"erreur\"><b>Aucune epreuve </b></p>" ;
		}
		else 
		{
			echo "<h3> Les epreuves pour la discipline $discipline dans le dossier $ndossier: </h3>" ;
			echo "<table><tr><th>Numéro épreuve</th><th> nombre de billets </th></tr>" ;
			
			//on affice un résultat et on passe au suivant s'il existe
			do {
                $numE = oci_result($curseur, 1) ;
                $sumB = oci_result($curseur, 2) ;
                echo "<tr><td>$numE</td><td>$sumB</td></tr>";

			} while (oci_fetch ($curseur));
		
			echo "</table>";
		}
	}
}
	include('pied.php');
?>
