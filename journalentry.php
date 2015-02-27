<?php
    include "dist/dbconnect.php";
    // Attempt to connect to the SQL Server Database
    //$dbConnection = db_connect();
    //$acct_names = get_acct_names();

    function get_acct_names(){
        global $dbConnection;
        $sql = "SELECT * FROM Account";
        $result = sqlsrv_query( $dbConnection, $sql );
        $output = array();
        while ($row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC) ){
            array_push($output, $row['Name']); 
        }
        return $output;
    }

    function gen_select_options(){
        $output = "<option>testing</option>";
        /*
        global $acct_names;
        $output = "";
        foreach ($acct_names as &$value){
            $output .= ("<option>".$value."</option>");
        }*/
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
        /* -- At this point we have all the field necessary for the insertion
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
        if (create_tmp_view($tmp_syntax)){
            for ($i = 0; $i < $row_ct; $i++){
                if ($filled[$i*6] !== NULL){
                     
                }
            }  
        }        
    }
     
    function create_tmp_view($input){
        global $dbConnection;
        $sql = $input;
        $result = sqlsrv_query( $dbConnection, $sql );
        if (!$result){
            return false;
        }
        return true;
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
