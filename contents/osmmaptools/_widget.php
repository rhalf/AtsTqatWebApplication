<?php
header("Cache-Control: no-cache, must-revalidate");
include_once("../../settings.php");
include_once("../../scripts.php");
include("_start.php");
?>

<div id='<?php echo $module?>tabs' style="height:95%;width:100%;padding:0 0 0 0;margin:0 0 0 0;overflow:hidden;">
  <ul style="-moz-border-radius-bottomleft: 0; -moz-border-radius-bottomright: 0;width:100%;padding:0 0 0 0;margin:0 0 0 0">
    <li><a href="#<?php echo $module?>drawing"><?php echo Drawing; ?></a></li>
    <li><a href="#<?php echo $module?>coloring"><?php echo Coloring;?></a></li>
  </ul>
  <div id="<?php echo $module?>drawing" style="height:215px">
    <table width="100%" border="0">
      <tr align="left">
        <td align="center"><select name="<?php echo $module?>SelectTools" id="<?php echo $module?>SelectTools" style="width:150px">
            <option class="ui-widget-content" value="0">Navigate</option>
            <option class="ui-widget-content" value="1">Markers</option>
            <option class="ui-widget-content" value="2">Line</option>
            <option class="ui-widget-content" value="3">Point</option>
            <option class="ui-widget-content" value="4">Polygon</option>
            <option class="ui-widget-content" value="5">regular Polygon</option>
          </select></td>
      </tr>
      <tr>
        <td colspan="2" align="left"><div id="<?php echo $module?>polygontools">
          <label for="sides"> sides</label>
          <input id="sides" type="text" size="2" maxlength="2"
                       name="sides" value="5" onchange="update()" />
          <input id="irregular" type="checkbox"
                               name="irregular" onchange="update()" />
          <label for="irregular">irregular</label>
        </div></td>
      </tr>
      <tr>
        <td colspan="2" align="left"><input type="checkbox" name="type" value="modify" id="modifyToggle"
                       onclick="toggleControl('modify');" />
          <label for="modifyToggle">modify feature</label></td>
      </tr>
      <tr>
        <td colspan="2" align="left"><input id="createVertices" type="checkbox" checked="checked" name="createVertices" onchange="update()" />
          <label for="createVertices"> vertices creation</label></td>
      </tr>
      <tr>
        <td colspan="2" align="left"><input id="rotate" type="checkbox" name="rotate" onchange="update()" />
          <label for="rotate"> rotation</label></td>
      </tr>
      <tr>
        <td colspan="2" align="left"><input id="resize" type="checkbox" name="resize" onchange="update()" />
          <label for="resize"> resizing</label>
          &nbsp;(
          <input id="keepAspectRatio" type="checkbox" name="keepAspectRatio" onchange="update()" checked="checked" />
          <label for="keepAspectRatio">keep aspect ratio</label>
          )&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" align="left"><input id="drag" type="checkbox"
                               name="drag" onchange="update()" />
          <label for="drag"> dragging</label>
          &nbsp;</td>
      </tr>
    </table>
  </div>
  <div id="<?php echo $module?>coloring" style="height:100%">
    <table width="100%">
      <tr>
        <td align="left">Radius</td>
        <td align="left"><input type="text" name="Radius" id="Radius" value="10" class="inputstyle"></td>
      </tr>
      <tr>
        <td align="left">Fill color</td>
        <td align="left"><input class="inputstyle" id="fillColor" name="fillColor" value="FF3414"></td>
      </tr>
      <tr>
        <td align="left">Stroke color</td>
        <td align="left"><input class="inputstyle" id="strokecolor" name="strokecolor" value="BF9643"></td>
      </tr>
      <tr>
        <td align="left">Stroke opacity</td>
        <td align="left"><input type="text" name="strokeopacity" id="strokeopacity" value=".5" class="inputstyle"></td>
      </tr>
      <tr>
        <td align="left">Fill opacity</td>
        <td align="left"><input type="text" name="fillopacity" id="fillopacity" value=".5" class="inputstyle"></td>
      </tr>
      <tr>
        <td align="left">Stroke width</td>
        <td align="left"><input type="text" name="strokewidth" id="strokewidth" value="5" class="inputstyle"></td>
      </tr>
      <tr>
        <td align="left"></td>
        <td align="left"><div id='area'></div></td>
      </tr>
    </table>
  </div>
</div>
<script type="text/javascript">
$('#<?php echo $module?>tabs').tabs({ event: "click",fx: { opacity: 'toggle' } });
$("select#<?php echo $module?>SelectTools").selectmenu();


function <?php echo $module?>Close() {
	<?php echo $module?>Dialog.Close()
}

function <?php echo $module?>Delete() {
	operation_toggleControl($('#<?php echo $module?>SelectTools').val(),'delete');
	$("select#<?php echo $module?>SelectTools").selectmenu("destroy");
	$("select#<?php echo $module?>SelectTools option:first-child").attr("selected", "selected");
	$("select#<?php echo $module?>SelectTools").selectmenu();
	 toggleControl("none");
}

function <?php echo $module?>Hide() {
	operation_toggleControl($('#<?php echo $module?>SelectTools').val(),'hide');
}

function <?php echo $module?>Show() {
	operation_toggleControl($('#<?php echo $module?>SelectTools').val(),'show');
}

$('#<?php echo $module?>polygontools').hide();
$('#<?php echo $module?>SelectTools').change(function () {
	$('#<?php echo $module?>polygontools').hide();
    var idx = $(this).val();
    switch (idx) {
        case "0":
            toggleControl("none");
            break;
        case "1":
            toggleControl("markers");
            break;
        case "2":
            toggleControl("line");
            break;
        case "3":
            toggleControl("point");
            break;
        case "4":
            toggleControl("polygon");
            break;
        case "5":
            toggleControl("regular");
			$('#<?php echo $module?>polygontools').show();
            break;
    }


});

$(function() {
	<?php echo $module?>Dialog.addButton('<?php echo $module?>delete','<?php echo  Delete?>','<?php echo $module?>Delete','delete');
	<?php echo $module?>Dialog.addButton('<?php echo $module?>show','<?php echo  Show ?>','<?php echo $module?>Show','show');
	<?php echo $module?>Dialog.addButton('<?php echo $module?>hide','<?php echo  Hide ?>','<?php echo $module?>Hide','hide');
	<?php echo $module?>Dialog.addButton('<?php echo $module?>close','<?php echo Close ?>','<?php echo $module?>Close','close');
	
<?php echo $module?>Dialog.setOption('title','<?php echo MapTools?>');

var fillColor = new jscolor.color(document.getElementById('fillColor'), {})
fillColor.fromString('FF3414') ;
var strokecolor = new jscolor.color(document.getElementById('strokecolor'), {})
strokecolor.fromString('8F9643') ;

});
</script>