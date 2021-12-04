<?php
require("../Controllers/Fonctions.class.php");
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <title>Admin</title>
    </head>

    <body>
        <?php require("../Views/haut.php"); ?>

        <Center>
            <h1>
                <U>
            Accueil
        </U>
            </h1>
            <form action="Login.php" method="POST" style="margin-top: 100px;">
                <table>
                    <tr>
                        <td>
                            <strong>Nom D'Utilisateur:</strong>
                        </td>
                        <td style="text-align: left;">
                            <input type="text" name="login" />
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: right;"><strong>
                    Mot de Passe:
                </strong></td>
                        <td style="text-align: left;">
                            <input name="password" type="password" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center;"><br><input type="submit" name="Admin" value="Se Connecter"></td>
                    </tr>
                </table>
            </form>

        </Center>
    </body>

    </html>
    <?php
// Admin();
?>