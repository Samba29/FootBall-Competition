<?php
require_once "Configuration.php";

function qualificationPool() // selectionne les deux premiers qualifié de chaque groupe pour le quart de finale
{
    $bdd = connectBdd();
    $req = $bdd->exec('UPDATE `equipe` SET `Participation` = 0'); //remplacer 1 par 0
    $req = $bdd->exec('UPDATE `equipe` SET `Participation` = 1 WHERE `Groupe` = \'A\'ORDER BY `Points` DESC LIMIT 2 ');
    $req = $bdd->exec('UPDATE `equipe` SET `Participation` = 1 WHERE `Groupe` = \'B\'ORDER BY `Points` DESC LIMIT 2 ');
    $req = $bdd->exec('UPDATE `equipe` SET `Participation` = 1 WHERE `Groupe` = \'C\'ORDER BY `Points` DESC LIMIT 2 ');
    $req = $bdd->exec('UPDATE `equipe` SET `Participation` = 1 WHERE `Groupe` = \'D\'ORDER BY `Points` DESC LIMIT 2 ');
}

function generateMatchQuarter()
{
    $bdd = connectBdd();
    $poolA = getTeamPool('A');
    $poolB = getTeamPool('B');
    $poolC = getTeamPool('C');
    $poolD = getTeamPool('D');
    CreateMatch($poolA[1], $poolB[2], 25);
    CreateMatch($poolB[1], $poolA[2], 26);
    CreateMatch($poolC[1], $poolD[2], 27);
    CreateMatch($poolD[1], $poolC[2], 28);
}

function generateDataQuarter()
{
    qualificationPool();
    generateMatchQuarter();
}

?>