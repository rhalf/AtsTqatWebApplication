<?php
header("Cache-Control: no-cache, must-revalidate");
include_once("../../settings.php");
include_once("../../scripts.php");
include("_start.php");
include(ROOT_DIR."/connect/connect_master_db.php");


$alllogquery = "SELECT `log_id`,`log_data`, `log_date` FROM log_" . $udb. " ORDER BY `log_date`;";

$alllogStatment = $CompanyConn->query($alllogquery);
$CompanyConn=null;
?>
<script type="text/javascript">
	
	
<?php if($privilege==1){?>
function Delete_logReport() {
	var u='contents/logreport/_cmd.php';
  $("#lgOutput").html('Loading..');   
  $.ajax({    
  type: 'POST',    
   url:u ,    
	success: function(data) {      
	if(data){
	ShowMessage(data);
	}
	$('#log_list').empty();     
	 },    
	error: function (XMLHttpRequest, textStatus, errorThrown) {     
	 ShowMessage('Timeout contacting server..');        
	  }});
	  
	 
};
<?php }?>

function <?php echo $module?>Close() {
 <?php echo $module?>Dialog.Close();
	
};   
<?php if($privilege==1){?>
function <?php echo $module?>Delete() {
	if($('#log_list option').length!=0){
	Delete_logReport();
	}
	
}; 
<?php }?>

$(function() {
	<?php if($privilege==1){?>
<?php echo $module?>Dialog.addButton('<?php echo $module?>delete','<?php echo Delete ?>','<?php echo $module?>Delete','delete');
<?php }?>	
<?php echo $module?>Dialog.addButton('<?php echo $module?>close','<?php echo Close ?>','<?php echo $module?>Close','close');

<?php echo $module?>Dialog.setOption('title','<?php echo LogReport?>');		
	});	


</script>
<div class="contents ui-widget-content" style="border:none;direction:<?php echo text_direction?>">
  <table width="100%" border="0">
  <tr>
    <td>
    <select class="textareastyle" name="log_list" id="log_list" size="12" style="width:100%">
<?php
while ($alllogrow = $alllogStatment->fetch(PDO::FETCH_ASSOC)){
    echo "<option value = " . $alllogrow["log_id"] . ">";

    echo $alllogrow["log_data"] .$alllogrow["log_date"]. "</option>";
}
?>
    </select></td>
</table>
</div>