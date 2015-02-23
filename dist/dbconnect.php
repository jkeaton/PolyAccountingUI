<?php
    function db_connect(){
        $serverName = "(local)";
        $connectionOptions = array("Database"=>"master", "UID"=>"sa", "PWD"=>"Spsu20!4");
	$link = sqlsrv_connect($serverName, $connectionOptions)
            or die();
        return $link;
    }
?>
