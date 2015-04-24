<?php
    session_start();
    include "dist/dbconnect.php";
    include "dist/common.php";
	bounce();

    // Attempt to connect to the database using current user's credentials
    $dbConnection = db_connect($_SESSION['db_uid'], $_SESSION['db_pass']);

    $acct_names = get_acct_names();
    $inbox = get_inbox($_SESSION['user'], $dbConnection);
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

    function get_acct_names(){
        global $dbConnection;
        $sql = "SELECT * FROM Account where IsActive = 1 "
                . "order by AccTypeID, SortOrder, AccNumber";
        $result = sqlsrv_query($dbConnection, $sql);
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
            if(isset($_POST['next_url'])){
                $next = $_POST['next_url'];
                $_POST = array();
                insert_entry($num_rows);
                header('Location: '.$next);
            }
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
        // Also here, ensure we're not checking the description
        if ($filled[$index] == "Select..." && $index != 13){
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
        global $filled, $input_err, $dbConnection;
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
        if (!submit_query($tmp_syntax, $dbConnection)){
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
            var filled = new Array();
            var either_dr_or_cr = 0;
            var dr_rows = [0];
            var cr_rows = [1];
            var error_set = false;
            var dr_amt = 0.0;
            var cr_amt = 0.0;
            var debited_accts = new Array();
            var credited_accts = new Array();
            var precise_unselected_field = 0;
            var precise_invalid_amt = 0;
            var precise_negative_amt = 0;
            var precise_empty_amt = 0;
            var precise_intersection_acct = 0;
            var precise_duplicate_acct = 0;
            var fields_with_backgrounds = new Array();
            // List the errors by priority. The ones that will be displayed are the ones closest to the top of the list.
            var list_of_errors = [
                "Please enter a date",
                "Date is invalid",
                "For each debit and credit row, please select an account from the dropdown menu",
                "The same account cannot be both debited and credited",
                "An account can only be used once per entry",
                "For each debit or credit row, please enter the amount debited or credited",
                "Debit amount is invalid, some examples of valid amounts are '500', '230.4', '1999.99', '.50' , and '300.'",
                "Credit amount is invalid, some examples of valid amounts are '500', '230.4', '1999.99', '.50' , and '300.'",
                "All amounts must be greater than 0.00",
                "Total debits do not equal total credits"
            ];
            var selected_err = list_of_errors.length;
            var highlighted_field = 0; // default to first form field
            var selected_accts = new Array();
            var unselected_field_unset = true;
            var invalid_amt_field_unset = true;
            var negative_amt_field_unset = true;

        </script>

        <script type="text/javascript">

            $(document).ready(function(){
                $(".add_debit").click(function(){
                    dr_rows.push(curr_row);
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
                                '<input name="i['+(start_at+4)+']"type="text" class="stored_val form-control dr_amt" placeholder="0.00">' +
                            '</td>' +
                            '<td class="t_credit"></td>' +
                        '</tr>'
                    );
                    $(new_line).insertAfter("#"+last_dr_id);
                    last_dr_id = ("debit_" + dr_ct);
                    ++dr_ct;
                    ++curr_row;
                    inc_row_ct();
                });
                
                $(".add_credit").click(function(){
                    cr_rows.push(curr_row);
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
                                '<input name="i['+(start_at+5)+']" type="text" class="stored_val form-control cr_amt" placeholder="0.00">' +
                            '</td>' +
                        '</tr>'
                    );
                    $(new_line).insertAfter("#"+last_cr_id);
                    last_cr_id = ("credit_" + cr_ct);
                    ++cr_ct;
                    ++curr_row;
                    inc_row_ct();
                });
            });

            function valid_fields(){
                var input_elems = document.forms["myForm"].getElementsByTagName("input");
                var select_elems = document.forms["myForm"].getElementsByTagName("select");
                var form = document.forms["myForm"];
                var re = new RegExp("i\[[0-9]*\]");
                set_filled(); // Get the array ready to be set with the form field values
                // Reset error so we pick the right one to display after validation
                selected_err = list_of_errors.length;
                // Reset the counter ensuring they enter all amount fields
                either_dr_or_cr = 0;
                // Reset the debited and credited account lists
                debited_accts = new Array();
                credited_accts = new Array();
                // Reset the fields with backgrounds
                fields_with_backgrounds = new Array();
                // Reset some other variables
                precise_unselected_field = 0;
                precise_invalid_amt = 0;
                precise_negative_amt = 0;
                precise_empty_amt = 0;
                highlighted_field = 0;
                precise_intersection_acct = 0;
                precise_duplicate_acct = 0;
                selected_accts = new Array();
                unselected_field_unset = true;
                invalid_amt_field_unset = true;
                negative_amt_field_unset = true;

                for (var elem in input_elems){
                    if (re.test(elem.toString())){
                        set_index(elem.toString(), form);
                        fields_with_backgrounds.push(elem.toString());
                    }
                }
                for (var elem in select_elems){
                    if (re.test(elem.toString())){
                        set_index(elem.toString(), form);
                        fields_with_backgrounds.push(elem.toString());
                        var acct = new Account(form[elem.toString()].value, elem.toString());
                        selected_accts.push(acct);
                    }
                }
                // At this point, the 'filled' array has been set with the values of the form fields
                make_fields_white();
                submit_form = false;
                if (!valid(document.getElementById("row_ct").value)){
                    document.getElementById("error_msg").style.color = "#FF0000";
                    if (selected_err < list_of_errors.length){
                        document.getElementById("error_msg").innerHTML = list_of_errors[selected_err];
                    }
                    else {
                        document.getElementById("error_msg").innerHTML = "Unhandled error";
                    }
                    highlight_field(form);
                }
                else{
                    document.getElementById("error_msg").style.color = "#009900";
                    document.getElementById("error_msg").innerHTML = "Success!";
                    // Just show where we would go on successful submission, based on which button was pressed
                    submit_form = true;
                }
                return submit_form;
            }

            function my_pause(){
                setTimeout(function() { alert("Hello"); }, 2000);
                return 0;
            }

            function Account(name, field){
                this.name = name;
                this.field = field;
            }

            function make_fields_white(){
                for (i = 0; i < fields_with_backgrounds.length; i++){
                    document.forms["myForm"][fields_with_backgrounds[i]].style.backgroundColor = "#FFFFFF";
                }
                return 0;
            }

            function highlight_field(f){
                var field_name = ("i[".concat(highlighted_field.toString()).concat("]"));
                document.forms["myForm"][field_name].style.backgroundColor = "#FFCCCC";
                document.forms["myForm"][field_name].focus();
                return 0;
            }

            function get_index_from_fname(fname){
                var pos1 = fname.indexOf("[");
                var pos2 = fname.indexOf("]");
                var index = fname.substring(pos1+1, pos2);
                return index;
            }

            function valid(row_ct){
                var err_ct = 0;
                var precise_empty_field_set = false;
                dr_amt = 0;
                cr_amt = 0;
                // First Check the Date
                err_ct += valid_date(0);
                // Now Check the Rest
                for (i = 0; i < row_ct; i++){
                    for (j = 0; j < 6; j++){
                        if (j == 1){
                            err_ct += valid_acct_title((i*6)+j);  
                        }
                        // Row with index 2 is always the description line
                        // Extra rows that are added enter the array in groups of 6
                        // starting at index 18...
                        if (4 <= j && j <= 5 && i != 2){
                            if (j == 4){
                                err_ct += valid_monetary_amt((i*6)+j, true);
                            }
                            else{
                                if (j == 5){
                                    err_ct += valid_monetary_amt((i*6)+j, false);
                                }
                            }
                        }
                    }

                    if (either_dr_or_cr != 0){
                        err_ct++;
                        if (!precise_empty_field_set){
                            if (isInArray(i, dr_rows)){
                                precise_empty_amt = (i*6)+4;  
                            }
                            else{
                                precise_empty_amt = (i*6)+5;  
                            }
                            precise_empty_field_set = true;
                        }
                        set_error(5);
                        either_dr_or_cr = 0;
                    }
                } 
                   
                if (intersection_exists(debited_accts, credited_accts)){
                    set_error(3);
                    err_ct++;
                }

                if (duplicates_exist(debited_accts) || duplicates_exist(credited_accts)){
                    set_error(4);
                    err_ct++;
                }

                if (dr_amt != cr_amt){
                    set_error(9);
                    err_ct++;
                }
        
                return (err_ct == 0);
            }

            function intersection_exists(a1, a2){
                if (a1.length == 0 || a2.length == 0 || !a1 || !a2){
                    return false;
                }
                else {
                    intersection = a1.filter(
                        function(n) {
                            return a2.indexOf(n) != -1;
                        }
                    );
                    if (intersection.length > 0){
                        for (i = 0; i < selected_accts.length; i++){
                            if (selected_accts[i].name == intersection[0]){
                                field_name = selected_accts[i].field;
                                precise_intersection_acct = get_index_from_fname(field_name);
                                break;
                            }
                        }
                        return true;
                    }
                    else {
                        return false;
                    }

                }
            }

            function duplicates_exist(arr){
                // There can be no duplicates if the size of the array is 0
                if (arr.length == 0 || !arr){
                    return false;
                }
                else {
                    var tmp = new Array();
                    for (i = 0; i < arr.length; i++){
                        // For some reason, firefox is mad at this method. We need to find out how to make it work in firefox
                        if (arr[i]){ 
                            if (tmp.indexOf(arr[i].toString()) == -1){
                                tmp.push(arr[i].toString());
                            }
                            else {
                                for (j = 0; j < selected_accts.length; j++){
                                    if (selected_accts[j].name == arr[i].toString()){
                                        field_name = selected_accts[j].field;
                                        precise_duplicate_acct = get_index_from_fname(field_name);
                                        break;
                                    }
                                }
                                return true;
                            }
                        }
                    }
                    return false;
                }
            }

            function valid_date(index){
                var date_str = filled[index];
                if (!date_str){
                    set_error(0);
                    return 1;
                }
                // First check for the pattern
                if(!/^\d{1,2}\/\d{1,2}\/\d{4}$/.test(date_str)){
                    set_error(1);
                    return 1;
                }

                // Parse the date parts to integers
                var parts = date_str.split("/");
                var day = parseInt(parts[1], 10);
                var month = parseInt(parts[0], 10);
                var year = parseInt(parts[2], 10);

                // Check the ranges of month and year
                if(year < 1000 || year > 3000 || month == 0 || month > 12){
                    set_error(1);
                    return 1;
                }

                var monthLength = [ 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ];

                // Adjust for leap years
                if(year % 400 == 0 || (year % 100 != 0 && year % 4 == 0)){
                    monthLength[1] = 29;
                }

                // Check the range of the day
                if (!(day > 0 && day <= monthLength[month - 1])){
                    set_error(1);
                    return 1;
                }
                else{
                    return 0;
                }
            }

            function valid_acct_title(index){
                // Ensure we're not checking the description
                if (filled[index] == "Select..." && index != 13){
                    set_error(2);
                    if (unselected_field_unset){
                        precise_unselected_field = index;
                        unselected_field_unset = false;
                    }
                    return 1;
                }
                else {
                    // debited_accts and credited_accts only grow by adding valid account names.
                    // when the selected option is still "Select..." this string is not added to these
                    // arrays.
                    if (isInArray(Math.floor(index/6), dr_rows)){
                        debited_accts.push(filled[index]);        
                    }
                    else {
                        if (isInArray(Math.floor(index/6), cr_rows)){
                            credited_accts.push(filled[index]);
                        }
                    }
                    return 0;
                }
            }

            function valid_monetary_amt(index, dr){
                var money_re = new RegExp("^[0-9]*\.{0,1}[0-9]{0,2}$");
                var negative_money_re = new RegExp("^-{0,1}[0-9]*\.{0,1}[0-9]{0,2}$");
                var isDebit = true;
                if (!filled[index]) {
                    // Make sure we're not checking the description line
                    if (index < 12 || index > 17){
                        either_dr_or_cr--;
                    }
                    return 0;
                } 
                else {
                    // Make sure we're not checking the description line
                    if (index < 12 || index > 17){
                        either_dr_or_cr++;
                    }
                    // Determine if this row is a debit or credit row
                    if (isInArray(Math.floor(index/6), dr_rows)){
                        isDebit = true;       
                    }
                    else {
                        if (isInArray(Math.floor(index/6), cr_rows)){
                            isDebit = false;
                        }
                    }
                    // Find out if the value is a valid monetary amount
                    if (!negative_money_re.test(filled[index])){
                        if (invalid_amt_field_unset){
                            precise_invalid_amt = index;
                            if (isDebit) {
                                set_error(6);
                            }
                            else {
                                set_error(7);
                            }
                            invalid_amt_field_unset = false;
                        }
                        return 1;
                    }
                    // Now determine if the amount is greater than 0.00,
                    else{
                        if (!money_re.test(filled[index]) || parseFloat(filled[index]) <= 0.00){
                            if (negative_amt_field_unset){
                                precise_negative_amt = index;
                                set_error(8);
                                negative_amt_field_unset = false;
                            }
                            return 1;
                        }
                        else {
                            if (dr) {
                                dr_amt += parseFloat(filled[index]);
                            }
                            else {
                                cr_amt += parseFloat(filled[index]);
                            }
                            return 0;
                        }
                    }
                }
            }

            function set_error(num){
                selected_err = Math.min(num, selected_err);
                if (selected_err == 0 || selected_err == 1){
                    // Set it to the date field
                    highlighted_field = 0;
                }
                else if(selected_err == 2){
                    // Set it to the unselected account title field
                    highlighted_field = precise_unselected_field;
                }
                else if(selected_err == 3){
                    // Set it to the first account listed in the intersection of debited and credited accounts
                    highlighted_field = precise_intersection_acct;
                }
                else if(selected_err == 4){
                    // Set it to the first account selection that is duplicated
                    highlighted_field = precise_duplicate_acct;
                }
                else if(selected_err == 5){
                    // Set it to the empty amount field
                    highlighted_field = precise_empty_amt;
                }
                else if(selected_err == 6 || selected_err == 7){
                    // Set it to the field that has an invalid amount
                    highlighted_field = precise_invalid_amt;
                }
                else if(selected_err == 8){
                    // Set it to the field with the negative amount
                    highlighted_field = precise_negative_amt;
                }
                else if(selected_err == 9){
                    // Set it to the first debit amount field
                    highlighted_field = 4;
                }
            }

            function isInArray(val, arr){
                return (arr.indexOf(val) > -1);
            }

            /**
             * Function that takes in the name of a form field, parses it's index
             * and uses that index to set the correct index in the 'filled' array
             */
            function set_index(n, f) {
                var pos1 = n.indexOf('[');
                var pos2 = n.indexOf(']');
                var index = parseInt(n.substring(pos1+1, pos2));
                filled[index] = (f[n].value).trim();
            }

            function set_filled(){
                var len = (document.getElementById("row_ct").value * 6);
                filled = new Array(len);    
                for (var i = 0; i < len; ++i){
                    filled[i] = null;
                }
            }

            function inc_row_ct(){
                document.getElementById("row_ct").setAttribute("value", curr_row);
            }

            function set_next_url(url){
                document.getElementById("next_url").setAttribute("value", url);
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
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Record<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="http://test-mesbrook.cloudapp.net/journalentry.php">Journal Entry</a></li>
                                <li><a href="http://test-mesbrook.cloudapp.net/closing_or_adjusting_journal_entry.php">Adjusting Entry</a></li>
                                <li><a href="http://test-mesbrook.cloudapp.net/closing_or_adjusting_journal_entry.php">Closing Entry</a></li>
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
            <form role="form"  id="myForm" name="myForm" method="post" onsubmit="return valid_fields()" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
            <div class="panel panel-primary col-centered form-group journalEntryPanel">
                <div class="panel-heading panel-heading-lg text-center">
                    <h3 class="panel-title">Poly Accounting Information Group</h3>
                    <h3 class="panel-title">General Journal</h3>
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
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="panel" id="my_table_body">
                    <table class="table my_table">
                        <tbody id="debits">
                            <input type="number" value="3" id="row_ct" name="row_ct_for_php" style="visibility: hidden;"></input>
                            <input type="text" value="" id="next_url" name="next_url" style="visibility: hidden;"></input>
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
                                    <input name="i[4]" type="text" class="stored_val form-control" id="debit" placeholder="0.00">
                                </td>
                                <td class="t_credit"></td>
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
                                    <input name="i[11]" type="text" class="stored_val form-control cr_amt" placeholder="0.00">
                                </td>
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
                            </tr>
                        </tbody>
                    </table>
                </div>                
                <div class="panel-footer text-center">
                    <p id="error_msg" class="error"></p>
                    <div class="form-group" role="group">
                        <button type="submit" id="attempt_post" onClick="set_next_url('http://test-mesbrook.cloudapp.net/ASP_NET/Journal%20and%20Ledger/UnpostTranx');" class="attempt_post btn btn-success" name="submit">
                            Save & Exit
                        </button>
                        <button type="submit" id="attempt_post_2" onClick="set_next_url('http://test-mesbrook.cloudapp.net/journalentry.php');" class="attempt_post btn btn-success" name="submit">
                            Save & New
                        </button>
                        <button id="clear_entry" onClick="window.location.reload()" type="button" class="btn btn-danger" name="clear">
                            Clear
                        </button>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </body>

</html>
