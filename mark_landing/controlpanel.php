<?php
    session_start();
    include "../dist/dbconnect.php";
    include "../dist/common.php";
	bounce();

    // Attempt to connect to the database using current user's credentials
    $dbConnection = db_connect($_SESSION['db_uid'], $_SESSION['db_pass']);

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if (isset($_POST['logout'])){
            return logout();
        }
        if (isset($_POST['send'])){
            send_email($dbConnection);
            $_POST = array();
        }
    }

    send_to_main();

    $welcome_msg = "Welcome ".$_SESSION['user'];
    $inbox = get_inbox($_SESSION['user'], $dbConnection);
    $inbox_ct = count($inbox);
    $recipients = array();
    $subject = $message = "";
    $today = date('m/d/Y');
?>

<!DOCTYPE html>
<html>

    <head>
        <title>
            Control Panel
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
        <!--<script src="../dist/js/jquery-1.9.1.js"></script>-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
   	    <script src="../dist/js/main.js"></script>
        <script type="text/javascript" src="../dist/js/transition.js"></script>
        <script type="text/javascript" src="../dist/js/collapse.js"></script>
        <script src="../dist/js/moment.js"></script>
        <script src="../dist/js/moment-with-locales.js"></script>
        <script src="../dist/js/bootstrap-datepicker.js"></script>
        <script src="../dist/js/bootstrap-timepicker.js"></script>
        <!--<script type="text/javascript" src="../dist/js/bootstrap.min.js"></script>-->

        <script type="text/javascript">
            $(function () {
                $('.datepicker').datepicker()
            });
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

            /*-------------------End of Calculator and Calendar Functions--------------*/
        </script>

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

        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <img src="../dist/images/AppDomainFinalProjectLogo.png"
                    alt="PAI Logo" height="30" width="30" class="logo-top nav"> 
                    <a class="navbar-brand" href="#">Poly Accounting Information Group</a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                View
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="http://test-mesbrook.cloudapp.net/ASP_NET/Financial%20Statement/Chart%20of%20Account">Chart of Accounts</a></li>
                                <li><a href="http://test-mesbrook.cloudapp.net/ASP_NET/Journal%20and%20Ledger/General%20Journal">View All Posted Transactions</a></li>
                                <li><a href="http://test-mesbrook.cloudapp.net/ASP_NET/Journal%20and%20Ledger/UnpostTranx">View All Pending Transactions</a></li>
                                <li><a href="http://test-mesbrook.cloudapp.net/ASP_NET/Journal%20and%20Ledger/RejectedTransaction.aspx">View All Rejected Transactions</a></li>
                                <li><a href="http://test-mesbrook.cloudapp.net/ASP_NET/Financial%20Statement/TrialBalance">Trial Balance</a></li>
                                <li><a href="http://test-mesbrook.cloudapp.net/ASP_NET/Financial%20Statement/IncomeStatement">Income Statement</a></li>
                                <li><a href="http://test-mesbrook.cloudapp.net/ASP_NET/Financial%20Statement/BalanceSheet.aspx">Balance Sheet</a></li>
                                <li><a href="http://test-mesbrook.cloudapp.net/ASP_NET/Financial%20Statement/OwnerEquityState">Statement of Owner's Equity</a></li>
                                <li><a href="http://test-mesbrook.cloudapp.net/ASP_NET/Financial%20Statement/CashFlowStatement">Cash Flow Statement</a></li>
                            </ul>
                        </li>
                        <li class="dropdown" style="margin-right: 20px;">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Record<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="http://test-mesbrook.cloudapp.net/journalentry.php">Journal Entry</a></li>
                                <li><a href="http://test-mesbrook.cloudapp.net/closing_or_adjusting_journal_entry.php">Adjusting Entry</a></li>
                                <li><a href="http://test-mesbrook.cloudapp.net/closing_or_adjusting_journal_entry.php">Closing Entry</a></li>
                            </ul>
                        </li>
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
                        <li style="margin-right: 20px;">
                            <span class="input-group btn navbar-left navbar-brand nav navbar-header wrapper3">
                                <a href="http://test-mesbrook.cloudapp.net/dashboard.php">
                                    <i style="color: #A4A4A4; height: 22px; width: 22px;" class="image3 glyphicon glyphicon-signal navbar-header"></i>
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
                        <h3 class="panel-title centered-y">Control Panel</h3>
                    </div>
                    <div class="panel-body">
                        <div class="panel panel-info">
                            <div class="panel-heading panel-heading-sm text-center">
                                <h3 class="panel-title centered-y-sm">View Financial Statements</h3>
                            </div>
                            <div class="panel-body container-fluid">
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6">
                                        <a href="http://test-mesbrook.cloudapp.net/ASP_NET/Financial%20Statement/Chart%20of%20Account">View Chart of Accounts</a>
                                    </div>  
                                    <div class="col-xs-6 col-sm-6">
                                        <a href="http://test-mesbrook.cloudapp.net/ASP_NET/Financial%20Statement/OwnerEquityState">View Statement of Owner's Equity</a>
                                    </div>  
                                </div>
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6">
                                        <a href="http://test-mesbrook.cloudapp.net/ASP_NET/Journal%20and%20Ledger/General%20Journal">View All Posted Transactions</a>
                                    </div>  
                                    <div class="col-xs-6 col-sm-6">
                                        <a href="http://test-mesbrook.cloudapp.net/ASP_NET/Financial%20Statement/TrialBalance">View Trial Balance</a>
                                    </div>  
                                </div>
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6">
                                        <a href="http://test-mesbrook.cloudapp.net/ASP_NET/Journal%20and%20Ledger/UnpostTranx">View All Pending Transactions</a>
                                    </div>  
                                    <div class="col-xs-6 col-sm-6">
                                        <a href="http://test-mesbrook.cloudapp.net/ASP_NET/Financial%20Statement/CashFlowStatement">View Cash Flow Statement</a>
                                    </div>  
                                </div>
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6">
                                        <a href="http://test-mesbrook.cloudapp.net/ASP_NET/Journal%20and%20Ledger/RejectedTransaction">View All Rejected Transactions</a>
                                    </div>  
                                    <div class="col-xs-6 col-sm-6">
                                        <a href="http://test-mesbrook.cloudapp.net/ASP_NET/Financial%20Statement/BalanceSheet.aspx">View Balance Sheet</a>
                                    </div>  
                                </div>
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6">
                                        <a href="http://test-mesbrook.cloudapp.net/ASP_NET/Financial%20Statement/IncomeStatement">View Income Statement</a>
                                    </div>  
                                    <div class="col-xs-6 col-sm-6">
                                    </div>  
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-info panel-buffer">
                            <div class="panel-heading panel-heading-sm text-center">
                                <h3 class="panel-title centered-y-sm">Record Transactions</h3>
                            </div>
                            <div class="panel-body container-fluid">
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6">
                                        <a href="../journalentry.php">Record a Journal Entry</a>
                                    </div>  
                                    <div class="col-xs-6 col-sm-6">
                                        <a href="../closing_or_adjusting_journal_entry.php">Record an Adjusting Journal Entry</a>
                                    </div>  
                                </div>
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6">
                                        <a href="../closing_or_adjusting_journal_entry.php">Record a Closing Journal Entry</a>
                                    </div>  
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-danger form-group col-centered panel-buffer">
                            <div class="panel-heading panel-heading-sm text-center">
                                <h3 class="panel-title centered-y-sm">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#main-page" href="#email-panel" aria-expanded="false" aria-controls="email-panel">
                                        Send Message
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
