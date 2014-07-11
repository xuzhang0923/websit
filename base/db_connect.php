<?php
    class DB_Connect{
        function __construct(){
            
        }
        
        function __destruct(){
            
        }
        
        public function connect(){
            require_once $_SERVER['DOCUMENT_ROOT'] . '/flower_shop/base/config.php';
            $con = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
            mysql_select_db(DB_DATABASE);
            
            return $con;
        }
        
        public function close(){
            mysql_close();
        }
    }
?>