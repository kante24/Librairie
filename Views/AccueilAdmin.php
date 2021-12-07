<?php
require("../Controllers/Fonctions.class.php");
session_start();
if (!isset($_SESSION['connection'])) {
    header('Location: Admin.php');
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

        <title>Accueil Admin</title>
    </head>

    <body>
        <?php require("../Views/hautAdmin.php"); ?>

        <Center>
            <h1>
                <U>
            Administrateur__<?=$_SESSION['nom']?>
        </U>
            </h1>
        </Center>
    </body>

    </html>