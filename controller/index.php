<?php 


require_once '../dao/CompteDao.php';
require_once('../model/Compte.class.php');
require_once('CompteController.php');
require_once("../dao/OperationDao.php");
require_once("../service/OperationService.php");
require_once("../modelMapper/OperationMapper.php");
require_once("../dto/CompteDto.php");



////////////////////////////////////////// TESTS //////////////////////////////////////////


echo "-----------------------------------------------";

// $getAllComptes = new CompteController();
// print_r($getAllComptes->getAllComptes());


// $getCompteWhitOperation = new CompteController();
// print_r($getCompteWhitOperation->getAllCompteWhitOperation());



$getOneCompteWithOperations = new CompteController();
print_r($getOneCompteWithOperations->getOneCompteWithOperations(666));


// $test = new CompteService();
// print_r($test->getAllCompteWhitOperation());

