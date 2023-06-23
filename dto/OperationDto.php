<?php

class OperationDto {

    public $description;
    public $date;
    public $montant;
    public $typeOperation;

    public function __construct() {
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

    public function getTypeOperation() {
        return $this->typeOperation;
    }

    public function setTypeOperation($typeOperation) {
        $this->typeOperation = $typeOperation;
    }




}

?>