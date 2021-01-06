<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php
		$path = $_SERVER['PHP_SELF']; 
    	$file = basename ($path);
	?>
	<form method="Post" action="noDisplay_InsertionTeam.php" enctype="multipart/form-data">
		<input type="hidden" name="MAX_FILE_SIZE" value="3000" />
		<label for="drapeau"> Choisissez le drapeau de votre equipe</br></label>
		<input type="file" name="drapeau">
		<input type="text" name="nom" placeholder="Nom de l'équipe">
		<input type ="text" id = "file" name = "file" value = "<?php echo $file?> " hidden/>
		<input type="submit" value="creer">
	</form>
</body>
</html>