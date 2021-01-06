 <ul class="nav">
        	<?php  
        		$path = $_SERVER['PHP_SELF']; // $path = /home/httpd/html/index.php
    			$file = basename ($path);
        	?>
            <li><a href="Admin_Pool">Pool</a></li>
            <li><a href="Admin_Quart">Quart de finale</a></li>
            <li><a href="Admin_Half">Demi Finale</a></li>
            <li><a href="Admin_Short">Petite Finale</a></li>
            <li><a href="Admin_Finale">Finale</a></li>
            <li><a href="inscriptionTeam.php">Inserer une équipe</a></li>
            <li><a href="Admin_TeamGestion.php">Gestion des équipes</a></li>
            <li><a href="ReinitialisationAll.php?lien= <?php echo($file)?>" class = "Danger">Reinitialisation</a></li>
        </ul>