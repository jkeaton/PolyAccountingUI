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
    
    function submit_query($sql){
        global $dbConnection;
        $result = sqlsrv_query( $dbConnection, $sql );
        if (!$result){
            return false;
        }
        return true;
    }

    function popup($msg){
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }
?>
