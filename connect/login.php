<?php
header("Cache-Control: no-cache, must-revalidate");
include_once('../libraries/classes/system_boot.php');
$session = system_sessions::getInstance();
$cookie = new system_cookies;
$useCookies = false;
if ($cookie->Exists('tqat') && !$cookie->IsEmpty('tqat')) {
    if (is_array(json_decode($cookie->Get('tqat'), true))) {
        $_array = json_decode($cookie->Get('tqat'), true);
        $uname = $_array['u'];
        $useCookies = true;
    }
}
$useCaptcha = false;
if ($session->is_set('try')) {
    if ($session->get('try') > 3) {
        $useCaptcha = true;
    }
}
?>
<div class="contents">
    <form id="loginform" action="connect/login_cmd.php" method="post" onsubmit="return Login_validateonsubmit(this);">
        <?php if ($useCookies == true) { ?>
            <br />
            <br />
            You are logged in as <?php echo $uname ?> 
            <br />
            <br />
            <br />
            <input type="hidden" name="rememberme" />
        <?php } ?>
        <?php if ($useCookies == false) { ?>
            <div class="contents">
                <table width="100%" border="0" align="center">
                    <tr>
                        <td width="20%" height="24"><label for="username"> Username</label></td>
                        <td width="80%"><span id="spryl_username">
                                <input type="text" id="username" name="username" maxlength="50"style="width:100%" title="Required" class="inputstyle" >
                                <span class="textfieldRequiredMsg"></span></span></td>
                    </tr>
                    <tr>
                        <td height="24"><label for="pass">Password</label></td>
                        <td><span id="spryl_password">
                                <input type="password" id="pass" name="pass" maxlength="50"style="width:100%" title="Required" class="inputstyle" >
                                <span class="passwordRequiredMsg"></span></span></td>
                    </tr>
                    <tr>
                        <td height="24"><label for="companyname">Company</label></td>
                        <td><span id="spryl_company">
                                <input type="text" name="companyname" id="companyname" maxlength="50"style="width:100%" title="Required" class="inputstyle" >
                                <span class="textfieldRequiredMsg"></span></span></td>
                    </tr>
                    <tr>
                        <td height="24"><label for="l_language">Language</label></td>
                        <td><select name="l_language" id="l_language" style="width:100%">
                                <option class="ui-widget-content" value="ar">Arabic</option>
                                <option class="ui-widget-content" value="en" selected>English</option>
                                <!--            <option class="ui-widget-content" value="ml">Malialum</option>
                                            <option class="ui-widget-content" value="hi">Hindi</option>-->
                            </select></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td height="24" valign="middle"><input type="checkbox" name="rememberme" id="rememberme" />
                            <label for="rememberme">Remember me</label></td>
                    </tr>
                    <?php
                    if ($useCaptcha) {
                        ?>
                        <tr>
                            <td align="right"><button type="button" id="reloadbtn" style="width:25px;height:25px" onClick="javascript: document.getElementById('captcha').src = 'libraries/captcha/captcha.php?' + Math.random();" ></button></td>
                            <td height="24" valign="middle"><img src="libraries/captcha/captcha.php" id="captcha" style="width:100%" /></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input type="text" name="captchainp" id="captchainp" autocomplete="off" maxlength="50"style="width:100%" class="inputstyle" />
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        <?php } ?>
        <hr>
        <div align="right" style="width:100%">
            <table height="32" style="width:100%;height:20px">
                <td width="75%"><div align="left" id="LoginOutput"></div></td>
                <?php if ($useCookies) { ?>
                    <td width="25%" align="right" nowrap="nowrap">
                        <button type="button" name="forgetme" id="forgetme">Forget me</button>
                    <td width="25%" align="right">
                        <button type="submit" name="login" id="login" value="Login">Continue</button>
                    </td>
                    </td>
                <?php } else { ?>
                    <td width="25%" align="right">
                        <button type="submit" name="login" id="login" value="Login">Login</button>
                    </td>
                <?php } ?>
                <tr>
                    <td colspan="5"></td>
                </tr>
            </table>
        </div>
    </form>
</div>
<script type="text/javascript">
    var spryl_username = new Spry.Widget.ValidationTextField("spryl_username");
    var spryl_password = new Spry.Widget.ValidationPassword("spryl_password");
    var spryl_company = new Spry.Widget.ValidationTextField("spryl_company");


    $("#login").button({icons: {primary: "ui-icon-check"}, text: true});
    $("#reloadbtn").button({icons: {primary: "ui-icon-refresh"}, text: false});
<?php if ($useCookies) { ?>
        $("#forgetme").button({icons: {primary: "ui-icon-refresh"}, text: true});
<?php } ?>
    $("select#l_language").selectmenu({width: 300});

    function Login_updateResponseDiv(req)
    {
        $('#LoginOutput').html(req.xhRequest.responseText).fadeIn('slow').delay('3000').fadeOut('slow');
    }
    function Login_validateonsubmit(form) {
        if (Spry.Widget.Form.validate(form) == true) {
            Spry.Utils.submitForm(form, Login_updateResponseDiv);
        }
        return false;
    }
    $(document).ready(function(e) {
<?php if ($useCookies) { ?>
            $('#forgetme').click(function(e) {
                window.location = 'connect/forgetme.php';
            });
            LoginDialog.setOption('height', 175);
<?php } ?>

<?php if ($useCaptcha) { ?>
            LoginDialog.setOption('height', 400);
<?php } ?>

        LoginDialog.setOption('title', 'Login');
        setTimeout(function() {
            $("#logindialog").parent().fadeIn('fast');
        }, 500);
    });
</script>