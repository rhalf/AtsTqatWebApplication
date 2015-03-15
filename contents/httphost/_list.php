<?php
header("Cache-Control: no-cache, must-revalidate");
include_once("../../settings.php");
include_once("../../scripts.php");
include("_start.php");
?>
<form id="<?php echo $module?>form" name="<?php echo $module?>form" method="post">
  <table id="<?php echo $module?>list">
  <select name="<?php echo $module?>groupby" id="<?php echo $module?>groupby" style="width:145px">
    <option value="httpport"><?php echo constant($module."LivePort");?></option>
    <option value="cmdport"><?php echo constant($module."CmdPort");?></option>
    <option value="clear" selected="selected"><?php echo Clear?></option>
  </select>
  <a id="<?php echo $module?>groupbylabel"><?php echo GroupBy ?> </a>
  <div style="float:left" id="<?php echo $module?>frozendiv">
    	<input type="checkbox" id="<?php echo $module?>frozen"/><label for="<?php echo $module?>frozen"><?php echo FreezeColumns?></label>
        </div>
  
  </table>
  <div id="<?php echo $module?>pager"></div>
  
</form>
<script type="text/javascript">
var <?php echo $module?>loaded=false;
var <?php echo $module?>data ,<?php echo $module?>rowdata;	
</script>
<script type="text/javascript">
function <?php echo $module?>Export(){
var exclude=new Array();
		var model = $("#<?php echo $module?>list").getGridParam('colModel');
	$.each(model, function(i) {
		if(this.hidden == true || this.name=='act' || this.hidedlg==true || this.name=='rn') {
			exclude.push(i);
		}
	});
	var extras={};
ExportToExcel('<?php echo $module?>',<?php echo $module?>data,exclude,extras);
 return false;  
};

function <?php echo $module?>Reload(){
	 $("#<?php echo $module?>list").setGridParam({datatype:'json', page:1}).trigger('reloadGrid');
}

function <?php echo $module?>Search(){
	$("#<?php echo $module?>list").jqGrid('searchGrid', {modal: true,closeOnEscape:true,sopt:['cn','bw','eq','ne','ew'],multipleSearch:true, overlay: false}); 
	var searchDialog = $("#searchmodfbox_"+"<?php echo $module?>list");
	searchDialog.css({position:"absolute", "z-index":$('#<?php echo $module?>dialog').parent().css('z-index')+1});	
	$('#searchmodfbox_<?php echo $module?>list').css('top',($('body').height()/2)-($('#searchmodfbox_<?php echo $module?>list').height()/2));
	$('#searchmodfbox_<?php echo $module?>list').css('left',($('body').width()/2)-($('#searchmodfbox_<?php echo $module?>list').width()/2));
	
	if($('#fbox_<?php echo $module?>list_cancel').length==0){
	
	$('#fbox_<?php echo $module?>list_search').parent().append('<a href="javascript:void(0)" id="fbox_<?php echo $module?>list_cancel" class="fm-button ui-state-default ui-corner-all fm-button-icon-left ui-reset"><span class="ui-icon ui-icon-close"></span><?php echo Close ?></a>')
	}
	$('#fbox_<?php echo $module?>list_reset').prependTo($('#fbox_<?php echo $module?>list_search').parent());
	$('#fbox_<?php echo $module?>list_search').removeClass('fm-button-icon-right').addClass('fm-button-icon-left');
	
	$("#fbox_<?php echo $module?>list_cancel").hover(
	  function () {
		$(this).addClass('ui-state-hover');
	  },
	  function () {
		$(this).removeClass('ui-state-hover');
	  }
	);
	$("#fbox_<?php echo $module?>list_cancel").click(function(e) {
       $("#searchmodfbox_"+"<?php echo $module?>list").find("a.ui-jqdialog-titlebar-close").trigger('click');
    });
	
	$("#<?php echo $module?>list").jqGrid('searchGrid',{afterShowSearch:function(){
		fixSearch('<?php echo $module?>');
	}});
		$("#<?php echo $module?>list").jqGrid('searchGrid',{beforeShowSearch:function(){
		fixSearch('<?php echo $module?>');
	}});
		$('.delete-rule').bind("click", function(){
    	fixSearch('<?php echo $module?>');    
    });
	$('.add-rule').bind("click", function(){
    	fixSearch('<?php echo $module?>');  
    });
		$('#fbox_<?php echo $module?>list_search').bind("click", function(){
    	fixSearch('<?php echo $module?>');   
    });
			$('#fbox_<?php echo $module?>list_reset').bind("click", function(){
    	fixSearch('<?php echo $module?>');  
    });


};	



