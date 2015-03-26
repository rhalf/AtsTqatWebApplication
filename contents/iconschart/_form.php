<?php
header("Cache-Control: no-cache, must-revalidate");
include_once ("../../settings.php");
include_once("../../scripts.php");
include("_start.php");
?>
<div class="contents ui-widget-content" style="direction:<?php echo text_direction?>">
    <table width="100%" border="0">
  <tr>
    <td width="40%"><font size="3"><?php echo constant($module.'VehiclesIcons'); ?></font></td>
    <td width="10%">&nbsp;</td>
    <td rowspan="9" width="10px"></td>
    <td width="40%"><font size="3"><?php echo constant($module.'AlarmsIcons'); ?></font></td>
    <td width="10%" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td><?php echo constant($module.'stopicon'); ?></td>
    <td><img src="images/car/icon_0_stop.gif" width="30px" height="30px" /></td>
    <td><?php echo constant($module.'emergencyicon'); ?></td>
    <td align="center"><img src="images/alarmsicons/emergency.png" width="15px" height="15px" /></td>
  </tr>
  <tr>
    <td><?php echo constant($module.'drivericon'); ?></td>
    <td><img src="images/car/icon_0_driver.gif" width="30px" height="30px" /></td>
    <td><?php echo constant($module.'geofenceicon'); ?></td>
    <td align="center"><img src="images/alarmsicons/geo-fence.png" width="15px" height="15px" /></td>
  </tr>
  <tr>
    <td><?php echo constant($module.'alarmicon'); ?></td>
    <td><img src="images/car/icon_0_alarm.gif" width="30px" height="30px" /></td>
    <td><?php echo constant($module.'speedLimiticon'); ?></td>
    <td align="center"><img src="images/alarmsicons/speedLimit.png" width="15px" height="15px" /></td>
  </tr>
  <tr>
    <td><?php echo constant($module.'losticon'); ?></td>
    <td><img src="images/car/icon_0_lost.gif" width="30px" height="30px" /></td>
    <td><?php echo constant($module.'BreakDownIcon'); ?></td>
    <td align="center"><img src="images/alarmsicons/breakdown.png" width="15px" height="15px" /></td>
  </tr>
  <tr>
    <td><?php echo constant($module.'IdleIcon'); ?></td>
    <td><img src="images/car/icon_0_idle.gif" width="30px" height="30px" /></td>
    <td><?php echo constant($module.'GPSofficon'); ?></td>
    <td align="center"><img src="images/alarmsicons/GPSoff.png" width="15px" height="15px" /></td>
  </tr>
  <tr>
    <td height="30">&nbsp;</td>
    <td>&nbsp;</td>
    <td><?php echo constant($module.'mileagelimiticon'); ?></td>
    <td align="center"><img src="images/alarmsicons/mileagelimit.png" width="15px" height="15px" /></td>
  </tr>
  <tr>
<td height="30">&nbsp;</td>
    <td>&nbsp;</td>
    <td><?php echo constant($module.'Expiredicon'); ?></td>
    <td align="center"><img src="images/alarmsicons/Expired.png" width="15px" height="15px" /></td>
  </tr>
  <tr>
<td height="30">&nbsp;</td>
    <td>&nbsp;</td>
    <td><?php echo constant($module.'CRExpiredicon'); ?></td>
    <td align="center"><img src="images/alarmsicons/CRExpired.png" width="15px" height="15px" /></td>
  </tr>
    </table>
    </div>
 <script type="text/javascript">
<?php echo $module?>Dialog.setOption('title','<?php echo IconsChart?>');
</script>   