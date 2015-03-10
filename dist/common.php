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

    function logout(){
        session_unset(); 
        session_destroy();
        header('Location: http://137.135.120.135/index.php');
        return 0;
    }

    function bounce(){
        if (!isset($_SESSION['authenticated'])) {
            header('Location: index.php');    
            return;
        }
        if ($_SESSION['authenticated'] === false){
            header('Location: index.php');    
            return;
        }
    }

    function escape_quotes($input){
        return str_replace("'", "''", $input);
    }

    function get_inbox($input){
        global $dbConnection;
        $rows = array();
        $sql = ("SELECT * FROM Email WHERE recipient='".$input."' AND deleted=0;");
        $results = sqlsrv_query( $dbConnection, $sql );
        if ($results === false){
            die (php_print( print_r( sqlsrv_errors(), true)));
        }
        else{
            $rows = array();
            while($row = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC)){
                array_push($rows, $row);  
            }
        }
        return $rows;
    }

    function normalize($d){
        if ($d instanceof DateTime){
            return $d->getTimestamp();
        }
        else{
            return strtotime($d);
        }
    }
?>
