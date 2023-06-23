<?php 

require_once '../config/DbConfig.php';

abstract class AbstractDao extends DbConfig {

public function __construct()
{
    parent::__construct();
}

}

?>