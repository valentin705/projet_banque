<?php

// requete sql pour recuperer les infos du compte 

$requete = "SELECT * FROM compte WHERE id = $id";

// requete pour recuperer les operations du compte

$requete2 = "SELECT * FROM operation WHERE compte_id = $id";

// requete pour recuperer les versements du compte  

$requete3 = "SELECT * FROM versement WHERE compte_id = $id";

// requete pour recuperer les retraits du compte

$requete4 = "SELECT * FROM retrait WHERE compte_id = $id";

// requete pour supprimer le compte

$requete5 = "DELETE FROM compte WHERE id = $id";

// requete pour supprimer les operations du compte

$requete6 = "DELETE FROM operation WHERE compte_id = $id";

// requete pour modifier le compte

$requete7 = "UPDATE compte SET solde = $solde WHERE id = $id";

// insertion des donnees dans la base de donnees

$requete = "INSERT INTO compte (id, numero, date_ouverture, solde) VALUES (NULL, '$numero', '$date', '$solde')";





