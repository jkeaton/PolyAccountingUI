<?php
    include "dist/dbconnect.php";
    include "dist/common.php";
    // Attempt to connect to the SQL Server Database
    $dbConnection = db_connect();
    $acct_names = get_acct_names();

    function get_acct_names(){
        global $dbConnection;
        $sql = "SELECT * FROM Account where IsActive = 1 "
                . "order by AccTypeID, SortOrder, AccNumber";
        $result = mssql_query( $sql, $dbConnection );
        $output = array();
        while ($row = mssql_fetch_array( $result, MSSQL_BOTH) ){
            array_push($output, $row['Name']); 
        }
        return $output;
    }

    function gen_select_options(){
        $output = "<option>testing</option>";
        global $acct_names;
        $output = "";
        foreach ($acct_names as &$value){
            $output .= ("<option>".$value."</option>");
        }
        return $output;
    }
    
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if (isset($_POST['submit'])) {
            validateFields();
        }
    }

    function validateFields(){
        insert_entry();
    }

    function insert_entry(){
        global $dbConnection;
        // Start a transaction so we can rollback if something fails
        mssql_begin_transaction();
        $test = $_POST['i'];
        $row_ct = $_POST["row_ct_for_php"];
        $filled = new SplFixedArray($row_ct*6);
        foreach ($filled as $val){
            $val = NULL;
        }
        //echo "<p>Size: ".count($test)."<p><br/><p>Total Max: ".($row_ct*6)."</p><br/>";
        foreach ($test as $key => $value){
            $filled[$key] = $value;
        }
        // -- At this point we have all the fields necessary for the insertion
        /*
        foreach ($filled as $key => $value){
            echo "<p>i[".$key."] => ".$value."</p>";
        }*/
        $tmp_syntax = 'Create table #tmp ([page] int null,'
            . '[Entry] int null,'
            . '[Date] datetime null,'
            . 'PostDate datetime null,'
            . 'Name varchar(150) null,'
            . '[Ref#] int null,'
            . '[Desc] varchar(150) null,'
            . 'Amount money not null,'
            . 'IsDebit bit not null,'
            . 'AccountID int not null)';
        if (!submit_query($tmp_syntax)){
            mssql_rollback();
        }
        for ($i = 0; $i < $row_ct; $i++){
            // First check if this is a row with a valid date in position 0
            if ($filled[$i*6] !== NULL){
                $tmp_syntax = get_date_row($filled[$i*6]);
                if (!submit_query($tmp_syntax)){
                    mssql_rollback();
                }
            }
            // The way the rows are retrieved from the form, the first row
            // also contains a valid debit transaction. Here, check if this
            // row is also a valid debit.
            if (isset($filled[($i*6)+1]) && $filled[($i*6)+1] !== 'Select...'
                && isset($filled[($i*6)+4]) && floatval($filled[($i*6)+4]) !== 0
                && $filled[($i*6)+5] === NULL){
                $tmp_syntax = get_dr_cr_row($filled[($i*6)+1], $filled[($i*6)+4], 1);
                if (!submit_query($tmp_syntax)){
                    mssql_rollback();
                }
            }
            // Now check if the current row is a valid credit. At most 2 of these
            // conditions should be satisfied. The first and second conditions
            // should be satisfied for the first row of the form. For each row
            // after the first, only one condition should be satisfied.
            if (isset($filled[($i*6)+1]) && $filled[($i*6)+1] !== 'Select...'
                && isset($filled[($i*6)+5]) && floatval($filled[($i*6)+5]) !== 0
                && $filled[($i*6)+4] === NULL){
                $tmp_syntax = get_dr_cr_row($filled[($i*6)+1], $filled[($i*6)+5], 0);
                if (!submit_query($tmp_syntax)){
                    mssql_rollback();
                }
            }
            // Now check if the current row is a valid description row
            if (isset($filled[($i*6)+1]) && $filled[($i*6)+1] !== 'Select...'
                && $filled[($i*6)+4] === NULL && $filled[($i*6)+5] === NULL){
                $tmp_syntax = get_desc_row($filled[($i*6)+1]);
                if (!submit_query($tmp_syntax)){
                    mssql_rollback();
                }
            }
        }
        $tmp_syntax = "insert into Journal select * from #tmp ";
        if (!submit_query($tmp_syntax)){
            mssql_rollback();
        }

        $tmp_syntax = "truncate table #tmp";
        if (!submit_query($tmp_syntax)){
            mssql_rollback();
        }
    }

    function get_desc_row($desc){
        return ("insert into #tmp (AccountID, [Desc], IsDebit, Amount) "
            . "values (1, '".$desc."', 1, 0)");
    }

    function get_dr_cr_row($acct_name, $amt, $is_debit){
        return ("insert into #tmp (AccountID, IsDebit, Amount) "
            . "select AccountID, ".(string)$is_debit.", ".$amt." "
            . "from Account where Name = '".$acct_name."'");
    }

    function get_date_row($d){
        return ('insert into #tmp (AccountID, [Date], IsDebit, Amount) '
            . 'values (1, '.($d).', 1, 0)');
    }
     
    function submit_query($sql){
        global $dbConnection;
        $result = mssql_query( $dbConnection, $sql );
        if (!$result){
            return false;
        }
        return $result;
    }
