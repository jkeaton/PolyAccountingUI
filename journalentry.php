<?php
    session_start();
    include "dist/dbconnect.php";
    include "dist/common.php";
	bounce();
    // Attempt to connect to the SQL Server Database
    $dbConnection = db_connect();
    $acct_names = get_acct_names();

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

    function get_filled_by_index($index){
        if (isset($filled[$index])){
            return $filled[$index];
        }
        else{
            return "";
        }
    }

    function get_acct_names(){
        global $dbConnection;
        $sql = "SELECT * FROM Account where IsActive = 1 "
                . "order by AccTypeID, SortOrder, AccNumber";
        $result = sqlsrv_query( $dbConnection, $sql);
        $output = array();
        while ($row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC) ){
            array_push($output, $row['Name']); 
        }
        return $output;
    }

    function gen_select_options(){
        global $acct_names;
        $output = "";
        foreach ($acct_names as &$value){
            $output .= ("<option>".$value."</option>");
        }
        return $output;
    }
    
    function validateFields(){
        global $filled, $input_err;
        $test = $_POST['i'];
        $num_rows = $_POST["row_ct_for_php"];
        $filled = new SplFixedArray($num_rows*6);
        foreach ($filled as $val){
            $val = NULL;
        }
        foreach ($test as $key => $value){
            $filled[$key] = $value;
        }
        if (valid($num_rows)){
            $_POST = array();
            insert_entry($num_rows);
		    header('Location: journalentry.php');
        }
    }

    function valid($row_ct){
        global $filled, $input_err, $either_dr_or_cr;
        $err_ct = 0;
        $dr_amt = 0;
        $cr_amt = 0;
        // First Check the Date
        $err_ct += valid_date(0);

        // Now Check the Rest
        for ($i = 0; $i < $row_ct; $i++){
            for ($j = 0; $j < 6; $j++){
                if ($j == 1){
                    $err_ct += valid_acct_title(($i*6)+$j);  
                }
                // Row with index 2 is always the description line
                // Extra rows that are added enter the array in groups of 6
                // starting at index 18...
                if (4 <= $j && $j <= 5 && $i != 2){
                    if ($j == 4){
                       $dr_amt += $filled[($i*6)+$j];
                    }
                    elseif ($j == 5){
                       $cr_amt += $filled[($i*6)+$j];
                    }
                    $err_ct += valid_monetary_amt(($i*6)+$j);
                }
            }
            if ($either_dr_or_cr != 0){
                $err_ct++;
                $input_err = "You must enter all debit and credit fields.";
                return false;
            }
            else{
                // Reset this to be checked for the next row
                $either_dr_or_cr = 0;
            }
        } 

        if ($dr_amt != $cr_amt){
            $err_ct++;
            $input_err = "Total debits do not equal total credits.";
            return false;
        }
        
        if ($err_ct == 0){
            return true;
        }
        else{
            return false;
        }
    }
    
    function valid_date($index){
        global $filled, $input_err;
        if ($filled[$index] === NULL) {
            $input_err = "You must provide a date";
            return 1;
        } 
        else {
            $filled[$index] = test_input($filled[$index]);
            $filled[$index] = DateTime::createFromFormat('m/d/Y', $filled[$index]);
            if (!$filled[$index]){
                $input_err = "Invalid Date";
                return 1;
            }
            else {
                $year = (int) ($filled[$index]->format("Y"));
                $month = (int) ($filled[$index]->format("m"));
                $day = (int) ($filled[$index]->format("d"));
                $filled[$index] = $filled[$index]->format("m/d/Y");
                if (!checkdate ($month , $day , $year )){
                    $input_err = "Not a valid Gregorian Date";
                    return 1;
                }
            }
        }
    }

    function valid_acct_title($index){
        global $filled, $input_err;
        if ($filled[$index] === NULL || $filled[$index] == ""){
            $input_err = "Must enter a description for the journal entry";
            return 1;
        }
        // Also here, ensure we're not checking the description
        else if ($filled[$index] == "Select..." && $index != 13){
            $input_err = "Must select an account name from the list";
            return 1;
        }
        else{
            $filled[$index] = test_input($filled[$index]);
            return 0;
        }
    }

    function valid_monetary_amt($index){
        global $filled, $input_err, $either_dr_or_cr;
        if ($filled[$index] === NULL) {
            // Make sure we're not checking the description line
            if ($index < 12 || $index > 17){
                $either_dr_or_cr--;
            }
        } 
        else {
            // Make sure we're not checking the description line
            if ($index < 12 || $index > 17){
                $either_dr_or_cr++;
            }
            $filled[$index] = test_input($filled[$index]);
            if (!is_numeric ($filled[$index])){
                $input_err = "Price must be a numeric value.";
                return 1;
            }
            elseif (!preg_match("/^[0-9\.]*$/", $filled[$index])) {
                $input_err = "Only digits and a radix point allowed";
                return 1;
            }
            else{
                $filled[$index] = floatval($filled[$index]);
                if ($filled[$index] <= 0){
                    $input_err = "Amount must be positive";
                    return 1;
                }
                else {
                    return 0;
                }
            }
        }
    }

    function insert_entry($row_ct){
        global $dbConnection, $filled, $input_err;
        // Start a transaction so we can rollback if something fails
        sqlsrv_begin_transaction($dbConnection);
        // -- At this point we have all the fields necessary for the insertion
        $tmp_syntax = ("IF OBJECT_ID('tempdb..#tmp') is null "
            . "BEGIN "
            . "Create table #tmp ([Date] datetime null, [Desc] varchar(150) null, Amount money not null, IsDebit bit not null, AccountID int not null) "
            . "END; ");
        $tmp_syntax .= "truncate table #tmp; ";
        for ($i = 0; $i < $row_ct; $i++){
            // First check if this is a row with a valid date in position 0
            if ($filled[$i*6] !== NULL){
                $tmp_syntax .= get_date_row($filled[$i*6]);
            }
            // The way the rows are retrieved from the form, the first row
            // also contains a valid debit transaction. Here, check if this
            // row is also a valid debit.
            if (isset($filled[($i*6)+1]) && $filled[($i*6)+1] !== 'Select...'
                && isset($filled[($i*6)+4]) && floatval($filled[($i*6)+4]) !== 0
                && $filled[($i*6)+5] === NULL){
                $tmp_syntax .= get_dr_cr_row($filled[($i*6)+1], $filled[($i*6)+4], 1);
            }
            // Now check if the current row is a valid credit. At most 2 of these
            // conditions should be satisfied. The first and second conditions
            // should be satisfied for the first row of the form. For each row
            // after the first, only one condition should be satisfied.
            if (isset($filled[($i*6)+1]) && $filled[($i*6)+1] !== 'Select...'
                && isset($filled[($i*6)+5]) && floatval($filled[($i*6)+5]) !== 0
                && $filled[($i*6)+4] === NULL){
                $tmp_syntax .= get_dr_cr_row($filled[($i*6)+1], $filled[($i*6)+5], 0);
            }
            // Now check if the current row is a valid description row
            if (isset($filled[($i*6)+1]) && $filled[($i*6)+1] !== 'Select...'
                && $filled[($i*6)+4] === NULL && $filled[($i*6)+5] === NULL){
                $tmp_syntax .= get_desc_row($filled[($i*6)+1]);
            }
        }
        $tmp_syntax .= "insert into Journal (AccountID,  [Date], [Desc], IsDebit, Amount) select AccountID,  [Date], [Desc], IsDebit, Amount from #tmp; ";
        if (!submit_query($tmp_syntax)){
            sqlsrv_rollback($dbConnection); 
            php_print(print_r( sqlsrv_errors(), true));
            $input_err = "Failed to submit a valid Journal Entry";
        }
        else{
            sqlsrv_commit($dbConnection);
        }
    }

    function get_desc_row($desc){
        return ("insert into #tmp (AccountID, [Desc], IsDebit, Amount) "
            . "values (1, '".escape_quotes($desc)."', 1, 0); ");
    }

    function get_dr_cr_row($acct_name, $amt, $is_debit){
        return ("insert into #tmp (AccountID, IsDebit, Amount) "
            . "select AccountID, ".(string)$is_debit.", ".$amt." "
            . "from Account where Name = '".escape_quotes($acct_name)."'; ");
    }

    function get_date_row($d){
        return ("insert into #tmp (AccountID, [Date], IsDebit, Amount) "
            . "values (1, '".($d)."', 1, 0); ");
    }

    function get_main_menu(){
        if ($_SESSION['level'] === 0){
            return 'http://test-mesbrook.cloudapp.net/mark_landing/adminpanel.php';
        }
        elseif ($_SESSION['level'] === 1){
            return 'http://test-mesbrook.cloudapp.net/mark_landing/controlpanel.php';
        }
        elseif ($_SESSION['level'] === 2){
            return 'http://test-mesbrook.cloudapp.net/mark_landing/controlpanel.php';
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
		
		<title>Journal Entry</title>

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

        <!-- Call the datepicker function when the date field is clicked -->
        <script type="text/javascript">
            $(function () {
                $('.datepicker').datepicker()
            });
        </script>

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

        <script type="text/javascript">
            var dr_ct = 2;
            var cr_ct = 2;
            var curr_row = 3;
            var last_dr_id = "debit_1";
            var last_cr_id = "credit_1";
        </script>

        <script type="text/javascript">

            $(document).ready(function(){
                $(".add_debit").click(function(){
                    var start_at = curr_row * 6;
                    var new_line = (
                        '<tr id="debit_' + (dr_ct) + '">' +
                            '<td class="t_date"></td>' +
                            '<td class="t_acct_title">' +
                                '<select name="i['+(start_at+1)+']" class="stored_val form-control debit_acct_name" id="acct_title" placeholder="Select Account">'+
                                    '<option>Select...</option>' +
                                    "'<?php echo gen_select_options(); ?>'" +
                                '</select>' +
                            '</td>' +
                            '<td class="t_src"></td>' +
                            '<td class="t_debit">' +
                                '<input name="i['+(start_at+4)+']"type="text" class="stored_val form-control dr_amt" placeholder="Amt">' +
                            '</td>' +
                            '<td class="t_credit"></td>' +
                            '<td class="t_action"></td>' +
                        '</tr>'
                    );
                    $(new_line).insertAfter("#"+last_dr_id);
                    last_dr_id = ("debit_" + dr_ct);
                    ++dr_ct;
                    ++curr_row;
                    inc_row_ct();
                });
                
                $(".add_credit").click(function(){
                    var start_at = curr_row * 6;
                    var new_line = (
                        '<tr id="credit_' + (cr_ct) + '">' +
                            '<td class="t_date"></td>' +
                            '<td class="t_acct_title">' +
                                '<select name="i['+(start_at+1)+']" class="stored_val form-control credit_acct_name" id="acct_title" placeholder="Select Account">'+
                                    '<option>Select...</option>' +
                                    "'<?php echo gen_select_options(); ?>'" +
                                '</select>' +
                            '</td>' +
                            '<td class="t_src"></td>' +
                            '<td class="t_debit"></td>' +
                            '<td class="t_credit">'+
                                '<input name="i['+(start_at+5)+']" type="text" class="stored_val form-control cr_amt" placeholder="Amt">' +
                            '</td>' +
                            '<td class="t_action"></td>' +
                        '</tr>'
                    );
                    $(new_line).insertAfter("#"+last_cr_id);
                    last_cr_id = ("credit_" + cr_ct);
                    ++cr_ct;
                    ++curr_row;
                    inc_row_ct();
                });
                /*
                $(".attempt_post").click(function(){
                    store_form_fields();
                });*/

                function store_form_fields(){
                    /*var elems = document.getElementsByClassName("stored_val");*/
                    var elems = document.body.getElementsByTagName("*");
                    var matching_elems = new Array();
                    var count = 0;
                    for (var elem in elems){
                        matching_elems.push(elem.id);
                    }
                    alert(matching_elems.join());
                }
            });

            function valid_fields(){
                var input_elems = document.forms["myForm"].getElementsByTagName("input");
                var select_elems = document.forms["myForm"].getElementsByTagName("select");
                var form = document.forms["myForm"];
                var matching_elems = new Array();
                var re = new RegExp("i\[[0-9]*\]");
                for (var elem in input_elems){
                    if (re.test(elem.toString())){
                        //matching_elems.push(elem.toString());
                        matching_elems.push(form[elem.toString()].value);
                    }
                }
                for (var elem in select_elems){
                    if (re.test(elem.toString())){
                        //matching_elems.push(elem.toString());  
                        matching_elems.push(form[elem.toString()].value);
                    }
                }
                alert(matching_elems.join());
                return false;
            }

            function inc_row_ct(){
                document.getElementById("row_ct").setAttribute("value", curr_row)
            }
            </script>
    </head>

    <body role="document">
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <img src="dist/images/AppDomainFinalProjectLogo.png"
                    alt="PAI Logo" height="30" width="30" class="logo-top nav"> 
                    <a class="navbar-brand" href="<?php echo get_main_menu(); ?>">Poly Accounting Information Group</a>
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
                                <li><a href="#">Transactions by Date Range</a></li>
                                <li><a href="http://test-mesbrook.cloudapp.net/ASP_NET/Journal%20and%20Ledger/General%20Journal">All Un-posted Transactions</a></li>
                                <li><a href="http://test-mesbrook.cloudapp.net/ASP_NET/Financial%20Statement/TrialBalance">Trial Balance</a></li>
                                <li><a href="http://test-mesbrook.cloudapp.net/ASP_NET/Financial%20Statement/IncomeStatement">Income Statement</a></li>
                                <li><a href="http://test-mesbrook.cloudapp.net/ASP_NET/Financial%20Statement/BalanceSheet.aspx">Balance Sheet</a></li>
                                <li><a href="http://test-mesbrook.cloudapp.net/ASP_NET/Financial%20Statement/OwnerEquityState">Statement of Owner's Equity</a></li>
                                <li><a href="#">Cash Flow Statement</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Record<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="http://test-mesbrook.cloudapp.net/journalentry.php">Journal Entry</a></li>
                                <li><a href="http://test-mesbrook.cloudapp.net/journalentry.php">Adjusting Entry</a></li>
                                <li><a href="http://test-mesbrook.cloudapp.net/journalentry.php">Closing Entry</a></li>
                            </ul>
                        </li>
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

        <div class="container">
            <form role="form"  name="myForm" method="post" onsubmit="return valid_fields()" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
            <div class="panel panel-primary col-centered form-group journalEntryPanel">
                <div class="panel-heading panel-heading-lg text-center">
                    <h3 class="panel-title panel-title-with-logo">General Journal</h3>
                </div>
                <div class="panel">
                <!-- Table -->
                    <table class="table" id="header_table">
                        <thead>
                            <tr>
                                <th class="t_date text-left">Date</th>
                                <th class="t_acct_title text-left">Account Title and Explanation</th>
                                <th class="t_src text-left">Src</th>
                                <th class="t_debit text-left">Debit</th>
                                <th class="t_credit text-left">Credit</th>
                                <th class="t_action text-left">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="panel" id="my_table_body">
                    <table class="table my_table">
                        <tbody id="debits">
                            <input type="number" value="3" id="row_ct" name="row_ct_for_php" style="visibility: hidden;"></input>
                            <tr id="debit_1">
                                <td class="t_date">
                                    <input type="text" name="i[0]" class="stored_val datepicker form-control" placeholder="Date">
                                </td>
                                <td class="t_acct_title">
                                    <div class="form-group">
                                        <div class='input-group input-ammend debit_acct_name' id='event-date'>
                                            <select name="i[1]" class="stored_val form-control" id="acct_title" placeholder="Select Account">
                                                <option>Select...</option>
                                                '<?php echo gen_select_options(); ?>'
                                            </select>
                                            <span class="add_debit input-group-addon btn">
                                                <span class="glyphicon glyphicon-plus"></span>
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="t_src"></td>
                                <td class="t_debit">
                                    <input name="i[4]" type="text" class="stored_val form-control" id="debit" placeholder="Amt">
                                </td>
                                <td class="t_credit"></td>
                                <td class="t_action">
                                    <button type="submit" id="attempt_post" class="attempt_post btn btn-primary form-control" name="submit">
                                        Submit
                                    </button>
                                </td>
                            </tr>
                            <tr id="credit_1">
                                <td class="t_date"></td>
                                <td class="t_acct_title">
                                    <div class="form-group">
                                        <div class='input-group input-ammend credit_acct_name' id='event-date'>
                                            <select name="i[7]" class="stored_val form-control" id="acct_title" placeholder="Select Account">
                                                <option>Select...</option>
                                                '<?php echo gen_select_options(); ?>'
                                            </select>
                                            <span class="add_credit input-group-addon btn">
                                                <span class="glyphicon glyphicon-plus"></span>
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="t_src"></td>
                                <td class="t_debit"></td>
                                <td class="t_credit">
                                    <input name="i[11]" type="text" class="stored_val form-control cr_amt" placeholder="Amt">
                                </td>
                                <td class="t_action"></td>
                            </tr>
                            <tr id="desc_1">
                                <td class="t_date"></td>
                                <td class="t_acct_title">
                                    <input name="i[13]" type="text" class="stored_val form-control trans_desc" id="trans_desc" placeholder="Description">
                                </td>
                                <td class="t_src">
                                    <div class="fileUpload btn btn-default form-control">
                                        <img src="dist/images/document_icon.png" alt="Source Doc" height="16" width="16" class="logo-je">
                                        <input name="img_1" type="file" class="upload">
                                    </div>
                                </td>
                                <td class="t_debit"></td>
                                <td class="t_credit"></td>
                                <td class="t_action">
                                    <button id="clear_entry" onClick="window.location.reload()" type="button" class="btn btn-danger form-control" name="clear">
                                        Clear
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>                
                <div class="panel-footer">
                <p class="error"><?php echo $input_err; ?></p>
                </div>
            </div>
            </form>
        </div>
    </body>

</html>
