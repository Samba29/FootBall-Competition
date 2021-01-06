<?php
Require_Once "Configuration.php";
function ReinitialiseAll($baseFile)
{
    $bdd = connectBdd();
    $req = $bdd->exec('UPDATE `equipe` SET `Participation` = 0, `BM` = 0, `BE` = 0, `DF` = 0, `Nulls` = 0, `Victoires` = 0, `Points` = 0, `Defaites` = 0
    	, `NombreMatchJouer` = 0, `Groupe` = "NONE"');
    $req = $bdd->exec('DELETE FROM `match` WHERE 1');
    $req = $bdd->exec('UPDATE equipe SET `Participation` = 1 WHERE `Choisi` = 1');
    reinitialiseDay();
    generateDataPool();
    header('Location: ' .$baseFile);
}

?>