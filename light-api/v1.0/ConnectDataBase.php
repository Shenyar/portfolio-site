<?php
/**
 * Created by PhpStorm.
 * User: io05
 * Date: 13.09.2016
 * Time: 11:16
 */

class ConnectDataBase {
    protected $host = 'localhost';
    protected $login = 'u670633594_ushow'; /**/
    protected $pass = 'archmage2501'; /**/
    protected $database = 'u670633594_show';

    protected $connection;

    protected function createConnection() {
        $this->connection = new mysqli($this->host,$this->login,$this->pass,$this->database);
        if($this->connection->connect_error) die("Не удалось подключиться к MySQL: ".$this->connection->connect_error);
        $this->connection->set_charset('utf8');
    }

    protected function closeConnection() {
        $this->connection->close();
    }
}