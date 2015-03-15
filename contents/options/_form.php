<?php
header("Cache-Control: no-cache, must-revalidate");
include_once ("../../settings.php");
include_once("../../scripts.php");
include("_start.php");
$link="contents/{$loc}/_cmd.php";
$settings=$session->get('settings');
$notifications=json_decode(get_setting('notification_'.$userid,$settings),true);
?>
<div class="contents ui-widget-content" style="direction:<?php echo text_direction?>">
 <form action="<?php echo $link?>" method="post" target="_self" id="<?php echo $module?>form" name="<?php echo $module?>form" onSubmit="return <?php echo $module?>OnSubmit(this);" >
  <table width="100%" border="0">
    <tr>
      <td width="40%"><?php echo Notification ?></td>
      <?php 
	  $checked='';
	  if (is_array($notifications)){
	  	$checked=$notifications['ntrunning']==1?'checked="checked"':'';
	  }
	  ?>
      <td><input name="ntrunning" type="checkbox" id="ntrunning" <?php echo $checked ?>>
        <label for="ntrunning"><?php echo RunningSection ?></label></td>
      <?php 
	  $checked='';
	  if (is_array($notifications)){
	  	$checked=$notifications['ntparking']==1?'checked="checked"':'';
	  }
	  ?> 
      <td><input type="checkbox" name="ntparking" id="ntparking" <?php echo $checked ?>>
        <label for="ntparking"><?php echo ParkingSection ?></label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <?php 
	  $checked='';
	  if (is_array($notifications)){
	  	$checked=$notifications['ntidle']==1?'checked="checked"':'';
	  }
	  ?> 
      <td><input type="checkbox" name="ntidle" id="ntidle" <?php echo $checked ?>>
        <label for="ntidle"></label>
        <?php echo IdleSection ?></td>
      <?php 
	  $checked='';
	  if (is_array($notifications)){
	  	$checked=$notifications['ntoverspeed']==1?'checked="checked"':'';
	  }
	  ?> 
      <td><input type="checkbox" name="ntoverspeed" id="ntoverspeed" <?php echo $checked ?>>
        <label for="ntoverspeed"><?php echo OverSpeedSection ?></label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <?php 
	  $checked='';
	  if (is_array($notifications)){
	  	$checked=$notifications['nturgent']==1?'checked="checked"':'';
	  }
	  ?> 
      <td><input type="checkbox" name="nturgent" id="nturgent" <?php echo $checked ?>>
        <label for="nturgent"><?php echo UrgentSection ?></label></td>
        
      <?php 
	  $checked='';
	  if (is_array($notifications)){
	  	$checked=$notifications['ntgeofence']==1?'checked="checked"':'';
	  }
	  ?> 
      <td><input type="checkbox" name="ntgeofence" id="ntgeofence" <?php echo $checked ?>>
        <label for="ntgeofence"><?php echo GeoFenceSection ?></label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <?php 
	  $checked='';
	  if (is_array($notifications)){
	  	$checked=$notifications['ntlost']==1?'checked="checked"':'';
	  }
	  ?> 
      <td><input type="checkbox" name="ntlost" id="ntlost" <?php echo $checked ?>>
        <label for="ntlost"></label>
        <?php echo LostSection ?></td>
      <?php 
	  $checked='';
	  if (is_array($notifications)){
	  	$checked=$notifications['ntbreakdown']==1?'checked="checked"':'';
	  }
	  ?> 
        <td><input type="checkbox" name="ntbreakdown" id="ntbreakdown" <?php echo $checked ?>>
        <label for="ntbreakdown"><?php echo BreakDownSection ?></label></td>
    </tr>
    <tr>
      <td><?php echo GroupingBy;?></td>
      <td colspan="2">
          <div style="width:100%"><select name="TGroupingBy" id="TGroupingBy" style="width:200px">
            <?php
foreach($gtypes as $gtype =>$value){
	if($privilege==1){
    $selected =get_setting('grouping_'.$userid,$settings)==$value? ' SELECTED' : '';
    echo '<option class="ui-widget-content" value="'.$value.'"'.$selected.'>'.$gtype.'</option>';	
		
	}else{
		if ($value!=0){
    $selected =get_setting('grouping_'.$userid,$settings)==$value? ' SELECTED' : '';
    	echo '<option class="ui-widget-content" value="'.$value.'"'.$selected.'>'.$gtype.'</option>';
		}
	}
}
?>
          </select></div>
       </td>
    </tr>
    <tr>
      <td><?php echo IconCaption;?></td>
      <td colspan="2"><div style="width:100%"><select name="iconcaption" id="iconcaption" style="width:200px">
      <?php 
