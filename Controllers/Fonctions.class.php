<?php

//Require
{
    require("../Controllers/UtilisateurManager.class.php");
    require("../Controllers/LivreManager.class.php");
    require("../Models/Utilisateur.class.php");
    require("../Models/Utilisateur_simple.class.php");
    require("../Models/Livre.class.php");
}


{
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
}



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

//date Aujourd'hui
function dateToday()
{
    $date = date('Y-m-d');
    return $date;
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

//Fonction connection avec nom utilisateur et mot de passe
function Admin()
{
    if (isset($_POST["Admin"])) {
        if (empty($_POST['login']) or empty($_POST['password'])) {
            echo"<center>Veuillez remplir tous les champs SVP</center>";
        } else {
            $db = connexion();
            $Utilisateur=new Utilisateur_simple(array("login"=>$_POST['login'],"password"=> $_POST['password']));
            $UtilisateurManager = new UtilisateurManager($db);
            $results=$UtilisateurManager->loginAdmin($Utilisateur);
    
            //test de contenu
            if ($results!== false) {
                session_start();
                $_SESSION['connection'] = true;
                $_SESSION['admin'] = $_POST['login'];
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

//Recherche d'un membre à partir de son login
function rechercheID($login)
{
    $user = "root";
    $pwd = "";
    $host = "localhost";
    $bdd = "Librairie";
    $link = mysqli_connect($host, $user, $pwd, $bdd) or die("Erreur de connexion au serveur!");
    $query = "SELECT * FROM Utilisateur Where login='" . $login . "';";
    $resultat = mysqli_query($link, $query) or die("Erreur dans la requête.");
    $Utilisateur = $resultat->fetch_assoc();

    $id = $Utilisateur["id"];
    return $id;
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
            echo "<a href='../Views/Livre.php?idLivre=". $value->idLivre() . "'><img style='width: 200px; height:200px' src='../Images/" . $value->image() . "'/></a> <br/><br/>" ;
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
            echo "<a href='../Views/Livre.php?idLivre=". $value->idLivre() . "'><img style='width: 200px; height:200px' src='../Images/" . $value->image() . "'/></a> <br/><br/>" ;
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
function livreSelectionne($Livre)
{
    $db = connexion();
    $LivreManager = new LivreManager($db);
    $result = $LivreManager->afficherLivre($Livre);
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
            $form ='<div style="width: 1000px; margin-top: 100px; margin-bottom: 50px ;">

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
                    </form><br/><br/>
                </div>

            </div><br/><br/>';
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
        $_SESSION['panier']['prixLivre'] = array();
    }
    return true;
}
    

//Ajout livre dans panier
function ajouterLivrePanier($idLivre, $titre, $prixLivre)
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
    if (!isset($_SESSION['panier'])) {
        creationPanier();
        afficherPanier();
    } else {
        $count=count($_SESSION['panier']['idLivre']);
        echo("<center>");
        echo("<table border style='text-align: center;width: 500px;'>");
        echo("<tr><td colspan=4>Panier d'achat</td></tr>");
        echo("<tr style=background-color:gainsboro> <td> Titre du Livre</td>  <td colspan=2>Prix d'achat</td> </tr>");

        for ($i=0; $i <$count ; $i++) {
            echo "<tr><td>".$_SESSION['panier']['titre'][$i] . " </td><td>".$_SESSION['panier']['prixLivre'][$i]."CAD</td>
        <td>
            <a href=AchatLivre.php?indice=".$i."><input type=submit name=supprimer value=Supprimer /></a>
        </td></tr>";
            $_SESSION['idLivre'] = $_SESSION['panier']['idLivre'][$i];
        }
        echo("<tr><td> Total(Incluant taxes)</td><td colspan=2> " . MontantGlobal() . " CAD </td></tr>");
        echo("<tr><td colspan=3> <form action ='AchatLivre.php' method='POST'>  <input style='width:100%' type=submit name=valider value='Valider les Livres'/> </form> </td></tr>");
        echo("<tr><td colspan=3> <a href=Recherche.php> Retour vers Recherche</a></td></tr>");
        echo("</table>");
        echo("</center>");
    }
}

//Supprimer livre du panier
function supprimerLivrePanier($idLivre)
{
    //Si le panier existe
    if (creationPanier()) {
        //Nous allons passer par un panier temporaire
        $_SESSION['panier2']=array();
        $_SESSION['panier2']['idLivre'] = array();
        $_SESSION['panier2']['titre'] = array();
        $_SESSION['panier2']['prixLivre'] = array();
 
 
        for ($i = 0; $i < count($_SESSION['panier']['idLivre']); $i++) {
            if ($_SESSION['panier']['idLivre'][$i] !== $idLivre) {
                array_push($_SESSION['panier2']['idLivre'], $_SESSION['panier']['idLivre'][$i]);
                array_push($_SESSION['panier2']['titre'], $_SESSION['panier']['titre'][$i]);
                array_push($_SESSION['panier2']['prixLivre'], $_SESSION['panier']['prixLivre'][$i]);
            }
        }
        //On remplace le panier en session par notre panier temporaire à jour
        $_SESSION['panier'] =  $_SESSION['panier2'];
        //On efface notre panier temporaire
        unset($_SESSION['panier2']);
    //echo 'test';
    } else {
        echo "Un problème est survenu veuillez réessayer";
    }
}


//Proceder au paiment des contenus du panier
function Payer()
{
    $db = connexion();
    $id = rechercheID($_SESSION["nom"]);
    $adresse = $_POST["adresse"];

    $count = count($_SESSION['panier']['idLivre']);
    for ($i = 0; $i < $count; $i++) {
        $idLivre = $_SESSION['panier']['idLivre'][$i];
        $prix = doubleval($_SESSION['panier']['prixLivre'][$i]);
        $date = dateToday();
        // echo "id = " . $id . " idLivre = " . $idLivre . " prix = " . $prix . " date = " . $date . " Adresse = " . $adresse;
        $query = $db->prepare("INSERT into Achat (idMembre, idLivre, prix, dateAchat, adresse) VALUES ($id, $idLivre, $prix, '$date', '$adresse') ");
        $query->execute() or die("<center>Erreur dans la requête</center>");
    }
    $montant = MontantGlobal();
    $d = date("Y-m-d");
    //fin de l'insertion

    $ncomm = $_SESSION['idLivre'];




    echo "<h1>Le numéro de la commande est:  ".$ncomm."</h1>";
    echo("<h2>le montant total de votre commande est :  ".$montant."$</h2></br>");

    $_SESSION['montantTotal'] = $montant;
    
    unset($_SESSION['panier']);
    header("Location: ../Views/facture.php");
}

//Factures des achats effectuées
function facture($id)
{
    $db = connexion();
    $query = $db->prepare("SELECT * FROM Achat Where idMembre  = ' " . $id . " '; ");
    $query->execute() or die("<center>Erreur dans la requête</center>");
    while ($Achat=$query->fetch(PDO::FETCH_ASSOC)) {
        $idLivre = $Achat["idLivre"];
        $LivreManager = new LivreManager($db);
        $result = $LivreManager->afficherLivre($idLivre);
        if ($result == null) {
            echo "<center><br/><br/><br/><h4>Aucun livre trouvé</center><h4>";
        } else {
            foreach ($result as $key =>$value) {
                echo "<center></br></br>";
                echo "<a href='../Views/Livre.php?idLivre=". $value->idLivre() . "'><img style='width: 200px; height:200px' src='../Images/" . $value->image() . "'/></a> <br/><br/>" ;
                echo "<table border = 1 style=width:600px;text-align:center;>";
                echo "<tr style=background-color:gainsboro> <td>Nom Auteur</td>  <td>Titre</td>  <td>Date Publication</td>  <td>Edition</td>  <td>Date Achat</td>  <td>Prix</td>  <td>Adresse Livraison</td></tr>";
                echo "<tr> <td>" . $value->nomAuteur(). "</td>  <td>" . $value->titre() . "</td>  <td>" . $value->anneePublication() . "</td>  <td>". $value->edition() . "</td>  <td>". $Achat["dateAchat"] . "</td>  <td>". $Achat["prix"] .  "</td>  <td>". $Achat["adresse"] . "</td></tr>";
                echo "</table>";
                echo '<form action="Livre.php" method="POST" style="margin-top: 20px; width:200px">';
                echo '<input type="hidden" name="idLivre" value="' . $value->idLivre() . '">';
                echo '<input type="submit" name="Afficher" value="Afficher ce Livre" style="width: 300px;"> ';
                echo '</form>';
                echo "<hr/>";
                echo "</center>";
            }
        }
    }
}

//Affiche les commentaires sur le livre en question
function Commentaires($livre)
{
    $db = connexion();
    $query = $db->prepare("SELECT * FROM Commentaire Where idLivre ='" . $livre . "' ORDER BY date DESC ");
    $query->execute() or die("<center>Erreur dans la requête</center>");
    echo '<div style="margin-top: 50px; width:1000px">
    <table border="1" style="text-align: center;">
    <tr>
    <th>
        Nom Membre
    </th>
    <th>
        Date Commentaire
    </th>
    <th>
        Commentaire
    </th>
    </tr>';
    while ($Commentaire = $query->fetch(PDO::FETCH_ASSOC)) {
        echo '
        <tr>
            <td>'. $Commentaire["loginMembre"] . '</td>
            <td>'. $Commentaire["date"] . '</td>
            <td>'. $Commentaire["commentaire"] . '</td>
        </tr>';
    }
    echo '</table></div>';
}

//Ajouter un commentaire
function Commenter($livre)
{
    $idLivre = $livre;
    $commentaire = $_POST["commentaire"];
    $loginMembre = $_SESSION["nom"];
    $date = dateToday();
    $ins=connexion();
    $query = $ins->prepare("INSERT into Commentaire (loginMembre, idLivre, date, commentaire) VALUES ('$loginMembre', '$idLivre', '$date', '$commentaire')");
    $query->execute() or die("<center>Erreur dans la requête</center>");
    echo '<script>
 	    window.location.replace("../Views/Livre.php?idLivre='. $idLivre .'")
 	</script>';
}


//Afficher infos User dans des text boxs
function RechercheUser()
{
    $db = connexion();
    $UtilisateurManager = new UtilisateurManager($db);
    $results=$UtilisateurManager->rechercheUser($_SESSION["nom"]);
    echo "</br></br></br>";
    foreach ($results as $key =>$value) {
        $Form = "";
        $Form .='<form action="'. $_SERVER["PHP_SELF"] .'" method="POST">';
        $Form .='<table>';
        $Form .='<tr>';
        $Form .='<td style="text-align: right;"><strong>Nom:</strong></td>';
        $Form .='<td style="text-align: left;">';
        $Form .='<input type="text" name="nom" value="' . $value->nom(). '" />';
        $Form .='</td>';
        $Form .='</tr>';
        $Form .='<tr>';
        $Form .='<td style="text-align: right;"><strong>Prenom:</strong></td>';
        $Form .='<td style="text-align: left;">';
        $Form .='<input type="text" name="prenom" value="' . $value->prenom(). '" />';
        $Form .='</td>';
        $Form .='</tr>';
        $Form .='<tr>';
        $Form .='<td style="text-align: right;"><strong>Âge:</strong></td>';
        $Form .='<td style="text-align: left;">';
        $Form .='<input type="text" name="age" value="' . $value->age(). '" />';
        $Form .='</td>';
        $Form .='</tr>';
        $Form .='<tr>';
        $Form .='<td style="text-align: center;">';
        $Form .='</br><input type="submit" name="modifierUser" value="Modifier"></td>';
        $Form .='<td style="text-align: center;">';
        $Form .='</br><input type="submit" name="supUser" value="Suprimer"></td>';
        $Form .='</tr>';
        $Form .='</table>';
        $Form .='</form>';
        echo $Form;
        $_SESSION["loginModife"] = $value->login() ;
    }
}


//Modifier un membre
function ModifierUser()
{
    if (isset($_POST["modifierUser"])) {
        if (empty($_POST['prenom'])  or empty($_POST['nom']) or empty($_POST['age'])) {
            echo"<center>Veuillez remplir les champs SVP</center>";
        } else {
            $db = connexion();
            $Utilisateur=new Utilisateur_simple(array("nom"=>$_POST['nom'], "prenom"=>$_POST['prenom'], "age"=>$_POST['age'] ));
            $UtilisateurManager = new UtilisateurManager($db);
            $UtilisateurManager->modifierUser($Utilisateur);
        }
    }
}


//Supprimer un membre
function SuprimerUser()
{
    if (isset($_POST["supUser"])) {
        $db = connexion();
        $UtilisateurManager = new UtilisateurManager($db);
        $UtilisateurManager->suprimerUser();
        echo "<center>Suppression réussie</center>";
    }
}
