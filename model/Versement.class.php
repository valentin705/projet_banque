<?php

require_once('Operation.class.php');
class Versement extends Operation
{


    public function __construct($date,$description, $montant)
    {
        parent::__construct($date,$description, $montant);
 
    }


    public function getType()
    {
        return "Versement";
    }

}