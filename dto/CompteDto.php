<?php

class CompteDto {
    public $numero;
    public $typeCompte;
    public $solde;
    public $decouvert;
    public $tauxInteret;

    public $nbOperation;

    public $operationDto;


public function __construct() {
    $this->operationDto = array();
}

public function getNumero() {
    return $this->numero;
}

public function setNumero($numero) {
    $this->numero = $numero;
}

public function getTypeCompte() {
    return $this->typeCompte;
}

public function setTypeCompte($typeCompte) {
    $this->typeCompte = $typeCompte;
}

public function getSolde() {
    return $this->solde;
}

public function setSolde($solde) {
    $this->solde = $solde;
}

public function getDecouvert() {
    return $this->decouvert;
}

public function setDecouvert($decouvert) {
    $this->decouvert = $decouvert;
}

public function getTauxInteret() {
    return $this->tauxInteret;
}

public function setTauxInteret($tauxInteret) {
    $this->tauxInteret = $tauxInteret;
}

public function getNbOperation() {
    return $this->nbOperation;
}

public function setNbOperation($nbOperation) {
    $this->nbOperation = $nbOperation;
}

public function getOperationDto() {
    return $this->operationDto;   
}

public function setOperationDto($operationDto) {
    $this->operationDto = $operationDto;
}

}
