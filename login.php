<?php
header("Cache-Control: no-cache, must-revalidate");
include_once('libraries/classes/system_boot.php');
$session = system_sessions::getInstance();
include('connect/mobile_check.php');
if ($session->isLoggedIn()) {
    header("Location: index.php");
}
?>
<!DOCTYPE HTML>
<head>
    <meta charset="utf-8">
    <title>GPS Tracking System</title>
    <link rel="shortcut icon" href="images/admin/favicon.ico" type="image/x-icon"/>

    <link type="text/css" href="libraries/CSS.php?files=login" rel="stylesheet">
    <script type="text/javascript" src="libraries/JS.php?files=login"></script>
    <script type="text/javascript">
        function login() {
<?php
if (!file_exists('connect/conf.php')) {

    include("contents/setup/_start.php");
    ?>
                var o = {
                    name: 'setup',
                    height: 175,
                    width: 400,
                    htmllink: 'contents/setup/_form.php',
                    imagelink: 'images/admin/install.png',
                    hideclose: true
                };
    <?php echo $module ?>Dialog.setParams(o);
    <?php echo $module ?>Dialog.createDialog(true);
<?php } else { ?>
                create_login();
<?php } ?>
        }
    </script>
</head>
<body class="ui-widget-content" style="overflow:hidden;border:none" onLoad="javascript:login()">
    <script type="text/javascript">
        $(document).ready(function() {
            // load default css
            $.fn.gcjs_themeswitcher_dialog.gcjs_m_load_initial_css("");
            setInterval(function() {
                $('.background').fadeOut('slow').stop(true, true).removeAttr('src').fadeIn(1000).attr('src', "images\\background\\" + Math.floor((Math.random() * 30) + 1) + ".jpg");
            }, 10000);
        });
    </script>
    <div class="background" style="display: table;left: 0px; top: 0; width: 100%; height: 100%;text-align:center;position:fixed";>
        <div style="display: table-cell;vertical-align:middle";>
            <img  class="background" src="images\background\<?php echo rand(1, 30); ?>.jpg" height=700 width=1024 border=0'/>
        </div>
    </div>
    <div style="height:36px;width:100%;bottom:0;position:absolute" class="ui-state-default">
        <div style="float:left">
            <div style="float:left;padding-top:3px"> <img src="images/admin/logo.png" width="32px" height="24px"/> </div>
            <div style="float:left;padding-top:8px"> <a target="_blank" href="http:\\www.ats-qatar.com">Advanced Technologies and Solutions</a> </div>
        </div>
        <div style="float:right;padding-right:5px;padding-top:8px"> © 2013 ATS QATAR </div>
    </div>
</body>
</html>