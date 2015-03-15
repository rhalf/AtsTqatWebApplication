function dialogClass(){

this.params={
	name:'',
	title:'',
	height:'',	
	width:'',	
	htmllink:'',
	html:'',
	imagelink:'',
	Extended:false,
	hideclose:false,
	hideheader:false,
	hasdiv:false, // if save options needed
	loaded:false,
	transparent:false,
};

this.icons={
'add':"ui-icon-plus",
'edit':"ui-icon-pencil",
'close':"ui-icon-close",
'cancel':"ui-icon-circle-close",
'export':"ui-icon-arrowthickstop-1-s",	
'reload':"ui-icon-refresh",
'search':"ui-icon-search",
'columns':"ui-icon-calculator",
'save':"ui-icon-check",
'delete':"ui-icon-trash",
'reset':"ui-icon-arrowrefresh-1-e",
'show':"ui-icon-radio-on",
'hide':"ui-icon-radio-off"
};

this.geturl=function(addr){
    var r = $.ajax({
        type: 'GET',
        url: addr,
        async: false
    }).responseText;
    return r;
}


this.setParams=function(settings){
	this.params=$.extend({},this.params,settings);	
}

this.isOpen=function(){
	if($("#"+this.params.name+'dialog').hasClass('ui-dialog-content')){
		if($("#"+this.params.name+'dialog').dialog("isOpen")===true){
			return true;
		}else{
			return false;
		}
	}else{
	return false;	
	}
}

this.Open=function(){
	var _this=this;
	//if (!_this.hasdiv){
		_this.clearButtons();
	//}
	
	$("#"+_this.params.name+'dialog').dialog("open");	
		if (!_this.params.hasdiv || _this.params.loaded==false){
			_this.Load();
		}
		
	if(_this.params.imagelink!=''){
		if ($('#'+_this.params.name+'image').length==0){
			$("#"+_this.params.name+'dialog').parent().find('.ui-dialog-titlebar').prepend('<img id="'+_this.params.name+'image'+'" src="'+_this.params.imagelink+'" style="height:16px;width:16px;float:left;padding-right:3px" />');
			
		 }
	}
	 if(_this.params.hideclose){
	 	$("#"+_this.params.name+'dialog').parent().children().children('.ui-dialog-titlebar-close').hide();
	 }
	if(_this.params.hideheader){
	 	$("#"+_this.params.name+'dialog').parent().find('.ui-dialog-titlebar').hide();
	}
	if(_this.params.transparent){
		$("#"+_this.params.name+'dialog').parent().hide();	
	}
	
}

this.Close=function(){
	var _this=this;
	$("#"+_this.params.name+'dialog').dialog("close");
/*	if (!_this.params.hasdiv){
		if(_this.params.Extended){
			$("#"+_this.params.name+'dialog').dialogExtend("destroy");
		}
	$("#"+_this.params.name+'dialog').dialog("destroy");
	}*/
}


this.setOption=function(option,value){
	var _this=this;
	$("#"+_this.params.name+'dialog').dialog( "option", option, value );
}

	
 this.clearButtons=function(){
	var _this=this;
	var buttons = $('#'+_this.params.name+'dialog').dialog("option", "buttons");
	buttons.length=0;
}

 this.addButton=function(aid,atext,afunc,aicon){
	var _this=this;
	var buttons = $('#'+_this.params.name+'dialog').dialog("option", "buttons");
	buttons.push({
			id:aid,
			text:atext,
			click: function() { 
				eval(afunc+ "()"); 
			},
			icons: {primary: _this.icons[aicon]}
		});
	$('#'+_this.params.name+'dialog').dialog("option", "buttons", buttons);
}

this.Load=function(){
	var _this=this;
	if(_this.params.transparent){
		_this.setOption("dialogClass", "transdiv" );
	}
	if(_this.params.htmllink!=''){
		$("#"+_this.params.name+'dialog').html(_this.geturl(_this.params.htmllink));
	}else{
		$("#"+_this.params.name+'dialog').html(_this.params.html);	
	}
	_this.params.loaded=true;	

}

this.createDialog=function(Open){
	//this.params.Extended=false;
	var _this=this;	
	//if (this.hasdiv){
	//	var Dialog=$('#'+_this.name+'dialog');	
	//}else{
		var Dialog =  $('<div id="'+_this.params.name+'dialog'+'"  class="ui-widget-content" title="'+_this.params.title+'" style="width:auto;padding:0 0 0 0;margin:0 0 0 0;overflow:hidden"></div>');
	//}
Dialog.dialog({
        autoOpen: false,
		hide: 'fade',
        show: 'fade',
        buttons: [
        ],
        closeOnEscape: true,
        closeText: 'close',
        dialogClass: '',
        draggable: true,
		resizable: true,
        height: _this.params.height,
        width: _this.params.width,
        maxHeight: false,
        maxWidth: false,
        minHeight: _this.params.height,
        minWidth: _this.params.width,
        modal: false,
	close:function(){
		if (typeof window[_this.params.name+ "Close"]=='function'){
			eval(_this.params.name+ "Close()");
		}else{
			_this.Close();
		}
	},
	open: function(event, ui) {
        if(_this.params.transparent){
			$(this).parent().hover( function () {
            $(this).css('opacity', 0.9);
        }, function (event) {
            $(this).css('opacity', 0.6);
        });
		}
    }
		
    });
if(_this.params.extended){	
Dialog.dialogExtend({
        "closable" : true,
        "maximizable" : true,
        "minimizable" : true,
       // "collapsable" : false,
        "dblclick" : "maximize",
        "titlebar" : false,
        "minimizeLocation" : "left",
        "icons" : {
          "close" : "ui-icon-close",
          "maximize" : "ui-icon-plus",
          "minimize" : "ui-icon-minus",
          "collapse" : "ui-icon-triangle-1-s",
          "restore" : "ui-icon-triangle-1-s"
        },
        "load" : function(evt, dlg){  },
        "beforeCollapse" : function(evt, dlg){  },
        "beforeMaximize" : function(evt, dlg){  },
        "beforeMinimize" : function(evt, dlg){$("#"+_this.params.name+'dialog').dialogExtend("maximize");  },
        "beforeRestore" : function(evt, dlg){  },
        "collapse" : function(evt, dlg){ },
        "maximize" : function(evt, dlg){ 
			if (typeof window[_this.params.name+ "Resize"]=='function'){
				eval(_this.params.name+ "Resize()");
			}
		 },
       "minimize" : function(evt, dlg){ 
			if (typeof window[_this.params.name+ "Resize"]=='function'){
				eval(_this.params.name+ "Resize()");
			}
		 },
        "restore" : function(evt, dlg){ 
			if (typeof window[_this.params.name+ "Resize"]=='function'){
				eval(_this.params.name+ "Resize()");
			}
		}
});		
}
	 if(Open){
		_this.Open();  
		  
	  }
	 if (_this.params.hasdiv ){
		this.Load();
	}
};
}