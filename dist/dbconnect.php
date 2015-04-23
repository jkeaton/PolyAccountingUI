<?php
    function db_connect($u, $p){
        $link = NULL;
        $serverName = "localhost";
        $connectionOptions = array("Database"=>"TransactionDB", "UID"=>$u, "PWD"=>$p);
        $link = sqlsrv_connect($serverName, $connectionOptions);
        return $link;
    }
?>
