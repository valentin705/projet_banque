<?php 

require_once('../model/Compte.class.php');
require_once('../model/CompteCourant.class.php');
require_once('../model/CompteEpargne.class.php');   
require_once('../modelmapper/CompteMapper.php');
require_once('AbstractDao.php');

class CompteDao extends AbstractDao {

    public function __construct() {
        parent::__construct();
    }

    // méthode qui permet d'obtenir tous les comptes 
    public function getAllComptes() {
        $sql = "SELECT * FROM T_ACCOUNT_ACC";
        $stmt = $this->getPdo()->prepare($sql);
        $stmt->execute();
        $resultat = $stmt->fetchAll();
        $comptes = CompteMapper::mapAll($resultat);
        return $comptes;
    }

    // méthode pour creer un compte courant 
    public function createCompteCourant($numero, $solde, $decouvert) {
        $this->getPdo()->beginTransaction();
        try{
        $sql = "INSERT INTO T_ACCOUNT_ACC (ACC_NUMBER, ACC_BALANCE, ACC_CREATE_AT, ACC_OVERDRAFT, TAC_ID)
         VALUES (?, ?, now(), ?, 1)";
        $stmt = $this->getPdo()->prepare($sql);
        $stmt->bindParam(1, $numero);
        $stmt->bindParam(2, $solde);
        $stmt->bindParam(3, $decouvert);
        $stmt->execute();
        $this->getPdo()->commit();
        } catch (Exception $e) {
            $this->getPdo()->rollBack();
            throw $e;
    } $stmt = null;
    }

    // méthode qui permet de creer un compte epargne
    public function createCompteEpargne($numero, $solde, $tauxInteret) {
        $this->getPdo()->beginTransaction();
        try{
        $sql = "INSERT INTO T_ACCOUNT_ACC (ACC_NUMBER, ACC_BALANCE, ACC_CREATE_AT, ACC_INTEREST_RATE, TAC_ID)
         VALUES (?, ?, now() , ?, 2)";
        $stmt = $this->getPdo()->prepare($sql);
        $stmt->bindParam(1, $numero);
        $stmt->bindParam(2, $solde);
        $stmt->bindParam(3, $tauxInteret);
        $stmt->execute();
        $this->getPdo()->commit();
        } catch (Exception $e) {
            $this->getPdo()->rollBack();
            throw $e;
    } $stmt = null;
    }

    // méthode qui permet de update le soldes d'un compte 
    public function updateSoldeCompte($number, $solde) {
        $sql = "UPDATE T_ACCOUNT_ACC SET ACC_BALANCE = ?, ACC_UPDATE_AT = now() WHERE ACC_NUMBER = ?";
        $stmt = $this->getPdo()->prepare($sql);
        $stmt->bindParam(1, $solde);
        $stmt->bindParam(2, $number);
        $stmt->execute();
        $this->getPdo()->commit();
    }

    // méthode qui permet de rechecher un compte en PDO en utilisant le numéro de compte et le mapper
    public function searchCompte($number) {
        $sql = "SELECT * FROM T_ACCOUNT_ACC WHERE ACC_NUMBER = ?";
        $stmt = $this->getPdo()->prepare($sql);
        $stmt->bindParam(1, $number);
        $stmt->execute();
        $result = $stmt->fetch();
        return CompteMapper::map($result);
    }

    // methode qui permet d'obtenir tous les comptes avec toutes leurs operations
    public function getAllCompteWhitOperation() {
        $sql = "SELECT acc.*, ope.OPE_ID, ope.OPE_description, ope.OPE_date, ope.OPE_amount, ope.TOP_ID
        FROM T_ACCOUNT_ACC acc
        LEFT JOIN T_OPERATION_OPE ope ON acc.ACC_ID = ope.ACC_ID
        ORDER BY acc.ACC_ID ASC";
        $stmt = $this->getPdo()->prepare($sql);
        $stmt->execute();
        $resultat = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $compteList = CompteMapper::compteDbListWithOpToCompteEntityListWithOp($resultat);
        return $compteList;
    
    }

    // methode qui permet d'obtenir un compte avec toutes ses operations
    public function getOneCompteWithOperations($compte) {
        $sql = "SELECT acc.*, ope.OPE_ID, ope.OPE_description, ope.OPE_date, ope.OPE_amount, ope.TOP_ID 
        FROM T_ACCOUNT_ACC acc 
        LEFT JOIN T_OPERATION_OPE ope ON acc.ACC_ID = ope.ACC_ID 
        WHERE acc.ACC_NUMBER = ? 
        ORDER BY acc.ACC_ID ASC";
        $stmt = $this->getPdo()->prepare($sql);
        $stmt->bindParam(1, $compte);
        $stmt->execute();
        $resultat = $stmt->fetchAll(PDO::FETCH_ASSOC);
       
        $compteList = CompteMapper::compteDbListWithOpToCompteEntityListWithOp($resultat);
        return $compteList;
    }

  // méthode qui permet d'obtenir le solde d'un compte en PDO
    public function getSoldeCompteByNum($number) {
        $sql = "SELECT ACC_BALANCE FROM T_ACCOUNT_ACC WHERE ACC_NUMBER = ?";
        $stmt = $this->getPdo()->prepare($sql);
        $stmt->bindParam(1, $number);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result;
    }

   public function getAllOperations($number) {
        $sql = "SELECT * FROM T_OPERATION_OPE WHERE ACC_ID = (SELECT ACC_ID FROM T_ACCOUNT_ACC WHERE ACC_NUMBER = ?)";
        $stmt = $this->getPdo()->prepare($sql);
        $stmt->bindParam(1, $number);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

        public function getCompteByNum($compte) {
        $compte = $this->searchCompte($compte);
        return $compte;
    }

    public function getNumCompte($compte) {
        $compte = $this->searchCompte($compte);
        return $compte->getNumber();
    }

    public function getSoldeCompte($compte) {
        $compte = $this->searchCompte($compte);
        return $compte->getSolde();
    }

    public function getDecouvertCompte($compte) {
        if ($compte instanceof CompteCourant) {
            $compte = $this->searchCompte($compte);
            return $compte->getDecouvert();
        }
    }
}