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
    </head>

    <body>
        <?php require("../Views/hautMembre.php"); ?>

        <Center>
            <h1>
                <U>
            Votre Panier d'Achat
        </U>
            </h1>
        </Center>

        

        <br/><br/>
    </body>

    </html>
    <?php



afficherPanier();

if (isset($_POST['ajoutPanier'])) {
    creationPanier();

    ajouterLivrePanier($_POST['idLivre'], $_POST['titre'], $_POST['prix']);

    header('Location: AchatLivre.php');
    // echo "id = ". $_POST['idLivre']. " titre = " . $_POST['titre']. " prix = " . $_POST['prix'];
}

if (isset($_GET['indice'])) {
    $indice =(int)$_GET['indice'];
    $id = $_SESSION['panier']['idLivre'][$indice];
    supprimerLivrePanier($id);
    header('Location: AchatLivre.php');
}


if (isset($_POST['valider'])) {
    $count=count($_SESSION['panier']['idLivre']);
    if (count($_SESSION['panier']['idLivre']) == 0)
    {
        echo "<center><h3>Votre panier est vide</h3></center>";
    }
    else
    {
        echo "<br/><center>
        <form action='" . $_SERVER["PHP_SELF"]  .  "' method=POST>
            <table>
            <tr>
                <td> Adresse Livraison : </td>
                <td> <input type=text name=adresse /></td>
            </tr>
            <tr>
            <td colspan=2><br/> <input style=width:300px type=submit name=payer value=PAYER /></td>
            </tr>
            </table>
        </form></center>";
    }
}

if (isset($_POST['payer'])) {
    Payer();
}



?>