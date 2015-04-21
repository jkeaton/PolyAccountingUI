<?php
    function db_connect($user, $pass){
        $serverName = "test-mesbrook.cloudapp.net";
        $connectionOptions = array("Database"=>"TransactionDB", "UID"=>strval($user), "PWD"=>strval($pass));
        $link = sqlsrv_connect($serverName, $connectionOptions)
            or die();
        return $link;
    }
?>
