<?php
header("Cache-Control: no-cache, must-revalidate");
include_once ("../../settings.php");
include_once("../../scripts.php");
include("_start.php");
?>
<div class="contents ui-widget-content" style="direction:<?php echo text_direction?>">
 <table width="100%" border="0" style="padding:0 0 0 0;margin:0 0 0 0">
  <tr>
    <td valign="top" width="10%"><select name="maps_list" id="maps_list" style="width:150px">
    <?php if($active_googlemap){ ?>
        <option class="ui-widget-content" value="1" selected><?php echo GoogleMap; ?></option>
        <?php }?>
        <?php if($active_bingmap){ ?>
        <option class="ui-widget-content"  value="2"><?php echo BingMap; ?></option>
        <?php }?>
         
        <option class="ui-widget-content" value="3"><?php echo OpenstreetMap; ?></option>
        <?php if($active_ovimap){ ?>
         <option class="ui-widget-content" value="4"><?php echo OviMap; ?></option>
        <?php }?>  
        <?php if($active_nokiamap){ ?>
         <option class="ui-widget-content" value="5"><?php echo NokiaMap; ?></option>
        <?php }?>    
        <?php if($active_arcgismap){ ?>
         <option class="ui-widget-content" value="6"><?php echo ArcGISMap; ?></option>
        <?php }?>           
      </select></td>
    <td align="left" valign="top" width="10%"></td>
    <td align="left" valign="top" width="10%"><div style="margin-top:5px"><a id='addmap' href="javascript:add_map();"><?php echo Add;?></a></div></td>
    <td></td>
  </tr>
</table>
</div>
<script type="text/javascript">
$(document).ready(function(){
		$("select#maps_list").selectmenu();		
	<?php echo $module?>Dialog.addButton('<?php echo $module?>close','<?php echo Close ?>','<?php echo $module?>Close','close');
<?php echo $module?>Dialog.setOption('title','<?php echo MapsManager?>');		
	
});
function add_map() {
	var map=$("#maps_list").val();
if (map==1){
MapClass.currMap = 'gmap';		
}else if(map==2){
MapClass.currMap = 'bmap';		
}else if(map==3){
MapClass.currMap = 'omap';			
}else if(map==4){
MapClass.currMap = 'vmap';		
}else if(map==5){
MapClass.currMap = 'nmap';		
}else if(map==6){
MapClass.currMap = 'amap';		
}
						
    create_map_tab($("#maps_list option:selected").text(), $("#maps_list option:selected").val(),'normal');
	GeoFenceViewer.CreateAll();
};
function <?php echo $module?>Close() {
	<?php echo $module?>Dialog.Close()
}
</script>