<?php

namespace System\DB;


class Mysql
{
       protected $con = null;
       protected $result = null;
       protected $last_query = null;

       public function __construct($host, $name, $user, $password=''){
         $this->con = new \PDO("mysql:host='{$host}';dbname={$name}",$user,$password);
         $this->con->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
     }

     public function query($sql){
         $this->last_query = $sql;
         $this->result = $this->con->prepare($sql);
         $this->result->execute();
         return $this->result;
     }

     public function num_rows(){
         return $this->result->rowCount();
     }
     public function fetch_assoc(){
         return $this->result->fetchAll();
     }

     public function last_query(){
         return $this->result->last_query;
     }
}