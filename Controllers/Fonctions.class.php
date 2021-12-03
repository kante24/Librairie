<?php
//  $_SERVER['PHP_SELF']
require("../Controllers/UtilisateurManager.class.php");
require("../Controllers/LivreManager.class.php");
require("../Models/Utilisateur.class.php");
require("../Models/Utilisateur_simple.class.php");
require("../Models/Livre.class.php");

// Fonction pour charger automatiquement les classes utilisées
// function chargerClasse($classe)
// {
//     if (preg_match('../Controllers$/', $classe . ".class.php")) {
//         require("../Controllers/" . $classe . ".class.php");
//     } else {
//         require("../Models/" . $classe . ".class.php");
//     }
// }
// spl_autoload_register('chargerClasse');



//connexion pdo à la bd
function connexion()
{
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=Librairie", "root", "");
        return $pdo;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

//Fonction connection avec nom utilisateur et mot de passe
function Login()
{
    if (isset($_POST["Connection"])) {
        if (empty($_POST['login']) or empty($_POST['password'])) {
            echo"<center>Veuillez remplir tous les champs SVP</center>";
        } else {
            $db = connexion();
            $Utilisateur=new Utilisateur_simple(array("login"=>$_POST['login'],"password"=> $_POST['password']));
            $UtilisateurManager = new UtilisateurManager($db);
            $results=$UtilisateurManager->login($Utilisateur);
    
            //test de contenu
            if ($results!== false) {
                session_start();
                $_SESSION['connexion'] = true;
                $_SESSION['nom'] = $_POST['login'];
                header("Location:AccueilMembre.php");
            } else {
                echo"<center>Veuillez vous enregistrer</center>";
            }
        }
    }
}

//Deconnection
function LogOut()
{
    session_start();
    session_destroy();
    header('Location: ../index.php');
}

//Inscription nouveau membre
function Inscription()
{
    if (isset($_POST["Inscription"])) {
        if (empty($_POST['nom']) or empty($_POST['prenom']) or empty($_POST['age']) or empty($_POST['login']) or empty($_POST['password'])) {
            echo"<center>Veuillez remplir tous les champs SVP</center>";
        } else {
            $db = connexion();
            $Utilisateur=new Utilisateur_simple(array("nom"=>$_POST['nom'], "prenom"=>$_POST['prenom'], "age"=>$_POST['age'], "login"=>$_POST['login'], "password"=> $_POST['password']));
            $UtilisateurManager = new UtilisateurManager($db);
            $UtilisateurManager->inscription($Utilisateur);
            echo "<center>Inscription réussie, vous pouvez vous connecter</center>";
        }
    }
}

//Afficher tous les livres
function afficherLivres()
{
    $db = connexion();

    $LivreManager = new LivreManager($db);
    $results=$LivreManager->Livres();
    if ($results == null) {
        echo "<center>Aucun livre disponible, Veuillez revenir ultérieurement</center>";
    } else {
        echo "</br></br></br>";
        foreach ($results as $key =>$value) {
            echo "<center></br></br>";
            echo "<table border = 1 style=width:500px;text-align:center;>";
            echo "<tr style=background-color:gainsboro> <td>Nom Auteur</td>  <td>Titre</td>  <td>Date Publication</td>  <td>Edition</td></tr>";
            echo "<tr> <td>" . $value->nomAuteur(). "</td>  <td>" . $value->titre() . "</td>  <td>" . $value->anneePublication() . "</td>  <td>". $value->edition() . "</td></tr>";
            echo "</table>";
            echo '<form action="Livre.php" method="POST" style="margin-top: 20px;">';
            echo '<input type="hidden" name="idLivre" value="' . $value->idLivre() . '">';
            echo '<input type="submit" name="Afficher" value="Afficher" style="width: 200px;"> ';
            echo '</form>';
            echo "<hr/>";
            echo "</center>";
        }
    }
}


//Achiffer livre selon un critère
function afficherLivre()
{
    $db = connexion();
    $LivreManager = new LivreManager($db);
    $result = $LivreManager->afficherLivre($_POST["Livre"]);
    if ($result == null) {
        echo "<center><br/><br/><br/><h4>Aucun livre trouvé</center><h4>";
    } else {
        foreach ($result as $key =>$value) {
            echo "<center></br></br>";
            echo "<table border = 1 style=width:500px;text-align:center;>";
            echo "<tr style=background-color:gainsboro> <td>Nom Auteur</td>  <td>Titre</td>  <td>Date Publication</td>  <td>Edition</td></tr>";
            echo "<tr> <td>" . $value->nomAuteur(). "</td>  <td>" . $value->titre() . "</td>  <td>" . $value->anneePublication() . "</td>  <td>". $value->edition() . "</td></tr>";
            echo "</table>";
            echo '<form action="Livre.php" method="POST" style="margin-top: 20px;">';
            echo '<input type="hidden" name="idLivre" value="' . $value->idLivre() . '">';
            echo '<input type="submit" name="Afficher" value="Afficher" style="width: 200px;"> ';
            echo '</form>';
            echo "<hr/>";
            echo "</center>";
        }
    }
}

//Affihcer le livre selectionné
function livreSelectionne()
{
    $db = connexion();
    $LivreManager = new LivreManager($db);
    $result = $LivreManager->afficherLivre($_POST["idLivre"]);
    if ($result == null) {
        echo "<center><br/><br/><br/><h4>Veuillez récommencer</center><h4>";
    } else {
        //Boucle mais $result ne contient qu'un element
        foreach ($result as $key =>$value) {
            echo"<Center>
                <h1>
                    <U>
                    ". $value->titre() . "
            </U>
                </h1>
                </center>";
            $form = "";
            $form ='<div style="width: 1000px; margin-top: 100px;">

                <div style="width: 500px;float: left;">
                    <img style="width: 300px; height:500px" src = "../Images/' . $value->image() . '" alt="' . $value->image() . '" /> 
                </div>

                <div style="width: 500px;float: right;">
                    <table style=" height:500px">
                        <tr> <td style="text-align: right;"> Nom Auteur:</td>  <td>'  . $value->nomAuteur() . '</td> </tr>
                        <tr> <td style="text-align: right;"> Titre:</td>  <td> ' . $value->titre() . '</td> </tr>
                        <tr> <td style="text-align: right;"> Date Publication:</td>  <td> ' . $value->anneePublication() . '</td> </tr>
                        <tr> <td style="text-align: right;"> Edition:</td>  <td>' . $value->edition() . '</td> </tr>
                        <tr> <td style="text-align: right;"> Prix:</td>  <td>' . $value->prix() . ' CAD</td> </tr>
                    </table>

                    <form action="AchatLivre.php" method="POST" style="margin-top: 20px;">
                    <input type="hidden" name="idLivre" value="' . $value->idLivre() . '">
                    <input type="hidden" name="titre" value="' . $value->titre() . '">
                    <input type="hidden" name="prix" value="' . $value->prix() . '">
                    <input type="submit" style="width: 400px"  name="ajoutPanier" value="Ajouter au Panier"/>
                    </form>
                </div>

            </div>';
            echo $form;
        }
    }
}


//Création du panier si pas crééé
function creationPanier()
{
    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier']=array();
        $_SESSION['panier']['idLivre'] = array();
        $_SESSION['panier']['titre'] = array();
        $_SESSION['panier']['prixLivre'] = array();
    }
    return true;
}
    

