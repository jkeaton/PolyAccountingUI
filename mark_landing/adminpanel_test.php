<?php
    session_start();
    include "../dist/dbconnect.php";
    include "../dist/common.php";
	bounce();

    // Attempt to connect to the database using current user's credentials
    $dbConnection = db_connect($_SESSION['db_uid'], $_SESSION['db_pass']);
    $user_array = array();

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if (isset($_POST['logout'])){
            return logout();
        }
        if (isset($_POST['send'])){
            send_email($dbConnection);
            $_POST = array();
        }
        if (isset($_POST['save'])){
            save_changes();
            $_POST = array();
        }
    }

    //send_to_main();
    set_users();
    $welcome_msg = "Welcome ".$_SESSION['user'];
    $inbox = get_inbox($_SESSION['user'], $dbConnection);
    $inbox_ct = count($inbox);
    $today = date('m/d/Y');

    $emailErr = $fnameErr = $lnameErr = $passErr = $utypeErr = $confErr = "";
    $email = $fname = $lname = $pass = $utype = $hashed_pass = "";

    // Deal with the form being submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        // Handle insert event attempt
        if (isset($_POST['new_user'])) {
            validateFields();
        }
    }

    function validateFields(){
        global $email, $lname, $fname, $pass, $utype, $emailErr, $lnameErr, $fnameErr, $passErr, $hashed_pass;
        $errCount = 0;

        if (empty($_POST["email"])) {
            ++$errCount;
            $emailErr = "Email address is required";
        }
        else {
            $email = test_input($_POST["email"]);
            // check if e-mail address is well-formed
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                ++$errCount;
                $emailErr = "Invalid email format";
            }
        }

        // Get fname  
        if (empty($_POST["fname"])) {
            ++$errCount;
            $fnameErr = "First name is required";
        } 
        else {
            $fname = test_input($_POST["fname"]);
            // only allow alpha characters as part of the first name
            if (!preg_match("/^[a-zA-Z]*$/",$fname)) {
                ++$errCount;
                $fnameErr = "Only letters allowed";
            }
        }

        // Get lname  
        if (empty($_POST["lname"])) {
            ++$errCount;
            $lnameErr = "Last name is required";
        } 
        else {
            $lname = test_input($_POST["lname"]);
            // only allow alpha characters as part of the last name
            if (!preg_match("/^[a-zA-Z]*$/",$lname)) {
                ++$errCount;
                $lnameErr = "Only letters allowed";
            }
        }

        // Get password  
        if (empty($_POST["pass"])) {
            ++$errCount;
            $passErr = "Password is required";
        } 
        else {
            $pass = test_input($_POST["pass"]);
        }

        // Get Password confirmation 
        if (empty($_POST["confirm"])) {
            ++$errCount;
            $confErr = "Confirmation is required";
        } 
        else {
            $confirm = test_input($_POST["pass"]);
            if ($confirm != $pass){
                ++$errCount;
                $confErr = "Confirmation does not match password.";
            }
        }

        // Get User type 
        if (empty($_POST["utype"])) {
            ++$errCount;
            $utypeErr = "User type is required";
        } 
        else {
            $utype = test_input($_POST["utype"]);
        }

        if ($errCount == 0){
            if (createUser()){
                $_POST = array();
		        //header('Location: http://test-mesbrook.cloudapp.net/mark_landing/adminpanel.php');
            }
        } 
    }

    function createUser(){
        global $fname, $lname, $email, $pass, $dbConnection, $utype;
        $similar_ct = 0;
        $userNameAttempt = (strtolower($fname)[0].strtolower($lname));
        $sql = "Select * FROM [TransactionDB].[dbo].[User] WHERE [UserName] LIKE '".$userNameAttempt."%'";
        // Ask the database how many usernames begin the same as this one
        $results = sqlsrv_query($dbConnection, $sql );
        // Modify the attempted username to account for similar ones
        while ($row = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC)){
            ++$similar_ct;
        } // the php function sqlsrv_num_rows( $results ) is not working for me, but this simple algorithm works
        if ($similar_ct > 0){
            $userNameAttempt = ($userNameAttempt.strval($similar_ct));
        }
        $sql = "Exec [TransactionDB].[dbo].[CreateUser] '".$userNameAttempt."', '".$pass."', '".$utype."', '".$fname."', '".$lname."', '".$email."'";
        $results = sqlsrv_query($dbConnection, $sql);
        return true;
    } 

    function set_users(){
        global $dbConnection, $user_array;
        $sql = ('SELECT [ID]'
            . ',[UserName]'
            . ',[FName]'
            . ',[LName]'
	        . ',[Type]'
            . ',[Email]'
            . ',[IsLoginDisabled]'
            . 'FROM [TransactionDB].[dbo].[UserList]');
        $results = sqlsrv_query($dbConnection, $sql);
        // Add all users indexed by ID
        while ($row = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC)){
            $user_array[$row['ID']] = $row;
        }
    }

    function disable_user($un){
        global $dbConnection;
        if ($un != 'admin'){
            $sql = "UPDATE [TransactionDB].[dbo].[User] SET [IsLoginDisabled] = 1 "
                . "WHERE UserName = '".$un."';";
            $results = sqlsrv_query($dbConnection, $sql);
        }
        return 0;
    }

    function enable_user($un){
        global $dbConnection;
        if ($un != 'admin'){
            $sql = "UPDATE [TransactionDB].[dbo].[User] SET [IsLoginDisabled] = 0 "
                . "WHERE UserName = '".$un."';";
            $results = sqlsrv_query($dbConnection, $sql);
        }
        return 0;
    }

    function reset_user_pass($un){
        global $dbConnection;
        if ($un != 'admin'){
            $sql = "alter login ".$un." with password = 'Poly!123'";
            $results = sqlsrv_query($dbConnection, $sql);
        }
        return 0;
    }

    function get_users(){
        global $user_array;
        $output = '<tbody class="tbody">';
        $count = 0;
        foreach ($user_array as $val){
            $output .= ("<tr>"
                . "<td class='col-sm-2 text-left' style='padding-left: 15px;'>"
                . "<input type='hidden' value='". $val['UserName'] ."' name='un[".$count."]'/>"
                . $val['UserName']
                . "</td>"
                . "<td class='col-sm-2 text-left' style='padding-left: 22px;'>". $val['FName'] ."</td>"
                . "<td class='col-sm-2 text-left' style='padding-left: 33px'>". $val['LName'] ."</td>"
                . "<td class='col-sm-2 text-left' style='padding-left: 43px'>". $val['Type'] ."</td>"
                . "<td class='col-sm-1 text-left'>". $val['Email'] ."</td>"
                . "<td class='col-sm-1 text-center'>"
                . "<input type='checkbox' onchange='set_val(\"cb_".$count."\");' id='cb_".$count."' name='cb[".$count."]' value='". $val['IsLoginDisabled'] ."'/>"
                . "</td>"
                . "<td class='col-sm-2 text-center'>"
                . "<input type='checkbox' onchange='set_val(\"rp_".$count."\");' id='rp_".$count."' name='rp[".$count."]'/>"
                . "</td>"
                . "</tr>");
            $count++;
        }
        $output .= '</tbody>';
        return $output;
    }

    function save_changes(){
        var_dump($_POST);
        if (isset($_POST['un'])){
            // enable the users for whom the disable checkbox isn't set
            // disable the ones where it is set
            if (isset($_POST['cb'])){
                foreach ($_POST['un'] as $key => $val){
                    if (isset($_POST['cb'][$key])){
                        disable_user($_POST['un'][$key]);
                    }
                    else{
                        enable_user($_POST['un'][$key]);
                    }
                }
            }
            // enable all users here
            else{
                foreach ($_POST['un'] as $key => $val){
                    enable_user($_POST['un'][$key]);
                }
            }
            // reset the passwords for the users checked
            if (isset($_POST['rp'])){
                foreach ($_POST['un'] as $key => $val){
                    if (isset($_POST['rp'][$key])){
                        reset_user_pass($_POST['un'][$key]);
                    }
                }
            }
        }
        $_POST = array();
        header('Location: http://test-mesbrook.cloudapp.net/mark_landing/adminpanel.php');
    }
