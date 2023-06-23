<?php

require_once('../dto/CompteDto.php');
require_once('DtoMapperOperation.php');

class DtoMapperCompte
{
   static public function compteEntityToCompteDtoWithOperations($compteEntity)
   {
    $compteDto = new CompteDto();
    $compteDto->setNumero($compteEntity->getNumber());
    $compteDto->setTypeCompte($compteEntity->getType());
    $compteDto->setSolde($compteEntity->getSolde());
    if($compteEntity instanceof CompteCourant) {
        $compteDto->setTypeCompte("Courant");
        $compteDto->setDecouvert($compteEntity->getDecouvert());

    } else if ($compteEntity instanceof CompteEpargne) {
        $compteDto->setTypeCompte("Epargne");
        $compteDto->setTauxInteret($compteEntity->getTauxInteret());
    }
    $compteDto->setOperationDto(DtoMapperOperation::operationEntityListToOperationDtoList($compteEntity->getOperations()));
    return $compteDto;
}

    static public function compteEntityListToCompteDtoListWithOperations($compteEntityList)
    {
        $compteDtoList = array();
        foreach ($compteEntityList as $compteEntity) {
            array_push($compteDtoList, self::compteEntityToCompteDtoWithOperations($compteEntity));
        }
        return $compteDtoList;
    }

   
}