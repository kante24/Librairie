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

    public function rechercheLivreAchat($idMembre)
    {
        $user = "root";
        $pwd = "";
        $host = "localhost";
        $bdd = "Librairie";
        $link = mysqli_connect($host, $user, $pwd, $bdd) or die("Erreur de connexion au serveur!");
        $query = "SELECT * FROM Achat Where idMembre ='" . $idMembre . "';";
        $resultat = mysqli_query($link, $query) or die("Erreur dans la requête.");
        while ($Achat=$resultat->fetch_assoc()) {
            $idLivre = $Achat["idLivre"];
            return afficherLivre($idLivre);
        }
    }
}