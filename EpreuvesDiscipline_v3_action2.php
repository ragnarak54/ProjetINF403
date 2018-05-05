<?php
	$discipline = $_POST['discipline'];
	$ndossier = $_POST['ndossier'];
	$titre = "Résultat";
	include ('entete.php');
   $requete = ("
   		select nbillet from lesBillets natural join lesepreuves where discipline = :disc and nEpreuve in 
		(select distinct nEpreuve from lesBillets where ndossier = :doss)
	");
	
	// analyse de la requete et association au curseur
	$curseur = oci_parse ($lien, $requete) ;
	// affectation des variables
	oci_bind_by_name ($curseur,':doss', $ndossier);
	oci_bind_by_name ($curseur,':disc', $discipline);
	// execution de la requete
	$ok = @oci_execute ($curseur) ;

	include('pied.php');
?>

ndossier + discipline ->>> nbillet