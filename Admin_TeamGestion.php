<!DOCTYPE html>
<html >
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" media="screen" href="../css/Administration2.css" />
</head>
<body>
	<nav class="side"><?php
		Require_Once "modules/mod_MenuAdmin.php"
	;
	?>
	</nav>	
	<div class="ManageTeam">
		<?php
			Require_Once "modules/mod_ManageTeam.php"; 
		?>
	</div>
	<div class="leftSide">
		<h4>Equipes Participantes</h4>
		<?php
			Require_Once "modules/mod_EquipeParticipante.php"; 
		?>
	</div>
</body>
</html>