function historicalDataClass(){
	this.fromdate;
	this.todate;
	this.exclude=true;
	this.items=[];
	this.obj;
		
this.Excute=function(un,TimeZone) {
	_this=this;
	
	if ($('#ExcludeData').is(":checked")){
		_this.exclude='1'	
	}else {
		_this.exclude='0'	
	}
	
    var u = 'contents/historicalreport/_xml.php?uin=' + un + '&exclude=' + _this.exclude

    + '&fdate=' + _this.fromdate + '&tdate=' + _this.todate;

    $.getJSON(u, function (json) {
        if (json != null && !jQuery.isEmptyObject(json)) {
			var TrackerObj=new TrackerObject();
				TrackerObj.Mobile=false;
				TrackerObj.Unit=un;
				TrackerObj.Driver=$('.d' + un).html();
				TrackerObj.Vehicle=$('.u' + un).html();;
				TrackerObj.Type=$('.type'+un).val();
				TrackerObj.TrackerImage=$(".img" + un).attr("title");;
				TrackerObj.Inputs=$('.inputs' + un).val();;
				TrackerObj.SpeedLimit=$('.speedlimit' + un).val();
				TrackerObj.MileageLimit=$('.mileagelimit'+un).val();
				TrackerObj.MileageInit=$('.mileage' + un).val();
				TrackerObj.MileageReset=$('.mileagereset'+un).val();
				TrackerObj.Http=$('.http' + un).val();
				TrackerObj.TrackerExpiry=$('.expiry'+un).val();
				TrackerObj.VehicleregExpiry=$('.regexpiry'+un).val();
				_this.obj=TrackerObj;						
            $.each(json.rows, function (i, item) {
                var trVariable = {};
                trVariable.length = 0;
                trVariable = eval("({" + item.cell + "})");
				trVariable.gm_unit=un;
				_this.Items.push(trVariable);
            });
				_this.Apply();
        }else{
		}
    });
};	
  
 this.Apply=function(i) { 
 
 var latlng = new google.maps.LatLng(TrackingReplayArray[0].Items[i].gm_lat,TrackingReplayArray[0].Items[i].gm_lng);
 var tvar=Parse_tvar(TrackingReplayArray[0].Items[i],TrackingReplayArray[0].Obj);	
	var richMarkerContent =CreateMarker(tvar);
	marker = new RichMarker({
		position: latlng,
		map: maps[TrackingReplayArray[0].Map],
		flat:true,
		content:richMarkerContent.get(0) 
	});
	TrackingReplayArray[0].Marker=marker;
  };
  
 
   

this.Clear=function(){
	if (TrackingReplayArray[0]){
	//$('#maptabs').tabs('remove', TrackingReplayArray[0].Map);
	$(".mapclose"+TrackingReplayArray[0].Map).click();
	removeByValue(MapClass.tabs, "map"+TrackingReplayArray[0].Map);
	TrackingReplayArray[0].Remove();
	}else{
	//$('#maptabs').tabs('remove', MapClass.currMapID-1);	
	$(".mapclose"+MapClass.currMapID-1).click();
	removeByValue(MapClass.tabs, "map"+MapClass.currMapID-1);
	}
	
	$('#treplay').html('');
	$('#treplayli').hide();
	$('#layout-south_tabs').tabs( "option", "active",0 );
};

};

var TrackingReply=new TrackingReplyClass();