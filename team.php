<?php
    Require_Once "Configuration.php";   
    function getPlayers()
    {
        $bdd = connectBdd();
        $req = $bdd->prepare('SELECT * FROM `joueur` WHERE `Nationalite` = ?  ');
        $req->execute(array($_GET['Nationalite']));
        while ($donnees = $req->fetch())
        {
            ?>
            <p>
            <img src= <php $donnees[Image] ?>>
            <?php 
            echo ($donnees['Nom']."".$donnees['Age'].$donnees['Poste']."".$donnees['Nationalite']);
            ?>
            </p>
            <?php
        }
    }

    function getTeam($level)
    {
        $bdd = connectBdd();
        $req = $bdd->prepare('SELECT * FROM `equipe` WHERE `Participation` = ? ORDER BY `Groupe`,`Points`');
        $req->execute(array($level));
        while($donnees = $req->fetch())
        {
            ?>
            <p>
            <img src = <php $donnees[Image] ?>>
            <?php
            echo ("".$donnees['Nom']. "".$donnees['Nulls']."".$donnees['Victoires']."".$donnees['Defaites']."".$donnees['Points']);
            ?>
            </p>
            <?php
        }
    }

    function nameTeam($ID)
    {
        $bdd = connectBdd();
        $req = $bdd->prepare('SELECT `Nom` FROM `equipe` WHERE `ID` = ?');
        $req->execute(array($ID));
        $donnees = $req->fetch();
        return $donnees['Nom'];
    }

    function flag($ID)
    {
        $bdd = connectBdd();
        $req = $bdd->prepare('SELECT `ImageUrl` FROM `equipe` WHERE `ID` = ?');
        $req->execute(array($ID));
        $donnees = $req->fetch();
        return $donnees['ImageUrl'];
    }

    function getTeamPool($pool) // renvoie les équipes par pool, l'indice commence a 1
    {
        $team[] = array();
        $bdd = connectBdd();
        $req = $bdd->prepare('SELECT `ID` FROM `equipe` WHERE `Groupe` = ? ORDER BY `Points` DESC');
        $req->execute(array($pool));
        while($donnees = $req->fetch())
        {
            $team[] = $donnees['ID'];
        }
        return $team;
    }

    function PrintgetTeamPool($pool) // affiche les équipes par pool
    {
        $bdd = connectBdd();
        $req = $bdd->prepare('SELECT * FROM `equipe` WHERE `Groupe` = ? ORDER BY `Points` DESC');
        $req->execute(array($pool));
        ?>
        <table>
            <caption><?php echo $pool?></caption>
            <tr>
                <th>Nom</th>
                <th>J </th>
                <th>BM</th>
                <th>BE</th>
                <th>DB</th>
                <th>Pts</th>
                <th>V</th>
                <th>N</th>
                <th>D</th>
            </tr>
        <?php
        while($donnees = $req->fetch())
        {
            ?>
            <tr>
                <td><?php echo $donnees['Nom'] ?></td>
                <td><?php echo $donnees['NombreMatchJouer'] ?></td>
                <td><?php echo $donnees['BM'] ?></td>
                <td><?php echo $donnees['BE'] ?></td>
                <td><?php echo $donnees['DF'] ?></td>
                <td><?php echo $donnees['Points'] ?></td>
                <td><?php echo $donnees['Victoires'] ?></td>
                <td><?php echo $donnees['Nulls'] ?></td>
                <td><?php echo $donnees['Defaites'] ?></td>
            </tr>
            <?php
        }
        ?>
        </table>
        <?php
    }

    function InsertTeam()
    { // si l'image a été envoyé on fait l'insertion de l'équipe
        $cheminImage = '';
        if ($_FILES['drapeau']['error'] > 0) {
                $error = "";
                if ($_FILES['drapeau']['error'] == UPLOAD_ERR_NO_FILE) {
                    $error = "Aucun fichier";
                }
                elseif ($_FILES['drapeau']['error'] == UPLOAD_ERR_FORM_SIZE) {
                    $error = "le fichier dépasse la taille autorisée";
                }
                elseif ($_FILES['drapeau']['error'] == UPLOAD_ERR_PARTIAL) {
                    $error = "Fichier transférer partiellement";
                }
                echo $error;
            }
        if ($_FILES['drapeau']['error'] == 0) { // on stock d'abord l'image
             // on stock d'abord l'image
            $extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
            $extension_upload = strtolower( substr( strrchr($_FILES['drapeau']['name'], '.') ,1) );
            if ( in_array($extension_upload,$extensions_valides) )
                {
                    $sizeImg = getimagesize($_FILES['drapeau']['tmp_name']);
                    if ($sizeImg[0] == 120 OR $sizeImg[1] == 80) {
                        $nom = "dp_".htmlspecialchars($_POST['nom']);
                    $cheminImage = "drapeau/{$nom}.{$extension_upload}";
                    $nom = "drapeau/{$nom}.{$extension_upload}";
                    $resultat = move_uploaded_file($_FILES['drapeau']['tmp_name'],$nom);
                    if ($resultat) echo "Transfert réussi";
                    }
                }
                // on insère l'équipe dans la base.
            $bdd = connectBdd();
            $req = $bdd->prepare('INSERT INTO `equipe` (`Nom`, `ImageUrl`, `Groupe`) VALUES (?, ?, "NONE")');
            $req->execute(array(htmlspecialchars($_POST['nom']), $cheminImage));
        }   
        header('Location: ' .$_POST['file']); 
    }

    function ManageTeam($pageCible)
    {
        $bdd = connectBdd();
        $req = $bdd->query('SELECT `ID`, `Nom`, `Groupe`, `Participation`, `Choisi` FROM `equipe` WHERE 1 ORDER BY `Nom`,`Choisi`');
        $path = $_SERVER['PHP_SELF'];
        $file = basename ($path);
        while ($donnees = $req->fetch()) {
            ?>
            <form action="<?php echo($pageCible)?>" method="post">
                <img src="<?php echo flag($donnees['ID'])?>">
                <input type="" name="Nom" id="Nom" value="<?php echo $donnees['Nom']?>">
                <p>Voulez vous que l'équipe participe? </br>
                <input type="radio" name="Participation" value= 1 id="Oui" 
                    <?php if ($donnees['Choisi'] == 1) {
                        echo "checked";
                    }?>>
                <label for="Oui"> Oui</label></br>
                <input type="radio" name="Participation" value= 0 id="Non"
                <?php if ($donnees['Choisi'] == 0) {
                        echo "checked";
                    }?>>
                <label for="Non"> Non</label></br>
                </p>
                <input type="" id = "ID" name = "ID" value = "<?php echo $donnees['ID']?>" value="<?php echo $donnees['ID']?>" hidden>
                <input type ="text" id = "file" name = "file" value = "<?php echo $file?> " hidden/>
                <input type="submit" name="modifier" value="modifier">
            </form>
            <?php
        }
    }

    function ModifTeam($pageCible)
    {
        try {
            $bdd = connectBdd();
            $req = $bdd->prepare('UPDATE equipe SET `Nom` = ? , `Choisi` = ? WHERE `ID` = ?');
            $req->execute(array((htmlspecialchars($_POST['Nom'])), $_POST['Participation'], $_POST['ID']));
            $req= $bdd->query('SELECT COUNT(`ID`) FROM equipe WHERE `Choisi` = 1');
            $donnees = $req->fetch();
            if ($donnees[COUNT(`ID`)] < 16 )
            {
                throw new Exception("Il faut au moins 16 équipes sélectionnées!");
                
            }
        
        } catch (Exception $e) {
            die("Il faut au moins 16 équipes sélectionnées!");
        }
        ReinitialiseAll($pageCible);
    }
?>