?>

<!DOCTYPE html>
<html lang="en">
	<head id="my_header">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Journal Entry</title>

        <!-- Reloadable Style Sheets -->
        <link href="dist/css/bootstrap.min.css" rel="stylesheet" class="reloadable">
        <link href="dist/css/custom.css" rel="stylesheet" class="reloadable">
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet" class="reloadable">

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

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

        <script type="text/javascript">

            $(document).ready(function(){
                $(".add_debit").click(function(){
                    var start_at = curr_row * 6;
                    var new_line = (
                        '<tr id="debit_' + (dr_ct) + '">' +
                            '<td class="t_date"></td>' +
                            '<td class="t_acct_title">' +
                                '<select name="i['+(start_at+1)+']" class="form-control debit_acct_name" id="acct_title" placeholder="Select Account">'+
                                    '<option>Select...</option>' +
                                    '<?php echo gen_select_options(); ?>' +
                                '</select>' +
                            '</td>' +
                            '<td class="t_src">' +
                                '<div class="fileUpload btn btn-default form-control">' +
                                    '<img src="dist/images/document_icon.png" alt="Source Doc" height="16" width="16" class="logo">' +
                                    '<input name="img_'+curr_row+'"type="file" class="upload">' +
                                '</div>' +
                            '</td>' +
                            '<td class="t_ref">' +
                                '<input name="i['+(start_at+3)+']"type="text" class="form-control" id="ref" placeholder="Ref">' +
                            '</td>' +
                            '<td class="t_debit">' +
                                '<input name="i['+(start_at+4)+']"type="text" class="form-control dr_amt" placeholder="Amt">' +
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
                                '<select name="i['+(start_at+1)+']" class="form-control credit_acct_name" id="acct_title" placeholder="Select Account">'+
                                    '<option>Select...</option>' +
                                    '<?php echo gen_select_options(); ?>' +
                                '</select>' +
                            '</td>' +
                            '<td class="t_src">' +
                                '<div class="fileUpload btn btn-default form-control">' +
                                    '<img src="dist/images/document_icon.png" alt="Source Doc" height="16" width="16" class="logo">' +
                                    '<input name="img_'+curr_row+'" type="file" class="upload">' +
                                '</div>' +
                            '</td>' +
                            '<td class="t_ref">' +
                                '<input name="i['+(start_at+3)+']" type="text" class="form-control" placeholder="Ref">' +
                            '</td>' +
                            '<td class="t_debit"></td>' +
                            '<td class="t_credit">'+
                                '<input name="i['+(start_at+5)+']" type="text" class="form-control cr_amt" placeholder="Amt">' +
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
                
            });

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
                    <a class="navbar-brand" href="#">Poly Accounting Information Group</a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="index.php">Log Out</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    
		<!--main
		================================================== -->
        <div class="container">
            <form role="form"  method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
            <div class="panel panel-primary col-centered form-group journalEntryPanel">
                <div class="panel-heading text-center">
                    <h3 class="panel-title">General Journal</h3>
                </div>
                <div class="panel">
                <!-- Table -->
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="t_date">Date</th>
                                <th class="t_acct_title">Account Title and Explanation</th>
                                <th class="t_src">Src</th>
                                <th class="t_ref">Ref</th>
                                <th class="t_debit">Debit</th>
                                <th class="t_credit">Credit</th>
                                <th class="t_action">Action</th>
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
                                    <input type="text" name="i[0]" class="form-control" id="date" placeholder="Date">
                                </td>
                                <td class="t_acct_title">
                                    <div class="form-group">
                                        <div class='input-group input-ammend debit_acct_name' id='event-date'>
                                            <select name="i[1]" class="form-control" id="acct_title" placeholder="Select Account">
                                                <option>Select...</option>
                                                '<?php echo gen_select_options(); ?>'
                                            </select>
                                            <span class="add_debit input-group-addon btn">
                                                <span class="glyphicon glyphicon-plus"></span>
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="t_src">
                                    <div class="fileUpload btn btn-default form-control">
                                        <img src="dist/images/document_icon.png" alt="Source Doc" height="16" width="16" class="logo">
                                        <input name="img_0" type="file" class="upload">
                                    </div>
                                </td>
                                <td class="t_ref">
                                    <input name="i[3]" type="text" class="form-control" id="ref" placeholder="Ref">
                                </td>
                                <td class="t_debit">
                                    <input name="i[4]" type="text" class="form-control" id="debit" placeholder="Amt">
                                </td>
                                <td class="t_credit"></td>
                                <td class="t_action">
                                    <button id="clear_entry" onClick="window.location.reload()" type="button" class="btn btn-danger form-control" name="clear">
                                        Clear
                                    </button>
                                </td>
                            </tr>
                            <tr id="credit_1">
                                <td class="t_date"></td>
                                <td class="t_acct_title">
                                    <div class="form-group">
                                        <div class='input-group input-ammend credit_acct_name' id='event-date'>
                                            <select name="i[7]" class="form-control" id="acct_title" placeholder="Select Account">
                                                <option>Select...</option>
                                                '<?php echo gen_select_options(); ?>'
                                            </select>
                                            <span class="add_credit input-group-addon btn">
                                                <span class="glyphicon glyphicon-plus"></span>
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="t_src">
                                    <div class="fileUpload btn btn-default form-control">
                                        <img src="dist/images/document_icon.png" alt="Source Doc" height="16" width="16" class="logo">
                                        <input name="img_1" type="file" class="upload">
                                    </div>
                                </td>
                                <td class="t_ref">
                                    <input name="i[9]" type="text" class="form-control" id="ref" placeholder="Ref">
                                </td>
                                <td class="t_debit"></td>
                                <td class="t_credit">
                                    <input name="i[11]" type="text" class="form-control cr_amt" placeholder="Amt">
                                </td>
                                <td class="t_action"></td>
                            </tr>
                            <tr id="desc_1">
                                <td class="t_date"></td>
                                <td class="t_acct_title">
                                    <input name="i[13]" type="text" class="form-control trans_desc" id="trans_desc" placeholder="Description">
                                </td>
                                <td class="t_src"></td>
                                <td class="t_ref"></td>
                                <td class="t_debit"></td>
                                <td class="t_credit"></td>
                                <td class="t_action">
                                    <button type="submit" id="attempt_post"class="btn btn-primary form-control" name="submit">
                                        Submit
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>                
            </div>
            </form>
        </div>

    </body>

</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="dist/js/bootstrap.min.js"></script>
