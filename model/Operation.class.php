<?php

abstract class Operation {
    protected $id;
    protected static $count = 0;

    protected $description;
    protected $date;
    protected $montant;


    public function __construct($date,$montant,$description) {
        $this->id = ++self::$count;
        $this->description = $description;
        $this->date = $date;
        $this->montant = $montant;
    }

    abstract public function getType();

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function getMontant() {
        return $this->montant;
    }

    public function setMontant($montant) {
        $this->montant = $montant;
    }








}