
<?php
class Utilisateur_simple extends Utilisateur
{
    public function __construct(array $donnees)
    {
        parent::hydrate($donnees);
    }
}
