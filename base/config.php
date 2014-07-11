<?php

    define("DB_HOST","localhost");
    define("DB_USER","root");
    define("DB_PASSWORD","");
    define("DB_DATABASE","Users");
    
    define('SALT1','PASSWORD1');
    define('SALT2','PASSWORD2');
    
    session_start();
    
    $_session['error']="";
    $sOutput="";
?>