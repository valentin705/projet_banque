<?php

require_once('../model/Compte.class.php');
require_once('../model/CompteCourant.class.php');
require_once('../model/CompteEpargne.class.php');
require_once('../dto/CompteDto.php');
require_once('../dao/CompteDao.php');
require_once('../dto/CompteConsulDto.php');

class CompteMapper
{

    // methode qui permet de mapper un compte en une entité 
    public static function map($row)
    {
        if ($row['TAC_ID'] == 1) {
            $compte = new CompteCourant(
                $row['ACC_NUMBER'],
                $row['ACC_CREATE_AT'],
                $row['ACC_BALANCE'],
                $row['ACC_OVERDRAFT'],
            );
        } else if ($row['TAC_ID'] == 2) {
            $compte = new CompteEpargne(
                $row['ACC_NUMBER'],
                $row['ACC_CREATE_AT'],
                $row['ACC_BALANCE'],
                $row['ACC_INTEREST_RATE']
            );
        }
        return $compte;
    }

    // methode qui permet de mapper une liste de compte en une liste d'entité

    public static function mapAll($rowsList)
    {
        $comptesListeEntity = array();

        foreach ($rowsList as $rowCompte) {
            array_push($comptesListeEntity, self::map($rowCompte));
        }
        return $comptesListeEntity;
    }

    ////////////////////////////MAPPER-DTO////////////////////////////
    public static function mapToEntity($compteEntity, $nbOperation)
    {
        $compteDto = new CompteDto();
        $compteDto->setNumero($compteEntity->getNumber());
        $compteDto->setSolde($compteEntity->getSolde());
        if ($compteEntity instanceof CompteCourant) {
            $compteDto->setTypeCompte("Courant");
            $compteDto->setDecouvert($compteEntity->getDecouvert());
        } else if ($compteEntity instanceof CompteEpargne) {
            $compteDto->setTypeCompte("Epargne");
            $compteDto->setTauxInteret($compteEntity->getTauxInteret());
        }
        $compteDto->setNbOperation($nbOperation);
        return $compteDto;
    }

    // ----------------------------------------------TEST----------------------------------------------
    public static function mapToEntityWithOperations($compte)
    {
        $compteConsultDto = new CompteConsulDto();
        $compteConsultDto->setNumero($compte->getNumber());
        $compteConsultDto->setSolde($compte->getSolde());
        if ($compte instanceof CompteCourant) {
            $compteConsultDto->setTypeCompte("Courant");
            $compteConsultDto->setDecouvert($compte->getDecouvert());
        } else if ($compte instanceof CompteEpargne) {
            $compteConsultDto->setTypeCompte("Epargne");
            $compteConsultDto->setTauxInteret($compte->getTauxInteret());
        }
        $listOp = array();
        foreach ($compte->ajouterOperation() as $operation) {
            $operationDto = new OperationDto();
            $operationDto->setDate($operation->getDate());
            $operationDto->setMontant($operation->getMontant());
            $operationDto->setDescription($operation->getDescription());
            if ($operation instanceof Versement) {
                $operationDto->setTypeOperation(1);
            } else if ($operation instanceof Retrait) {
                $operationDto->setTypeOperation(2);
            }
            array_push($listOp, $operationDto);
        }
        $compteConsultDto->setListeOperations($listOp);
        return $compteConsultDto;
    }


    public static function compteDbListWithOpToCompteEntityListWithOp($pCompteDbList)
    {
        $compteEntityList = array();
        for($i = 0; $i < count($pCompteDbList); $i++){

           $compteEntity = self::map($pCompteDbList[$i]);
           if(isset($pCompteDbList[$i]['OPE_ID'])){
               $compteEntity->addOperation(OperationMapper::operationDbToCompteOperationEntity(
                $pCompteDbList[$i]['OPE_ID'],
                $pCompteDbList[$i]['OPE_date'],  
                $pCompteDbList[$i]['OPE_amount'],
                $pCompteDbList[$i]['OPE_description'],
                $pCompteDbList[$i]['TOP_ID']
                ));
                $oldId = $compteEntity->getNumber();
                while($i+1<count($pCompteDbList) && $oldId == $pCompteDbList[$i+1]['ACC_NUMBER']){
                   
                    $compteEntity->addOperation(OperationMapper::operationDbToCompteOperationEntity(
                        $pCompteDbList[$i+1]['OPE_ID'],
                        $pCompteDbList[$i+1]['OPE_date'],  
                        $pCompteDbList[$i+1]['OPE_amount'],
                        $pCompteDbList[$i+1]['OPE_description'],
                        $pCompteDbList[$i+1]['TOP_ID']
                        )
                    );
                    $i++;
                }
            }
                array_push($compteEntityList, $compteEntity);
           
        }
        return $compteEntityList;
    }


}
