<?php
require_once('CompteController.php');
require_once('../modelMapper/OperationMapper.php');

$controller = new CompteController();


$requete = $_GET['requete'];
if (isset($_GET['requete']) && !empty($_GET['requete'])) {
    $requete = $_GET['requete'];
}


if ($requete == "main") {
    $comptes = $controller->getAllComptes();
    $compteToList = array();
    foreach ($comptes as $compte) {
        $nbOp =  $controller->getOperationsByNumber($compte->getNumber());
        $compteDto = CompteMapper::mapToEntity($compte, $nbOp);
        array_push($compteToList, $compteDto);
    }
    print json_encode($compteToList);
}


if ($requete == 'createCompte' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $content = file_get_contents('php://input');
    $data = json_decode($content, true);
    $numero = $data['numCompte'];
    $solde = $data['solde'];
    $typeCompte = $data['typeCompte'];
    $decouvertOuInteret = $data['decouvertOuInteret'];
    $createCompte = $controller->createCompte($numero, $solde, $typeCompte, $decouvertOuInteret);
}


if ($requete == 'operationCompte' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $content = file_get_contents('php://input');
    $data = json_decode($content, true);
    $numCompte = $data['numCompte'];
    $montantOperation = $data['montantOperation'];
    $typeOperation = $data['typeOperation'];
    $descriptionOpertion = $data['descriptionOpertion'];
    if ($typeOperation == 'versement') {
        $operation = $controller->versement($descriptionOpertion, $numCompte, $montantOperation);
    } else {
        $operation = $controller->retrait($descriptionOpertion, $numCompte, $montantOperation);
    }
}



if ($requete == 'rechercherCompte' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $content = file_get_contents('php://input');
    $data = json_decode($content, true);
    $numero = $data['chercherCompte'];
    $result = $controller->getOneCompteWithOperations($numero);
    print json_encode($result);
}



if ($requete == "consultationCompte" && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $numero = $_GET["numero"];
    $result = $controller->getOneCompteWithOperations($numero);
    print json_encode($result);
}




