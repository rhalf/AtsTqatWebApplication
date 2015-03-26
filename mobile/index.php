<?php
header("Cache-Control: no-cache, must-revalidate");
$mobileVersion = true;
include_once("../settings.php");
include_once("../scripts.php");
include(ROOT_DIR . "/connect/connect_master_db.php");
include(ROOT_DIR . "/contents/users/_sql.php");
$session->set('users', $UsersResult);
include(ROOT_DIR . "/connect/connection.php");
include(ROOT_DIR . "/contents/trackers/_sql.php");
$session->set('trackers', $TrackersResult);

include(ROOT_DIR . "/contents/httphost/_sql.php");
$session->set('httphosts', $Result);

include(ROOT_DIR . "/contents/dbhost/_sql.php");
$session->set('dbhosts', $Result);
$CompanyConn = null;
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
        <form action="map.php" method="post" data-ajax="false">
            <div data-theme="a" data-role="header">
                <div class="ui-bar ui-grid-b">
                    <div align="left" class="ui-block-a"><input name="locate" type="submit" value="Locate" data-icon="search" data-iconpos="left" data-theme="b" /></div>
                    <div class="ui-block-b"></div>
                    <div align="right" class="ui-block-c"> <a  href="../connect/userlogout.php/?mob" data-role="button" data-mini="true" data-icon="delete" data-iconpos="left" data-theme="a" data-ajax="false">Logout</a></div>
                </div>
            </div>

            <div data-role="content">
                <div data-role="collapsible-set" data-theme="" data-content-theme="">
                    <div data-role="collapsible" data-collapsed="true">


                        <h3><?php echo $username ?></h3>
                        <?php
                        foreach ($TrackersResult as $row) {
                            if (in_array($userid, explode(',', $row['tusers']))) {
                                $uid = $row["tid"];
                                $vehiclereg = $row["tvehiclereg"];
                                $drivername = $row["tdrivername"];
                                $unit = $row["tunit"];
                                $img = $row["timg"];
                                $type = $row["ttype"];
                                $MileageLimit = $row["tmileagelimit"];
                                $mileageInit = $row["tmileageInit"];
                                $mileageReset = $row["tmileagereset"];
                                $inputs = $row["tinputs"];
                                $SpeedLimit = $row["tspeedlimit"];
                                $httphost = $row["thttphost"];
                                ?>
                                <div class="div<?php echo $unit ?> ui-state-default">
                                    <table  width="100%" border="0">
                                        <tr>
                                            <td width="10%"><img id="img<?php echo $unit ?>"  class="<?php echo $img ?>" src="../images/car/icon_<?php echo $img ?>_stop.gif" width="15px" height="15px"></img>
                                            </td>
                                            <td width="90%"><input type="checkbox" name="chb[]" id="chb<?php echo $unit ?>" data-mini="true" value="'<?php echo $unit ?>','<?php echo $drivername ?>','<?php echo $vehiclereg ?>','<?php echo $type ?>','<?php echo $img ?>','<?php echo $inputs ?>','<?php echo $SpeedLimit ?>','<?php echo $MileageLimit ?>','<?php echo $mileageInit ?>','<?php echo $mileageReset ?>','<?php echo $httphost ?>'" class="custom" />
                                                <label for="chb<?php echo $unit ?>">
                                                    <table  width="100%" border="0">
                                                        <tr>
                                                            <td width="50%"><?php echo $drivername ?></td>
                                                            <td width="50%"><?php echo $vehiclereg ?></td>
                                                        </tr>
                                                    </table>
                                                </label></td>
                                        </tr>
                                    </table>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div> 
            </div>

            <div data-theme="a" data-role="footer">
                <h3> Choose your vehicles then press Locate button. </h3>
            </div>  
        </form>
    </div>
</body>
</html>