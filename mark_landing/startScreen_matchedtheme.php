<!DOCTYPE html>
<html>
    
    <head>
        <title>
            startScreen
        </title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">


        
        <!--<link href="files/resources/lib/theme/jqm/jqm.css" rel="stylesheet"/>-->
        <!--<link href="files/resources/lib/theme/flat-ui/flat-ui.css"
        rel="stylesheet" />-->
        <!--<link
            href="files/resources/lib/jquerymobile/1.4.4/jquery.mobile.structure-1.4.4.css"
            rel="stylesheet" />-->

        <!-- Basic bootstrap css theme -->
		<link href="../dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom Style sheet for moving the body down below nav bar -->
        <link href="../dist/css/custom.css" rel="stylesheet">
        <link href="files/resources/css/mobilebase.css" rel="stylesheet"
            type="text/css"/>
        <link href="startScreen.css" rel="stylesheet" type="text/css" />

        <script type="text/javascript" src="files/resources/lib/underscore/underscore.js"></script>
        <script type="text/javascript" src="files/resources/lib/store/json2.js"></script>
        <script type="text/javascript" src="files/resources/lib/jquery/jquery-2.1.1.js"></script>
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
        <script type="text/javascript" src="files/resources/lib/jquerymobile/1.4.4/jquery.mobile-1.4.4.js"></script>
        <script type="text/javascript" src="files/resources/js/mobilebase.js"></script>
        <script type="text/javascript" src="files/resources/lib/event/customEventHandler.js"></script>
        <script type="text/javascript" src="files/resources/lib/base/sha1.js"></script>
        <script type="text/javascript" src="files/resources/lib/base/oauth.js"></script>
        <script type="text/javascript" src="files/resources/lib/base/contexts.js"></script>
        <script type="text/javascript" src="files/resources/lib/base/jquery.xml2json.min.js"></script>
        <script type="text/javascript" src="files/resources/lib/base/appery.js"></script>
        <script type="text/javascript" src="files/resources/lib/base/component-manager.js"></script>
        <script type="text/javascript" src="files/resources/lib/base/mapping-impl.js"></script>
        <script type="text/javascript" src="files/resources/lib/base/entity-api.js"></script>
        <script type="text/javascript" src="files/resources/lib/base/storage-api.js"></script>
        <script type="text/javascript" src="files/resources/lib/get_target_platform.js"></script>
        <script type="text/javascript" src="files/resources/lib/cordova.js"></script>
        <script type="text/javascript" src="files/views/assets/js/services/model.js"></script>
        <script type="text/javascript" src="files/views/assets/js/services/service.js"></script>
    </head>
    
    <body>
        <script language="JavaScript" type="text/javascript">
                
        </script>

        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <img src="../dist/images/AppDomainFinalProjectLogo.png"
                    alt="PAI Logo" height="30" width="30" class="logo-top nav"> 
                    <a class="navbar-brand" href="#">Poly Accounting Information Group</a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                    <form role="form" class="navbar-form navbar-nav" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
                        <button type="submit" class="btn btn-danger" name="logout">Log Out</button>
                    </form>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
            <div class="panel panel-primary col-centered form-group">
                <div class="panel-heading text-center">
                    <h3 class="panel-title centered-y">Control Panel</h3>
                </div>
                <div class="panel-body">
                    <div class="panel panel-success">
                        <div class="panel-heading panel-heading-sm text-center">
                            <h3 class="panel-title centered-y-sm">View</h3>
                        </div>
                        <div class="panel-body container-fluid">
                            <div class="row">
                                <div class="col-xs-6 col-sm-6">
                                    <a href="">Chart of Accounts</a>
                                </div>  
                                <div class="col-xs-6 col-sm-6">
                                    <a href="">Transactions by Date Range</a>
                                </div>  
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-sm-6">
                                    <a href="">All Un-posted Transactions</a>
                                </div>  
                                <div class="col-xs-6 col-sm-6">
                                    <a href="">Trial Balance</a>
                                </div>  
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-info">
                        <div class="panel-heading panel-heading-sm text-center">
                            <h3 class="panel-title centered-y-sm">Record</h3>
                        </div>
                        <div class="panel-body container-fluid">
                            <div class="row">
                                <div class="col-xs-6 col-sm-6">
                                    <a href="../journalentry.php">Transactions</a>
                                </div>  
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-danger">
                        <div class="panel-heading panel-heading-sm text-center">
                            <h3 class="panel-title centered-y-sm">Send Email</h3>
                        </div>
                        <div class="panel-body container-fluid">
                            <div class="row">
                                <div class="col-xs-6 col-sm-6">
                                    <a>Send Email</a>
                                    <!--
                                    <a data-role="button" name="btn_openEmail" dsid="btn_openEmail" class="startScreen_btn_openEmail"
                                        id="startScreen_btn_openEmail" data-corners="true" data-icon="none" data-iconpos='nowhere'
                                        x-apple-data-detectors="false" data-mini="false" data-theme="b" tabindex="8">
                                            Send Email
                                    </a>-->
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
                                                    <div class="cell-wrapper">
                                                        <a data-role="button" name="btn_openEmail" dsid="btn_openEmail" class="startScreen_btn_openEmail"
                                                        id="startScreen_btn_openEmail" data-corners="true" data-icon="none" data-iconpos='nowhere'
                                                        x-apple-data-detectors="false" data-mini="false" data-theme="b" tabindex="8">
                                                        Send Email
                                                        </a>
                                                    </div>

            <!-- panel_2 (The Side Panel) -->
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
