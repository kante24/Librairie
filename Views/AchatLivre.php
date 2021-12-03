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


if (isset($_POST['ajoutPanier'])) {

    creationPanier();

    ajouterLivrePanier($_POST['idLivre'], $_POST['titre'], $_POST['prix']);

    afficherPanier();

    // echo "id = ". $_POST['idLivre']. " titre = " . $_POST['titre']. " prix = " . $_POST['prix'];
} else {
    header('Location: Livre.php');
}

if(isset($_GET['indice']))
	
{
	$indice =(int)$_GET['indice'];
	$id = $_SESSION['panier']['idLivre'][$indice];
	supprimerLivrePanier($id);
    header('Location: AchatLivre.php');
}


// if (isset($_POST['valider'])) {
//     $user = "root";
//     $pwd = "";
//     $host = "localhost";
//     $bdd = "projetcommelec";
//     $link = mysqli_connect($host, $user, $pwd, $bdd) or die("Erreur de connexion au serveur!");

//     $count = count($_SESSION['panier']['noSerie']);
//     for ($i = 0; $i < $count; $i++) {
//         $noSerie = $_SESSION['panier']['noSerie'][$i];
//         $code = $_SESSION['code'];
//         $prix = intval($_SESSION['panier']['prixLocation'][$i]);
//         // $query= " INSERT INTO location (code,noSerie, dateLocation, dateRetour, prixLocation)
//         $query = " INSERT INTO achat (numSerie,codeClient, prixAchat)
//             VALUES
//             ( '$noSerie','$code','$prix' ) ";
//         $result = mysqli_query($link, $query) or die("<center>Erreur dans la requete</center>");
//     }
//     $montant = MontantGlobal();
//     $d = date("Y-m-d");
//     //fin de l'insertion

//     $ncomm = $_SESSION['noSerie'];




//     echo "<h1>Le numéro de la commande est:  ".$ncomm."</h1>";
//     echo("<h2>le montant total de votre commande avant taxes:  ".$montant."$</h2></br>");

//     //considerons les taxes à 15 pourcents du montant
//     $taxes=$montant*0.15;

//     echo("<h2>Taxes:  ".$taxes."$</h2>");

//     $montantT=$montant+$taxes;

//     echo("<h2>Le montant total apres taxes: ".$montantT."$</h2></br>");
//     $_SESSION['montantTotal'] = $montantT;
//     // echo '<center>Achat  Réussi....Merci a bientot.!<a href="Recherche2.php">Retour</a></center>';
//     echo"
//     <form action=https://www.sandbox.paypal.com/cgi-bin/webscr method=post>
//         <input name=amount type=hidden value=" . $montant . " />
//         <input name=currency_code type=hidden value=CAD />
//         <input name=shipping type=hidden value=transport />
//         <input name=tax type=hidden value=" . $taxes . " />
//         <input name=return type=hidden value=https://localhost/dashboard/projetVente/Recherche2.php />
//         <input name=cancel_return type=hidden value=https://localhost/dashboard/projetVente/Recherche2.php />
//         <input name=notify_url type=hidden value=https://localhost/dashboard/projetVente/ipn.php />
//         <input name=cmd type=hidden value=_xclick />
//         <input name=business type=hidden value=sb-b7mp36739711@business.example.com />
//         <input name=item_name type=hidden value=Détail de votre achat />
//         <input name=no_note type=hidden value=1 />
//         <input name=lc type=hidden value=FR />
//         <input name=bn type=hidden value=PP-BuyNowBF />
//         <input name=custom type=hidden value=" . $ncomm . " />
//         <input type=hidden name=rm value=2>
//         <!--/* Bouton pour valider le paiement */-->
//         <input class=bouton type=submit value=Payer />
//         </form>";
    
//     // unset($_SESSION['panier']);
//     mysqli_close($link);
// }




?>