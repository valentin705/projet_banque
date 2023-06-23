<?php

require_once '../service/CompteService.php';
require_once('../service/OperationService.php');
require_once('../dtomapper/DtoMapperCompte.php');

class CompteController 

{

    private $compteService;
    private $operationService;

    public function __construct() {
        $this->compteService = new CompteService();
        $this->operationService = new OperationService();
    }

    // function pour afficher la liste des comptes sur la page index.html
    public function getAllComptes() {
        return $this->compteService->getAllComptes();
        
    }

      // function pour obtenir le nombre d'operation sur la page index.html
    public function getOperationsByNumber($number) {
        return $this->compteService->getOperationsByNumber($number);
    }

    // function pour créer un compte sur la page addAccount.html
    public function createCompte($numero, $solde, $typeCompte, $decouvertOuInteret) {
            if ($typeCompte == 'courant') {
                $decouvert = $decouvertOuInteret;
                $this->compteService->createCompte($numero, $solde, $decouvert, null);
            } else {
                $tauxInteret = $decouvertOuInteret;
                $this->compteService->createCompte($numero, $solde, null, $tauxInteret);
            }
    }
  
    // function pour les operations de la page operationCompte.html
    public function versement($description, $numeroCompte, $montant)
    {
        return $this->operationService->versement($description, $numeroCompte, $montant);
    }
    public function retrait($description, $numeroCompte, $montant)
    {
        return $this->operationService->retrait($description, $numeroCompte, $montant);
    }

    // function pour afficher un compte et les operations de la page consultCompte.html 
    // et la page consultCompteDirectBtn.html
  public function getOneCompteWithOperations($number) {
       $compte = $this->compteService->getOneCompteWithOperations($number);
       $compteDto = DtoMapperCompte::compteEntityListToCompteDtoListWithOperations($compte);
       return $compteDto;
   }

   ////////////// Function que je n'utilise pas mais qui peuvent servir //////////////

    // public function getConsulCompteOpByNumber($number) {
    //     return $this->compteService->getConsulCompteOpByNumber($number);
    // }

    // public function getCompteByNumber($number) {
    //     return $this->compteService->getCompteByNumber($number);
    // }

    // public function getAllOperations($number) {
    //     return $this->compteService->getAllOperations($number);
    // }

//    public function getCompteWhitOperation($number) {
//        return $this->compteService->getCompteWhitOperation($number);
//    }

//    public function getAllCompteWhitOperation() {
//        $compteList = $this->compteService->getAllCompteWhitOperation();
//        $compteDtoList = DtoMapperCompte::compteEntityListToCompteDtoListWithOperations($compteList);
//     return $compteDtoList;
       
//    }

//    function deleteSession(){
//     session_destroy();
//    }

}

?>