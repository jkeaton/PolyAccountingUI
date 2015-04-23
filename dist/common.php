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
        $result = sqlsrv_query($_SESSION['dbConnection'], $sql );
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
        header('Location: http://test-mesbrook.cloudapp.net/index.php');
        return 0;
    }

    function bounce(){
        if (!isset($_SESSION['authenticated'])) {
            header('Location: http://test-mesbrook.cloudapp.net/index.php');    
            return;
        }
        if ($_SESSION['authenticated'] === false){
            header('Location: http://test-mesbrook.cloudapp.net/index.php');    
            return;
        }
    }

    function send_to_main(){
        if ($_SESSION['level'] === 0){
            if (strcmp(strtolower("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"), strtolower("http://test-mesbrook.cloudapp.net/mark_landing/adminpanel.php")) !== 0){
                header('Location: http://test-mesbrook.cloudapp.net/mark_landing/adminpanel.php');
            }
        }
        elseif ($_SESSION['level'] === 1 || $_SESSION['level'] === 2){
            if (strcmp(strtolower("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"), strtolower("http://test-mesbrook.cloudapp.net/mark_landing/controlpanel.php")) !== 0){
                header('Location: http://test-mesbrook.cloudapp.net/mark_landing/controlpanel.php');
            }
        }
    }

    function escape_quotes($input){
        return str_replace("'", "''", $input);
    }

    function get_inbox($input, $conn){
        $rows = array();
        $sql = ("SELECT * FROM Email WHERE recipient='".$input."' AND deleted=0;");
        $results = sqlsrv_query($conn, $sql);
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

    function mysplit($delims, $string){
        if (!$delims || !$string){
            return NULL;
        }
        $formatted = str_replace($delims, $delims[0], $string);
        return explode($delims[0], $formatted);
    }

    function send_email(){
        global $recipients, $subject, $message;
        if (!isset($_POST['recipients'])){
            return -1;
        }
        elseif (!isset($_POST['subject'])){
            return -1;
        }
        elseif (!isset($_POST['message'])){
            return -1;
        }
        else{
            $recipients = mysplit(array(' ', ','), $_POST['recipients']);
            $subject = $_POST['subject'];
            $message = $_POST['message'];
            $date = new DateTime("now");
            foreach ($recipients as $recipient){
                if (strlen($recipient) > 0){
                    $formatted_datetime = $date->format("Y-m-d\TH:i:s");
                    $sql = "insert into Email (sender, recipient, [time], [subject], [message], deleted, seen) values ('".$_SESSION['user']."', '".$recipient."', CONVERT(datetime, '".$formatted_datetime."', 126), '".$subject."', '".$message."', 0, 0)";
                    if (!submit_query($sql)){
                        var_dump($sql);
                        die(php_print(print_r(sqlsrv_errors(), true)));
                    }
                }
            } 
        }
        return 0;
    }
?>
