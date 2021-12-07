<?php
require("hautAdmin.php");
require("../Controllers/Fonctions.class.php");
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <title>Administration Users</title>
    </head>

    <body>

        <Center>
            <h1>
                <U>
                Administration des Utilisateurs
        </U>
            </h1>
            <h1 style="background-color: gainsboro;text-align:center;margin-top:100px">
                <U>
                    Utilisateur à modifier
                </U>
            </h1>
            <form action="adminUtilisateur.php" method="POST" style="margin-top:100px">
                <table>
                    <tr>
                        <td style="text-align: right;"><strong>Nom d'utilisateur:</strong></td>
                        <td style="text-align: left;">
                            <input type="text" name="login" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center;">
                            </br><input type="submit" name="rechercheUser" value="Rechercher"></td>
                    </tr>
                </table>
            </form>

            <?php
            if(isset($_POST["rechercheUser"]))
            {
                RechercheUser($_POST["login"]) ;
            }

            if (isset($_POST["modifierUser"])) {
                ModifierUserByAdmin($_POST["loginModife"]);
                // echo $_POST["loginModife"];
            }

            if (isset($_POST["supUser"])) {
                SuprimerUserByAdmin($_POST["loginModife"]);
            }
            ?>

        </Center>


    </body>
    
    </html>

    <?php

    ?>