<?php
	include('entete.php');
	$nepreuve = $_POST['nepreuve'];

	//get the new ndossier
	$maxDoss = "select max(ndossier) from lesdossiers_base";
	$curseur = oci_parse($lien, $maxDoss);
	$ok1 = @oci_execute($curseur);
	oci_fetch($curseur);
	$nDossier = oci_result($curseur, 1) + 1;
	//create it
	$newDossier = "insert into lesdossiers_base values (:d, '1337', SYSDATE)";
	$curseur = oci_parse($lien, $newDossier);
	oci_bind_by_name($curseur, ':d', $nDossier);
	$ok2 = @oci_execute($curseur);

	
	//get the new nbillet
	$maxbillet = "select max(nbillet) from lesbillets";
	$curseur = oci_parse($lien, $maxbillet);
	$ok3 = @oci_execute($curseur);
	oci_fetch($curseur);
	$newNBillet = oci_result($curseur, 1) + 1;	
	//create it
	$newBillet = "insert into lesbillets values (:nbillet, :d, :nepreuve)";
	$curseur = oci_parse($lien, $newBillet);
	oci_bind_by_name($curseur, ':nbillet', $newNBillet);
	oci_bind_by_name($curseur, ':nepreuve', $nepreuve);
	oci_bind_by_name($curseur, ':d', $nDossier);
	$ok4 = @oci_execute($curseur);
	if(!($ok2 and $ok4))
	{
		echo "$newNBillet $nepreuve $nDossier";
		$error_message = oci_error($curseurIns);
		echo "<p class=\"erreur\">{$error_message['message']}</p>";
		oci_rollback($lien);
	}
	else
	{
		$price = "select prix from lesepreuves where nepreuve = :e";
		$curseur = oci_parse($lien, $price);
		oci_bind_by_name($curseur, ':e', $nepreuve);
		@oci_execute($curseur);
		oci_fetch($curseur);
		$montant = oci_result($curseur, 1);
		echo "Transcation validée! Vous (l'utilisateur 1337), avez été débité $$montant";
		oci_commit($lien);
	}

	include('pied.php');
?>