<?php
	$nomS = $_POST['nom'];
	$prenom = $_POST['prenom'];
	$pays = $_POST['pays'];
	$categorie = $_POST['categorie'];
	$dateEpreuve = $_POST['dateEpreuve'];
	$dateNais = $_POST['dateNais'];
	$titre = "Inscrire un sportif";
	include ('entete.php');
	
	$requete1 = ("
		SELECT max(nsportif)
		FROM sowersc.LesSportifs
	");
	
	// analyse de la requete et association au curseur
	$curseur1 = oci_parse ($lien, $requete1) ;
	// execution de la requete
	$ok = @oci_execute ($curseur1) ;
	$res = oci_fetch($curseur1);
	
	if($lien){
	$insertion = ("
		insert into sowersc.LesSportifs values (:nsportif, :nomS, :prenom, :pays, :categorie, TO_DATE(:dateNais, 'DD-MM-YY'))	");
	// analyse de la requete et association au curseur
	$curseurIns = oci_parse ($lien, $insertion);
	// affectation des variables saisies
	$nsportif = oci_result($curseur1, 1) + 1; 
	
	$okbind1 = oci_bind_by_name($curseurIns, ':nsportif', $nsportif);
	$okbind2 = oci_bind_by_name($curseurIns, ':nomS', $nomS);	
	$ok3 = oci_bind_by_name($curseurIns, ':prenom', $prenom);
	$ok4 = oci_bind_by_name($curseurIns, ':pays', $pays);
	$ok5 = oci_bind_by_name($curseurIns, ':categorie', $categorie);
	$okbind3 = oci_bind_by_name($curseurIns, ':dateNais', $dateNais);
	// execution de la requete

	if(!$okbind1 OR !$okbind3 or !$ok3 or !$ok4 or !$ok5)
	{
		echo "u dum lul";
	}
	else
	{
		$okIns = @oci_execute($curseurIns);
	
		if($okIns) 
		{
			echo "Enregistrement effectue" ;
			
			$requete = ("
				with R1 as (
				select nombat, nlogement, count(nsportif) numloc from leslocataires group by nombat, nlogement
				) select nombat, nlogement, (capacite-numloc) places from leslogements natural join R1 where capacite-numloc > 0 order by 1
				");
			$curseur1 = oci_parse($lien, $requete);
			$ok = @oci_execute($curseur1);
			$res = oci_fetch($curseur1);

			$insertion = ("
					insert into leslocataires values (:nsportif, :nlogement, :nombat)
				");

			$curseurIns = oci_parse ($lien, $insertion);
			$nombat = oci_result($curseur1, 1);
			echo $nombat;
			$nlogement = oci_result($curseur1, 2);
			echo $nlogement;
			echo $nsportif;
			$ok1 = oci_bind_by_name($curseurIns, ':nsportif', $nsportif);
			$ok2 = oci_bind_by_name($curseurIns, ':nombat', $nombat);
			$ok3 =oci_bind_by_name($curseurIns, ':nlogement', $nlogement);
			if(!$ok1 or !$ok2 or !$ok3)
			{
				echo "what da fak";
				oci_rollback($lien);
			}
			else
			{
				$okIns = @oci_execute($curseurIns);
					if($okIns) {
						echo "Enregistrement effectue" ;
						echo ("
							\"$nsportif\" a ete mis dans \"$nlogement\" dans le batiment \"$nombat\"	
							");
						oci_commit($lien) ; } 
					else
					{
						$error_message = oci_error($curseurIns);
						echo "<p class=\"erreur\">{$error_message['message']}</p>";
						oci_rollback($lien);
					}
			}
		} 
		else
		{
			$error_message = oci_error($curseurIns);
			echo "<p class=\"erreur\">{$error_message['message']}</p>";
			oci_rollback($lien);
			echo ("
				\"$nsportif\" <br />
				\"$nomS\" <br />
				\"$prenom\" <br />
				\"$pays\" <br />
				\"$categorie\" <br />
				\"$dateNais\" <br />



			");			
		}
	}
	oci_close($curseur1);
	oci_close($curseurIns);
}
include('pied.php');
?>