<?php
header("Cache-Control: no-cache, must-revalidate");
include('../settings.php');
include(ROOT_DIR.'/libraries/Classes/System_boot.php');
$session= System_Sessions::getInstance();
	    if ($session->isLoggedIn()) {
        header("Location: $webroot/mobile/index.php");
		}
$cookie=new system_cookies;
$useCookies=false;
 if ($cookie->Exists('tqat') && !$cookie->IsEmpty('tqat')){ 
	if (is_array(json_decode($cookie->Get('tqat'),true))){
		$_array=json_decode($cookie->Get('tqat'),true);
		$uname =$_array['u'];
		$useCookies=true;
	}
 }
?>
<!DOCTYPE html>
        <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>T-Qat GPS Tracking System</title>
<link type="text/css" href="lib/cssmob.php" rel="stylesheet">
<script type="text/javascript" src="lib/jsmob.php?files=site"></script>
        </head>
        <body>
<div data-role="page" id="page1">
          <div  data-theme="a" data-role="header">
    <p><h4> T-Qat GPS Tracking System </h4></p>
  </div>
  
  
  
 
   <div data-role="content">
    <form action="../connect/login_cmd.php?mob" method="post" data-ajax="false">
     <?php if ($useCookies){?>
     <div class="ui-bar ui-grid-a">
      	 <br />
  	<br />
  	You are logged in as <?php echo $uname?> 
    <br />
    <br />
    <br />
    <input type="hidden" name="rememberme" />
    <br />
    <br />
    </div>
    <div class="ui-grid-b">
      <div align="left" class="ui-block-a"><a href="../connect/forgetme.php/?mob" data-role="button" data-mini="false" data-icon="refresh" data-iconpos="left" data-theme="c" data-ajax="false">Forget me</a>
      </div> 
     <div align="right" class="ui-block-c">
     <input name="login" type="submit" value="Continue" data-icon="check" data-iconpos="left" data-theme="b"/>
     </div> 
     </div>
     <?php }?>
    
    
     <?php if ($useCookies==false){?>
     <div class="ui-bar ui-grid-a">
        <div class="ui-block-a"> User name </div>
        <div class="ui-block-b"><input name="username" id="username" placeholder="" value="" type="text" /></div>
        <div class="ui-block-a"> Password </div>
        <div class="ui-block-b"><input name="pass" id="pass" placeholder="" value="" type="password" /></div>
        <div class="ui-block-a"> Company </div>
        <div class="ui-block-b"><input name="companyname" id="companyname" placeholder="" value="" type="text" /></div>
        <div class="ui-block-a">Languages</div>
        <div class="ui-block-b">
          <select name="l_language" id="l_language">
            <option value="en"> English </option>
            <option value="ar"> Arabic </option>
          </select>
        </div>
        <div class="ui-block-a"></div>
        <div class="ui-block-b"><input name="rememberme" id="rememberme" placeholder="" value="" type="checkbox" />
        <label for="rememberme">Remember me</label>
        </div>
        
        <div class="ui-block-a"><input name="login" type="submit" value="Login" data-icon="check" data-iconpos="left" /></div>
      </div>
	  <?php }?>
            </form>
  </div>
  <div data-role="footer" class="footer-docs" data-theme="a">
		<p><h4>&copy; ATS Advanced Technologies & Solutions</h4></p>
</div>
        </div>
</body>
</html>