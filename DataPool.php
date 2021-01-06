<?php
require_once "Configuration.php";

function affectationGroups() //affecte les equipes au groupe
{
    $bdd = connectBdd();
    $req = $bdd->exec('UPDATE `equipe` SET `Groupe` = \'D\' WHERE `Participation` =  1 LIMIT 16');
    $req = $bdd->exec('UPDATE `equipe` SET `Groupe` = \'C\' WHERE `Participation` =  1 LIMIT 12');
    $req = $bdd->exec('UPDATE `equipe` SET `Groupe` = \'B\' WHERE `Participation` =  1 LIMIT 8 ');
    $req = $bdd->exec('UPDATE `equipe` SET `Groupe` = \'A\' WHERE `Participation` =  1 LIMIT 4 ');
     
}

function generateMatchPool() //génere les matchs
{
    $bdd = connectBdd();
    $req = $bdd->exec('DELETE FROM `match`'); // on vide la table
    $poolA = getTeamPool('A');
    $poolB = getTeamPool('B');
    $poolC = getTeamPool('C');
    $poolD = getTeamPool('D');
    try {
    CreateMatch($poolA[1], $poolA[2], 1);
    CreateMatch($poolB[1], $poolB[2], 2);
    CreateMatch($poolC[1], $poolC[2], 3);
    CreateMatch($poolD[1], $poolD[2], 4);
    // fin des premiers match
    CreateMatch($poolA[1], $poolA[3], 5);
    CreateMatch($poolB[1], $poolB[3], 6);
    CreateMatch($poolC[1], $poolC[3], 7);
    CreateMatch($poolD[1], $poolD[3], 8);
    // fin deuxième groupe de match
    CreateMatch($poolA[1], $poolA[4], 9);
    CreateMatch($poolB[1], $poolB[4], 10);
    CreateMatch($poolC[1], $poolC[4], 11);
    CreateMatch($poolD[1], $poolD[4], 12);
    //fin troisième groupe de match
    CreateMatch($poolA[2], $poolA[3], 13);
    CreateMatch($poolB[2], $poolB[3], 14);
    CreateMatch($poolC[2], $poolC[3], 15);
    CreateMatch($poolD[2], $poolD[3], 16);
    //fin quatrième groupe de match
    CreateMatch($poolA[2], $poolA[4], 17);
    CreateMatch($poolB[2], $poolB[4], 18);
    CreateMatch($poolC[2], $poolC[4], 19);
    CreateMatch($poolD[2], $poolD[4], 20);
    //fin cinquième groupe de match
    CreateMatch($poolA[3], $poolA[4], 21);
    CreateMatch($poolB[3], $poolB[4], 22);
    CreateMatch($poolC[3], $poolC[4], 23);
    CreateMatch($poolD[3], $poolD[4], 24);
    } catch (Exception $e) {
        echo "La compétition doit avoir 16 équipes pour se dérouler";
    }
}


function generateDataPool()
{
    affectationGroups();
    generateMatchPool();
}

?>