<?php
require("../Controllers/Fonctions.class.php");
session_start();
if (!isset($_SESSION['connexion'])) {
    header('Location: Recherche.php');
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

        <style>
            table {
                font-family: arial, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }
            
            td {
                border: 1px solid #dddddd;
                padding: 8px;
            }
            
            tr:nth-child(even) {
                background-color: #dddddd;
            }
        </style>

        <title>Livre</title>
    </head>

    <body>
        <?php require("../Views/hautMembre.php"); ?>

        <center>
            <?php
          if (isset($_POST["idLivre"]) or isset($_GET["idLivre"])) {
              if (isset($_POST["idLivre"])) {
                  $livre = $_POST["idLivre"];
                  livreSelectionne($livre);
                  Commentaires($livre);


                  echo '<br/><center><form action="Livre.php" method="POST">
                  <input type="hidden" name="idLivre" value="'. $livre .'">
                  <input style="width:600px" type="text" name="commentaire">
                  <input type="submit" name="ajoutCommentaire" value=" Ajouter un Commentaire" style="width: 300px;">
                  </form></center>';
                  if (isset($_POST["ajoutCommentaire"])) {
                      if (empty($_POST["commentaire"])) {
                          echo"<center><h4><Veuillez fournir un commentaire</h4></center>";
                      } else {
                          Commenter($livre);
                      }
                  }
              } elseif (isset($_GET["idLivre"])) {
                  $livre = $_GET["idLivre"];
                  livreSelectionne($livre);
                  Commentaires($livre);

                  echo '<br/><center><form action="Livre.php" method="POST">
                  <input type="hidden" name="idLivre" value="'. $livre .'">
                  <input style="width:600px" type="text" name="commentaire">
                  <input type="submit" name="ajoutCommentaire" value=" Ajouter un Commentaire" style="width: 300px;">
                  </form></center>';
                  if (isset($_POST["ajoutCommentaire"])) {
                      if (empty($_POST["commentaire"])) {
                          echo"<center><h4><Veuillez fournir un commentaire</h4></center>";
                      } else {
                          Commenter($livre);
                      }
                  }
              }
          } else {
              header('Location: Recherche.php');
          }
          
          ?>
        </center>

    </body>

    </html>