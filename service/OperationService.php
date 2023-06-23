<?php

require_once('../dao/CompteDao.php');
require_once('../dao/OperationDao.php');
require_once('../dao/AbstractDao.php');
require_once('../model/Compte.class.php');
require_once('../model/CompteCourant.class.php');
require_once('../model/CompteEpargne.class.php');
require_once('../modelMapper/CompteMapper.php');
require_once('AbstractService.php');

class OperationService extends AbstracService {

    private $compteDao;

    private $operationDao;

    public function __construct() {
        parent::__construct();
        $this->compteDao = new CompteDao();
        $this->operationDao = new OperationDao();
    }

    public function getNumCompte($numeroCompte) {
        return $this->compteDao->getNumCompte($numeroCompte);
    }

    public function getSoldeCompte($numeroCompte) {
        return $this->compteDao->getSoldeCompte($numeroCompte);
    }

    public function getDecouvertCompte($numeroCompte) {
        return $this->compteDao->getDecouvertCompte($numeroCompte);
    }

    public function retraitCompteCourant($description, $numeroCompte, $montant) 
    {
        $compte = $this->compteDao->getNumCompte($numeroCompte);
        $solde = $this->compteDao->getSoldeCompte($numeroCompte);
        $decouvert = $this->compteDao->getDecouvertCompte($numeroCompte);
        if ($solde + $montant < $decouvert) 
        {
           echo "Le solde du compte est insuffisant sur votre compte courant";
           return -1;
        } else {
            $this->getPdo()->beginTransaction();

        try {
            $this->operationDao->addOperation($description, $montant, $compte, 1);
            $this->compteDao->updateSoldeCompte($compte ,$solde - $montant);
            $this->getPdo()->commit();
        } catch (Exception $e) {
            $this->getPdo()->rollBack();
            throw $e;
        }
        }        
    }

    public function retraitCompteEpargne($description, $numeroCompte, $montant) 
    {
        
        $compte = $this->compteDao->getNumCompte($numeroCompte);
        $solde = $this->compteDao->getSoldeCompte($numeroCompte);
        if ($solde - $montant < 0) {
            echo "Le solde du compte est insuffisant sur votre compte épargne";
            return -1;
        } else {
            $this->getPdo()->beginTransaction();
        
            try {
                $this->operationDao->addOperation($description, $montant, $compte, 1);
                $this->compteDao->updateSoldeCompte($compte , $solde - $montant);
                $this->getPdo()->commit();
            } catch (Exception $e) {
                $this->getPdo()->rollBack();
                throw $e;
            }
        }
    }


    public function retrait($description, $numeroCompte, $montant) {
        $compte = $this->getNumCompte($numeroCompte);
        if (isset($compte)) {
                if ($compte instanceof CompteEpargne) {
                   $this->retraitCompteEpargne($description, $compte, $montant);
                } else {
                     $this->retraitCompteCourant($description, $compte, $montant);
                }
                } else {
                    echo "Le compte n'a pas été retrouvé !";
                    return -2;
                }
            }
    
            



    public function versement($description, $numeroCompte, $montant)
    {
        $compte = $this->getNumCompte($numeroCompte);
        $solde = $this->getSoldeCompte($numeroCompte);
        if (isset($compte)) {
            $this->getPdo()->beginTransaction();    
            try {
                $this->operationDao->addOperation($description, $montant, $numeroCompte, 2);
                $this->compteDao->updateSoldeCompte($numeroCompte, $solde + $montant);
                $this->getPdo()->commit();
                print_r("Le versement a été effectué avec succès !");  
            } catch (Exception $e) {
                $this->getPdo()->rollBack();
                throw $e;
            }
        } else {
            print_r("Le compte n'a pas été retrouvé !");
            return -2;
        }
    }

    


}
