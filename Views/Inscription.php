<?php
require("../Controllers/Fonctions.class.php");
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>

<body>
<?php require("../Views/haut.php"); ?>
    <Center>
        <h1>
            <U>
            Inscription
        </U>
        </h1>

        <form action="Inscription.php" method="POST" style="margin-top: 100px;">
            <table>
                <tr>
                    <td style="text-align: right;"><strong>Nom:</strong></td>
                    <td style="text-align: left;">
                        <input type="text" name="nom" />
                    </td>
                </tr>

                <tr>
                    <td style="text-align: right;"><strong>Prenom:</strong></td>
                    <td style="text-align: left;">
                        <input type="text" name="prenom" />
                    </td>
                </tr>

                <tr>
                    <td style="text-align: right;"><strong>Âge:</strong></td>
                    <td style="text-align: left;">
                        <input type="number" name="age" />
                    </td>
                </tr>

                <tr>
                    <td style="text-align: right;"><strong>Nom D'Utilisateur:</strong></td>
                    <td style="text-align: left;">
                        <input type="text" name="login" />
                    </td>
                </tr>

                <tr>
                    <td style="text-align: right;"><strong>
                    Mot de Passe:
                </strong></td>
                    <td style="text-align: left;">
                        <input type="password" name="password" />
                    </td>
                </tr>

                <tr>
                    <td colspan="2" style="text-align: center;"><input type="submit" name="Inscription" value="Valider"></td>
                </tr>
            </table>
        </form>

    </Center>
</body>

</html>

<?php
Inscription();
?>