<?php

require_once('Operation.class.php');
class Retrait extends Operation
{
    
    protected $retrait;

    public function __construct($date,$description, $montant)
    {
        parent::__construct($date,$description, $montant);


    }

    public function getType()
    {
        return "Retrait";
    }

}