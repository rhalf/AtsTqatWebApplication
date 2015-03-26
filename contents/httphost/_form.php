<?php
header("Cache-Control: no-cache, must-revalidate");
include_once ("../../settings.php");
include_once("../../scripts.php");
include("_start.php");

if(!$_GET['type'])die;
$type=$_GET['type'];

if ($type==1){
	$code=$module_add;	
	$link="contents/{$loc}/_cmd.php?type=1";
}else if ($type==2){
	if (!isset($_GET['id']))die;
	$id=$_GET["id"];
	$code=$module_edit;	
	$link="contents/{$loc}/_cmd.php?type=2";
	$Result=$session->get('httphosts');
	foreach ($Result as $row){
		if ($id==$row['httphostid']){
			$httphostRow=$row;	
			break;	
		}
	}
	$link.="&id=$id";
}
?>
<div class="contents ui-widget-content" style="direction:<?php echo text_direction?>">
   <form method="post" id="<?php echo $code?>form" name= "<?php echo $code?>form" target="_self" action="<?php
echo $link ?>" onSubmit="return <?php echo $code?>OnSubmit(this);">
    <table width="100%" height="100%" border="0">
       <tr>
        <td width="105" height="24"><label for="<?php echo $code?>hostname"><?php echo constant($module.'HostName')?></label></td>
        <td width="208"><span id="spry<?php echo $code?>hostname">
        <input name="<?php echo $code?>hostname" type="text" id="<?php echo $code?>hostname" style="width:100%" maxlength="50" value="<?php
if ($type==2){
echo $httphostRow['httphostname'];
}
?>" title="Required, Min chars is 4, Max chars is 50" class="inputstyle" />
        <span class="textfieldRequiredMsg"></span><span class="textfieldMinCharsMsg"></span><span class="textfieldMaxCharsMsg"></span></span></td>
      </tr>
       <tr>
        <td width="105" height="24"><label for="<?php echo $code?>hostip"><?php echo constant($module.'IPAddress')?></label></td>
        <td width="208"><span id="spry<?php echo $code?>hostip">
        <input name="<?php echo $code?>hostip" type="text" id="<?php echo $code?>hostip" style="width:100%" maxlength="50"  value="<?php
if ($type==2){
echo $httphostRow['httphostip'];
}
?>" title="Required, Min chars is 4, Max chars is 50" class="inputstyle"/>
        <span class="textfieldRequiredMsg"></span><span class="textfieldMinCharsMsg"></span><span class="textfieldMaxCharsMsg"></span></span></td>
      </tr>
       <tr>
        <td width="105" height="24"><label for="<?php echo $code?>httpport"><?php echo constant($module.'LivePort')?></label></td>
        <td width="208"><span id="spry<?php echo $code?>liveport">
        <input name="<?php echo $code?>liveport" type="text" id="<?php echo $code?>liveport" style="width:100%" maxlength="5" title="Required, Min value is 0, Max value is 65535" class="inputstyle" value="<?php
if ($type==2){
echo $httphostRow['httpport'];
}
?>"/>
        <span class="textfieldRequiredMsg"></span><span class="textfieldInvalidFormatMsg"></span><span class="textfieldMinValueMsg"></span><span class="textfieldMaxValueMsg"></span></span></td>
      </tr>
       <tr>
         <td height="24"><?php echo constant($module.'CmdPort')?></td>
         <td>
      <span id="spry<?php echo $code?>cmdport">
        <input name="<?php echo $code?>cmdport" type="text" id="<?php echo $code?>cmdport" style="width:100%" maxlength="5" title="Required, Min value is 0, Max value is 65535" class="inputstyle" value="<?php
if ($type==2){
echo $httphostRow['cmdport'];
}
?>"/>
        <span class="textfieldRequiredMsg"></span><span class="textfieldInvalidFormatMsg"></span><span class="textfieldMinValueMsg"></span><span class="textfieldMaxValueMsg"></span></span></td>
       </tr>
     </table>
  </form>
 </div>
<script type="text/javascript">
var spry<?php echo $code?>hostname = new Spry.Widget.ValidationTextField("spry<?php echo $code?>hostname", "none", {minChars:4, maxChars:50});
var spry<?php echo $code?>hostip = new Spry.Widget.ValidationTextField("spry<?php echo $code?>hostip", "ip");
var spry<?php echo $code?>liveport = new Spry.Widget.ValidationTextField("spry<?php echo $code?>liveport", "integer", {minValue:0, maxValue:65535});
var spry<?php echo $code?>cmdport = new Spry.Widget.ValidationTextField("spry<?php echo $code?>cmdport", "integer", {minValue:0, maxValue:65535});
</script>
<script type="text/javascript">
function <?php echo $code?>Close(){	
	<?php echo $code?>Dialog.Close();
}

function <?php echo $code?>Save(){	
	$('#<?php echo $code?>form').submit();
}

function <?php echo $code?>resetForm(){	
	$('#<?php echo $code?>form')[0].reset();
}	

function <?php echo $code?>Resize(){	
}

function <?php echo $code?>Response(req){
	ShowMessage(req.xhRequest.responseText);
	if ( <?php echo $module?>Dialog.isOpen()){
	   <?php echo $module?>Reload();
	}
	<?php if ($type==1){?>
	 <?php echo $code?>resetForm();	
	<?php }else if ($type==2){?>
	<?php echo $code?>Dialog.Close();
	<?php }?>	 	
} 
function <?php echo $code?>OnSubmit(form){
	if (Spry.Widget.Form.validate(form) == true){
		
		Spry.Utils.submitForm(form, <?php echo $code?>Response);	
	}
	return false;
}
<?php if ($type==2){?>		
function <?php echo $code?>Delete() {
	var u='contents/<?php echo $loc?>/_cmd.php?type=3&id='+'<?php echo $id?>';
  $.ajax({    
  type: 'POST',    
   url:u ,     
	success: function(data) {      
		ShowMessage(data);
		<?php echo $code?>Close();
		if (<?php echo $module?>Dialog.isOpen()){
	   <?php echo $module?>Reload();
		}
	 },    
	error: function (XMLHttpRequest, textStatus, errorThrown) {     
	 	ShowMessage('Timeout contacting server..');       
	  }});
};	
<?php }?>
 </script>
<script type="text/javascript">
$(document).ready(function(e) {
	
<?php if($type==1){?>
<?php echo $code?>Dialog.addButton('<?php echo $code?>add','<?php echo Save ?>','<?php echo $code?>Save','save');
<?php echo $code?>Dialog.addButton('<?php echo $code?>reset','<?php echo Reset ?>','<?php echo $code?>resetForm','reset');
<?php echo $code?>Dialog.addButton('<?php echo $code?>close','<?php echo Close ?>','<?php echo $code?>Close','close');
<?php echo $code?>Dialog.setOption('title','<?php echo AddHTTPHost ?>');
<?php }else if($type==2){?>
<?php echo $code?>Dialog.addButton('<?php echo $code?>add','<?php echo Save ?>','<?php echo $code?>Save','save');
<?php echo $code?>Dialog.addButton('<?php echo $code?>delete','<?php echo Delete ?>','<?php echo $code?>Delete','delete');
<?php echo $code?>Dialog.addButton('<?php echo $code?>close','<?php echo Close ?>','<?php echo $code?>Close','close');
<?php echo $code?>Dialog.setOption('title','<?php echo EditHTTPHost ?>');
<?php }?>	

});
</script>