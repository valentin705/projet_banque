<?php

abstract class DbConfig {
    private $pdo;
    private const HOST = 'localhost';
    private const DB_NAME = 'bank_appli';
    private const username = 'root';
    private const password = '';
    public function __construct() {
        try {
            $this->pdo = new PDO('mysql:host=' . self::HOST . ';dbname=' .
             self::DB_NAME, self::username, self::password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, false);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }
    public function getPdo() {
        return $this->pdo;
    }
}




?>

