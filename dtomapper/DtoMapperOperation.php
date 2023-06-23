<?php 

require_once('../model/Retrait.class.php');
require_once('../model/Versement.class.php');

class DtoMapperOperation {

    static public function operationEntityToOperationDto($operationEntity) {
        $operationDto = new OperationDto();
        $operationDto->setDescription($operationEntity->getDescription());
        $operationDto->setDate($operationEntity->getDate());
        $operationDto->setMontant($operationEntity->getMontant());
        if ($operationEntity instanceof Versement) {
            $operationDto->setTypeOperation("Versement");
        } else if ($operationEntity instanceof Retrait) {
            $operationDto->setTypeOperation("Retrait");
        }
        return $operationDto;
    }

    public static function operationEntityListToOperationDtoList($operationEntityList) {
        $operationDtoList = array();
        foreach ($operationEntityList as $operationEntity) {
            array_push($operationDtoList, self::operationEntityToOperationDto($operationEntity));
        }
        return $operationDtoList;
    }
}