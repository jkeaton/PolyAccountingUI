<?php
    function db_connect(){
        $serverName = "test-mesbrook.cloudapp.net";
        $user = 'sa';
        $pwd = 'Spsu20!4';
        $link = mssql_connect($serverName, $user, $pwd);
        if(!$link) {
            // Linkly an invaild password or user name
            echo 'Could not connect';
            die('Could not connect: ' . mssql_error());
	}
        if(!mssql_select_db('TransactionDB', $link)) {
            echo 'Database not available';
            die('Database not available: ' . mssql_error());
        }
	//echo'Successful connection';
        return $link;
    }
?>
