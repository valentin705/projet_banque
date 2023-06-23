<?php 

require_once('Compte.class.php');
class CompteCourant extends Compte
{
    protected $decouvert;

    public function __construct($number, $date, $solde, $decouvert)
    {
        parent::__construct($number, $date, $solde);
        $this->decouvert = $decouvert;
    }

    public function getType()
    {
        return "Compte Courant";
    }

    public function getDecouvert()
    {
        return $this->decouvert;
    }

    public function setDecouvert($decouvert)
    {
        $this->decouvert = $decouvert;
    }


}