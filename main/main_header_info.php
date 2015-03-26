<?php
header("Cache-Control: no-cache, must-revalidate");
include_once ("../settings.php");
include_once("../scripts.php");
?>
<?php echo Welcome . " <a id='curruserbtn' href='javascript:void(0)'>" . $username .
 "</a> | <a href='connect/userlogout.php'>"
?><?php echo Logout . "</a>"; ?> | <?PHP echo TimeZone; ?>:
<?php if (isset($timezone)) {
    echo $timezone;
} ?>
<br />
<?PHP echo Company; ?>:
<?php
if (isset($CompanyDisplay)) {
    echo " <a id='cmpinfo' href='javascript:void(0)' >" . $CompanyDisplay . "</a>";
} else {
    echo " <a id='cmpinfo' href='javascript:void(0)' >" . $company . "</a>";
}
?>
<br />
<?php
if ($session->is_set('left_days')) {
    echo sprintf(UserLeftDays, $session->get('left_days'));
}
?>
<br />
<?php
if ($session->is_set('cmp_left_days')) {
    echo sprintf(CompanyLeftDays, $session->get('cmp_left_days'));
}
?>

<script type="text/javascript">
    $('#cmpinfo').click(function(e) {
        create_companyinfo();
        return false;
    });

    $("#curruserbtn").click(function() {
        create_e_user('<?php echo $userid ?>');
        return false;
    });
</script>