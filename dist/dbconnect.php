<?php
    function db_connect($u, $p){
        $serverName = "test-mesbrook.cloudapp.net";
        $connectionOptions = array("Database"=>"TransactionDB", "UID"=>strval($u), "PWD"=>strval($p));
        $link = sqlsrv_connect($serverName, $connectionOptions)
            or die();
        return $link;
    }
?>
