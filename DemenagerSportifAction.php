<?php
	$nsportif = $_POST['num'];
	$nombat = $_POST['nombat'];
	include('entete.php');

	$requete = ("
			with R1 as (
			select nombat, nlogement, count(nsportif) numloc from leslocataires group by nombat, nlogement
			) select nombat, nlogement from leslogements natural join R1 where capacite-numloc > 0 and nombat = :bat
		");
	$curseur = oci_parse($lien, $requete);
	oci_bind_by_name($curseur, ':bat', $nombat);
	$ok = @oci_execute($curseur);
	if(!$ok)
	{
		$errormsg = oci_error($curseur);
		echo "<p class=\"erreur\">{$errormsg['message']}</p>";
	}
	else
	{
		$res = oci_fetch($curseur);

		$insertion = ("
				insert into leslocataires values (:nsportif, :nlogement, :nombat)
			");

		$curseurIns = oci_parse ($lien, $insertion);
		$nombat = oci_result($curseur, 1);
		$nlogement = oci_result($curseur, 2);
		$ok1 = oci_bind_by_name($curseurIns, ':nsportif', $nsportif);
		$ok2 = oci_bind_by_name($curseurIns, ':nombat', $nombat);
		$ok3 =oci_bind_by_name($curseurIns, ':nlogement', $nlogement);

		$deletion = ("
				delete from leslocataires where nsportif = :nsportif
			");	
		$curseurDel = oci_parse($lien, $deletion);
		oci_bind_by_name($curseurDel, ':nsportif', $nsportif);
		$okDel = @oci_execute($curseurDel);		
		$okIns = @oci_execute($curseurIns);
		if($okIns and $okDel)
		{
			echo ("
				<h3> \"$nsportif\" a ete mis dans \"$nlogement\" dans le batiment \"$nombat\" </h3>
				");
			oci_commit($lien) ; 
		}
		else
		{
			$error_message = oci_error($curseurIns);
			echo "<p class=\"erreur\">{$error_message['message']}</p>";
			$error_message = oci_error($curseurDel);
			echo "<p class=\"erreur\">{$error_message['message']}</p>";
			oci_rollback($lien);
		}
	}
	


	include('pied.php');
?>