//Ajout livre dans panier
function ajouterLivrePanier($idLivre,$titre, $prixLivre)
{
    //Si le panier existe
    if (creationPanier()) {
        array_push($_SESSION['panier']['idLivre'], $idLivre);
        array_push($_SESSION['panier']['titre'], $titre);
        array_push($_SESSION['panier']['prixLivre'], $prixLivre);
    } else {
        echo "Un problème est survenu veuillez réessayer";
    }
}

//Montant total du panier avec taxes
function MontantGlobal()
{
    $total=0;
    for ($i = 0; $i < count($_SESSION['panier']['idLivre']); $i++) {
        $total = $total + floatval($_SESSION['panier']['prixLivre'][$i]);
        $total = $total + ($total * 15 / 100);
    }
    return $total;
}

//Affichage du contenu du panier
function afficherPanier()
{
    $count=count($_SESSION['panier']['idLivre']);
    echo("<center>");
    echo("<table border style='text-align: center;'>");
    echo("<tr><td colspan=4>Panier d'achat</td></tr>");
    echo("<tr> <td> Titre du Livre</td>  <td>Prix d'achat</td> </tr>");

    for ($i=0; $i <$count ; $i++) {
        echo "<tr><td>".$_SESSION['panier']['titre'][$i] . " </td><td>".$_SESSION['panier']['prixLivre'][$i]."$</td><td>
      <a href=traitement.php?indice=".$i."><input type=submit name=supprimer value=supprimer /></a> 

      </td></tr>";
        $_SESSION['idLivre'] = $_SESSION['panier']['idLivre'][$i];
    }
    echo("<tr><td> Total(Incluant taxes)</td><td> " . MontantGlobal() . "$ </td></tr>");
    echo("<tr><td colspan=2> <form action ='achat.php' method='POST'>  <input style='width:100%' type=submit name=valider value='Valider'/> </form> </td></tr>");
    echo("<tr><td colspan=2> <a href=Recherche.php> Retour vers Recherche</a></td></tr>");
    echo("</table>");
    echo("</center>");
}