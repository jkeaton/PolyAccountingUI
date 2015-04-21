<?php
    function db_connect($u, $p){
        $link = NULL;
        if (isset($u) && isset($p)){
            $serverName = "test-mesbrook.cloudapp.net";
            $connectionOptions = array("Database"=>"TransactionDB", "UID"=>strval($u), "PWD"=>strval($p));
            $link = sqlsrv_connect($serverName, $connectionOptions)
                or die();
        }
        return $link;
    }
?>
