<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Custom styles for this template -->
    <link href="<?=$GLOBALS['appurl']?>/css/style.css" rel="stylesheet">
	<script src="<?=$GLOBALS['appurl']?>/js/jscript.js"></script>
      <link href="<?=$GLOBALS['appurl']?>/css/lightbox.css" rel="stylesheet">
      <script src="<?=$GLOBALS['appurl']?>/js/lightbox-plus-jquery.js"></script>
    <title><?= $title ?></title>
  </head>
  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand">Bilder-DB</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
			<!-- fix schf -->
            <?php
                if(isset($_SESSION['besucht']) && $_SESSION['besucht'] == true){
            ?>
                    <li><a href="<?=$GLOBALS['appurl']?>/logout">Logout</a></li>
                    <li><a href="<?=$GLOBALS['appurl']?>/gallery/createGallery">Galerie erstellen</a></li>
                    <li><a href="<?=$GLOBALS['appurl']?>/gallery/">Galerien anzeigen</a></li>
                    <li><a href="<?=$GLOBALS['appurl']?>/picture">Bild hochladen</a></li>

                <?php
                }else {
                ?>
                    <li><a href="<?= $GLOBALS['appurl'] ?>/login">Login</a></li>
                    <li><a href="<?= $GLOBALS['appurl'] ?>/login/registration">Registration</a></li>
                <?php
                }?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <div class="container content">
    <h3><?= $heading ?> </h3>
