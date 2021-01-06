<?php
	
	Require_Once "Configuration.php";
	function readDay()
	{
	    $fichier = fopen('fichier/jour.txt', 'r+');
	    $ligne = fgets($fichier);
	    $ligne = (int)$ligne;
	    echo $ligne;
	    fclose($fichier);
	    return $ligne;
	}

	function goToNextDay()
	{
	    $valeur = readDay();
	    $valeur = $valeur + 1;
	    $fichier = fopen('fichier/jour.txt', 'r+');
	    fseek($fichier, 0);
	    fputs($fichier, $valeur);
	    fclose($fichier);
	}
	 function reinitialiseDay()
	 {
	    $valeur = readDay();
	    $valeur = 0;
	    $fichier = fopen('fichier/jour.txt', 'w+');
	    fputs($fichier, $valeur);
	    fclose($fichier);
	 }

	function connectBdd()
	{
	    try
	    {
	        $bdd = new PDO('mysql:host=localhost;dbname=tp201', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	    }catch (Exception $e)
	    {
	       die('Erreur : ' . $e->getMessage());
	    }
	    return $bdd;
	}


	function PreviewTeamSelectionned()
	{
		$bdd = connectBdd();
		$req= $bdd->query('SELECT COUNT(`ID`) FROM equipe WHERE `Choisi` = 1');
		$donnees = $req->fetch();
		echo ($donnees[COUNT(`ID`)]);
		$req = $bdd->query('SELECT `ID` FROM equipe WHERE `Choisi` = 1');
		while($donnes = $req->fetch()) {
			?><span class="PreviewTeam">
				<img src="<?php echo flag($donnes['ID']);?>">
				<br><p><?php echo nameTeam($donnes['ID']); ?></p>
			</span><?php 
		}
	}
?>