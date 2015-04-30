<?php
    session_start();
    include "dist/dbconnect.php";
    include "dist/common.php";
	bounce();
    // Attempt to connect to the SQL Server Database
    $dbConnection = db_connect($_SESSION['db_uid'], $_SESSION['db_pass']);
    $inbox = get_inbox($_SESSION['user'], $dbConnection);
    $inbox_ct = count($inbox);
    
    $input_err = "";
    $filled = array();
    $either_dr_or_cr = 0;
    $welcome_msg = "Welcome ".$_SESSION['user'];
    $today = date('m/d/Y');

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if (isset($_POST['logout'])){
            return logout();
        }
    }

    function get_main_menu(){
        if ($_SESSION['level'] === 0){
            return './mark_landing/adminpanel.php';
        }
        elseif ($_SESSION['level'] === 1){
            return './mark_landing/controlpanel.php';
        }
        elseif ($_SESSION['level'] === 2){
            return './mark_landing/controlpanel.php';
        }
        else{
            var_dump($_SESSION['level']);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
	<head id="my_header">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title>Inbox</title>

        <!-- Style Sheets -->
        <link href="dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="dist/css/bootstrap.css" rel="stylesheet">
        <link href="dist/css/custom.css" rel="stylesheet">
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
        <link href="dist/css/datepicker.css" rel="stylesheet">
        <link href="dist/css/bootstrap-timepicker.css" rel="stylesheet">

        <!-- External Javascript Files -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
   	    <script src="dist/js/main.js"></script>
        <script type="text/javascript" src="dist/js/transition.js"></script>
        <script type="text/javascript" src="dist/js/collapse.js"></script>
        <script src="dist/js/moment.js"></script>
        <script src="dist/js/moment-with-locales.js"></script>
        <script src="dist/js/bootstrap-datepicker.js"></script>
        <script src="dist/js/bootstrap-timepicker.js"></script>
        <script>
            // The Calculator and Calendar Functions ---------------------------------->
            
            $(function () {
                $('.datepicker').datepicker()
            });

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
            /*-------------------End of Calculator and Calendar Functions--------------*/
        </script>

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>

	<body role="document">
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
        <!--<p>Date: <input type="text" id="datepicker"></p>-->

        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <img src="dist/images/AppDomainFinalProjectLogo.png"
                    alt="PAI Logo" height="30" width="30" class="logo-top nav"> 
                    <a class="navbar-brand" style="margin-right: 20px;" href="<?php echo get_main_menu(); ?>">Poly Accounting Information Group</a>
                    <ul class="nav navbar-nav navbar-right">
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
                        <li style="margin-right: 20px;">
                            <span class="input-group btn navbar-left navbar-brand nav navbar-header wrapper3">
                                <a href="http://test-mesbrook.cloudapp.net/dashboard.php">
                                    <i style="color: #A4A4A4; height: 22px; width: 22px;" class="image3 glyphicon glyphicon-signal navbar-header"></i>
                                </a>
                            </span>
                        </li>
                    </ul>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <?php
                            if (isset($_SESSION['user'])){
                                echo "<li class=\"navbar-left\">
                                <a>".$welcome_msg."</a></li><li class=\"navbar-nav\"><a href=\"\">Inbox <span class=\"badge\">".$inbox_ct."</span></a></li><li
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
    
		<!--main
		================================================== -->
        <div class="container">
            <form role="form"  method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
            <div class="panel panel-primary col-centered form-group journalEntryPanel" style="min-height: 500px;">
                <div class="panel-heading panel-heading-lg text-center">
                    <h3 class="panel-title panel-title-with-logo">My Inbox</h3>
                </div>
                <div class="panel">
                <!-- Table -->
                    <table class="table" id="header_table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Time</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Subject</th>
                                <th>Message</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($inbox as $email){
                                    $output = ("<tr><td>".$email['time']->format('m-d-Y')."</td>"
                                                ."<td>".$email['time']->format('H:m:s')."</td>"
                                                ."<td>".$email['sender']."</td>"
                                                ."<td>".$email['recipient']."</td>"
                                                ."<td>".$email['subject']."</td>"
                                                ."<td>".$email['message']."</td></tr>");
                                    echo $output;
                                }
                            ?>
                        </tbody>
                    </table>
                </div>                
            </div>
            </form>
        </div>
    </body>
</html>
