<?php

error_reporting(0);
session_start();
if($_SESSION['besucht'] == true){
    $option_text = " Logout";
    $link = "/Logout";
    $class = "glyphicon glyphicon-log-out";
    $style_hidden = "show"; 
    $style_register = "hidden";
    require_once '../repository/UserRepository.php';
    $userrepository = new UserRepository();
    $username = $userrepository->readById($_SESSION['user_id'])->username;
}
else{
  $option_text = " Login";
  $link = "/Login";
  $class = "glyphicon glyphicon-log-in";
  $style_hidden = "hidden";
  $style_register = "show"; 
}

?>
<!DOCTYPE html>
<html lang="de">
  <head>
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= $title ?> | YouGallery</title>

    <!-- Bootstrap core CSS -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
  </head>
  <body>
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span> 
          </button>
          <a class="navbar-brand navcolor" href="/" style="font-size: 1.2em; color: #7F5959;"><span class="glyphicon glyphicon-camera" style="font-size: 1.2em; color: #7F5959;"></span> YouGallery</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
          <ul class="nav navbar-nav <?= $style_hidden ?>">
            <li class="<?=$active_feed?>"><a href="/feed">Feed</a></li>
            <li class="<?=$active_hot?>"><a href="/hot">Hot</a></li>
            <li class="<?=$active_picture?>"><a href="/picture">Bild hochladen</a></li>
          </ul>
        
          <div class="col-sm-3 col-md-3">
            <form class="navbar-form <?= $style_hidden ?>" role="search" action="/search" method="GET">
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Search" name="keyword" id="search">
                  <div class="input-group-btn">
                    <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search" style="color: #FFB2B2;"></i></button>
                  </div>
              </div>
            </form>
          </div>
          <ul class="nav navbar-nav navbar-right">
            <li class="<?=$style_hidden?>"><a href="/profile?userId=<?=$_SESSION['user_id']?>"><strong>Hey</strong>, <?=$username?></a></li>
            <li class="<?=$style_register?>"><a href="/user"><span class="glyphicon glyphicon-user"></span> Registrieren</a></li>
            <li><a href=<?= $link ?>><span class="<?= $class ?>"></span><?= $option_text ?></a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container">

    <h1><?= $heading ?></h1>
