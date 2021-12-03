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

        <title>Recherche Livre</title>
    </head>

    <body>
        <?php require("../Views/hautMembre.php"); ?>

        <Center>
            <h1>
                <U>
                    Tous les Livres
        </U>
            </h1>

            <div style="margin-top:100px;">
            <form action=" <? $_SERVER['PHP_SELF'] ?> " method="POST">
                <input type="submit" name="livres" value="Afficher les Livres Disponibles">
                <input style="margin-left: 100px;" type="submit" name="rechercher" value="Rechercher un livre">
            </form>
        </div>
        </Center>
    


    </body>

    </html>

    <?php
    if (isset($_POST["rechercher"]) )
    {
        echo "<center><br/><br/> <h3>Rechercher par Nom de l'auteur, Titre de l'oeuvre ou par Maison d'Edition</h3>";
        echo '<form style="margin-top:50px" action="' . $_SERVER['PHP_SELF'] . '" method="POST">';
        echo '<input type="text" name="Livre" >';
        echo '<input style="margin-left: 10px;" type="submit" name="afficherLivreRecherche" value="Rechercher">';
        echo '</form></center>';
    }
    if (isset($_POST["livres"])) { afficherLivres(); }
    if (isset($_POST["afficherLivreRecherche"])) { afficherLivre(); }
    
    ?>