?>

<!DOCTYPE html>
<html>

    <head>
        <title>
            Admin Control Panel
        </title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- CSS Style Sheets -->
		<link href="../dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="../dist/css/bootstrap.css" rel="stylesheet">
        <link href="../dist/css/custom.css" rel="stylesheet">
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
        <link href="../dist/css/datepicker.css" rel="stylesheet">
        <link href="../dist/css/bootstrap-timepicker.css" rel="stylesheet">

        <!-- Necessary External Javascript files -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
   	    <script src="../dist/js/main.js"></script>
        <!--<script src="../dist/js/jquery-1.9.1.js"></script>-->
        <script type="text/javascript" src="../dist/js/transition.js"></script>
        <script type="text/javascript" src="../dist/js/collapse.js"></script>
        <!--<script type="text/javascript" src="../dist/js/bootstrap.min.js"></script>-->
        <script src="../dist/js/moment.js"></script>
        <script src="../dist/js/moment-with-locales.js"></script>
        <script src="../dist/js/bootstrap-datepicker.js"></script>
        <script src="../dist/js/bootstrap-timepicker.js"></script>

        <!-- Call the datepicker function when the date field is clicked -->
        <script type="text/javascript">
            $(function () {
                $('.datepicker').datepicker()
            });
        </script>

        <script type="text/javascript">
            // The Calculator and Calendar Functions ---------------------------------->
            
            function reset_cal(){
                var today = new Date();
                var dd = today.getDate();
                var mm = today.getMonth()+1; 
                var yyyy = today.getFullYear();

                if(dd<10) {
                    dd='0'+dd;
                } 

                if(mm<10) {
                    mm='0'+mm;
                } 

                today = mm+'/'+dd+'/'+yyyy;
                var elem = document.getElementById('cal_input');
                elem.value = today;
            }

            function select_cal(){
                var elem = document.getElementById('cal_input');
                elem.focus();
            }

            var operand_val = 0;
            var in_string = '';
            var answer = 0;
            var start_new = false;

            function calculate(){
                var elem = document.getElementById('calc_input');
                try{
                    answer = eval(in_string);
                    if (!isNaN(answer)){
                        // if answer is a valid integer display it as one
                        if (Math.floor(answer) == answer){
                            answer = parseInt(answer);
                            in_string = answer.toString();
                        }
                        // otherwise let it be accurate to 10 decimal places
                        else {
                            in_string = answer.toFixed(10);
                        }
                    }
                    else {
                        in_string = 'Error';
                        start_new = true;
                    }
                }
                catch (e){
                    in_string = 'Error'
                    start_new = true;
                }
                elem.value = in_string;
            }

            function myClear(){
                var elem = document.getElementById('calc_input');
                in_string = '';
                answer = 0;
                elem.value = in_string;    
            }

            function input_append(val){
                var elem = document.getElementById('calc_input');
                if (start_new){
                    in_string = val;
                    start_new = false;
                }
                else {
                    in_string += val;    
                }
                elem.value = in_string;    
            }

            function set_val(id){
                var elem = document.getElementById(id);
                if (elem.checked){
                    elem.value = 1;
                }
                else {
                    elem.value = 0;
                }
            }

            function set_checks(){
                var elements = document.getElementsByTagName('input');
                for (var i = 0; i < elements.length; i++){
                    if(elements[i].type && elements[i].type == 'checkbox'){
                        if(elements[i].value == 1){
                            elements[i].checked = true;
                        }
                    }
                } 
            }

            /*-------------------End of Calculator and Calendar Functions--------------*/
        </script>
    </head>
    
    <body role="document" onload="set_checks();">
        <!-- Calculator and Calendar Modals -->
        <div id="calculatorModal" class="modal fade" role="dialog" aria-labelledby="calculator" aria-hidden="true">
            <div class="modal-dialog" style="width: 300px;">
                <div class="modal-content calc" id="sized_modal">
                    <div class="modal-body calc">
                        <div class="container-fluid">
                        <div class="row text-center">
                            <button type='button' style="color: #000000;" class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                            <h2 style="color: #000000;"><b>Calculator</b></h2>
                        </div>
                        <div class="row text-center">
                            <div class="col-sm-12">
                            <input type="text" id="calc_input" name="calc_input" value="" class="form-control" readonly/>
                            </div>
                        </div><br/>
                        <div class="row">
                            <div class="col-sm-3">
                                <button onclick="input_append('1');" class="button_font form-control btn btn-sm other_btn">
                                    <b>1</b>         
                                </button>
                            </div>
                            <div class="col-sm-3">
                                <button onclick="input_append('2');" class="button_font form-control btn btn-sm other_btn">
                                    <b>2</b>
                                </button>
                            </div>
                            <div class="col-sm-3">
                                <button onclick="input_append('3');" class="button_font form-control btn btn-sm other_btn">
                                    <b>3</b>         
                                </button>
                            </div>
                            <div class="col-sm-3">
                                <button onclick="input_append('+');" class="button_font form-control btn btn-sm other_btn">
                                    <b>+</b>         
                                </button>
                            </div>
                        </div><br/>
                        <div class="row">
                            <div class="col-sm-3">
                                <button onclick="input_append('4');" class="button_font form-control btn btn-sm other_btn">
                                    <b>4</b>           
                                </button>
                            </div>
                            <div class="col-sm-3">
                                <button onclick="input_append('5');" class="button_font form-control btn btn-sm other_btn">
                                    <b>5</b>
                                </button>
                            </div>
                            <div class="col-sm-3">
                                <button onclick="input_append('6');" class="button_font form-control btn btn-sm other_btn">
                                    <b>6</b>         
                                </button>
                            </div>
                            <div class="col-sm-3">
                                <button onclick="input_append('-');" class="button_font form-control btn btn-sm other_btn">
                                    <b>-</b>         
                                </button>
                            </div>
                        </div><br/>
                        <div class="row">
                            <div class="col-sm-3">
                                <button onclick="input_append('7');" class="button_font form-control btn btn-sm other_btn">
                                    <b>7</b>         
                                </button>
                            </div>
                            <div class="col-sm-3">
                                <button onclick="input_append('8');" class="button_font form-control btn btn-sm other_btn">
                                    <b>8</b>
                                </button>
                            </div>
                            <div class="col-sm-3">
                                <button onclick="input_append('9');" class="button_font form-control btn btn-sm other_btn">
                                    <b>9</b>         
                                </button>
                            </div>
                            <div class="col-sm-3">
                                <button onclick="input_append('*');" class="button_font form-control btn btn-sm other_btn">
                                    <b>x</b>         
                                </button>
                            </div>
                        </div><br/>
                        <div class="row">
                            <div class="col-sm-3">
                                <button onclick="myClear();" class="button_font form-control btn btn-sm other_btn">
                                    <b>CL</b>         
                                </button>
                            </div>
                            <div class="col-sm-3">
                                <button onclick="input_append('0');" class="button_font form-control btn btn-sm other_btn">
                                    <b>0</b>
                                </button>
                            </div>
                            <div class="col-sm-3">
                                <button onclick="input_append('.');" class="button_font form-control btn btn-sm other_btn">
                                    <b>.</b>          
                                </button>
                            </div>
                            <div class="col-sm-3">
                                <button onclick="input_append('/');" class="button_font form-control btn btn-sm other_btn">
                                    <b>/</b>       
                                </button>
                            </div>
                        </div><br/>
                        <div class="row">
                            <div class="col-sm-3">
                                <button onclick="input_append('(');" class="button_font form-control btn btn-sm other_btn">
                                    <b>(</b>         
                                </button>
                            </div>
                            <div class="col-sm-3">
                                <button onclick="input_append(')');" class="button_font form-control btn btn-sm other_btn">
                                    <b>)</b>
                                </button>
                            </div>
                            <div class="col-sm-6">
                                <button onclick="calculate();" class="button_font form-control btn btn-sm equals_btn">
                                    =
                                </button>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="calendarModal" class="modal fade" role="dialog" aria-labelledby="calendar" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" id="sized_modal">
                    <div class="modal-body">
                        <button type='button' style="color: #000000;" class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                        <label for="cal_input">Today's Date: </label>
                        <div class='input-group input-ammend'>
                            <input type="text" id="cal_input" name="cal_input" onchange="alert('changed!');" value="<?php echo $today;?>" class="datepicker form-control"/>
                            <span id="dpickSpan" onclick="select_cal();" class="btn input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Calculator and Calendar Modals -->
        <div id="createUserModal" class="modal fade" role="dialog" aria-labelledby="create_user" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-body">
            <button type='button' style="color: #000000;" class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
            <div class="row">
                <div class="panel panel-primary col-centered form-group myPanel">
                    <div class="panel-heading panel-heading-lg">
                        <img src="../dist/images/AppDomainFinalProjectLogo.png" alt="PAI Logo" height="42" width="42" class="logo">
                        <h3 class="panel-title panel-title-with-logo">Poly Accounting Information Group</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" class="form-signin container-fluid" method="post" id="sign_up_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="row">
                                <h4 class="form-signin-heading">Create a New Account</h4>
                            </div>
                            <div class="row">
                                <label for="inputFname" class="sr-only">First Name</label>
                                <input type="text" name="fname" id="inputFname" class="form-control" placeholder="First Name" required autofocus>
                            </div>
                            <div class="row">
                                <label for="inputLname" class="sr-only">Last Name</label>
                                <input type="text" name="lname" id="inputLname" class="form-control" placeholder="Last Name" required autofocus>
                            </div>
                            <div class="row">
                                <label for="inputEmail" class="sr-only">Email</label>
                                <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email" required autofocus>
                            </div>
                            <div class="row">
                                <label for="inputPassword" class="sr-only">Password</label>
                                <input type="password" name="pass" id="inputPassword" class="form-control" placeholder="Password" required>
                            </div>
                            <div class="row">
                                <label for="inputPassword" class="sr-only">Confirm Password</label>
                                <input type="password" name="confirm" id="inputPassword" class="form-control" placeholder="Confirm Password" required>
                            </div>
                            <div class="row no-gutter">
                                <div class="button-left col-sm-4 left-btn">
                                    <label for="utype">User Type</label>
                                    <select name="utype" class="form-control">
                                        <option value="Normal">Normal</option>
                                        <option value="Manager">Manager</option>
                                        <option value="Admin">Admin</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row no-gutter">
                                <div class="button-left col-sm-offset-7 col-sm-5 left-btn text-right">
                                    <button class="btn btn-lg btn-primary btn-block" name="new_user" type="submit">Create Account</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="errorPane">
                                    <span class="error">
                                        <p>
                                            <?php 
                                                if (isset($loginErr)){
                                                    echo $loginErr;      
                                                }
                                            ?>
                                        </p>
                                    </span> 
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            </div>
            </div>
            </div>
        </div>

        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header" style="margin-right: 20px;">
                    <img src="../dist/images/AppDomainFinalProjectLogo.png"
                    alt="PAI Logo" height="30" width="30" class="logo-top nav"> 
                    <a class="navbar-brand" href="#">Poly Accounting Information Group</a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <!-- Links for Calculator and Calendar Modals and Wiki-->
                        <li style="margin-right: 20px;">
                            <span class="input-group btn navbar-left navbar-brand nav navbar-header wrapper">
                                <a href="#" data-toggle="modal" data-target="#calendarModal" onclick="reset_cal();">
                                    <i style="color: #A4A4A4; height: 22px; width: 22px;" class="image glyphicon glyphicon-calendar navbar-header"></i>
                                </a>
                            </span>
                        </li>        
                        <li style="margin-right: 20px;">
                            <span class="input-group btn navbar-left navbar-brand nav navbar-header wrapper2">
                                <a href="#" data-toggle="modal" data-target="#calculatorModal">
                                    <img src="http://test-mesbrook.cloudapp.net/dist/images/calculator.png" color="#A4A4A4" class="image2 navbar-header" height="19" width="19"></img>
                                </a>
                            </span>
                        </li>
                        <li style="margin-right: 20px;">
                            <span class="input-group btn navbar-left navbar-brand nav navbar-header wrapper3">
                                <a href="https://polyaccounting.wordpress.com/" target="_blank">
                                    <i style="color: #A4A4A4; height: 22px; width: 22px;" class="image3 glyphicon glyphicon-question-sign navbar-header"></i>
                                </a>
                            </span>
                        </li>
                        <!-- End Links for Calculator and Calendar Modals -->
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <?php
                            global $inbox_ct;
                            if (isset($_SESSION['user'])){
                                echo "<li class=\"navbar-left\">
                                <a>".$welcome_msg."</a></li><li class=\"navbar-nav\"><a href=\"http://test-mesbrook.cloudapp.net/inbox.php\">Inbox <span class=\"badge\">".$inbox_ct."</span></a></li><li
                                class=\"navbar-left\"><form role=\"form\"
                                class=\"navbar-form navbar-left\" method=\"post\"
                                action=\"" . htmlspecialchars($_SERVER["PHP_SELF"]) . "\"><button
                                type=\"submit\" class=\"btn btn-danger\"
                                name=\"logout\">Log Out</button></form></li>";
                            }
                        ?>   
                    </ul>
                </div>
            </div>
        </nav>
        <div class="panel-group" id="main-page" role="tablist">
            <div class="container">
                <div class="panel panel-primary col-centered form-group">
                    <div class="panel-heading text-center">
                        <h3 class="panel-title centered-y">Admin Panel</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                        <div class="panel panel-info">
                            <div class="panel-heading panel-heading-sm text-center">
                                <h3 class="panel-title centered-y-sm">Users</h3>
                            </div>
                            <div class="panel-body container-fluid">
                                <div class="row">
                                    <div class="col-sm-2 text-left">
                                        <label class='my_th'>
                                            User Name 
                                        </label>
                                    </div>
                                    <div class="col-sm-2 text-left">
                                        <label class="my_th">
                                            First Name 
                                        </label>
                                    </div>
                                    <div class="col-sm-2 text-left">
                                        <label class='my_th'>
                                            Last Name
                                        </label>
                                    </div>
                                    <div class="col-sm-2 text-left">
                                        <label class='my_th'>
                                            User Type
                                        </label>
                                    </div>
                                    <div class="col-sm-1 text-left">
                                        <label class='my_th'>
                                            Email
                                        </label>
                                    </div>
                                    <div class="col-sm-1 text-center" style="padding-left: 32px;">
                                        <label class='my_th'>
                                            Disabled 
                                        </label>
                                    </div>
                                    <div class="col-sm-2 text-center" style="padding-left: 30px;">
                                        <label class='my_th'>
                                            Reset Password
                                        </label>
                                    </div>
                                </div>
                                <div class="row" id="table_portion">
                                    <table class="table table-hover">
                                        <?php echo get_users(); ?>
                                    </table>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-offset-6 col-sm-6 text-right">
                                        <a type="button" class="btn btn-primary" href="#" data-toggle="modal" data-target="#createUserModal">Create New User</a>
                                        <button type="submit" name="save" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                        <div class="panel panel-info panel-buffer">
                            <div class="panel-heading panel-heading-sm text-center">
                                <h3 class="panel-title centered-y-sm">Account</h3>
                            </div>
                            <div class="panel-body container-fluid">
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6">
                                        <a href="http://test-mesbrook.cloudapp.net/ASP_NET/manageaccount/newaccount">Edit or Add Accounts</a>
                                    </div>  
                                    <div class="col-xs-6 col-sm-6">
                                        <a href="http://test-mesbrook.cloudapp.net/ASP_NET/ManageAccount/Manageaccount">Manage Accounts</a>
                                    </div>  
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-danger form-group col-centered panel-buffer">
                            <div class="panel-heading panel-heading-sm text-center">
                                <h3 class="panel-title centered-y-sm">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#main-page" href="#email-panel" aria-expanded="false" aria-controls="email-panel">
                                        Send Email
                                    </a>
                                </h3>
                            </div>
                            <!-- Side Panel for sending Email -->
                            <div role="tabpanel" id="email-panel" class="panel-collapse collapse panel-body">
                                <form role="form" class="form-signin container-fluid" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                                    <div class="row top-buffer">
                                        <input type="text" class="form-control" id="recipients" name="recipients" placeholder="Recipients">
                                    </div>
                                    <div class="row top-buffer">
                                        <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject">
                                    </div>
                                    <div class="row top-buffer">
                                        <textarea class="form-control" rows="5" id="message" name="message" placeholder="Message"></textarea>
                                    </div>
                                    <div class="row top-buffer no-gutter">
                                        <div class="col-xs-6 col-sm-3 left-btn">
                                            <button id="contacts" type="button" class="btn btn-primary form-control" name="contacts">
                                                Find Recipients
                                            </button>
                                        </div>
                                        <div class="col-xs-6 col-sm-3 left-btn">
                                            <button id="attach" type="button" class="btn btn-primary form-control" name="attach">
                                                Upload Attachment
                                            </button>
                                        </div>
                                        <div class="col-xs-6 col-sm-3 col-sm-offset-3 right-btn">
                                            <button id="send" type="submit" class="btn btn-primary form-control" name="send">
                                                Send
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

