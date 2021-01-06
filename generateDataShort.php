<?php
    Require_Once "Configuration.php";

    function generateMatchShort()
    {
        $bdd = connectBdd();
        $req = $bdd->query('SELECT * FROM `match` WHERE `Jour` BETWEEN 29 AND 30 ');
        $team[] = array();
        while ($donnees = $req->fetch()) {
           if ($donnees['Equipe1'] == $donnees['Vainqueur']) {
                $team[] = $donnees['Equipe2'];
            }
            else
            {
                 $team[] = $donnees['Equipe1'];
            }

        }
        CreateMatch($team[1], $team[2], 31);
    }

    function generateDataShort()
    {
        generateMatchShort();
    }
?>