<?php 

require_once('Compte.class.php');
class CompteEpargne extends Compte
{
    protected $tauxInteret;

    public function __construct($number, $date, $solde, $tauxInteret)
    {
        parent::__construct($number, $date, $solde);
        $this->tauxInteret = $tauxInteret;
    }

    public function getType()
    {
        return "Compte Epargne";
    }

    public function getTauxInteret()
    {
        return $this->tauxInteret;
    }

    public function setTauxInteret($tauxInteret)
    {
        $this->tauxInteret = $tauxInteret;
    }


}