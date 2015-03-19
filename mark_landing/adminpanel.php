<?php
    session_start();
    include "../dist/dbconnect.php";
    include "../dist/common.php";
	bounce();

    $dbConnection = db_connect();

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if (isset($_POST['logout'])){
            return logout();
        }
        if (isset($_POST['send'])){
            send_email();
            $_POST = array();
        }
    }

    send_to_main();

    $welcome_msg = "Welcome ".$_SESSION['user'];
    $inbox = get_inbox($_SESSION['user']);
    $inbox_ct = count($inbox);
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
        <link href="../dist/css/custom.css" rel="stylesheet">

        <!-- Necessary External Javascript files -->
        <script src="../dist/js/jquery-1.9.1.js"></script>
        <script type="text/javascript" src="../dist/js/transition.js"></script>
        <script type="text/javascript" src="../dist/js/collapse.js"></script>

    </head>
    
    <body role="document">

        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <img src="../dist/images/AppDomainFinalProjectLogo.png"
                    alt="PAI Logo" height="30" width="30" class="logo-top nav"> 
                    <a class="navbar-brand" href="#">Poly Accounting Information Group</a>
                </div>
                <div class="navbar-collapse collapse">
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
                        <div class="panel panel-success">
                            <div class="panel-heading panel-heading-sm text-center">
                                <h3 class="panel-title centered-y-sm">Users</h3>
                            </div>
                            <div class="panel-body container-fluid">
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6">
                                        <a href="">Create New User</a>
                                    </div>  
                                    <div class="col-xs-6 col-sm-6">
                                        <a href="">Reset User's Password</a>
                                    </div>  
                                </div>
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6">
                                        <a href="">Deactivate User Account</a>
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-info panel-buffer">
                            <div class="panel-heading panel-heading-sm text-center">
                                <h3 class="panel-title centered-y-sm">Account</h3>
                            </div>
                            <div class="panel-body container-fluid">
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6">
                                        <a href="">Add New Account</a>
                                    </div>  
                                    <div class="col-xs-6 col-sm-6">
                                        <a href="">Deactivate/Activate an Account</a>
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
