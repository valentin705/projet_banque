<?php

require_once('../dao/CompteDao.php');
require_once('../dao/OperationDao.php');
require_once('../dao/AbstractDao.php');
require_once('AbstractService.php');
require_once('OperationService.php');

class CompteService extends AbstracService
{

    private $compteDao;

    private $operationDao;

    public function __construct()
    {
        parent::__construct();
        $this->compteDao = new CompteDao();
        $this->operationDao = new OperationDao();
    }

    // méthode qui permet de récupérer la liste des comptes
    public function getAllComptes()
    {
        return $this->compteDao->getAllComptes();
    }

    // méthode qui permet de créer un compte
    public function createCompte($numero, $solde, $decouvert, $tauxInteret)
    {

        if (isset($decouvert)) {
            $this->compteDao->createCompteCourant($numero, $solde, $decouvert);
        } else {
            $this->compteDao->createCompteEpargne($numero, $solde, $tauxInteret);
        }

        $this->operationDao->addOperation('Virement initiale', $solde, $numero, 2);
    }
    
    // méthode qui d'obtenir le nombre d'operation
    public function getOperationsByNumber($number)
    {
        return $this->operationDao->getOperationsByNumber($number);
    }

    // méthode qui permet d'obtenir toutes les operations d'un compte
    public function getAllOperations($number)
    {
        return $this->operationDao->getAllOperations($number);
    }


    // méthode qui permet de consulter un compte 
    public function getConsulCompteOpByNumber($number)
    {
        $this->getPdo()->beginTransaction();

        try {
        $compte =  $this->compteDao->searchCompte($number);
        $nbOperation = $this->operationDao->getOperationsByNumber($number);
        $allOperation = $this->operationDao->getAllOperations($number);
        $this->getPdo()->commit();
         return array($compte, $nbOperation, $allOperation);
        } catch (Exception $e) {
            $this->getPdo()->rollBack();
            throw $e;
        }
}

    public function getCompteByNumber($number)
    {
        return $this->compteDao->searchCompte($number);
    }


    //-----------------------------------------TEST--------------------------------------------

    // public function getCompteWhitOperation($number)
    // {
    //     return $this->compteDao->getCompteWhitOperation($number);
    // }


public function getAllCompteWhitOperation()
{
    return $this->compteDao->getAllCompteWhitOperation();
}

public function getOneCompteWithOperations($number)
{
    return $this->compteDao->getOneCompteWithOperations($number);

}

}
