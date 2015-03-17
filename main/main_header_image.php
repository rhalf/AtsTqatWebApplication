<?php
header("Cache-Control: no-cache, must-revalidate");
include_once ("../settings.php");
include_once("../scripts.php");

$settings = $session->get('settings');

$logo = get_setting('logo', $settings);
?>
<?php if ($logo != 'default') { ?>
    <img id="imagebtn" style="cursor:pointer" src="iupload/<?php echo $logo ?>" height="60px" width="80px" />
<?php } else { ?>
    <img id="imagebtn" style="cursor:pointer" src="images/admin/logo.png" height="60px" width="80px" />
    <?php
}?>