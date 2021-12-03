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

    <title>Factures</title>
</head>

<body>
<?php require("../Views/hautMembre.php"); ?>
    <form>
        <center>
            <input type="button" value="Imprimer les facture" onClick="window.print()">
        </center>
    </form>
</body>

</html>
<?php
    $id = rechercheID($_SESSION["nom"]);
    echo facture($id);
?>