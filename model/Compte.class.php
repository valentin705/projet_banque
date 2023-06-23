<?php

require_once 'Versement.class.php';
abstract class Compte
{
    protected $id;
    protected static $count = 0;
    protected $number;
    protected $date;
    protected $solde;
    protected $operations;

    public function __construct($number, $date, $solde)
    {
        $this->id = ++self::$count;
        $this->number = $number;
        $this->date = $date;
        $this->solde = $solde;
        $this->operations = array();
    }

    public function addOperation($operation)
    {
        array_push($this->operations, $operation);
    }

    public function getOperations()
    {
        return $this->operations;
    }

    public function setOperations($operations)
    {
        $this->operations = $operations;
    }
    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function setNumber($number)
    {
        $this->number = $number;
    }

    public function getSolde()
    {
        return $this->solde;
    }

    public function setSolde($solde)
    {
        $this->solde = $solde;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    abstract public function getType();

}

?>