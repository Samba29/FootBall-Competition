<!DOCTYPE html>
<html>
<?php require_once('Configuration.php') ?>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/Administration1.css" />
</head>
<body>
    <header class="container immobile">
        <?php include("modules/mod_AffichagePool.php"); ?>
    </header>
    <nav class="side">
       <?php include("modules/mod_MenuAdmin.php"); ?>
    </nav>
    <section class="affichage">
        <?php
            previewMatchPoolAdmin();
        ?>
    </section>
</body>
</html>