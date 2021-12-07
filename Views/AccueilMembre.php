<?php
require("../Controllers/Fonctions.class.php");
session_start();
if (!isset($_SESSION['connexion'])) {
    header('Location: Login.php');
    exit;
}
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <title>Accueil Membre</title>
    <style>
    body {
 background-image: url("../Images/Librairie.jpg");
 background-color: #cccccc;
}
</style>
    </head>

    <body>
        <?php require("../Views/hautMembre.php"); ?>

        <Center>
            <h1 style="background-color: white;">
                <U>
            Accueil <?=$_SESSION['nom']?>
        </U>
            </h1>
        </Center>


    <div class="container" style="width: 400px; height: 300px; margin-top:100px">

<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" >
    

    <ol class="carousel-indicators">
      <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
    </ol>

    <div class="carousel-inner">

    <div class="carousel-item active">
        <img class="d-block w-100" src="../Images/a_toi_pour_toujours_ta_marie_lou_lemeac.jpg"/>
      </div>
      <div class="carousel-item">
        <img class="d-block w-100" src="../Images/maria_Chapdelaine_BQ.jpg"/>
      </div>
      <div class="carousel-item">
        <img class="d-block w-100" src="../Images/oscar_et_la_dame_rose.jpg"/>
      </div>
      <div class="carousel-item">
        <img class="d-block w-100" src="../Images/zadig.jpg"/>
      </div>

    </div>

    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>





<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


    </body>

    </html>