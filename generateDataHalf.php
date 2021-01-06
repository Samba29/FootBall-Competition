<?php
require_once "Configuration.php";

function qualificationHalf()
{
    $bdd = connectBdd();
    $req = $bdd->exec('UPDATE `equipe` SET `Participation` = 0');
    $req = $bdd->query('SELECT * FROM `match` WHERE `Jour` BETWEEN 25 AND 28');
    $team[] = array();
    while ($donnees = $req->fetch()) {
    	$team[] = $donnees['Vainqueur'];
    }
    $i = 0;
    while ($i < 4) {
    	$req = $bdd->prepare('UPDATE `equipe` SET `Participation` = 1 WHERE `ID` = $team[$i]');
    	$i += 1;
    }
        // on prends les vainqueurs des quarts de finale et on les sélectionne pour la demi finale
}

function generateMatchHalf()
{
	$bdd = connectBdd();
	$req = $bdd->query('SELECT * FROM `match` WHERE `Jour` BETWEEN 25 AND 28 ');
	$team[] = array();
	while ($donnees = $req->fetch()) {
		$team[] = (int)$donnees['Vainqueur']; 
	}
	CreateMatch($team[1], $team[2], 29);
	CreateMatch($team[3], $team[4], 30);
}

function generateDataHalf()
{
	qualificationHalf();
	generateMatchHalf();
}
?>