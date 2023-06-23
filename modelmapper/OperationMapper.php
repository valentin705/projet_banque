<?php

require_once('../model/Operation.class.php');
require_once('../model/Retrait.class.php');
require_once('../model/Versement.class.php');
require_once('../dto/OperationDto.php');
require_once('../dto/CompteDto.php');

class OperationMapper 
{

    public static function mapToTypeOperation($typeOperation)
    {
        if ($typeOperation['TOP_ID'] == 1) {
            $operation = new Retrait(
                $typeOperation['OPE_description'],
                 $typeOperation['OPE_date'],
                    $typeOperation['OPE_amount'],
                );
        } else if ($typeOperation['TOP_ID'] == 2) {
            $operation = new Versement(
                $typeOperation['OPE_description'],
                $typeOperation['OPE_date'],
                $typeOperation['OPE_amount'],
                );
        }
        return $operation;
    }

    public static function mapallOperation($rowList)
    {
        $operationList = array();
        foreach ($rowList as $row) {
            $operation = OperationMapper::mapToTypeOperation($row);
            array_push($operationList, $operation);
        }
        return $operationList;
    }

    public static function operationDbToCompteOperationEntity(
        $id, $montant, $dateCreation, $description, $typeOperation)
    {
        $operation = null;
        if ($typeOperation == 1) {
            $operation = new Retrait(
                $montant,
                $dateCreation,
                $description
            );
        } else if ($typeOperation == 2) {
            $operation = new Versement(
                $montant,
                $dateCreation,
                $description
            );
        }
        if ($operation != null) {
            $operation->setId($id);
        }
        return $operation;
    }
///////////////////////////////////////////MAPPER-DTO///////////////////////////////////////////////
    public static function mapToEntityOperation($operationEntity)
    {
        $operationDto = new OperationDto();
        $operationDto->setDate($operationEntity->getDate());
        $operationDto->setMontant($operationEntity->getMontant());
        $operationDto->setDescription($operationEntity->getDescription());
        if ($operationEntity instanceof Retrait) {
            $operationDto->setTypeOperation(1);
        } else if ($operationEntity instanceof Versement) {
            $operationDto->setTypeOperation(2);
        }
        return $operationDto;
    }



     public static function mapallOperationTest($rowList)
    {
        $operationList = array();
        foreach ($rowList as $row) {
            $operation = OperationMapper::mapToEntityOperation($row);
            array_push($operationList, $operation);
        }
        return $operationList;
    }



}