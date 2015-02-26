<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Poly Accounting Login</title>

		<!-- Bootstrap -->
		<link href="dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom Style sheet for moving the body down below nav bar -->
        <link href="dist/css/custom.css" rel="stylesheet">

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

        <script type="text/javascript">
            function clearFields(){
                var fields = document.getElementsByClassName("form-control");
                for each (f in fields){
                    f.value = '';
                }
            }

        </script>
	</head>

	<body role="document" onload="javascript:clearFields()">
    
		<!--main
		================================================== -->
        <div class="row">
            <div class="panel panel-primary col-centered form-group myPanel">
                <div class="panel-heading">
                    <img src="dist/images/AppDomainFinalProjectLogo.png" alt="PAI Logo" height="42" width="42" class="logo"> 
                    <h3 class="panel-title">Poly Accounting Information Group</h3>
                </div>
                <div class="panel-body">
                    <form role="form" class="form-signin container-fluid" method="post" id="sign_up_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="row">
                            <h4 class="form-signin-heading">Please sign in</h4>
                        </div>
                        <div class="row">
                            <label for="inputUsername" class="sr-only">Username</label>
                            <input type="text" id="inputUsername" class="form-control" placeholder="Username" required autofocus>
                        </div>
                        <div class="row">
                            <label for="inputPassword" class="sr-only">Password</label>
                            <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
                        </div>
                        <div class="row">
                            <div class="button-left">
                                <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
                            </div>
                            <div id="helpLinks">
                                <a href="emailverification.php">Forgot my Password</a></br>
                                <a href="newaccount.php">Create new Account</a>
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

    </body>

</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="dist/js/bootstrap.min.js"></script>