function <?php echo $module?>Columns(){
	$("#<?php echo $module?>list").jqGrid('columnChooser', {modal: true});
		$('#colchooser_<?php echo $module?>list').parent().find('.ui-dialog-buttonpane').find('.ui-dialog-buttonset').find('.ui-button').first().button({icons: {primary: "ui-icon-check"}}).next().button({icons: {primary: "ui-icon-circle-close"}});
        $("#<?php echo $module?>list").jqGrid('columnChooser', {
		   done : function (perm) {
			  if (perm) {
				  // "OK"
				  this.jqGrid("remapColumns", perm, true);
				  var gwdth = $("#t_<?php echo $module?>list").jqGrid("getGridParam","width");
				  $("#t_<?php echo $module?>list").jqGrid("setGridWidth",gwdth);
			  } else {
				  // "Cancel"
			  }
		   }
	}); 
};	

function <?php echo $module?>Close(){
	 $("#<?php echo $module?>list").jqGrid('GridDestroy');
	 $('#alertmod_<?php echo $module?>list').remove();
	<?php echo $module?>Dialog.Close();
}

function <?php echo $module?>Add(){
	create_<?php echo $module_add?>();
	return false;
}

function <?php echo $module?>Edit(id){
	create_<?php echo $module_edit?>(id);
	return false;
}

function <?php echo $module?>Resize(){
	$("#<?php echo $module?>list").jqGrid("setGridWidth",$('#<?php echo $module?>dialog').width());
	$("#<?php echo $module?>list").jqGrid("setGridHeight",$('#<?php echo $module?>dialog').height()-100);	
};

function <?php echo $module?>Frozen(){
	$("#<?php echo $module?>list").jqGrid('setFrozenColumns');
	<?php echo $module?>loaded=true;	
}
</script>

<script type="text/javascript">

