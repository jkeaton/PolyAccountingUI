<?php
    function db_connect(){
        $serverName = "test-mesbrook.cloudapp.net";
        $connectionOptions = array("Database"=>"TransactionDB", "UID"=>"sa", "PWD"=>"Spsu20!4");
        $link = sqlsrv_connect($serverName, $connectionOptions)
            or die();
        return $link;
    }
?>
