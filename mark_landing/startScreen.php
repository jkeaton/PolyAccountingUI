<?php
    session_start();
    include "dist/dbconnect.php";
    include "dist/common.php";
	bounce();
    // Attempt to connect to the SQL Server Database
    $dbConnection = db_connect();
?>

<!DOCTYPE html>
<html>
    
    <head>
        <title>
            startScreen
        </title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!--<meta name="format-detection" content="telephone=no">
        <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <meta name="msapplication-tap-highlight" content="no">-->
        <link href="files/resources/lib/theme/jqm/jqm.css" rel="stylesheet" />
        <link href="files/resources/lib/theme/flat-ui/flat-ui.css" rel="stylesheet" />
        <link href="files/resources/lib/jquerymobile/1.4.4/jquery.mobile.structure-1.4.4.css"
        rel="stylesheet" />
        <script type="text/javascript" src="files/resources/lib/underscore/underscore.js">
        </script>
        <script type="text/javascript" src="files/resources/lib/store/json2.js">
        </script>
        <script type="text/javascript" src="files/resources/lib/jquery/jquery-2.1.1.js">
        </script>
        <!--<script type="text/javascript">
                    $(document).bind("mobileinit", function()
            {
                if (navigator.userAgent.toLowerCase().indexOf("android") != -1)
                {
                    $.mobile.defaultPageTransition = 'none';
                    $.mobile.defaultDialogTransition = 'none';
                }
                else if (navigator.userAgent.toLowerCase().indexOf("msie") != -1)
                {
                    $.mobile.allowCrossDomainPages = true;
                    $.support.cors = true;
                }
            });
        </script>-->
        <script type="text/javascript" src="files/resources/lib/jquerymobile/1.4.4/jquery.mobile-1.4.4.js">
        </script>
        <script type="text/javascript" src="files/resources/js/mobilebase.js">
        </script>
        <script type="text/javascript" src="files/resources/lib/event/customEventHandler.js">
        </script>
        <script type="text/javascript" src="files/resources/lib/base/sha1.js">
        </script>
        <script type="text/javascript" src="files/resources/lib/base/oauth.js">
        </script>
        <script type="text/javascript" src="files/resources/lib/base/contexts.js">
        </script>
        <script type="text/javascript" src="files/resources/lib/base/jquery.xml2json.min.js">
        </script>
        <script type="text/javascript" src="files/resources/lib/base/appery.js">
        </script>
        <script type="text/javascript" src="files/resources/lib/base/component-manager.js">
        </script>
        <script type="text/javascript" src="files/resources/lib/base/mapping-impl.js">
        </script>
        <script type="text/javascript" src="files/resources/lib/base/entity-api.js">
        </script>
        <script type="text/javascript" src="files/resources/lib/base/storage-api.js">
        </script>
        <script type="text/javascript" src="files/resources/lib/get_target_platform.js">
        </script>
        <script type="text/javascript" src="files/resources/lib/cordova.js">
        </script>
        <link href="files/resources/css/mobilebase.css" rel="stylesheet" type="text/css"
        />
        <script type="text/javascript" src="files/views/assets/js/services/model.js">
        </script>
        <script type="text/javascript" src="files/views/assets/js/services/service.js">
        </script>
    </head>
    
    <body>
        <script language="JavaScript" type="text/javascript">
                
        </script>
        <div data-role="page" style="min-height:480px;" dsid="startScreen" id="startScreen"
        class="type-interior" data-theme="b">
            <!-- mobilecontainer -->
            <div data-role="content" id="startScreen_mobilecontainer" name="mobilecontainer"
            class="startScreen_mobilecontainer ui-content" dsid="mobilecontainer" data-theme="b">
                <link href="startScreen.css" rel="stylesheet" type="text/css" />
                <script type="text/javascript" src="startScreen.js">
                </script>
                <!-- spacer_29 -->
                <div id="startScreen_spacer_29" data-role="appery_spacer" dsid="spacer_29" class='mobilespacer startScreen_spacer_29'>
                </div>
                <!-- mobilegrid_21 -->
                <div class="startScreen_mobilegrid_21_wrapper" data-wrapper-for="mobilegrid_21">
                    <table id="startScreen_mobilegrid_21" class="startScreen_mobilegrid_21" dsid="mobilegrid_21"
                    name="mobilegrid_21" cellpadding=0 cellspacing=0>
                        <col style="width:auto;" />
                        <tr class="startScreen_mobilegrid_21_row_0">
                            <!-- mobilegridcell_22 -->
                            <td id="startScreen_mobilegridcell_22" name="mobilegridcell_22" class="startScreen_mobilegridcell_22"
                            colspan=1 rowspan=1>
                                <div class="cell-wrapper">
                                    <!-- mobilegrid_30 -->
                                    <div class="startScreen_mobilegrid_30_wrapper" data-wrapper-for="mobilegrid_30">
                                        <table id="startScreen_mobilegrid_30" class="startScreen_mobilegrid_30" dsid="mobilegrid_30"
                                        name="mobilegrid_30" cellpadding=0 cellspacing=0>
                                            <col style="width:auto;" />
                                            <col style="width:auto;" />
                                            <col style="width:auto;" />
                                            <tr class="startScreen_mobilegrid_30_row_0">
                                                <!-- mobilegridcell_31 -->
                                                <td id="startScreen_mobilegridcell_31" name="mobilegridcell_31" class="startScreen_mobilegridcell_31"
                                                colspan=1 rowspan=1>
                                                    <div class="cell-wrapper">
                                                        <!-- label_software_name -->
														<div class="navbar-header">
															<img src="../dist/images/AppDomainFinalProjectLogo.png"
															alt="PAI Logo" height="30" width="30" class="logo-top nav"> 
															<a class="navbar-brand" href="#">Poly Accounting Information Group</a>
														</div>
                                                        <!--<div name="label_software_name" id="startScreen_label_software_name" dsid="label_software_name"
                                                        data-role="appery_label" class="startScreen_label_software_name">
                                                            Poly Accounting
                                                        </div>-->
                                                    </div>
                                                </td>
                                                <!-- mobilegridcell_32 -->
                                                <td id="startScreen_mobilegridcell_32" name="mobilegridcell_32" class="startScreen_mobilegridcell_32"
                                                colspan=1 rowspan=1>
                                                    <div class="cell-wrapper">
                                                        <!-- label_welcome -->
                                                        <div name="label_welcome" id="startScreen_label_welcome" dsid="label_welcome" data-role="appery_label"
                                                        class="startScreen_label_welcome">
                                                            Welcome ...
                                                        </div>
                                                    </div>
                                                </td>
                                                <!-- mobilegridcell_35 -->
                                                <td id="startScreen_mobilegridcell_35" name="mobilegridcell_35" class="startScreen_mobilegridcell_35"
                                                colspan=1 rowspan=1>
												<div class="navbar-collapse collapse">
													<ul class="nav navbar-nav navbar-right">
													<form role="form" class="navbar-form navbar-nav" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
														<button type="submit" class="btn btn-danger" name="logout">Log Out</button>
													</form>
													</ul>
												</div>
                                                    <!--<div class="cell-wrapper">
                                                        <!-- btn_logout --><!--
                                                        <a data-role="button" name="btn_logout" dsid="btn_logout" class="startScreen_btn_logout"
                                                        id="startScreen_btn_logout" data-corners="true" data-icon="none" data-iconpos='nowhere'
                                                        x-apple-data-detectors="false" data-mini="false" data-theme="b" tabindex="6">
                                                        Log Out
                                                        </a>
                                                    </div>-->
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="startScreen_mobilegrid_21_row_1">
                            <!-- mobilegridcell_24 -->
                            <td id="startScreen_mobilegridcell_24" name="mobilegridcell_24" class="startScreen_mobilegridcell_24"
                            colspan=1 rowspan=1>
                                <div class="cell-wrapper">
                                    <!-- mobilegrid_38 -->
                                    <div class="startScreen_mobilegrid_38_wrapper" data-wrapper-for="mobilegrid_38">
                                        <table id="startScreen_mobilegrid_38" class="startScreen_mobilegrid_38" dsid="mobilegrid_38"
                                        name="mobilegrid_38" cellpadding=0 cellspacing=0>
                                            <col style="width:auto;" />
                                            <tr class="startScreen_mobilegrid_38_row_0">
                                                <!-- mobilegridcell_39 -->
                                                <td id="startScreen_mobilegridcell_39" name="mobilegridcell_39" class="startScreen_mobilegridcell_39"
                                                colspan=1 rowspan=1>
                                                    <div class="cell-wrapper">
                                                        <!-- label_view -->
                                                        <div name="label_view" id="startScreen_label_view" dsid="label_view" data-role="appery_label"
                                                        class="startScreen_label_view">
                                                            View
                                                        </div>														
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="startScreen_mobilegrid_38_row_1">
                                                <!-- mobilegridcell_41 -->
                                                <td id="startScreen_mobilegridcell_41" name="mobilegridcell_41" class="startScreen_mobilegridcell_41"
                                                colspan=1 rowspan=1>
                                                    <div class="cell-wrapper">
													<div class="view_list">
															<table>
																<tr>
																	<td><a href="">Chart of Accounts</a></td>
																</tr>
																<tr></tr>
																<tr>
																	<td><a href="">Transactions by Date Range</a></td>
																</tr>
																<tr></tr>
																<tr>
																	<td><a href="">All Un-posted Transactions</a></td>
																</tr>
																<tr></tr>
																<tr>
																	<td><a href="">Trial Balance</a></td>
																</tr>
															</table>
														</div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="startScreen_mobilegrid_21_row_2">
                            <!-- mobilegridcell_26 -->
                            <td id="startScreen_mobilegridcell_26" name="mobilegridcell_26" class="startScreen_mobilegridcell_26"
                            colspan=1 rowspan=1>
                                <div class="cell-wrapper">
                                    <!-- mobilegrid_44 -->
                                    <div class="startScreen_mobilegrid_44_wrapper" data-wrapper-for="mobilegrid_44">
                                        <table id="startScreen_mobilegrid_44" class="startScreen_mobilegrid_44" dsid="mobilegrid_44"
                                        name="mobilegrid_44" cellpadding=0 cellspacing=0>
                                            <col style="width:auto;" />
                                            <tr class="startScreen_mobilegrid_44_row_0">
                                                <!-- mobilegridcell_45 -->
                                                <td id="startScreen_mobilegridcell_45" name="mobilegridcell_45" class="startScreen_mobilegridcell_45"
                                                colspan=1 rowspan=1>
                                                    <div class="cell-wrapper">
                                                        <!-- label_record -->
                                                        <div name="label_record" id="startScreen_label_record" dsid="label_record" data-role="appery_label"
                                                        class="startScreen_label_record">
                                                            Record
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="startScreen_mobilegrid_44_row_1">
                                                <!-- mobilegridcell_47 -->
                                                <td id="startScreen_mobilegridcell_47" name="mobilegridcell_47" class="startScreen_mobilegridcell_47"
                                                colspan=1 rowspan=1>
                                                    <div class="cell-wrapper">
														<div class="view_list">
															<table>
																<tr>
																	<td><a href="../journalentry.php">Transactions</a></td>
																</tr>																
															</table>
														</div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="startScreen_mobilegrid_21_row_3">
                            <!-- mobilegridcell_27 -->
                            <td id="startScreen_mobilegridcell_27" name="mobilegridcell_27" class="startScreen_mobilegridcell_27"
                            colspan=1 rowspan=1>
                                <div class="cell-wrapper">
                                    <!-- mobilegrid_50 -->
                                    <div class="startScreen_mobilegrid_50_wrapper" data-wrapper-for="mobilegrid_50">
                                        <table id="startScreen_mobilegrid_50" class="startScreen_mobilegrid_50" dsid="mobilegrid_50"
                                        name="mobilegrid_50" cellpadding=0 cellspacing=0>
                                            <col style="width:auto;" />
                                            <col style="width:auto;" />
                                            <tr class="startScreen_mobilegrid_50_row_0">
                                                <!-- mobilegridcell_51 -->
                                                <td id="startScreen_mobilegridcell_51" name="mobilegridcell_51" class="startScreen_mobilegridcell_51"
                                                colspan=1 rowspan=1>
                                                    <div class="cell-wrapper">
                                                        <!-- btn_openEmail --><!--
                                                        --><a data-role="button" name="btn_openEmail" dsid="btn_openEmail" class="startScreen_btn_openEmail"
                                                        id="startScreen_btn_openEmail" data-corners="true" data-icon="none" data-iconpos='nowhere'
                                                        x-apple-data-detectors="false" data-mini="false" data-theme="b" tabindex="8">
                                                        Send Email
                                                        </a>
                                                    </div>
                                                </td>
                                                <!-- mobilegridcell_52 -->
                                                <td id="startScreen_mobilegridcell_52" name="mobilegridcell_52" class="startScreen_mobilegridcell_52"
                                                colspan=1 rowspan=1>
                                                    <div class="cell-wrapper">
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <!-- panel_2 -->
            <div data-role="panel" tabindex="-1" data-position="left" data-display="overlay"
            id="startScreen_panel_2" class="panel_2  startScreen_panel_2" name="panel_2" dsid="panel_2"
            data-theme="b">
                <!-- label_sendEmail -->
                <div name="label_sendEmail" id="startScreen_label_sendEmail" dsid="label_sendEmail"
                data-role="appery_label" class="startScreen_label_sendEmail">
                    Send Email
                </div>
                <!-- spacer_5 -->
                <div id="startScreen_spacer_5" data-role="appery_spacer" dsid="spacer_5" class='mobilespacer startScreen_spacer_5'>
                </div>
                <!-- input_recipients -->
                <div data-role="fieldcontain" class="startScreen_input_recipients ">
                    <input type="text" name="input_recipients" dsid="input_recipients" value="" placeholder="Recipients"
                    id="startScreen_input_recipients" tabindex="1" multiple data-theme="b" class="startScreen_input_recipients"
                    />
                </div>
                <!-- mobilegrid_6 -->
                <div class="startScreen_mobilegrid_6_wrapper" data-wrapper-for="mobilegrid_6">
                    <table id="startScreen_mobilegrid_6" class="startScreen_mobilegrid_6" dsid="mobilegrid_6"
                    name="mobilegrid_6" cellpadding=0 cellspacing=0>
                        <col style="width:auto;" />
                        <col style="width:30%;" />
                        <tr class="startScreen_mobilegrid_6_row_0">
                            <!-- mobilegridcell_7 -->
                            <td id="startScreen_mobilegridcell_7" name="mobilegridcell_7" class="startScreen_mobilegridcell_7"
                            colspan=1 rowspan=1>
                                <div class="cell-wrapper">
                                    <!-- btn_findRecipients --><!--
                                    --><a data-role="button" name="btn_findRecipients" dsid="btn_findRecipients" class="startScreen_btn_findRecipients"
                                    id="startScreen_btn_findRecipients" data-corners="true" data-icon="none" data-iconpos='nowhere'
                                    x-apple-data-detectors="false" data-mini="true" data-theme="b" tabindex="2">
                                    Find Recipients
                                    </a>
                                </div>
                            </td>
                            <!-- mobilegridcell_8 -->
                            <td id="startScreen_mobilegridcell_8" name="mobilegridcell_8" class="startScreen_mobilegridcell_8"
                            colspan=1 rowspan=1>
                                <div class="cell-wrapper">
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <!-- mobilegrid_12 -->
                <div class="startScreen_mobilegrid_12_wrapper" data-wrapper-for="mobilegrid_12">
                    <table id="startScreen_mobilegrid_12" class="startScreen_mobilegrid_12" dsid="mobilegrid_12"
                    name="mobilegrid_12" cellpadding=0 cellspacing=0>
                        <col style="width:auto;" />
                        <col style="width:30%;" />
                        <tr class="startScreen_mobilegrid_12_row_0">
                            <!-- mobilegridcell_13 -->
                            <td id="startScreen_mobilegridcell_13" name="mobilegridcell_13" class="startScreen_mobilegridcell_13"
                            colspan=1 rowspan=1>
                                <div class="cell-wrapper">
                                    <!-- btn_addAttachmnt --><!--
                                    --><a data-role="button" name="btn_addAttachmnt" dsid="btn_addAttachmnt" class="startScreen_btn_addAttachmnt"
                                    id="startScreen_btn_addAttachmnt" data-corners="true" data-icon="none" data-iconpos='nowhere'
                                    x-apple-data-detectors="false" data-mini="true" data-theme="b" tabindex="3">
                                    Upload Attachment
                                    </a>
                                </div>
                            </td>
                            <!-- mobilegridcell_14 -->
                            <td id="startScreen_mobilegridcell_14" name="mobilegridcell_14" class="startScreen_mobilegridcell_14"
                            colspan=1 rowspan=1>
                                <div class="cell-wrapper">
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <!-- textarea_emailMsg -->
                <div data-role="fieldcontain" class="startScreen_textarea_emailMsg ">
                    <textarea name="textarea_emailMsg" id="startScreen_textarea_emailMsg" tabindex="4"
                    dsid="textarea_emailMsg" data-theme="b" placeholder="add message..." class="startScreen_textarea_emailMsg">
</textarea>
                </div>
                <!-- spacer_19 -->
                <div id="startScreen_spacer_19" data-role="appery_spacer" dsid="spacer_19" class='mobilespacer startScreen_spacer_19'>
                </div>
                <!-- btn_sendMail --><!--
                --><a data-role="button" name="btn_sendMail" dsid="btn_sendMail" class="startScreen_btn_sendMail"
                id="startScreen_btn_sendMail" data-corners="true" data-icon="mail" data-iconpos="left"
                x-apple-data-detectors="false" data-mini="false" data-theme="b" tabindex="5">
                Send
                </a>
            </div>
        </div>
    </body>

</html>