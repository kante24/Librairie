
<?php
class Utilisateur
{
    private $_nom;
    private $_prenom;
    private $_age;
    private $_login;
    private $_password;


    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }
    //definition des getters

    public function nom()
    {
        return $this->_nom;
    }
    public function prenom()
    {
        return $this->_prenom;
    }
    public function age()
    {
        return $this->_age;
    }
    public function login()
    {
        return $this->_login;
    }
    public function password()
    {
        return $this->_password;
    }


    //definition des setters
    public function setNom($nom)
    {
        $this->_nom = $nom;
    }
    public function setPrenom($prenom)
    {
        $this->_prenom = $prenom;
    }
    public function setAge($age)
    {
        $this->_age = $age;
    }
    public function setLogin($login)
    {
        $this->_login = $login;
    }

    public function setPassword($pss)
    {
        $this->_password = $pss;
    }


    public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value) {
            $method = 'set'.ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }
}
