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

                    <form action="Login.php" method="POST" style="margin-top: 20px;">
                    <input type="submit" style="width: 400px"  name="ajoutPanier" value="Ajouter au Panier"/>
                    </form>
                </div>

            </div>';
            echo $form;
        }
    }
}

// function Annonces()
// {
//     //fin de la fonction connexion
//     $db = connexion();
//     $AnnonceManager = new AnnonceManager($db);
//     $results=$AnnonceManager->afficherAdminAnnonces();
//     echo "</br></br></br>";
//     foreach ($results as $key =>$value) {
//         echo "<center></br></br>";
//         echo "<table border = 1 style=width:500px;text-align:center;>";
//         echo "<tr style=background-color:gainsboro> <td>Description</td>  <td>Date</td>  <td>Auteur</td></tr>";
//         echo "<tr> <td>" . $value->description(). "</td>  <td>" . $value->date(). "</td>  <td>" . $value->auteur(). "</td>  <td>" .  "</tr>";
//         echo "</table>";
//         echo "<hr/>";
//         echo "</center>";
//     }
// }

// function AnnoncesPrive()
// {
//     $db = connexion();
//     $AnnonceManager = new AnnonceManager($db);
//     $results=$AnnonceManager->afficherAnnoncesPrivees();
//     echo "</br></br></br>";
//     foreach ($results as $key =>$value) {
//         echo "<center></br></br>";
//         echo "<table border = 1 style=width:500px;text-align:center;>";
//         echo "<tr style=background-color:gainsboro> <td>Description</td>  <td>Date</td>  <td>Auteur</td></tr>";
//         echo "<tr> <td>" . $value->description(). "</td>  <td>" . $value->date(). "</td>  <td>" . $value->auteur(). "</td></tr>";
//         echo "</table>";
//         echo "<hr/>";
//         echo "</center>";
//     }
// }



// function LoginAmin()
// {
//     if (isset($_POST["ConnectionAdmin"])) {
//         if (empty($_POST['login']) or empty($_POST['password'])) {
//             echo"<center>Veuillez remplir tous les champs SVP</center>";
//         } else {
//             $db = connexion();
//             $Utilisateur=new Admin(array("login"=>$_POST['login'],"password"=> $_POST['password']));
//             $UtilisateurManager = new UtilisateurManager($db);
//             $results=$UtilisateurManager->loginAdmin($Utilisateur);
    
//             //test de contenu
//             if ($results!== false) {
//                 session_start();
//                 $_SESSION['connexion'] = true;
//                 $_SESSION['nom'] = $_POST['login'];
//                 header("Location:AccueilAdmin.php");
//             // echo $_SESSION['nom'];
//             } else {
//                 echo"<center>Veuillez vous enregistrer</center>";
//             }
//         }
//     }
// }



// function rechercheID($login)
// {
//     $user = "root";
//     $pwd = "";
//     $host = "localhost";
//     $bdd = "TP1";
//     $link = mysqli_connect($host, $user, $pwd, $bdd) or die("Erreur de connexion au serveur!");
//     $query = "SELECT * FROM Utilisateur Where login='" . $login . "';";
//     $resultat = mysqli_query($link, $query) or die("Erreur dans la requête.");
//     $Utilisateur = $resultat->fetch_assoc();

//     $id = $Utilisateur["id"];
//     return $id;
// }

// function publierAnnoncePublique()
// {
//     if (isset($_POST["publier"])) {
//         if (empty($_POST['description']) or empty($_POST['date'])) {
//             echo"<center>Veuillez remplir tous les champs SVP</center>";
//         } else {
//             $db = connexion();
//             $annonce=new Annonce_publique(array("description"=>$_POST['description'], "date"=>$_POST['date'], "auteur"=>$_SESSION["nom"] ));
//             $AnnonceManager = new AnnonceManager($db);
//             $AnnonceManager->creerAnnoncePublique($annonce);
//             echo "<center>Annonce publiée</center>";
//         }
//     }
// }

