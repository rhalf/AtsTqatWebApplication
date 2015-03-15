<script language="JavaScript">
    function moveToUrl(url) {
        window.location = url;
    }
</script>
<?php
header("Cache-Control: no-cache, must-revalidate");
include_once('../settings.php');
include(ROOT_DIR . "/libraries/classes/system_boot.php");
include_once(ROOT_DIR . "/connect/func.php");

if (!is_form()) {
    die;
}
if (!isset($_POST['login'])) {
    die;
}

$session = system_sessions::getInstance();
if (isset($_GET['mob'])) {
    $mobileVersion = true;
} else {
    $mobileVersion = false;
}


// cockies
$useCookies = false;
if (isset($_POST['rememberme'])) {
    $cookie = new system_cookies;
    if ($cookie->Exists('tqat') && !$cookie->IsEmpty('tqat')) {
        if (is_array(json_decode($cookie->Get('tqat'), true))) {
            $_array = json_decode($cookie->Get('tqat'), true);
            $uname = $_array['u'];

            $upass = $_array['p'];
            $company = $_array['c'];
            $lang = $_array['l'];
            $useCookies = true;
        }
    }
}


// check language
if ($useCookies == false) {
    if (isset($_POST['l_language'])) {
        $lang = $_POST['l_language'];
    } else {
        $lang = "en";
    }
}
include (ROOT_DIR . "/languages/$lang.php");


// check try
if ($session->is_set('try') == false) {
    $session->set('try', 1);
}

if ($session->get('try') > 3 && !isset($_POST['captchainp'])) {
    ?>
    <script type="text/javascript">
        moveToUrl('<?php echo "$webroot/index.php" ?>');
    </script>
    <?php
} else
if ($session->get('try') > 3 && isset($_POST['captchainp'])) {
    if ($_POST['captchainp'] != $_SESSION['captcha']) {
        die(WrongCredentials);
    }
}


// login
if ($useCookies == false) {
    $uname = sanitize($_POST['username']);
    $upass = stripslashes($_POST['pass']);
    $company = sanitize($_POST['companyname']);
}

if (!$uname | !$upass | !$company) {
    die(WrongCredentials);
}


include (ROOT_DIR . "/connect/connect_master_db.php");


$companydb = $companydata["cmpdbname"];
$check = $CompanyConn->query("SELECT `uid`,`uname`,`upass`,`upriv`,`utimezone`,`uactive`,`uexpiredate`,`udbs` FROM " . 'cmp_' . $companydb .
    ".usrs WHERE uname = '" . $uname . "'");
$CompanyConn = null;

if ($check->rowCount() == 0) {
    $try = $session->get('try');
    $try++;
    $session->set('try', $try);
    die(WrongCredentials);
} else {

    while ($info = $check->fetch()) {
        $expire_date_state = user_expire_date($info['uexpiredate']);
        $info['upass'] = stripslashes($info['upass']);
        if ($useCookies == false) {
            $upass = md5($upass);
        }
        // Wrong 
        if ($upass != $info['upass']) {

            $try = $session->get('try');
            $try++;
            $session->set('try', $try);

            die(WrongCredentials);

            // Unactive	
        } else if ($info['uactive'] != 1) {
            die(AccountDeactivated);
            // Expired
        } else if ($expire_date_state == 1) {
            die(AccountExpired);
            // Login OK			
        } else {
            if ($expire_date_state == 2) {
                $left_days = user_left_days($info['uexpiredate']);
                if ($left_days < 31) {
                    $session->set('left_days', $left_days);
                }
            }
            $session->validateUser($info['uid'], $uname, $upass, $companydb, $company, $CmpDisplay, $info['utimezone'], $info['upriv'], $info['udbs'], $lang);
            $session->un_set('try');

            // cockies
            if (isset($_POST['rememberme'])) {
                $_array = array(
                  'u' => $uname,
                  'p' => $upass,
                  'c' => $company,
                  'l' => $lang,
                  'r' => 1
                );
                $cookie->Set('tqat', json_encode($_array));
            }


            if (isset($_GET['mob'])) {
                ?>
                <script type="text/javascript">
                    moveToUrl('<?php echo "$webroot/mobile/index.php" ?>');
                </script>
                <?php
            } else {
                ?>
                <script type="text/javascript">
                    moveToUrl('<?php echo "$webroot/index.php" ?>');
                </script>
                <?php
                exit();
            }
        }
    }
}
?>
