<?php
class LivreManager
{
    //retour de l'objet de connection pdo
    private $_db;

    public function __construct($db)
    {
        $this->setDb($db);
    }

    public function db()
    {
        $this->_db;
    }

    public function setDb($db)
    {
        return $this->_db = $db;
    }


    public function Livres()
    {
        $req=$this->_db->query("SELECT * FROM Livre");
        $Livres= array();
        while ($data=$req->fetch(PDO::FETCH_ASSOC)) {
            $Livres[] = new Livre($data);
        }
        return $Livres;
    }

    public function afficherLivre($livre)
    {
        $req=$this->_db->query("SELECT * FROM livre WHERE (titre = '$livre' or edition = '$livre' or idLivre = '$livre' or nomAuteur = '$livre') ");
        $Livre= array();
        while ($data=$req->fetch(PDO::FETCH_ASSOC)) {
            $Livre[] = new Livre($data);
        }
        return $Livre;
    }
//     public function creerAnnoncePublique(Annonce_publique $annonces)
//     {
//         $date = $annonces->date();
//         $description =$annonces->description() ;
//         $auteur = $annonces->auteur();
//         $ins=$this->_db;
//         $query = $ins->prepare("INSERT INTO `Annonce_publique`(`description`, `date`, `auteur`) VALUES ('$description', '$date', '$auteur') ");
//         $query->execute() or die("<center>Erreur dans la requête</center>");
//     }
//     public function creerAnnoncePrivee(Annonce_prive $annonces)
//     {
//         $date = $annonces->date();
//         $description =$annonces->description() ;
//         $auteur = $annonces->auteur();
//         $id = rechercheID($_POST["login"]);
//         $ins=$this->_db;
//         $query = $ins->prepare("INSERT INTO `Annonce_prive`(`description`, `date`, `auteur`, `destinataire`) VALUES ('$description','$date','$auteur', $id) ");
//         $query->execute() or die("<center>Erreur dans la requête</center>");
//     }

//     public function afficherAnnoncesPrivees()
//     {
//         $req=$this->_db->query("SELECT Utilisateur.id, Utilisateur.login,Annonce_prive.description,Annonce_prive.date, Annonce_prive.auteur, Annonce_prive.destinataire FROM(Utilisateur INNER JOIN Annonce_prive ON Utilisateur.id = Annonce_prive.destinataire) WHERE Annonce_prive.destinataire = " . rechercheID($_SESSION["nom"]));
//         $annonces= array();
//         while ($data=$req->fetch(PDO::FETCH_ASSOC)) {
//             $annonces[] = new Annonce_prive($data);
//         }
//         return $annonces;
//     }

//     public function afficherAdminAnnonces()
//     {
//         $req=$this->_db->query("SELECT * FROM (Annonce_publique INNER JOIN Annonce_prive ON Annonce_publique.id = Annonce_prive.id) ") ;
//         $annonces= array();
//         while ($data=$req->fetch(PDO::FETCH_ASSOC)) {
//             $annonces[] = new Annonce_publique($data);
//         }
//         return $annonces;
//     }


//     public function modifierAnnonce(Annonce_publique $annonce)
//     {
//         $description = $annonce->description();
//         $date =$annonce->date() ;
//         $auteur = $annonce->auteur();
//         $id = $annonce->id();
//         $ins=$this->_db;
//         $query = $ins->prepare("UPDATE `Annonce_publique` SET `description`='$description',`date`='$date',`auteur`='$auteur' WHERE `Annonce_publique`.`id` = '$id'");
//         $query->execute() or die("<center>Erreur dans la requête</center>");
//     }


//     public function suprimerAnnonce()
//     {
//         $id = $_POST["id"];
//         $ins=$this->_db;
//         $query = $ins->prepare("DELETE FROM `Annonce_publique` WHERE `Annonce_publique`.`id` = '$id'");
//         $query->execute() or die("<center>Erreur dans la requête</center>");
//     }
}
