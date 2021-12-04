
<?php
class UtilisateurManager
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


    public function inscription(Utilisateur_simple $utilisateur)
    {
        $nom = $utilisateur->nom();
        $prenom =$utilisateur->prenom() ;
        $age = $utilisateur->age();
        $login =$utilisateur->login() ;
        $pass = $utilisateur->password();
        $ins=$this->_db;
        $query = $ins->prepare("INSERT into Utilisateur (nom, prenom, age, login, password) VALUES ('$nom', '$prenom', '$age', '$login', '$pass')");
        $query->execute() or die("<center>Erreur dans la requête</center>");
    }

    public function login(Utilisateur_simple $utilisateur)
    {
        $login=$utilisateur->login();
        $password=$utilisateur->password();
        $req=$this->_db->query("SELECT * FROM Utilisateur WHERE login='".$login."' AND password='".$password."'");
        $data=$req->fetch(PDO::FETCH_ASSOC);
        if ($data != null) {
            $objet = new Utilisateur($data);
            return $objet;
        } else {
            return false;
        }
    }



    // public function loginAdmin(Admin $utilisateur)
    // {
    //     $login=$utilisateur->login();
    //     $password=$utilisateur->password();
    //     $req=$this->_db->query("SELECT * FROM Administrateur WHERE login='".$login."' AND password='".$password."'");
    //     $data=$req->fetch(PDO::FETCH_ASSOC);
    //     if ($data != null) {
    //         $objet = new Utilisateur($data);
    //         return $objet;
    //     } else {
    //         return false;
    //     }
    // }


    public function rechercheUser($login)
    {
        $req=$this->_db->query("SELECT * FROM Utilisateur WHERE login = '$login' ");
        $utilisateur= array();
        while ($data=$req->fetch(PDO::FETCH_ASSOC)) {
            $utilisateur[] = new Utilisateur_simple($data);
        }
        return $utilisateur;
    }


    public function modifierUser(Utilisateur_simple $utilisateur)
    {
        $nom = $utilisateur->nom();
        $prenom =$utilisateur->prenom() ;
        $age = $utilisateur->age();
        $login = $_SESSION["loginModife"];
        $ins=$this->_db;
        $query = $ins->prepare("UPDATE `Utilisateur` SET `nom`='$nom', `prenom`='$prenom', `age`='$age' WHERE `Utilisateur`.`login` = '$login'");
        $query->execute() or die("<center>Erreur dans la requête</center>");
    }


    public function suprimerUser()
    {
        $login = $_SESSION["loginModife"];
        $ins=$this->_db;
        $query = $ins->prepare("DELETE FROM `Utilisateur` WHERE `Utilisateur`.`login` = '$login'");
        $query->execute() or die("<center>Erreur dans la requête</center>");
    }

    public function afficherDestinataires()
    {
        $req=$this->_db->query("SELECT * FROM Utilisateur");
        $utilisateur= array();
        while ($data=$req->fetch(PDO::FETCH_ASSOC)) {
            $utilisateur[] = new Utilisateur_simple($data);
        }
        return $utilisateur;
    }
}
