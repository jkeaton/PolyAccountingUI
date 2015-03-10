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
        header('Location: index.php');
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
?>
