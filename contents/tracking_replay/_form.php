<?php
header("Cache-Control: no-cache, must-revalidate");
include_once("../../settings.php");
include_once("../../scripts.php");
include("_start.php");

$un= $_GET['id'];
?>
 <div class="contents" style="direction:<?php echo text_direction?>">
<form id="<?php echo $module?>form" name="<?php echo $module?>form" method="post">
      <table width="100%">
    <tr>
          <td width="20%"><?php echo From ?></td>
          <td width="80%" colspan="3"><input name="<?php echo $module?>datefrom" id="<?php echo $module?>datefrom" type="text" class="inputstyle" style="width:100%"></td>
        </tr>
    <tr>
          <td><?php echo To ?></td>
          <td colspan="3"><input name="<?php echo $module?>dateTo" id="<?php echo $module?>dateTo" type="text"class="inputstyle" style="width:100%"></td>
        </tr>
  </table>
    </form>
    </div>
<script type="text/javascript">
$('#<?php echo $module?>dateTo').val("<?php echo setTime(time(),$timezone)?>");
$('#<?php echo $module?>datefrom').val("<?php echo date('d/m/Y H:i:s',strtotime('midnight')) ?>");

function destroy(){
	$('#trdatefrom').datepicker( "destroy" );	
	$('#trdateTo').datepicker( "destroy" );	
}	
	

function <?php echo $module?>Excute(){	
$('#treplayli').show();
//$('#layout-south_tabs').tabs('select', 4);
$('#layout-south_tabs').tabs({ active: 1 });
$('#layout-south_tabs').tabs( "option", "active",1 );
create_map_tab(document.getElementById('maps_list').options[document.getElementById('maps_list').selectedIndex].text,document.getElementById('maps_list').options[document.getElementById('maps_list').selectedIndex].value);

    var dfromParts, TfromParts, dfrom, dtoParts, TtoParts, dto;
    dfromParts = $('#trackingreplaydatefrom').val().split(" ")[0].split("/");
    TfromParts = $('#trackingreplaydatefrom').val().split(" ")[1];
    dfrom = dfromParts[1] + '/' + dfromParts[0] + '/' + dfromParts[2] + ' ' + TfromParts;

    dtoParts = $('#trackingreplaydateTo').val().split(" ")[0].split("/");
    TtoParts = $('#trackingreplaydateTo').val().split(" ")[1];
    dto = dtoParts[1] + '/' + dtoParts[0] + '/' + dtoParts[2] + ' ' + TtoParts;

    var fdate = Date.parse(dfrom);
    var tdate = Date.parse(dto);
TrackingReply.fromdate=fdate;
TrackingReply.todate=tdate;


TrackingReplayArray.length=0;
TrackingReply.Excute('<?php echo $un ?>' ,MapClass.currMapID,MapClass.currMap,TimeZone);
<?php echo $module?>Close();
ResizeSouthPane(200,false);
};

function <?php echo $module?>Close() {
	<?php echo $module?>Dialog.Close();
};


$(function() {
	<?php echo $module?>Dialog.addButton('<?php echo $module?>ok','<?php echo Ok?>','<?php echo $module?>Excute','save');
	<?php echo $module?>Dialog.addButton('<?php echo $module?>close','<?php echo Close ?>','<?php echo $module?>Close','close');
	
	<?php echo $module?>Dialog.setOption('title','<?php echo TrackingReplay?>');
	
	$("#<?php echo $module?>close").button();
	$("#<?php echo $module?>excute").button();	
	$('#<?php echo $module?>datefrom').datetimepicker({
		dateFormat: 'dd/mm/yy',
		showSecond: true,
		timeFormat: 'hh:mm:ss'
		});
	$('#<?php echo $module?>dateTo').datetimepicker({
		dateFormat: 'dd/mm/yy',
		showSecond: true,
		timeFormat: 'hh:mm:ss'
	});

});

</script>