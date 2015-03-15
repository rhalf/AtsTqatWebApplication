<?php
header("Cache-Control: no-cache, must-revalidate");
include_once("../../settings.php");
include_once("../../scripts.php");
include("_start.php");
if (!$_GET['type']) {
    die;
}
$type=$_GET['type'];

$Result=$session->get('geofence');

if ($type==1){
	$code=$module_add;	
	$link="contents/{$loc}/_cmd.php?type=1";	
}else if ($type==2){
	$code=$module_edit;	
	$link="contents/{$loc}/_cmd.php?type=2";
}
?>
<script type="text/javascript">
	
function <?php echo $code?>Response(req){
	ShowMessage(req.xhRequest.responseText);
	<?php if($type==2){?>
	$('#<?php echo $module?>_list_a').click();
	$('#<?php echo $module?>_edit_li').hide();
	<?php }?>
	$('#<?php echo $code?>form')[0].reset();
	$('#<?php echo $module?>_list_tab').html(geturl('contents/<?php echo $loc?>/_list.php'));	 	
} 
function <?php echo $code?>OnSubmit(form){
		if (Spry.Widget.Form.validate(form) == true){
			<?php if ($type==1){?>
			finish_adding_geofence();
			DrawingGeoFence.draw();
			<?php }else if ($type==2){?>
			finish_editing_geofence();
			<?php }?>
			Spry.Utils.submitForm(form, <?php echo $code?>Response);
		}
		return false;
		
	}
<?php if ($type==2){?>
function del_geofence(id) {
	var u='contents/<?php echo $loc?>/_cmd.php?type=3&id='+id;  
  $.ajax({    
  type: 'POST',    
   url:u ,   
	success: function(data) {      
	ShowMessage(data);  
	<?php if($type==2){?>    
		$('#<?php echo $module?>_List_a').click();
		$('#<?php echo $module?>_edit_li').hide();
		<?php }?>
		$('#<?php echo $module?>_list_tab').html(geturl('contents/<?php echo $loc?>/_list.php')); 
		DrawingGeoFence.reset();
	 },    
	error: function (XMLHttpRequest, textStatus, errorThrown) {     
	 ShowMessage('Timeout contacting server..');     
	  }});
};
<?php }?>

</script>

<div class="contents ui-widget-content" style="height:100%;direction:<?php echo text_direction?>">
  <form method="post" id="<?php echo $code?>form" name= "<?php echo $code?>form" target="_self" action="<?php echo $link?>" onSubmit="return <?php echo $code?>OnSubmit(this);">
  <table width="100%" height="100%" border="0">
    <tr>
      <td width="20%" align="left"><?php echo constant($module.'Name'); ?></td>
      <td width="80%" align="left"><span id="spry<?php echo $code?>name">
      <input name="<?php echo $code?>name" id="<?php echo $code?>name" type="text" style="width:100%" class="inputstyle" />
      <span class="textfieldRequiredMsg"></span><span class="textfieldMaxCharsMsg"></span></span>
  <input type="hidden" name="<?php echo $code?>polyarr" id="<?php echo $code?>polyarr" /><input type="hidden" name="<?php echo $code?>id" id="<?php echo $code?>id" />    
      </td>
    </tr>
  </table>
  </form>
</div>
<script type="text/javascript">
var spry<?php echo $code?>name = new Spry.Widget.ValidationTextField("spry<?php echo $code?>name");
</script>