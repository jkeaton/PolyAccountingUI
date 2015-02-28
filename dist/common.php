<?php    
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        $data = strip_tags($data);
        return $data;
    }

    function php_print($input){
        echo "<p>".$input."</p><br/>";
    }

    function mssql_begin_transaction() { 
        mssql_query("BEGIN TRANSACTION"); 
    } 

    function mssql_rollback() { 
        mssql_query("ROLLBACK"); 
    } 
?>
    
