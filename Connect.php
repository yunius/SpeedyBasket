<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Connect
 *
 * @author gilou
 */
class Connect {
    private $PDOinstance = null;
    private static $instance = null;
    const USER = 'root';
    const PASSWORD = 'root';
    const HOST = 'localhost';
    const DBNAME = 'db_speedymarket';
    
    private function __construct() {
        $this->PDOinstance = new PDO('mysql:dbname='.self::DBNAME.';host='.self::HOST,self::USER ,self::PASSWORD);
    }
    
    public static function getInstance() {  
    if(is_null(self::$instance))
    {
      self::$instance = new Connect();
    }
    return self::$instance;
    }
    
    public function query($query) {
    return $this->PDOinstance->query($query);
    }
    
    public function prepare($prepare) {
    return $this->PDOinstance->prepare($prepare);
    }
    
    public function exec($exec) {
        return $this->PDOinstance->exec($exec);
    }
    
}