$().ready(function (){
	
  $("#<?php echo $module?>list").jqGrid({
    url:'contents/<?php echo $loc?>/_xml.php',
	mtype: 'GET',
    datatype: 'json',
    colNames:['','id','<?php echo constant($module.'HostName')?>', '<?php echo constant($module.'IPAddress')?>','<?php echo constant($module.'LivePort')?>','<?php echo constant($module.'CmdPort')?>'],
    colModel :[ 
	  {name:'act',index:'act', width:100, align:'center',sortable:false,search:false,frozen:true,stype: 'none',hidedlg:true},
	  {name:'httphostid',index:'httphostid',hidden:true,sortable:false,search:false,frozen:true,stype: 'none',hidedlg:true},	 
      {name:'httphostname', index:'httphostname', width:150, align:'center',search:true,frozen:true, stype:'text'}, 
      {name:'httphostip', index:'httphostip', width:150, align:'center',search:true, stype:'text'}, 
      {name:'httpport', index:'httpport', width:100, align:'center',search:true, stype:'text'},
	   {name:'cmdport', index:'cmdport', width:100, align:'center',search:true, stype:'text'}
    ],
		direction:'<?php echo text_direction?>',
	paging:true,
   	rowNum:10,

   	rowList:[10,20,30],
   	pager: '#<?php echo $module?>pager',
   	sortname: 'httphostname',
	rownumbers: true,
	rownumWidth: 40,
	autowidth: true,
	gridview: true,
	autoheight:true,
	width:'100%',
	height:'100%',
    viewrecords: true,

	sortorder: "asc",

	toolbar: [true,"bottom"],
	loadonce:true,
	shrinkToFit:false,

	gridComplete: function(){
	var	 ids = $("#<?php echo $module?>list").jqGrid('getDataIDs');
		for(var i=0;i<ids.length;i++){
			var cl = ids[i];
			var ret = $("#<?php echo $module?>list").jqGrid('getRowData',ids[i]);
			be = "<a  href=\"#\" onclick=\"javascript:<?php echo $module?>Edit("+ret.httphostid+");\"  ><font color=\"#0066CC\" size=\"2px\"><?php echo Edit?></font></a>";
			$("#<?php echo $module?>list").jqGrid('setRowData',ids[i],{act:be});
		}
		<?php echo $module?>Resize();

	},
	loadComplete: function (data) {
		if($("#<?php echo $module?>list").jqGrid('getGridParam','url')!=''){
		if(data.cols){  
			<?php echo $module?>rowdata=data;
		}else{
			for (i in data.rows){
				data.rows[i].act='';	
			};
			data['cols']=<?php echo $module?>rowdata.cols;
			for (i in data.rows){
				if(("cell" in data.rows[i])){
					delete	data.rows[i]["cell"];
					}
				for (j in data.rows[i]){
					if(! ("cell" in data.rows[i])){
						data.rows[i]["cell"]=[];
					}
					if(j!="_id_"){
						data.rows[i]["cell"].push(data.rows[i][j]);
					}
				}
			}
			
			
		}
		<?php echo $module?>data=data;		
		fixPositionsOfFrozenDivs.call(this);
		}
	}
});
 $('#<?php echo $module?>dialog').bind("dialogresize", function(event, ui) {
      <?php echo $module?>Resize();	
 });
$("#<?php echo $module?>list").jqGrid('navGrid','#<?php echo $module?>pager',{add:false,edit:false,del:false,search:false,refresh:false});



$("#t_<?php echo $module?>list").css('height','32px'); 
$("#<?php echo $module?>pager").css('height','32px'); 

$('.ui-pg-selbox option').addClass('ui-widget-content');
$('.ui-pg-input').css('width','70px');
$('.ui-pg-input').addClass('inputstyle');


$("#t_<?php echo $module?>list").append($("#<?php echo $module?>frozendiv"));

$("#<?php echo $module?>frozen").click(function(){	
var lbl= $("label[for='"+$(this).attr('id')+"']")
	if(lbl.attr('aria-pressed')=='true'){
		$("#<?php echo $module?>list").jqGrid('setFrozenColumns');
		$('.jspDrag').addClass('ui-widget-header');
		$('.jspDrag').css('border','none');
		<?php echo $module?>Reload();
	}else{
		$("#<?php echo $module?>list").jqGrid('destroyFrozenColumns');
		$('#gview_<?php echo $module?>list').find('.frozen-bdiv').remove();
		$('#gview_<?php echo $module?>list').find('.frozen-div').remove();
	}
})


$("#t_<?php echo $module?>list").append($("#<?php echo $module?>groupbylabel"));
$("#t_<?php echo $module?>list").append($("#<?php echo $module?>groupby"));
$("#<?php echo $module?>groupby").change(function(){	
	var vl = $(this).val();
	if(vl) {
		if(vl == "clear") {
			$("#<?php echo $module?>list").jqGrid('groupingRemove',true).trigger('reloadGrid');
			
		} else {
			$("#<?php echo $module?>list").jqGrid('groupingRemove',true).trigger('reloadGrid');
			
			var GroupOption = new Object();
				var groupField = [];
				groupField.push(vl);
				
				GroupOption.groupField = groupField;
				GroupOption.groupColumnShow = true;
				GroupOption.groupCollapse = false;
				GroupOption.groupText = ['<b>{0} - {1} <?php echo HTTPHostCount?></b>'];			
				$("#<?php echo $module?>list").setGridParam({groupingView : GroupOption});
				$("#<?php echo $module?>list").setGridParam({grouping : true}).trigger('reloadGrid');
				groupField.length=0;
				GroupOption.length=0;
		}
	}
});




});
</script>

<script type="text/javascript">
$(function() {
	<?php echo $module?>Dialog.addButton('<?php echo $module?>add','<?php echo Add ?>','<?php echo $module?>Add','add');
	<?php echo $module?>Dialog.addButton('<?php echo $module?>columns','<?php echo Columns ?>','<?php echo $module?>Columns','columns');
	<?php echo $module?>Dialog.addButton('<?php echo $module?>search','<?php echo Search ?>','<?php echo $module?>Search','search');
	<?php echo $module?>Dialog.addButton('<?php echo $module?>reload','<?php echo Reload ?>','<?php echo $module?>Reload','reload');
	<?php echo $module?>Dialog.addButton('<?php echo $module?>export','<?php echo Export ?>','<?php echo $module?>Export','export');
	<?php echo $module?>Dialog.addButton('<?php echo $module?>close','<?php echo Close ?>','<?php echo $module?>Close','close');
	
	$('#<?php echo $module?>groupby').selectmenu();
	$('#<?php echo $module?>frozen').button({icons: {primary: "ui-icon-locked"}});
	$('.ui-pg-selbox').selectmenu({width:75});
	$('.ui-pg-input').css('height','30px');
	
<?php echo $module?>Dialog.setOption('title','<?php echo HTTPHosts ?>');	

});
</script>