// function publierAnnoncePrive()
// {
//     if (isset($_POST["publierPrive"])) {
//         if (empty($_POST['description']) or empty($_POST['date']) or empty($_POST['login'])) {
//             echo"<center>Veuillez remplir tous les champs SVP</center>";
//         } else {
//             $db = connexion();
//             $annonce=new Annonce_prive(array("description"=>$_POST['description'], "date"=>$_POST['date'], "auteur"=>$_SESSION["nom"] ));
//             $AnnonceManager = new AnnonceManager($db);
//             $AnnonceManager->creerAnnoncePrivee($annonce);
//             echo "<center>Annonce publiée</center>";
//         }
//     }
// }

// function RechercheUser()
// {
//     if (isset($_POST["rechercheUser"])) {
//         if (empty($_POST['login'])) {
//             echo"<center>Veuillez remplir le champs de login SVP</center>";
//         } else {
//             $db = connexion();
//             $UtilisateurManager = new UtilisateurManager($db);
//             $results=$UtilisateurManager->rechercheUser($_POST["login"]);
//             echo "</br></br></br>";
//             foreach ($results as $key =>$value) {
//                 $Form = "";
//                 $Form .='<form action="adminUtilisateur.php" method="POST">';
//                 $Form .='<table>';
//                 $Form .='<tr>';
//                 $Form .='<td style="text-align: right;"><strong>Nom:</strong></td>';
//                 $Form .='<td style="text-align: left;">';
//                 $Form .='<input type="text" name="nom" value="' . $value->nom(). '" />';
//                 $Form .='</td>';
//                 $Form .='</tr>';
//                 $Form .='<tr>';
//                 $Form .='<td style="text-align: right;"><strong>Prenom:</strong></td>';
//                 $Form .='<td style="text-align: left;">';
//                 $Form .='<input type="text" name="prenom" value="' . $value->prenom(). '" />';
//                 $Form .='</td>';
//                 $Form .='</tr>';
//                 $Form .='<tr>';
//                 $Form .='<td style="text-align: right;"><strong>Âge:</strong></td>';
//                 $Form .='<td style="text-align: left;">';
//                 $Form .='<input type="text" name="age" value="' . $value->age(). '" />';
//                 $Form .='</td>';
//                 $Form .='</tr>';
//                 $Form .='<tr>';
//                 $Form .='<td style="text-align: center;">';
//                 $Form .='</br><input type="submit" name="modifierUser" value="Modifier"></td>';
//                 $Form .='<td style="text-align: center;">';
//                 $Form .='</br><input type="submit" name="supUser" value="Suprimer"></td>';
//                 $Form .='</tr>';
//                 $Form .='</table>';
//                 $Form .='</form>';
//                 echo $Form;
//                 $_SESSION["loginModife"] = $value->login() ;
//             }
//         }
//     }
// }

// function ModifierUser()
// {
//     if (isset($_POST["modifierUser"])) {
//         if (empty($_POST['prenom'])  or empty($_POST['nom']) or empty($_POST['age'])) {
//             echo"<center>Veuillez remplir les champs SVP</center>";
//         } else {
//             $db = connexion();
//             $Utilisateur=new Utilisateur_simple(array("nom"=>$_POST['nom'], "prenom"=>$_POST['prenom'], "age"=>$_POST['age'] ));
//             $UtilisateurManager = new UtilisateurManager($db);
//             $UtilisateurManager->modifierUser($Utilisateur);
//             echo "<center>Modification réussie</center>";
//         }
//     }
// }

// function SuprimerUser()
// {
//     if (isset($_POST["supUser"])) {
//         $db = connexion();
//         $UtilisateurManager = new UtilisateurManager($db);
//         $UtilisateurManager->suprimerUser();
//         echo "<center>Suppression réussie</center>";
//     }
// }

