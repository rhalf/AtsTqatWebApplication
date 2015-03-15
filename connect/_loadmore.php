<?php
include_once("../settings.php");
include_once("../scripts.php");

$settings = $session->get('settings');

$grouping = get_setting('grouping_' . $userid, $settings);

if ($grouping == '') {
    if ($privilege == 1) {
        $grouping = '0';
    } else {
        $grouping = '1';
    }
}

$id = $_GET['id'];
$count = $_GET['count'];
$limit = 20;

$CollectionsResult = $session->get('colls');
$UsersResult = $session->get('users');
$TrackersResult = $session->get('trackers');
$HTTPHostsResult = $session->get('httphosts');


if ($privilege == 1) {
    $cmpsResult = $session->get('cmps');
    $alltrksResult = $session->get('alltrackers');
}

if ($grouping == 0) {
    foreach ($cmpsResult as $cmp) {
        if ($cmp['cmpid'] == $id) {
            $company = $cmp;
            break;
        }
    }

    $trksArray = array();
    foreach ($alltrksResult as $tracker) {
        if ($company['cmpdbname'] == $tracker['tcmp']) {
            $trksArray[] = $tracker;
        }
    }
}
/**
 * 
 */
$n = 0;
foreach ($trksArray as $trk) {

    if ($n >= $count && $n - $count < $limit) {
        echo CreateTracker($trk, $privilege);
    }
    $n++;
}
?>
<script>
    $('.context').bind('click', function(e) {
        var id = $(this).attr('class').split(' ')[1].split('context')[1];
        $('.tpopup' + id).load('connect/_tracker_popup.php?id=' + id);
    });
    $('.chb').bind('change', function() {
        setCheck($(this).attr('class').split(' ')[0], $(this).is(':checked'));
        RealTimeClass.AddLive($(this).val());
    }
    );
</script>