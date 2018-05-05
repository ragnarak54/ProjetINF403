<?php
	$nomE = $_POST['name'];
	$forme = $_POST['forme'];
	$discipline = $_POST['discipline'];
	$categorie = $_POST['categorie'];
	$nbs = $_POST['nbs'];
	$dateEpreuve = $_POST['dateEpreuve'];
	$prix = $_POST['prix'];
	$titre = "Gérer les épreuves";
	include ('entete.php');
	
	$requete1 = ("
		SELECT max(nepreuve)
		FROM sowersc.LesEpreuves
	");
	
	// analyse de la requete et association au curseur
	$curseur1 = oci_parse ($lien, $requete1) ;
	// execution de la requete
	$ok = @oci_execute ($curseur1) ;
	$res = oci_fetch($curseur1);
	
	if($lien){
	$insertion = ("
		insert into sowersc.LesEpreuves values (:nEpreuve, :nomE, :forme, :discipline, :categorie, :nbs, TO_DATE(:dateEpreuve, 'DD-MM-YY'), :prix)	
		");
	// analyse de la requete et association au curseur
	$curseurIns = oci_parse ($lien, $insertion);
	// affectation des variables saisies
	$nEpreuve = oci_result($curseur1, 1) + 1; 
	
	$okbind1 = oci_bind_by_name($curseurIns, ':nEpreuve', $nEpreuve);
	$okbind2 = oci_bind_by_name($curseurIns, ':nomE', $nomE);	
	oci_bind_by_name($curseurIns, ':forme', $forme);
	oci_bind_by_name($curseurIns, ':discipline', $discipline);
	oci_bind_by_name($curseurIns, ':categorie', $categorie);
	oci_bind_by_name($curseurIns, ':nbs', $nbs);
	$okbind3 = oci_bind_by_name($curseurIns, ':dateEpreuve', $dateEpreuve);
	oci_bind_by_name($curseurIns, ':prix', $prix);
	// execution de la requete

	if(!$okbind1 OR !$okbind3)
	{
		echo "u dum lul";
	}
	else
	{
		$okIns = @oci_execute($curseurIns);
	
	if($okIns) {
		echo "Enregistrement effectue" ;
		oci_commit($lien) ; } 
	else
	{
		$error_message = oci_error($curseurIns);
		echo "<p class=\"erreur\">{$error_message['message']}</p>";
		echo ("
				\"$nEpreuve\" <br />
				\"$nomE\" <br />
				\"$forme\" <br />
				\"$discipline\" <br />
				\"$categorie\" <br />
				\"$nbs\" <br />
				\"$dateEpreuve\" <br />
				\"$prix\" <br />


			");





		oci_rollback($lien);
	}
	}
	
	oci_close($curseurIns); }
	include('pied.php');
?>

