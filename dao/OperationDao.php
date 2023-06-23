<?php

require_once('../model/Operation.class.php');
require_once('../model/Retrait.class.php');
require_once('../model/Versement.class.php');
require_once('AbstractDao.php');

class OperationDao extends AbstractDao
{

    public function __construct()
    {
        parent::__construct();
    }


    // méthode qui permet d'ajouter une opération 
    public function addOperation($description, $montant, $numeroCompte, $type)
    {
        $this->getPdo()->beginTransaction();
        try {
            $sql = "INSERT INTO T_OPERATION_OPE (OPE_description, OPE_date, OPE_amount, ACC_ID, TOP_ID)
    VALUES (?, now(), ?, (SELECT ACC_ID FROM T_ACCOUNT_ACC WHERE ACC_NUMBER = ?), 
    (SELECT TOP_ID FROM T_R_TYPEOPERATION_TOP WHERE TOP_ID = ?))";
            $stmt = $this->getPdo()->prepare($sql);
            $stmt->bindParam(1, $description);
            $stmt->bindParam(2, $montant);
            $stmt->bindParam(3, $numeroCompte);
            $stmt->bindParam(4, $type);
            $stmt->execute();
            $this->getPdo()->commit();
        } catch (Exception $e) {
            $this->getPdo()->rollBack();
            throw $e;
        }
    }

    // méthode qui permet de compter le nombre d'operation 
    public function getOperationsByNumber($id)
    {
        $sql = "SELECT * FROM T_OPERATION_OPE WHERE ACC_ID = (SELECT ACC_ID FROM T_ACCOUNT_ACC WHERE ACC_NUMBER = ?)";
        $stmt = $this->getPdo()->prepare($sql);
        $stmt->bindParam(1, $id, pdo::PARAM_INT);
        $stmt->execute();
        $nboperation = $stmt->rowCount();
        return $nboperation;
    }

    // méthode qui permet de récupérer toutes les opérations d'un compte
    public function getAllOperations($number)
    {
        $sql = "SELECT * FROM T_OPERATION_OPE WHERE ACC_ID = (SELECT ACC_ID FROM T_ACCOUNT_ACC WHERE ACC_NUMBER = ?)";
        $stmt = $this->getPdo()->prepare($sql);
        $stmt->bindParam(1, $number);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $operations = OperationMapper:: mapallOperation($result);
        return $operations;
    }

    //   méthode qui permet de récupérer toutes les opérations d'un compte en PDO
    // public function getAllOperations($number)
    // {
    //     $sql = "SELECT * FROM T_OPERATION_OPE WHERE ACC_ID = (SELECT ACC_ID FROM T_ACCOUNT_ACC WHERE ACC_NUMBER = ?)";
    //     $stmt = $this->getPdo()->prepare($sql);
    //     $stmt->bindParam(1, $number);
    //     $stmt->execute();
    //     $result = $stmt->fetchAll();
    //     if ($result) {
    //         $operations = array();
    //         foreach ($result as $row) {
    //             array_push($operations, OperationMapper::mapToTypeOperation($row));
                
    //         }
    //         return $operations;
    //     }
    // }
}
