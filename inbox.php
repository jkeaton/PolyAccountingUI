<?php
    session_start();
    include "dist/dbconnect.php";
    include "dist/common.php";
	bounce();
    // Attempt to connect to the SQL Server Database
    if (isset($_SESSION['db_uid']) && isset($_SESSION['db_pass'])){
        $dbConnection = db_connect($_SESSION['db_uid'], $_SESSION['db_pass']);
    }
    else{
        $dbConnection = db_connect('Noman', 'odysseus');
    }

    $inbox = get_inbox($_SESSION['user']);
    $inbox_ct = count($inbox);
    
    $input_err = "";
    $filled = array();
    $either_dr_or_cr = 0;
    $welcome_msg = "Welcome ".$_SESSION['user'];

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if (isset($_POST['submit'])) {
            validateFields();
        }
        elseif (isset($_POST['logout'])){
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

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>

	<body role="document">
        <!--<p>Date: <input type="text" id="datepicker"></p>-->

        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <img src="dist/images/AppDomainFinalProjectLogo.png"
                    alt="PAI Logo" height="30" width="30" class="logo-top nav"> 
                    <a class="navbar-brand" href="<?php echo get_main_menu(); ?>">Poly Accounting Information Group</a>
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
