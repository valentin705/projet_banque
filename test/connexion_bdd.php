<?php 

// connexion pdo à la base de données

$pdo = new PDO('mysql:host=localhost;dbname=banque', 'root', '');

// formulaire de création de compte

if (isset($_POST['submit'])) {

    $numero = $_POST['numero'];
    $date = $_POST['date'];
    $solde = $_POST['solde'];

    // insertion des donnees dans la base de donnees

    $requete = "INSERT INTO compte (id, numero, date_ouverture, solde) VALUES (NULL, '$numero', '$date', '$solde')";

    $pdo->exec($requete);

    header('Location: index.php');

}