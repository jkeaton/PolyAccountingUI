<?php
    function db_connect(){
        $serverName = "TEST-MESBROOK\SWE_SQLEXPRESS";
        $connectionInfo = array("Database"=>"master", "UID"=>"sa", "PWD"=>"Spsu20!4");
        $conn = sqlsrv_connect( $serverName, $connectionInfo );
        return $conn;
    }
?>
