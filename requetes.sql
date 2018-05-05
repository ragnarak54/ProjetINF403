/* Afficher les épreuves sans billet vendu */

select nepreuve from lesepreuves
	minus
select distinct nepreuve from lesbillets


dossier -> discipline
with R1 as(
select distinct nEpreuve from lesBillets where dossier = 2
) select distinct discipline from lesepreuves where discipline in R1

dossier and discipline -> billets, nombre de places

select nbillet from lesbillets where nepreuve in
(select nepreuve from lesepreuves where discipline = :d and nepreuve in 
(select distinct nEpreuve from lesBillets where ndossier = :d))
