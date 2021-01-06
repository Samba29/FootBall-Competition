<?php

    require_once("Configuration.php");

    function qualificationFinale()
    {
        $bdd = connectBdd();
        $req = $bdd->query('SELECT * FROM `match` WHERE `Jour` BETWEEN 29 AND 30');
        $team[] = array();
        while ($donnees = $req->fetch()) {
        	$team[] = $donnees['Vainqueur'];
        }
        $i = 0;
        while ($i < 2) {
        	$req = $bdd->prepare('UPDATE `equipe` SET `Participation` = 1 WHERE `ID` = $team[$i]');
        	$i += 1;
        }
            // on prends les vainqueurs des quarts de finale et on les sélectionne pour la demi finale
    }

    function generateMatchFinale()
    {
    	$bdd = connectBdd();
    	$req = $bdd->query('SELECT * FROM `match` WHERE `Jour` BETWEEN 29 AND 30 ');
    	$team[] = array();
    	while ($donnees = $req->fetch()) {
    		$team[] = (int)$donnees['Vainqueur']; 
    	}
    	CreateMatch($team[1], $team[2], 32);
    }

    function generateDataFinale()
    {
    	qualificationFinale();
    	generateMatchFinale();
    }
?>