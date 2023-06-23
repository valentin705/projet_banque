<?php 

require_once('../config/DbConfig.php');

abstract class AbstracService extends dbConfig {

public function __construct()
{
    parent::__construct();
}

}