// function afficherAnnoncesAdmin()
// {
//     $db = connexion();
//     $AnnonceManager = new AnnonceManager($db);
//     $results=$AnnonceManager->afficherAnnonces();
//     echo "</br></br></br>";
//     foreach ($results as $key =>$value) {
//         $Form = "";
//         $Form .='<form action= "'.$_SERVER['PHP_SELF'].'" method="POST">';
//         $Form .='<table>';
//         $Form .='<tr>';
//         $Form .='<td style="text-align: right;"><strong>Description:</strong></td>';
//         $Form .='<td style="text-align: left;">';
//         $Form .='<textarea style="height: 100px;" name="description"/> ' . $value->description(). '</textarea> ';
//         $Form .='</td>';
//         $Form .='</tr>';
//         $Form .='<tr>';
//         $Form .='<td style="text-align: right;"><strong>Date:</strong></td>';
//         $Form .='<td style="text-align: left;">';
//         $Form .='<input type="text" name="date" value="' . $value->date(). '" />';
//         $Form .='</td>';
//         $Form .='</tr>';
//         $Form .='<tr>';
//         $Form .='<td style="text-align: right;"><strong>Auter:</strong></td>';
//         $Form .='<td style="text-align: left;">';
//         $Form .='<input type="text" name="auteur" value="' . $value->auteur(). '" />';
//         $Form .='</td>';
//         $Form .='</tr>';
//         $Form .='<tr>';
//         $Form .='<td style="text-align: center;">';
//         $Form .='</br><input type="submit" name="modifierAnnonce" value="Modifier"></td>';
//         $Form .='<td style="text-align: center;">';
//         $Form .='</br><input type="submit" name="supAnnonce" value="Suprimer"></td>';
//         $Form .='<td style="text-align: center;">';
//         $Form .='</br><input type="hidden" name="id" value="' . $value->id(). '"></td>';
//         $Form .='</tr>';
//         $Form .='</table>';
//         $Form .='</form>';
//         $Form .='<hr></br></br></br>';
//         echo $Form;
//     }
// }

// function ModifierAnnonce()
// {
//     if (isset($_POST["modifierAnnonce"])) {
//         echo "okay";
//         if (empty($_POST['description'])  or empty($_POST['date']) or empty($_POST['auteur'])) {
//             echo"<center>Veuillez remplir les champs SVP</center>";
//         } else {
//             $db = connexion();
//             $annonce=new Annonce_publique(array("description"=>$_POST['description'], "date"=>$_POST['date'], "auteur"=>$_POST['auteur'], "id"=>$_POST['id'] ));
//             $AnnonceManager = new AnnonceManager($db);
//             $AnnonceManager->modifierAnnonce($annonce);
//             echo "<center>Modification réussie</center>";?>
<!-- //             <script type='text/javascript'> -->
<!-- //                 window.location.href = 'adminAnnonce.php' -->
<!-- //             </script> -->
             <?php
//         }
//     }
// }

// function SuprimerAnnonce()
// {
//     if (isset($_POST["supAnnonce"])) {
//         $db = connexion();
//         $AnnonceManager = new AnnonceManager($db);
//         $AnnonceManager->suprimerAnnonce();
//         echo "<center>Suppression réussie</center>";?>
<!-- //         <script type='text/javascript'> -->
<!-- //             window.location.href = 'adminAnnonce.php' -->
<!-- //         </script> -->
         <?php
//     }
// }
// function SelectionDestinataire()
// {
//     $db = connexion();
//     $UtilisateurManager = new UtilisateurManager($db);
//     $results=$UtilisateurManager->afficherDestinataires();
//     echo '<select name="login">';
//     foreach ($results as $key =>$value) {
//         echo '<option value=' . $value->login() . '>' . $value->login() . '</option>';
//     }
//     echo '</select>';
// }

// function dateToday()
// {
//     $date = date('Y-m-d');
//     echo $date;
// }
