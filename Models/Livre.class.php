
<?php
class Livre
{
    private $_nomAuteur;
    private $_titre;
    private $_anneePublication;
    private $_edition;
    private $_id;
    private $_image;
    private $_prix;


    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }
    //definition des getters

    public function nomAuteur()
    {
        return $this->_nomAuteur;
    }
    public function titre()
    {
        return $this->_titre;
    }
    public function anneePublication()
    {
        return $this->_anneePublication;
    }
    public function edition()
    {
        return $this->_edition;
    }
    public function idLivre()
    {
        return $this->_id;
    }
    public function image()
    {
        return $this->_image;
    }
    public function prix()
    {
        return $this->_prix;
    }


    //definition des setters
    public function setNomAuteur($nomAuteur)
    {
        $this->_nomAuteur = $nomAuteur;
    }
    public function setTitre($titre)
    {
        $this->_titre = $titre;
    }
    public function setAnneePublication($anneePublication)
    {
        $this->_anneePublication = $anneePublication;
    }
    public function setEdition($edition)
    {
        $this->_edition = $edition;
    }
    public function setIdLivre($id)
    {
        $this->_id = $id;
    }
    public function setImage($image)
    {
        $this->_image = $image;
    }
    public function setPrix($prix)
    {
        $this->_prix = $prix;
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