$selected0 =get_setting('iconcaption_'.$userid,$settings)==0? ' SELECTED' : '';	 
$selected1 =get_setting('iconcaption_'.$userid,$settings)==1? ' SELECTED' : '';	 
	  ?>
          <option class="ui-widget-content" value="0" <?php echo $selected0 ?>><?php echo VehicleReg;?></option>
          <option class="ui-widget-content" value="1" <?php echo $selected1 ?>><?php echo DriverName;?></option>
        </select></div></td>
    </tr>
    <tr>
      <td><?php echo TrackersConnected ?></td>
       <?php 
	  $checked='';
	  $checked=get_setting('TrkConnected_'.$userid,$settings)==1?'checked="checked"':'';
	  ?> 
      <td><input type="checkbox" name="TrkConnected" id="TrkConnected" <?php echo $checked ?> /></td>
        <td></td>
    </tr>
    <tr>
      <td><?php echo ExcludeData ?></td>
             <?php 
	  $checked='';
	  $exdata=get_setting('ExcludeData_'.$userid,$settings);
	  $checked=(($exdata==1)or($exdata==''))?'checked="checked"':'';
	  ?> 
      <td><input name="ExcludeData" type="checkbox" id="ExcludeData" <?php echo $checked ?> />
        <label for="ExcludeData"></label></td>
          <td></td>
    </tr>
    <tr>
      <td align="left"><?php echo DisplayonMap ?></td>
      <?php 
	  $checked='';
	  $displmap=get_setting('gf_displaycheck_'.$userid,$settings);
	 $checked=(($displmap==1)or($displmap==''))?'checked="checked"':'';
	  ?> 
      <td><input name="gf_displaycheck" type="checkbox" id="gf_displaycheck" <?php echo $checked ?>/></td>
        <td></td>
    </tr>
    <tr>
      <?php if (($privilege==1)or($privilege==2)){ ?>
      <td><?php echo Logo ?></td>
     
      <td>
      
    
    <span class="fileinput-button">
        <span>Select file...</span>
        <input id="logofile" type="file" name="logofile">
    </span>
      
      
   </td>
   <td><span class="resetlogo-button" onclick="javascript:reset_logoicon();" style="float:left"><span>reset</span></span></td>
      <?php }?>
    </tr>
  </table>
  </form>
  </div>
  <script type="text/javascript">
  
function <?php echo $module?>Save(){	
 $('#<?php echo $module?>form').submit();
}  
  
 function <?php echo $module?>Response(req){
	ShowMessage(req.xhRequest.responseText);

	$('#rightdiv').hide();
	$('#rightdiv').load("main/get_menu_trackers.php");
	$('#rightdiv').delay(1000).show();

	<?php echo $module?>Close();
}

function <?php echo $module?>OnSubmit(form){	
	if (Spry.Widget.Form.validate(form) == true){
		Spry.Utils.submitForm(form, <?php echo $module?>Response);
	}
	return false;
} 
  
  
  
$(document).ready(function(){	
$('.fileinput-button').button({icons: {primary: "ui-icon-plus"}});
$('.resetlogo-button').button({icons: {primary: "ui-icon-trash"}});

	<?php echo $module?>Dialog.addButton('<?php echo $module?>save','<?php echo Save ?>','<?php echo $module?>Save','save');	

	<?php echo $module?>Dialog.addButton('<?php echo $module?>close','<?php echo Close ?>','<?php echo $module?>Close','close');

	
<?php echo $module?>Dialog.setOption('title','<?php echo Options?>');	
});  
  
  	$("select#iconcaption").selectmenu();
	$("select#TGroupingBy").selectmenu();
	
function <?php echo $module?>Close() {
	<?php echo $module?>Dialog.Close()
}	


	
	// fileUpload
    $('#logofile').fileupload(
	{
		url:"connect/uploadfile.php",
		done: function (e, data) {
		$('.header-image').html(geturl("main/main_header_image.php")); 
        }
    });	
	
	
	function reset_logoicon (){
	   $.ajax({    
		 type: 'POST',    
		 url:"connect/reset_logoicon.php",     
		success: function(data) { 
			$('.header-image').html(geturl("main/main_header_image.php"));   
		 },    
		error: function (XMLHttpRequest, textStatus, errorThrown) {     
		// $("#etdiv_image").html('Timeout contacting server..');     
		 }
		});	
	};
  </script>