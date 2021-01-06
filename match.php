<?php  

    Require_Once "Configuration.php";
        
    function previewMatch($start, $end)
    {
        $bdd = connectBdd();
        $temps = readDay();
        $req = $bdd->prepare('SELECT `Equipe1`, `Equipe2`, `Jour` FROM `match` 
            INNER JOIN `equipe` ON `match`.`Equipe1` = `equipe`.`ID`  WHERE `match`.`Jour` > ? AND`match`.`Jour` BETWEEN ? AND ? ');
        $req->execute(array($temps, $start, $end));
        while($donnees = $req->fetch())
        {
            echo nameTeam($donnees['Equipe1']). "Vs" .nameTeam($donnees['Equipe2']). $donnees['Jour'] ?>
            ;<br> 
            <?php
        }
        
    }


    function previewLastMatch()
    {
        $bdd = connectBdd();
        $req = $bdd->query('SELECT * FROM `match`WHERE `Passer` = 1 ORDER BY `ID` LIMIT 1');
        while($donnees = $req->fetch())
        {
         ?>
        <span class ="flag">
            <img src= "<?php echo flag($donnees['Equipe1']); ?>">
            <p><?php echo nameTeam($donnees['Equipe1']); ?></p>
        </span>
                <label><?php echo $donnees['Buts_Equipe1'] ?></label>
                <label>Vs</label>
                <label><?php echo $donnees['Buts_Equipe2'] ?></label>
                <span class ="flag">
                <img src= "<?php echo flag($donnees['Equipe2']); ?>">
                <p><?php echo nameTeam($donnees['Equipe2']); ?></p>
        </span>
            <?php
        }
        
    }

    function previewNextMatch()
    {
        $bdd = connectBdd();
        $req = $bdd->query('SELECT * FROM `match`WHERE `Passer` = 0 ORDER BY `ID` LIMIT 1');
        while($donnees = $req->fetch())
        {
         ?>
        <span class ="flag">
            <img src= "<?php echo flag($donnees['Equipe1']); ?>">
            <p><?php echo nameTeam($donnees['Equipe1']); ?></p>
        </span>
                <label>?</label>
                <label>Vs</label>
                <label>?</label>
                <span class ="flag">
                <img src= "<?php echo flag($donnees['Equipe2']); ?>">
                <p><?php echo nameTeam($donnees['Equipe2']); ?></p>
        </span>
            <?php
        }
    }

    function previewMatchAdmin($start, $end)
    {
        $bdd = connectBdd();
        $temps = readDay();
        $req = $bdd->prepare('SELECT * FROM `match` WHERE `match`.`Jour` BETWEEN ? AND ? ORDER BY `match`.`Passer`');
        $req->execute(array($start, $end));
        ?>
        <?php
        $path = $_SERVER['PHP_SELF']; // $path = /home/httpd/html/index.php
        $file = basename ($path);
        ?><table class="previewMatchTable">
            <tr>
                <th>Equipe 1</th>
                <th></th>
                <th>Equipe 2</th>
            </tr>
                
            <?php
        while($donnees = $req->fetch())
        {   
            ?>
            <tr>
                 <form method="post" action="SetMatch">
                    <td class="score1"><span class ="flag">
                        <img src= "<?php echo flag($donnees['Equipe1']); ?>">
                        <p><?php echo nameTeam($donnees['Equipe1']); ?></p>
                    </span></td>
                    <td class="center">
                         <?php
                            if ($donnees['Passer'] == 1) {
                                ?>
                               <label><?php echo $donnees['Buts_Equipe1'] ?></label>
                                <label>Vs</label>
                                <label><?php echo $donnees['Buts_Equipe2'] ?></label>
                                <?php
                            }
                            else{ ?>
                                <input type ="number" id = "score1" name = "score1"  min = 0 max = 10 required/>
                                <input type="submit" value ="Simuler"/> 
                                <input type ="number" id = "score2" name = "score2"  min = 0 max = 10 required/>
                                <?php
                            }

                        ?>
                    </td>
                    <td class="score2"><span class ="flag">
                        <img src= "<?php echo flag($donnees['Equipe2']); ?>">
                        <p><?php echo nameTeam($donnees['Equipe2']); ?></p
                    </span></td>
                    <input type ="text" id = "IDMatch" name = "IDMatch" value = "<?php echo $donnees['ID']?> " hidden/>
                    <input type ="text" id = "IDEquipe1" name = "IDEquipe1" value = "<?php echo $donnees['Equipe1']?> " hidden/>
                    <input type ="text" id = "IDEquipe2" name = "IDEquipe2" value = "<?php echo $donnees['Equipe2']?> " hidden/>
                    <input type ="text" id = "file" name = "file" value = "<?php echo $file?> " hidden/>

                    </form>
                </tr>
            <?php 
        }
        ?><table><?php
    }

    function CreateMatch($eq1, $eq2, $jour)
    {
        $bdd = connectBdd();
        $req = $bdd->prepare('INSERT INTO `match` 
        (`ID`, `Jour`, `Equipe1`, `Equipe2`, `Buts_Equipe1`, `Buts_Equipe2`) VALUES 
        (NULL, :jour, :eq1, :eq2, 0, 0)
        ');
        $req->execute(array(
            'jour' => $jour,
            'eq1' => $eq1,
            'eq2' => $eq2
        ));
    }


    function setScore($but1, $but2, $idMatch, $idEquipe1, $idEquipe2, $baseFile) // vette fonction se charge de mettre les scores et de modifier les paramètres des équipes
    {
        $bdd = connectBdd();
        $req = $bdd->prepare('UPDATE `match` SET `Buts_Equipe1` = ?,  `Buts_Equipe2` = ?, `Passer` = 1 WHERE `ID` = ?');
        $req->execute(array($but1, $but2, $idMatch));
        if($but1 == $but2)
        {
            $req = $bdd->prepare('UPDATE `equipe` SET `Nulls` = (`Nulls` + 1), `Points` = (`Points` + 1) WHERE `ID` = ?');
            $req->execute(array($idEquipe1));
            $req = $bdd->prepare('UPDATE `equipe` SET `Nulls` = (`Nulls` + 1), `Points` = (`Points` + 1) WHERE `ID` = ?');
            $req->execute(array($idEquipe2));   
        }
        if ($but1 > $but2)
            {
                $req = $bdd->prepare('UPDATE `match` SET `Vainqueur` = `Equipe1`  WHERE `ID` = ?');
                $req->execute(array($idMatch));
                $req = $bdd->prepare('UPDATE `equipe` SET `Victoires` = (`Victoires` + 1), `Points` = (`Points` + 3) WHERE `ID` = ?');
                $req->execute(array($idEquipe1));
                $req = $bdd->prepare('UPDATE `equipe` SET `Defaites` = (`Defaites` + 1) WHERE `ID` = ?');
                $req->execute(array($idEquipe2));
            }
         if ($but1 < $but2)
            {
                $req = $bdd->prepare('UPDATE `match` SET `Vainqueur` = `Equipe2` WHERE `ID` = ?');
                $req->execute(array($idMatch)); 
                $req = $bdd->prepare('UPDATE `equipe` SET `Victoires` = (`Victoires` + 1), `Points` = (`Points` + 3) WHERE `ID` = ?');
                $req->execute(array($idEquipe2)); 
                $req = $bdd->prepare('UPDATE `equipe` SET `Defaites` = (`Defaites` + 1) WHERE `ID` = ?');
                $req->execute(array($idEquipe1));
            } 
        $req = $bdd->prepare('UPDATE `equipe` SET `BM` = (`BM` + ?),  `BE` = (`BE` + ?), `DF` = (`BM` - `BE`), `NombreMatchJouer` = (`NombreMatchJouer` + 1) WHERE `ID` = ?');
        $req->execute(array($but1, $but2, $idEquipe1)); 

        $req = $bdd->prepare('UPDATE `equipe` SET `BM` = (`BM` + ?),  `BE` = (`BE` + ?), `DF` = (`BM` - `BE`), `NombreMatchJouer` = (`NombreMatchJouer` + 1) WHERE `ID` = ?');
        $req->execute(array($but2, $but1, $idEquipe2));
        goToNextDay();
        // Ici on vérifie si l'on doit passer a la phase suivante en comptant les jours.
        $jour = readDay();
        if ($jour == 24) {
            generateDataQuarter();
        }
        elseif ($jour == 28) {
            generateDataHalf();
        }
        elseif ($jour == 30) {
            generateDataShort();
            generateDataFinale();
        }
        header('Location: ' .$baseFile);
        }

        function previewMatchPool()
    {
        return previewMatch(1, 24);
    }

    function previewMatchQuart()
    {
        return previewMatch(25, 28);
    }

    function previewMatchHalf()
    {
        return previewMatch(29, 30);
    }

    function previewMatchShort()
    {
        return previewMatch(31, 31);
    }

    function previewMatchFinal()
    {
        return previewMatch(32, 32);
    }

    function previewMatchPoolAdmin()
    {
        return previewMatchAdmin(1, 24);
    }

    function previewMatchQuartAdmin()
    {
        return previewMatchAdmin(25, 28);
    }

    function previewMatchHalfAdmin()
    {
        return previewMatchAdmin(29, 30);
    }

    function previewMatchShortAdmin()
    {
        return previewMatchAdmin(31, 31);
    }
    function previewMatchFinalAdmin()
    {
        return previewMatchAdmin(32, 32);
    }
?>