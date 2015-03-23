// RealTime
function RealTimeMarker(){
	this.Marker;
	this.Unit;
	this.Locations=[];
	this.Trackable=false;
	this.MapID;
	this.Label;
	this.Img;
	this.AlarmImg;
	this.Deg;
	this.Mobile=false;
	this.InfoWindow;
	this.PopupWindow;
	this.InfoBox;
	this.bingClick;
	this.Status='init';
	this.MoveCounter;
	this.MoveTimeout;
	this.deltaLat;
	this.deltaLng;	
	this.numDeltas;
};


function RTClass(){
	this.Markers=[];
	this.Units=[];

	this.GeoFenceID=[];
	this.GeoFenceUnit=[];

	this.OSMGeoFenceID=[];
	this.OSMGeoFenceUnit=[];
	
	this.bingGeoFenceID=[];
	this.bingGeoFenceUnit=[];
	
	this.lockgrid=false;
	
	this.MarkerExists=function(UnitID){
		if (this.Units.indexOf(UnitID) !=-1){
			return true
		}else{
			return false	
		}	
	};
	
	
	this.getMarker=function(UnitID){
		return this.Markers[this.Units.indexOf(UnitID)];
	};

	this.DeleteMarkers=function(){
		if (MapClass.currMap=='gmap'){
			for (i in this.Markers){		
				this.Markers[i].Marker.setMap(null);
				this.Markers[i].InfoWindow.setMap(null);
				clearTimeout(this.Markers[i].MoveTimeout);	
			}	
		}else if (MapClass.currMap=='omap'){
			for (i in this.Markers){
				osmmaps[this.Markers[i].MapID].getLayer('Tracking'+this.Markers[i].MapID).clearMarkers();		
					this.Markers[i].PopupWindow.destroy();	
				clearTimeout(this.Markers[i].MoveTimeout);
				
			}	
			  
		}else if (MapClass.currMap=='bmap'){
			for (i in this.Markers){
				bmaps[MapClass.currMapID].entities.remove(this.Markers[i].Marker);
				bmaps[MapClass.currMapID].entities.remove(this.Markers[i].InfoBox);		
				clearTimeout(this.Markers[i].MoveTimeout);	
			}	 
		}
		this.Markers.length=0;
	};
	
	
	this.DeleteOneMarker=function(un){
		if (MapClass.currMap=='gmap'){
			for (i in this.Markers){
				if (this.Markers[i].Unit==un){		
					this.Markers[i].Marker.setMap(null);
					this.Markers[i].InfoWindow.setMap(null);
					clearTimeout(this.Markers[i].MoveTimeout);
					removeByIndex(this.Markers,i);
					removeByIndex(this.Units,i);
					break;
				}
			}	
		}else if (MapClass.currMap=='omap'){
			for (i in this.Markers){
				if (this.Markers[i].Unit==un){		
					osmmaps[this.Markers[i].MapID].getLayer('Tracking'+this.Markers[i].MapID).clearMarkers();		
					this.Markers[i].PopupWindow.destroy();	
					clearTimeout(this.Markers[i].MoveTimeout);
					removeByIndex(this.Markers,i);
					removeByIndex(this.Units,i);
					break;
				}
			}	  
		}else if (MapClass.currMap=='bmap'){
			for (i in this.Markers){
				if (this.Markers[i].Unit==un){		
					bmaps[MapClass.currMapID].entities.remove(this.Markers[i].Marker);
					bmaps[MapClass.currMapID].entities.remove(this.Markers[i].InfoBox);
					clearTimeout(this.Markers[i].MoveTimeout);
					removeByIndex(this.Markers,i);
					removeByIndex(this.Units,i);
					break;
				}
			}
		}
		for (i in this.LiveIDs){
			if (this.LiveIDs[i]==un){
				removeByIndex(this.LiveArr,i);
				removeByIndex(this.LiveArrPOS,i);
				removeByIndex(this.LiveArrData,i);
				break;
			}
		}
		$('#rt_edit').hide();	
		var imgID=$(".image" + un).val();
		$('.img' + un).removeAttr("src").attr('src', "images/car/icon_" + imgID + "_stop.gif").attr('height','15px').attr('width','15px');
		$('.imgreg' + un).hide();
		$('.imgexp' + un).hide();
		$('.imgmileagelimit' + un).hide();
		$('.imgonoff' +  un).removeAttr('src').attr('src', "images/admin/off.png");
		removeByIndex(this.LiveObjects,this.LiveIDs.indexOf(un));
		removeByValue(this.LiveIDs,un);
		this.refillGrid();
	};
	
	this.refillGrid=function(){
		this.StopLive();
		this.LiveArr.length=0;
		this.LiveArrPOS.length=0;
		for (i in this.LiveArrData){
			this.LiveArr.push(this.LiveArrData[i].gm_unit);
			this.LiveArrPOS.push(this.LiveArr.length);
		}
		jQuery("#listtrackersdata").jqGrid("clearGridData", true);
		
		for (i in this.LiveArrPOS){
			$("#listtrackersdata").addRowData(i, this.LiveArrData[i]);
			coloring_grid( i-1,$("#listtrackersdata"));
		}
		this.ResumeLive();
	};

	this.DeleteGeoFence=function(){
		if (MapClass.currMap=='gmap'){
			this.GeoFenceID.length=0;
			this.GeoFenceUnit.length=0;
		}else if (MapClass.currMap=='omap'){
			this.OSMGeoFenceID.length=0;
			this.OSMGeoFenceUnit.length=0;
		}else if (MapClass.currMap=='bmap'){
			this.bingGeoFenceID.length=0;
			this.bingGeoFenceUnit.length=0;
		}
	};	

	
this.ViewGeoFence=function(ID,Unit,show){
	 if (MapClass.currMap=='gmap'){		 
		 this.ViewGeoFence_google(ID,Unit,show);
	 }else if (MapClass.currMap=='omap'){
		 this.ViewGeoFence_osm(ID,Unit,show);
	 }else if (MapClass.currMap=='bmap'){
		 this.ViewGeoFence_bing(ID,Unit,show);
	 }
};

 this.ViewGeoFence_google=function(ID,Unit,show){
	if (show){	
		if (this.GeoFenceUnit.indexOf(Unit) == -1){
			this.GeoFenceID.push(ID);
			this.GeoFenceUnit.push(Unit);
		}
		GeoFenceViewer.View(ID,show,true); 
	}else{
		removeByIndex(this.GeoFenceID,this.GeoFenceUnit.indexOf(Unit));
		removeByIndex(this.GeoFenceUnit,this.GeoFenceUnit.indexOf(Unit)); 			
		if (this.GeoFenceID.indexOf(ID) != -1){
			GeoFenceViewer.View(ID,true,true); 
		}else{
			GeoFenceViewer.View(ID,true,false); 	
		}
	}				
};
	
 this.ViewGeoFence_osm=function(ID,Unit,show){
	if (show){	
		if (this.OSMGeoFenceUnit.indexOf(Unit) == -1){
			this.OSMGeoFenceID.push(ID);
			this.OSMGeoFenceUnit.push(Unit);
		}
		GeoFenceViewer.View(ID,show,true); 
	}else{
		removeByIndex(this.OSMGeoFenceID,this.OSMGeoFenceUnit.indexOf(Unit));
		removeByIndex(this.OSMGeoFenceUnit,this.OSMGeoFenceUnit.indexOf(Unit)); 			
		if (this.OSMGeoFenceID.indexOf(ID) != -1){
			GeoFenceViewer.View(ID,true,true); 
		}else{
			GeoFenceViewer.View(ID,true,false); 	
		}
	}		
};	

 this.ViewGeoFence_bing=function(ID,Unit,show){
	if (show){	
		if (this.bingGeoFenceUnit.indexOf(Unit) == -1){
			this.bingGeoFenceID.push(ID);
			this.bingGeoFenceUnit.push(Unit);
		}
		GeoFenceViewer.View(ID,show,true); 
	}else{
		removeByIndex(this.bingGeoFenceID,this.bingGeoFenceUnit.indexOf(Unit));
		removeByIndex(this.bingGeoFenceUnit,this.bingGeoFenceUnit.indexOf(Unit)); 			
		if (this.GeoFenceID.indexOf(ID) != -1){
			GeoFenceViewer.View(ID,true,true); 
		}else{
			GeoFenceViewer.View(ID,true,false); 	
		}
	}				
};

 this.Remove = function(){
		this.DeleteMarkers();
		this.DeleteGeoFence();
		this.Units.length=0;
	};
	
	
// Live
this.req=[];
this.realTimeouts=[];
this.TrackedID='';
this.ONOFFreq=[];
this.ONOFFTimeouts=[];
this.ONOFFInterval;
this.tvar={};
this.LiveArr=[];
this.LiveArrPOS=[];
this.LiveArrData=[];
this.LiveIDs=[];
this.LiveObjects=[];

this.getGridPosition=function(id){
	return this.LiveArrPOS[ this.LiveArr.indexOf(id)]	
};
	
this.AddLive=function(value){
	if ($('.chb'+value).is(':checked')){
		if (this.LiveIDs.indexOf(value)==-1){
			this.LiveIDs.push(value);
			var TrackerObj=new TrackerObject();
				TrackerObj.Mobile=false;
				TrackerObj.Unit=value;
				TrackerObj.Driver=$('.d' + value).html();
				TrackerObj.Vehicle=$('.u' + value).html();;
				TrackerObj.Type=$('.type'+value).val();
				TrackerObj.TrackerImage=$(".img" + value).attr("title");;
				TrackerObj.Inputs=$('.inputs' + value).val();;
				TrackerObj.SpeedLimit=$('.speedlimit' + value).val();
				TrackerObj.MileageLimit=$('.mileagelimit'+value).val();
				TrackerObj.MileageInit=$('.mileage' + value).val();
				TrackerObj.MileageReset=$('.mileagereset'+value).val();
				TrackerObj.Http=$('.http' + value).val();
				TrackerObj.TrackerExpiry=$('.expiry'+value).val();
				TrackerObj.VehicleregExpiry=$('.regexpiry'+value).val();
				this.LiveObjects.push(TrackerObj);
		}
		if ($('#TrkConnected').is(':checked')){	
			this.StartOnOffLive(value,1000);
			if (this.LiveIDs.length==1){	
				this.ONOFFInterval=setInterval(function(){this.ResumeOnOffLive()},120000);
			}
		}
		this.StartLive(this.LiveObjects[this.LiveIDs.indexOf(value)],false,1000);
	}else{
		this.DeleteOneMarker(value);
	
	}
};	
	
this.StartLive=function(object,last,timeout) {
	var _this=this;
	 if (typeof (object)!=='undefined'){
		if (this.LiveIDs.indexOf(object.Unit)!==-1){
			clearTimeout(this.realTimeouts[this.LiveIDs.indexOf(object.Unit)]);
		}
		this.realTimeouts[this.LiveIDs.indexOf(object.Unit)] = setTimeout(function () {
		_this.get_realtimeTracker(object,last)
		}, timeout);
	 }
};

this.ResumeLive=function() {	
	for (i in this.LiveIDs){
		this.AddLive(this.LiveIDs[i]);
	};
};


this.StopLive=function() {
	for ( i in this.req) {
		this.req[i].abort();
	}
	for (i in this.realTimeouts) {
		clearTimeout(this.realTimeouts[i]);	
	}
	this.req.length=0;
	this.realTimeouts.length=0;
};		
	
this.ClearLive=function() {
	this.StopLive();
	this.LiveIDs.length=0;
	this.LiveArr.length=0;
	this.LiveArrPOS.length=0;
	this.LiveArrData.length=0;
	this.LiveObjects.length=0;
	this.Remove();
};

this.get_realtimeTracker=function(object, last) {
	var _this=this;
   // if ($('.chb' + object.Unit).is(":checked") || last) {
	   	if (last && object.Mobile){
			var Url="../connect/get_position.php?uin=" + object.Unit+'&type='+object.Type;	
		}else if (!last && object.Mobile){
			var Url="../connect/get_realtime.php?url=http://"+Http.getIP(object.Http)+':'+Http.getLivePort(object.Http)+"/?id=" + object.Unit;
		}
	   
		if (last && !object.Mobile){
			var Url="connect/get_position.php?uin=" + object.Unit+'&type='+object.Type;	
		}else if (!last && !object.Mobile){
			var Url="connect/get_realtime.php?url=http://"+Http.getIP(object.Http)+':'+Http.getLivePort(object.Http)+"/?id=" + object.Unit;
		}
        this.req[this.LiveIDs.indexOf(object.Unit)] = $.ajax({
            type: 'GET',
            url:Url ,
            // timeout: 60000,    
            success: function (data) {
                if (data != '0' && data != '1' && data.length>10) {
					var tvar={};
                    tvar.length = 0;
                    tvar = eval("(" + data + ")");
					var RTinterval;
					tvar.gm_unit=object.Unit;
					tvar = Parse_tvar(tvar,object,'realtime');	
					if (last==false){
						if (tvar.gm_timeInterval=='' ||tvar.gm_timeInterval==undefined ||tvar.gm_timeInterval=='0' ||tvar.gm_timeInterval=='n/a' ){
							RTinterval='10';
							tvar.gm_timeInterval=RTinterval;
						}else {
							RTinterval=tvar.gm_timeInterval;	
						}
						_this.StartLive(_this.LiveObjects[_this.LiveIDs.indexOf(object.Unit)],false,parseFloat(RTinterval) * 1000);
					}else{
						_this.StartLive(_this.LiveObjects[_this.LiveIDs.indexOf(object.Unit)],false,10000);
					}
                       _this.gotolocation(tvar);
                } else {
					if (_this.LiveArr.indexOf(object.Unit) == -1){
						_this.StartLive(_this.LiveObjects[_this.LiveIDs.indexOf(object.Unit)],true,10000);	
					}else{
						_this.StartLive(_this.LiveObjects[_this.LiveIDs.indexOf(object.Unit)],false,10000);	
					}
					if (grouping=='2'){
							remove_tracker_FromSection(object.Unit,'resultRunning');
							remove_tracker_FromSection(object.Unit,'resultParking');
							remove_tracker_FromSection(object.Unit,'resultIdle');
							remove_tracker_FromSection(object.Unit,'resultUrgent');
							remove_tracker_FromSection(object.Unit,'resultOverSpeed');
							remove_tracker_FromSection(object.Unit,'resultGeoFence');
							remove_tracker_FromSection(object.Unit,'resultBreakDown');
							remove_tracker_FromSection(object.Unit,'resultLost');
							move_tracker_toSection(object.Unit,'resultLost');	
					}
					if ($('#ntlost').is(":checked")){
						setNoty(VEHICLEREG_LBL+' '+object.Vehicle+' '+LOSTMODE_LBL);	
					}
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
              if ( _this.LiveArr.indexOf(object.Unit) == -1){
				  _this.StartLive(_this.LiveObjects[_this.LiveIDs.indexOf(object.Unit)],true,20000);	
				}
				_this.StartLive(_this.LiveObjects[_this.LiveIDs.indexOf(object.Unit)],false,20000);	
            }
        });
    //}
};

this.UpdateMarker=function(tvar){
	/*
		Modified by: Rhalf Wendel D Caacbay
		Modified on: 20150323

		Note:
			*Remarks
				-Added an update for Address
	*/
	if (MapClass.currMap == 'omap') {
		osm_AddressCodeLatLng(tvar.gm_lat, tvar.gm_lng);
		tvar.gm_address = osm_code;
	}


    var unitName = tvar.gm_unit;
    var vreg = tvar.tvehiclereg;
	var Drivername= tvar.tdrivername;
    var unitLat = tvar.gm_lat;
    var unitLng = tvar.gm_lng;
    var unitspeed = tvar.gm_speed;
	var unitmileage=tvar.gm_mileage;
	var unitsignal=tvar.gm_signal;
	var unitinput1=tvar.gm_input1;
	var unitinput2=tvar.gm_input2;
	tvar.pos=this.getGridPosition(unitName);

	var imgid=tvar.imgid;	

	if (GeoFenceViewer.ID.length!=0){
	setGridvalue(tvar.pos,tvar.geoFArea);
	this.ViewGeoFence(tvar.geoFID,unitName,tvar.geoFAlarm);
	}
			

////////////////// parsing states entry
if (tvar.ExpAlarm){
		for(var im=0;im< $('.imgexp' + unitName).length;im++){
			$('.imgexp' + unitName).css('display','block');
		}
}else{
		for(var im=0;im< $('.imgexp' + unitName).length;im++){
			$('.imgexp' + unitName).css('display','none');	
		}
}
	
if(tvar.regAlarm){
	for(var im=0;im< $('.imgreg' + unitName).length;im++){
		$('.imgreg' + unitName).css('display','block');
	}
}else{
	for(var im=0;im< $('.imgreg' + unitName).length;im++){
		$('.imgreg' + unitName).css('display','none');
	}
}

if(tvar.MileageAlarm){
		for(var im=0;im< $('.imgmileagelimit' + unitName).length;im++){
			$('.imgmileagelimit' + unitName).css('display','block');
		}
}else{
		for(var im=0;im< $('.imgmileagelimit' + unitName).length;im++){
			$('.imgmileagelimit' + unitName).css('display','none');	
		}
}

		for(var im=0;im< $('.img' + unitName).length;im++){
			$('.img' + unitName).removeAttr("src").attr('src', tvar.img).attr('height','15px').attr('width','15px');	
		}

// notifacation
if (tvar.lostAlarm){
	if ($('#ntlost').is(":checked")){
		setNoty(VEHICLEREG_LBL+' '+vreg+' '+LOSTMODE_LBL );	
	}
}else if (tvar.UrgentAlarm){
	if ($('#nturgent').is(":checked")){
		setNoty(VEHICLEREG_LBL+' '+vreg+' '+URGENTMODE_LBL );	
	}
}else{	
	if (parseFloat(unitspeed)>0){
		if(!tvar.AccAlarm ){
			if ($('#ntbreakdown').is(":checked")){
				setNoty(VEHICLEREG_LBL+' '+vreg+' '+BREAKDOWNMODE_LBL );	
			}
		}else{	 
			 if( !tvar.geoFAlarm && !tvar.OverSpeedAlarm){
				if ($('#ntrunning').is(":checked")){
					setNoty(VEHICLEREG_LBL+' '+vreg+' '+RUNNINGMODE_LBL);
				}
			 }
			 if( !tvar.geoFAlarm && tvar.OverSpeedAlarm){
				if ($('#ntoverspeed').is(":checked")){
					setNoty(VEHICLEREG_LBL+' '+vreg+' '+OVERSPEEDMODE_LBL );	
				}
			 }
			 if( tvar.geoFAlarm && !tvar.OverSpeedAlarm){
				if ($('#ntgeofence').is(":checked")){
					setNoty( VEHICLEREG_LBL+' '+vreg+' '+GEOFENCEMODE_LBL+' '+ tvar.geoFArea);
				}
			 }	
		}
	}else if (parseFloat(unitspeed)==0){
		if (tvar.AccAlarm){
			if ($('#ntidle').is(":checked")){
				setNoty( VEHICLEREG_LBL+' '+vreg+' '+IDLEMODE_LBL );
			}
		}else{ 
			if (!tvar.geoFAlarm){
				if ($('#ntparking').is(":checked")){
					setNoty(VEHICLEREG_LBL+' '+vreg+' '+PARKINGMODE_LBL );
				}
			}else if (tvar.geoFAlarm )	{
				if ($('#ntgeofence').is(":checked")){
					setNoty( VEHICLEREG_LBL+' '+vreg+' '+GEOFENCEMODE_LBL+' '+ tvar.geoFArea);
				}	
			}
		}
	}
}


// moving to state section 
if (grouping=='2'){
	remove_tracker_FromSection(unitName,'resultRunning');
	remove_tracker_FromSection(unitName,'resultParking');
	remove_tracker_FromSection(unitName,'resultIdle');
	remove_tracker_FromSection(unitName,'resultUrgent');
	remove_tracker_FromSection(unitName,'resultOverSpeed');
	remove_tracker_FromSection(unitName,'resultGeoFence');
	remove_tracker_FromSection(unitName,'resultBreakDown');
	remove_tracker_FromSection(unitName,'resultLost');
	
	
if (tvar.lostAlarm){
		move_tracker_toSection(unitName,'resultLost');
}else if (tvar.UrgentAlarm){
		move_tracker_toSection(unitName,'resultUrgent');	
}else{	
	if (parseFloat(unitspeed)>0){
		if(!tvar.AccAlarm ){
				move_tracker_toSection(unitName,'resultBreakDown');	
		}else{	 
			 if( !tvar.geoFAlarm && !tvar.OverSpeedAlarm){
					move_tracker_toSection(unitName,'resultRunning');	
			 }
			 if( !tvar.geoFAlarm && tvar.OverSpeedAlarm){
					move_tracker_toSection(unitName,'resultOverSpeed');	
			 }
			 if( tvar.geoFAlarm && !tvar.OverSpeedAlarm){
					move_tracker_toSection(unitName,'resultGeoFence');	
			 }	
		}
	}else if (parseFloat(unitspeed)==0){
		if (tvar.AccAlarm){
				move_tracker_toSection(unitName,'resultIdle');
		}else{ 
			if (!tvar.geoFAlarm){
					move_tracker_toSection(unitName,'resultParking');
			}else if (tvar.geoFAlarm )	{
					move_tracker_toSection(unitName,'resultGeoFence');	
			}
		}
	}
}
// counting
$('#RunningSection').text(RUNNINGSECTION_LBL).append("<font size='-3' style='padding-right:40px;float: right;'>" +$('#resultRunning').find($('div[class*="div"]')).size()+' '+TRACKERCOUNT_LBL+"</font>");
$('#ParkingSection').text(PARKINGSECTION_LBL).append("<font size='-3' style='padding-right:40px;float: right;'>" +$('#resultParking').find($('div[class*="div"]')).size()+' '+TRACKERCOUNT_LBL+"</font>");
$('#IdleSection').text(IDLESECTION_LBL).append("<font size='-3' style='padding-right:40px;float: right;'>" +$('#resultIdle').find($('div[class*="div"]')).size()+' '+TRACKERCOUNT_LBL+"</font>");
$('#UrgentSection').text(URGENTSECTION_LBL).append("<font size='-3' style='padding-right:40px;float: right;'>" +$('#resultUrgent').find($('div[class*="div"]')).size()+' '+TRACKERCOUNT_LBL+"</font>");
$('#OverSpeedSection').text(OVERSPEEDSECTION_LBL).append("<font size='-3' style='padding-right:40px;float: right;'>" +$('#resultOverSpeed').find($('div[class*="div"]')).size()+' '+TRACKERCOUNT_LBL+"</font>");
$('#GeoFenceSection').text(GEOFENCESECTION_LBL).append("<font size='-3' style='padding-right:40px;float: right;'>" +$('#resultGeoFence').find($('div[class*="div"]')).size()+' '+TRACKERCOUNT_LBL+"</font>");
$('#BreakDownSection').text(BREAKDOWNSECTION_LBL).append("<font size='-3' style='padding-right:40px;float: right;'>" +$('#resultBreakDown').find($('div[class*="div"]')).size()+' '+TRACKERCOUNT_LBL+"</font>");
$('#LostSection').text(LOSTSECTION_LBL).append("<font size='-3' style='padding-right:40px;float: right;'>" +$('#resultLost').find($('div[class*="div"]')).size()+' '+TRACKERCOUNT_LBL+"</font>");

}

	$('#rotation'+unitName).css(get_rotationStyles(tvar.gm_deg)); 
	$('#arrow'+tvar.gm_unit).removeAttr("src").attr('src', tvar.img);
	
	if (tvar.alarmimg!="none"){
		$('#alarm'+tvar.gm_unit).removeAttr("src").attr('src', tvar.alarmimg);
		$('#alarm'+tvar.gm_unit).show();
	}else{
		$('#alarm'+tvar.gm_unit).hide();
	}
	$('#text'+tvar.gm_unit).html(tvar.caption);
	
};

this.UpdateGrid=function(tvar){
	/*
		Modified by: Rhalf Wendel D Caacbay
		Modified on: 20150323

		Note:
			*Remarks
				-Added an update for Address
	*/
	if (MapClass.currMap == 'omap') {
		osm_AddressCodeLatLng(tvar.gm_lat, tvar.gm_lng);
		tvar.gm_address = osm_code;
	}

 if ( this.LiveArr.indexOf(tvar.gm_unit) == -1) {
		this.LiveArr.push(tvar.gm_unit);
		this.LiveArrPOS.push(this.LiveArr.length);
		this.LiveArrData.push(tvar);
		$("#listtrackersdata").addRowData( this.LiveArr.length, tvar);
		coloring_grid( this.LiveArr.length-1,$("#listtrackersdata"));

    } else {
		$("#listtrackersdata").setRowData(this.getGridPosition(tvar.gm_unit), tvar);
		this.LiveArrData[this.LiveArr.indexOf(tvar.gm_unit)]=tvar;
		coloring_grid( this.LiveArr.indexOf(tvar.gm_unit),$("#listtrackersdata"));
	}
	
    $('#trackerdatarecordcount').html(TRACKERCOUNT_LBL+': ' + jQuery("#listtrackersdata").jqGrid('getGridParam', 'records'));	
	
};



this.CreateMarker=function(tobj){
	var richMarkerContent=$('<div/>', {id: 'marker'+tobj.gm_unit});
	/*
		Modified by: Rhalf Wendel D. Caacbay
		Modified on: 20150316

		Note:
			*Before 
				var arrowImage=$('<img/>', {
					id: 'arrow'+tobj.gm_unit,
					src:tobj.img,
					height:'35px',
					width:'35px'
					});	
				if (tobj.alarmimg!="none"){
					var AlarmImage=$('<img/>', {
						id: 'alarm'+tobj.gm_unit,
						src:tobj.alarmimg,
						height:'35px',
						width:'35px'
					}).css(get_alarmImageStyles());
				}	
	*/
	var arrowImage=$('<img/>', {
		id: 'arrow'+tobj.gm_unit,
		src:tobj.img,
		height:'20px',
		width:'20px'
		});	
	if (tobj.alarmimg!="none"){
		var AlarmImage=$('<img/>', {
			id: 'alarm'+tobj.gm_unit,
			src:tobj.alarmimg,
			height:'20px',
			width:'20px'
		}).css(get_alarmImageStyles());
	}	
	var rotationElement=$('<div/>', {id: 'rotation'+tobj.gm_unit}).css(get_rotationStyles(tobj.gm_deg));
	$(arrowImage).appendTo(rotationElement);
	
	var TextElement=$('<span/>', {id: 'text'+tobj.gm_unit}).html(tobj.caption).css(get_captionStyles());
	TextElement.appendTo(richMarkerContent);
	rotationElement.appendTo(richMarkerContent);
	
	if (tobj.alarmimg!="none"){
		AlarmImage.appendTo(richMarkerContent);
	}	
	return richMarkerContent;
};

this.gotolocation=function(tobj){

	if (tobj.mobile){
		this.osm_gotoLocation(tobj);
	}else{
		if(MapClass.currMap=='gmap'){
			this.google_gotoLocation(tobj)	
		}else if (MapClass.currMap=='omap'){
			this.osm_gotoLocation(tobj)	
		}else if (MapClass.currMap=='bmap'){
			this.bing_gotoLocation(tobj)	
		}
	}
	
};


this.google_gotoLocation=function(tobj) { 
	var _this=this;
	var latlng = new google.maps.LatLng(tobj.gm_lat,tobj.gm_lng);	
	if (this.MarkerExists(tobj.gm_unit)==false){
	var richMarkerContent =this.CreateMarker(tobj);
	marker = new RichMarker({
		position: latlng,
		map: maps[tobj.map],
		flat:true,
		content:richMarkerContent.get(0) 
	});
	var ContentInfo=createInfoWindowContent(tobj);

	var googleMarker=new RealTimeMarker();
	googleMarker.Marker=marker;
	
	googleMarker.InfoWindow = new google.maps.InfoWindow({
    	content: ContentInfo
	});	
	google.maps.event.addListener(googleMarker.Marker, 'click', function() {
  		googleMarker.InfoWindow.open(maps[tobj.map],googleMarker.Marker);
	});
	googleMarker.Unit=tobj.gm_unit;
	googleMarker.MoveCounter=0;
	googleMarker.Locations.push(tobj);
	googleMarker.Trackable=tobj.trackable;
	googleMarker.MapID=tobj.map;
	this.Markers.push(googleMarker);
	this.Units.push(tobj.gm_unit);
		
		setTimeout(function(){
			_this.UpdateMarker(tobj);
		},500);
		this.UpdateGrid(tobj);
		this.moveMarker(googleMarker);

	}else{
		var marker=this.getMarker(tobj.gm_unit);
		marker.Locations.push(tobj);
		marker.Trackable=tobj.trackable;
		marker.MapID=tobj.map;
		marker.Label=tobj.caption;
		marker.Img=tobj.img;
		marker.AlarmImg=tobj.alarmimg;
		marker.Deg=tobj.gm_deg;
		
		marker.Status='stopped';
    } 	
};
	
	
this.moveMarker=function(marker){

var _this=this;

if (marker.Status!='init'){
	if (marker.Status=='stopped' ){
		if (marker.Locations.length>=2){

			var OldLatLng=new google.maps.LatLng(marker.Locations[0].gm_lat,marker.Locations[0].gm_lng);
			var NewLatLng= new google.maps.LatLng(marker.Locations[1].gm_lat,marker.Locations[1].gm_lng);
			marker.numDeltas=new BigNumber(marker.Locations[1].gm_timestamp-marker.Locations[0].gm_timestamp,10).multiply(10);
			if (marker.numDeltas!=0){
				if(marker.Locations[1].gm_speed!=0){
					this.UpdateMarker(marker.Locations[1]);
					marker.InfoWindow.setContent(createInfoWindowContent(marker.Locations[1]));
					this.UpdateGrid(marker.Locations[1]);
					marker.deltaLat =new BigNumber (NewLatLng.lat() - OldLatLng.lat()).divide(marker.numDeltas);
					marker.deltaLng =new BigNumber (NewLatLng.lng() - OldLatLng.lng()).divide(marker.numDeltas);
					marker.Status='started';
				}else{
						this.UpdateMarker(marker.Locations[1]);
						marker.InfoWindow.setContent(createInfoWindowContent(marker.Locations[1]));
						if (!marker.Mobile){
							this.UpdateGrid(marker.Locations[1]);
						}
						removeByIndex(marker.Locations,0);
				}
			}else{
				removeByIndex(marker.Locations,0);	
			}
		}
	}else{			
		var OldLatLng=marker.Marker.getPosition();
		var newLat= new BigNumber(OldLatLng.lat(),10);
		var newLng= new BigNumber(OldLatLng.lng(),10);
		newLat = newLat.add(marker.deltaLat);
		newLng = newLng.add(marker.deltaLng);
		marker.Marker.setPosition(new google.maps.LatLng(newLat, newLng));
		marker.InfoWindow.setPosition(new google.maps.LatLng(newLat, newLng));
			if (marker.Trackable){
				if (maps[marker.MapID].getZoom()<11){
					maps[marker.MapID].setZoom(16);	
				} 
					maps[marker.MapID].setCenter(new google.maps.LatLng(newLat, newLng)); 
			}
		if(marker.MoveCounter!=marker.numDeltas){
			marker.MoveCounter++;
		}else{
			marker.MoveCounter=0; 
			marker.Marker.setPosition(new google.maps.LatLng(marker.Locations[1].gm_lat, marker.Locations[1].gm_lng));
			marker.InfoWindow.setPosition(new google.maps.LatLng(marker.Locations[1].gm_lat, marker.Locations[1].gm_lng));
			marker.Status='stopped';			
			if(marker.Locations[1].gm_speed==0){
				this.setTimer(marker,marker.numDeltas*100);
				this.UpdateMarker(marker.Locations[1]);
				marker.InfoWindow.setContent(createInfoWindowContent(marker.Locations[1]));
				this.UpdateGrid(marker.Locations[1]);
				removeByIndex(marker.Locations,0);
			return;	
			}
			removeByIndex(marker.Locations,0);
			
		}
	}

}
this.setTimer(marker,100);

};

this.setTimer=function(marker,timeout){
	var _this=this;
	clearTimeout(marker.MoveTimeout);
	marker.MoveTimeout=setTimeout(function(){
	
		_this.moveMarker(marker)
	
	}, timeout);
};	
	
	
/*osm_gotoLocation*/	
this.osm_gotoLocation=function(tobj) {
	var _this=this;
	
	if (this.MarkerExists(tobj.gm_unit)==false){
		var richMarkerContent =this.CreateMarker(tobj);	
		/*
			Modified by: Rhalf Wendel D. Caacbay
			Modified on: 20150316

			Note: 
				*Before
					var size = new OpenLayers.Size(50,50);
		*/ 
		var size = new OpenLayers.Size(25,25);
		var offset = new OpenLayers.Pixel(-(size.w/2), -size.h);
		var icon = new OpenLayers.Icon(null, size, offset);   
		icon.imageDiv=richMarkerContent.get(0);
		var lonlat = transform(new OpenLayers.LonLat(tobj.gm_lng, tobj.gm_lat));
		var ContentInfo=createInfoWindowContent(tobj);
		var marker=new OpenLayers.Marker(lonlat,icon);	
		var osmMarker=new RealTimeMarker();
		osmMarker.Marker=marker;
		
		osmMarker.PopupWindow = new OpenLayers.Popup("live"+tobj.gm_unit,
			lonlat,
			/*
				Modified by: Rhalf Wendel D. Caacbay
				Modified on: 20150316

				Note: 
					*Before
						new OpenLayers.Size(255,100)
			*/
			new OpenLayers.Size(255,60),
			ContentInfo,
			true
		);

		/*
			Modified by: Rhalf Wendel D. Caacbay
			Modified on: 20150316

			Note:
				*Added
					osmMarker.PopupWindow.setBorder("1px solid black");
					osmMarker.PopupWindow.setOpacity(0.8);
				*Not Working
					osmMarker.PopupWindow.autoSize();
		*/
		osmMarker.PopupWindow.setBorder("1px solid black");
		osmMarker.PopupWindow.setOpacity(0.8);


		osmMarker.PopupWindow.hide();			   
		osmmaps[tobj.map].addPopup(osmMarker.PopupWindow);	
		
		if (tobj.Mobile){	
			marker.events.register("touchstart", marker,
				function(){
					osmMarker.PopupWindow.show()
				}
			);	
			if($('#vehicles').val()==marker.Unit){
				$("#info").html(ContentInfo);
			}
		}else{
		marker.events.register("mousedown", marker,
			function(){
				osmMarker.PopupWindow.show()
			}
		);		
		/*
			Modified by: Rhalf Wendel D. Caacbay
			Modified on: 20150316

			Note:
				*Added
					events -> mouseout
		*/
		marker.events.register("mouseout", marker,
			function(){
				osmMarker.PopupWindow.hide();
			}
		);
		}
		osmmaps[tobj.map].getLayer('Tracking'+tobj.map).addMarker(marker);
		osmMarker.Unit=tobj.gm_unit;
		osmMarker.MoveCounter=0;
		osmMarker.Locations.push(tobj);
		osmMarker.Trackable=tobj.trackable;
		osmMarker.MapID=tobj.map;
		osmMarker.Mobile=tobj.mobile;
		this.Markers.push(osmMarker);		
		this.Units.push(tobj.gm_unit);
		setTimeout(function(){
			_this.UpdateMarker(tobj);
		},500);
		if (!osmMarker.Mobile){
			this.UpdateGrid(tobj);
		}
		this.moveMarker_osm(osmMarker);		
	}else{
	var marker=this.getMarker(tobj.gm_unit);
		marker.Locations.push(tobj);
		marker.Trackable=tobj.trackable;
		marker.MapID=tobj.map;
		marker.Label=tobj.caption;
		marker.Img=tobj.img;
		marker.AlarmImg=tobj.alarmimg;
		marker.Deg=tobj.gm_deg;		
		marker.Status='stopped';
	}  
  };
  
 this.moveMarker_osm=function(marker){
	var _this=this;
	if (marker.Status!='init'){
		if (marker.Status=='stopped' ){
			if (marker.Locations.length>=2){
				var OldLatLng=new OpenLayers.LonLat(marker.Locations[0].gm_lng, marker.Locations[0].gm_lat);
				var NewLatLng= new OpenLayers.LonLat(marker.Locations[1].gm_lng, marker.Locations[1].gm_lat);
				marker.numDeltas=new BigNumber(marker.Locations[1].gm_timestamp-marker.Locations[0].gm_timestamp).multiply(10);
				//check dublicate
				if (marker.numDeltas!=0){
					if(marker.Locations[1].gm_speed!=0){
						this.UpdateMarker(marker.Locations[1]);
						marker.PopupWindow.setContentHTML(createInfoWindowContent(marker.Locations[1]));
						if (!marker.Mobile){
							this.UpdateGrid(marker.Locations[1]);
						}else{
							if($('#vehicles').val()==marker.Unit){
								$("#info").html(createInfoWindowContent(marker.Locations[1]));
							}
						}
					
					marker.deltaLat = new BigNumber (NewLatLng.lat - OldLatLng.lat).divide(marker.numDeltas);
					marker.deltaLng = new BigNumber (NewLatLng.lon - OldLatLng.lon).divide(marker.numDeltas);
					marker.Status='started';
					}else{
						this.UpdateMarker(marker.Locations[1]);
						marker.PopupWindow.setContentHTML(createInfoWindowContent(marker.Locations[1]));
						if (!marker.Mobile){
							this.UpdateGrid(marker.Locations[1]);
						}else{
							if($('#vehicles').val()==marker.Unit){
								$("#info").html(createInfoWindowContent(marker.Locations[1]));
							}
						}
						removeByIndex(marker.Locations,0);
					}
				}else{
					removeByIndex(marker.Locations,0);	
				}
			}
		}else{
			var OldLatLng=retransform(marker.Marker.lonlat);
			var newLat= new BigNumber(OldLatLng.lat,10);
			var newLng= new BigNumber(OldLatLng.lon,10);
			newLat = newLat.add(marker.deltaLat);
			newLng = newLng.add(marker.deltaLng); 
			var lonlat =transform(new OpenLayers.LonLat(newLng, newLat));
			setLonLat_osm(marker.Marker,lonlat);
			marker.PopupWindow.lonlat=lonlat;
			marker.PopupWindow.updatePosition();
			
			if(marker.Mobile){
				if (marker.Trackable){
					osmmaps[0].setCenter(lonlat);
				}
			}else{
				if (marker.Trackable){
					osmmaps[MapClass.currMapID].setCenter(lonlat);
				}
			}
			if(marker.MoveCounter!=marker.numDeltas){
				marker.MoveCounter++;
			}else{
				marker.MoveCounter=0; 
				var lonlat =transform(new OpenLayers.LonLat(marker.Locations[1].gm_lng, marker.Locations[1].gm_lat));
				setLonLat_osm(marker.Marker,lonlat);
				marker.PopupWindow.lonlat=lonlat;
				marker.PopupWindow.updatePosition();
				
				marker.Status='stopped';
				if(marker.Locations[1].gm_speed==0){
					this.setTimer_osm(marker,marker.numDeltas*100);
					this.UpdateMarker(marker.Locations[1]);
					marker.PopupWindow.setContentHTML(createInfoWindowContent(marker.Locations[1]));
					if (!marker.Mobile){
						this.UpdateGrid(marker.Locations[1]);
					}else{
							if($('#vehicles').val()==marker.Unit){
								$("#info").html(createInfoWindowContent(marker.Locations[1]));
							}
						}
					removeByIndex(marker.Locations,0);
					return;	
				}
				removeByIndex(marker.Locations,0);
			}
		}
	}
	this.setTimer_osm(marker,100)

};

this.setTimer_osm=function(marker,timeout){
	var _this=this;
	clearTimeout(marker.MoveTimeout);
	marker.MoveTimeout=setTimeout(function(){
	
		_this.moveMarker_osm(marker)
	
	}, timeout);
};


/*bing_gotoLocation*/
this.bing_gotoLocation=function(tobj) { 
	var _this=this;
	var latlng = new Microsoft.Maps.Location(tobj.gm_lat,tobj.gm_lng);	
	if (this.MarkerExists(tobj.gm_unit)==false){
	var richMarkerContent =this.CreateMarker(tobj);
	
	var markerOptions = {
		width: null,
		height: null,
		htmlContent: richMarkerContent.html()
	};
	var marker = new Microsoft.Maps.Pushpin(latlng, markerOptions);
	 bmaps[tobj.map].entities.push(marker);
	

	var ContentInfo=createInfoWindowContent(tobj);

	var bingMarker=new RealTimeMarker();
	bingMarker.Marker=marker;
	
	 var infoboxOptions = {title:tobj.tvehiclereg, description:ContentInfo, visible:false}; 
	bingMarker.InfoBox = new Microsoft.Maps.Infobox(latlng, infoboxOptions );
	
	 bmaps[tobj.map].entities.push(bingMarker.InfoBox);    
	
	_this.bingClick = Microsoft.Maps.Events.addHandler(bingMarker.Marker, 'click', function() {
  		bingMarker.InfoBox.setOptions({visible:true});
	});
	bingMarker.Unit=tobj.gm_unit;
	bingMarker.MoveCounter=0;
	bingMarker.Locations.push(tobj);
	bingMarker.Trackable=tobj.trackable;
	bingMarker.MapID=tobj.map;
	this.Markers.push(bingMarker);
	this.Units.push(tobj.gm_unit);
		
		setTimeout(function(){
			_this.UpdateMarker(tobj);
		},500);
		this.UpdateGrid(tobj);
		this.moveMarker_bing(bingMarker);

	}else{
		var marker=this.getMarker(tobj.gm_unit);
		marker.Locations.push(tobj);
		marker.Trackable=tobj.trackable;
		marker.MapID=tobj.map;
		marker.Label=tobj.caption;
		marker.Img=tobj.img;
		marker.AlarmImg=tobj.alarmimg;
		marker.Deg=tobj.gm_deg;
		
		marker.Status='stopped';
    } 	
};
	
	
this.moveMarker_bing=function(marker){

var _this=this;

if (marker.Status!='init'){
	if (marker.Status=='stopped' ){
		if (marker.Locations.length>=2){

			var OldLatLng=new Microsoft.Maps.Location(marker.Locations[0].gm_lat,marker.Locations[0].gm_lng);
			var NewLatLng= new Microsoft.Maps.Location(marker.Locations[1].gm_lat,marker.Locations[1].gm_lng);
			marker.numDeltas=new BigNumber(marker.Locations[1].gm_timestamp-marker.Locations[0].gm_timestamp,10).multiply(10);
			if (marker.numDeltas!=0){
				if(marker.Locations[1].gm_speed!=0){
					this.UpdateMarker(marker.Locations[1]);
					marker.InfoBox.setHtmlContent(createInfoWindowContent(marker.Locations[1]));
					this.UpdateGrid(marker.Locations[1]);
					marker.deltaLat =new BigNumber (NewLatLng.latitude - OldLatLng.latitude).divide(marker.numDeltas);
					marker.deltaLng =new BigNumber (NewLatLng.longitude - OldLatLng.longitude).divide(marker.numDeltas);
					marker.Status='started';
				}else{
						this.UpdateMarker(marker.Locations[1]);
						marker.InfoBox.setHtmlContent(createInfoWindowContent(marker.Locations[1]));
						if (!marker.Mobile){
							this.UpdateGrid(marker.Locations[1]);
						}
						removeByIndex(marker.Locations,0);
				}
			}else{
				removeByIndex(marker.Locations,0);	
			}
		}
	}else{			
		var OldLatLng=marker.Marker.getLocation();
		var newLat= new BigNumber(OldLatLng.latitude,10);
		var newLng= new BigNumber(OldLatLng.longitude,10);
		newLat = newLat.add(marker.deltaLat);
		newLng = newLng.add(marker.deltaLng);
		marker.Marker.setLocation(new Microsoft.Maps.Location(newLat, newLng));
		marker.InfoBox.setLocation(new Microsoft.Maps.Location(newLat, newLng));
			if (marker.Trackable){
				if (bmaps[marker.MapID].getZoom()<11){
					bmaps[marker.MapID].setZoom(16);	
				} 
				bmaps[marker.MapID].setView({ zoom: bmaps[marker.MapID].getZoom(), center: new Microsoft.Maps.Location(newLat, newLng) })
			}
		if(marker.MoveCounter!=marker.numDeltas){
			marker.MoveCounter++;
		}else{
			marker.MoveCounter=0; 
			marker.Marker.setLocation(new Microsoft.Maps.Location(marker.Locations[1].gm_lat, marker.Locations[1].gm_lng));
			marker.InfoBox.setLocation(new Microsoft.Maps.Location(marker.Locations[1].gm_lat, marker.Locations[1].gm_lng));
			marker.Status='stopped';			
			if(marker.Locations[1].gm_speed==0){
				this.setTimer_bing(marker,marker.numDeltas*100);
				this.UpdateMarker(marker.Locations[1]);
				marker.InfoBox.setHtmlContent(createInfoWindowContent(marker.Locations[1]));
				this.UpdateGrid(marker.Locations[1]);
				removeByIndex(marker.Locations,0);
			return;	
			}
			removeByIndex(marker.Locations,0);
			
		}
	}

}
this.setTimer_bing(marker,100);

};

this.setTimer_bing=function(marker,timeout){
	var _this=this;
	clearTimeout(marker.MoveTimeout);
	marker.MoveTimeout=setTimeout(function(){
	
		_this.moveMarker_bing(marker)
	
	}, timeout);
};	


this.StartOnOffLive=function(value,timeout) {
		if (this.LiveIDs.indexOf(value)!==-1){
			clearTimeout(this.ONOFFTimeouts[this.LiveIDs.indexOf(value)]);
		}
		this.ONOFFTimeouts[this.LiveIDs.indexOf(value)] = setTimeout(function () {
			get_TrackerOnOff(value)
		}, timeout);
};

this.ResumeOnOffLive=function() {	
	for (i in this.LiveIDs){
		this.StartOnOffLive(this.LiveIDs[i],(this.LiveIDs.indexOf(this.LiveIDs[i])*500) + 3000);
	};
};

this.StopOnOffLive=function() {
	for ( i in this.ONOFFreq) {
		this.ONOFFreq[i].abort();
	}
	for (i in this.ONOFFTimeouts) {
		clearTimeout(this.ONOFFTimeouts[i]);	
	}
	this.ONOFFreq.length=0;
	this.ONOFFTimeouts.length=0;
	clearInterval(this.ONOFFInterval);
};

};


var RealTimeClass = new RTClass();


function createInfoWindowContent(obj){
	var content='<div class="infowindow contents" style="color:#000">'+
		'<table>'+
			'<tr>'+
				'<td colspan="2"><font size="-3"><strong>Time:</strong></font></td>'+
				'<td colspan="2" style="white-space:nowrap;"><font size="-3">'+obj.gm_time+'</font></td>'+
			'</tr>'+
			'<tr>'+
				'<td><font size="-3"><strong>Vehicle:</strong></font></td>'+
				'<td><font size="-3">'+obj.tvehiclereg+'</font></td>'+
				'<td><font size="-3"><strong>Speed:</strong></font></td>'+
				'<td><font size="-3">'+obj.gm_speed+'</font></td>'+
			'</tr>'+
			'<tr>'+
				'<td><font size="-3"><strong>Driver:</strong></font></td>'+
				'<td><font size="-3">'+obj.tdrivername+'</font></td>'+
				'<td><font size="-3"><strong>ACC:</strong></font></td>'+
				'<td><font size="-3">'+obj.gm_input2+'</font></td>'+
			'</tr>'+
		'</table>'+
    '</div>';
	return content;	
};

function setGridvalue(pos,val){
 $("#listtrackersdata").jqGrid('setRowData', pos, {
		gm_geofence: val
	});	
};



function SearchSectionCheck(set,id) {
	var dub=[];
	$('#'+id).find('input:checkbox').each(function(index, element) {
		var uval=$(element).val();
		if(dub.indexOf(uval)==-1){
		dub.push(uval);	
		var imgID=$(".image" + uval).val();
		 $('.img' + uval).removeAttr("src").attr('src', "images/car/icon_" + imgID + "_stop.gif").attr('height','15px').attr('width','15px');
		 $('.imgonoff' +  uval).removeAttr('src').attr('src', "images/admin/off.png");
		 $('.imgreg' + uval).hide();
		 $('.imgexp' + uval).hide();
		 $('.imgmileagelimit' + uval).hide();
		if (set===-1){
			$('.chb'+ uval).prop("checked",$('.chb'+ uval).is(':checked')?false:true);
		}else{
			$('.chb'+ uval).prop('checked',set)
		}
		RealTimeClass.AddLive(uval);
		}
	});
	dub.length=0;
};


function move_tracker_toSection(classname,section) {
	if(!check_tracker_inSection(classname,section)){
    	$('.div'+ classname).clone(true, true).appendTo('#'+section);
	}
};

function remove_tracker_FromSection(classname,section) {
  $('#'+section).find('.div'+classname).remove();
};

function check_tracker_inSection(classname,section) {
  if ( $('#'+section).find('.div'+classname).length ){
	return  true ; 
  }else {
	return false; 
  }

};


function DoSearch(){
	if (event.keyCode==13){
		search_trackers();
		return false;	
	}	
};

function setNoty(content){
	noty({text:  content });	
};




function get_TrackerOnOff(idx) {
	RealTimeClass.ONOFFreq[RealTimeClass.LiveIDs.indexOf(idx)] = $.ajax({
		type: 'GET',
		url: "connect/get_realtime.php?url=http://"+Http.getIP($('.http' +idx).val())+':'+Http.getLivePort($('.http' + idx).val())+"/?cid=" +idx,
		success: function (data) {
			var cunit = data.split(',')[0];
			var cvalue = data.split(',')[1];
			if (cvalue == '1') {
				$('.imgonoff' + cunit).removeAttr('src').attr('src', "contents/images/admin/on.png")
			} else {
				$('.imgonoff' + cunit).removeAttr('src').attr('src', "contents/images/admin/off.png")
			}
		},
		error: function (XMLHttpRequest, textStatus, errorThrown) {}
	});
};


function unset_TrackerOnOff(){
	for (var i in ONOFFreq) {
		ONOFFreq[i].abort();
	}
	
	for (var i in ONOFFTimeouts) {
	 clearTimeout(ONOFFTimeouts[i]);			
	}
	for (var i in checkboxONOFFArray) {
		$('.imgonoff' + checkboxONOFFArray[i]).removeAttr('src').attr('src', "images/admin/off.png")				
	}
	checkboxONOFFArray.length=0;	
	ONOFFreq.length=0;
	ONOFFTimeouts.length=0;	
};

function strToArray(str){  
	var latlng;
	latLngs = [], 
	str =str.replace(/\s/g, '');
	pairs = str.replace(/^\(|\)$/g,'').split('),('); 
	for(var i=0,pair;pair=pairs[i];i++) { 
		pair = pair.split(',');
		latlng= new google.maps.LatLng(pair[0], pair[1]); 
		latLngs.push(latlng);  
	} 
return 	latLngs;
};

function setLonLat_osm(marker, lonlat) {
    marker.lonlat = lonlat;
	var px = marker.map.getLayerPxFromLonLat(marker.lonlat);
	if (px != null) {
	 marker.draw(px);
	}
};


function get_rotationStyles(deg) {
	/*
		Modified by: Rhalf Wendel D. Caacbay
		Modified on: 20150316
		
		Note:
			*Before
				 if (navigator.appName == 'Microsoft Internet Explorer') {
			        var styles = {
			            'display': 'block',
			            'position': 'relative',
			            '-ms-transform': 'rotate(' + deg + 'deg)',
			            '-o-transform': 'rotate(' + deg + 'deg)',
			            '-moz-transform': 'rotate(' + deg + 'deg)',
			            '-webkit-transform': 'rotate(' + deg + 'deg)',
			            'margin-left': '5px',
			            'margin-top': '24px',
			            'width': '35px',
			            'height': '35px'
			        };
			    } else {
			        var styles = {
			            'display': 'block',
			            'position': 'relative',
			            'left': '0px',
			            'top': '0px',
			            'width': '35px',
			            'height': '35px',
			            '-moz-transform': 'rotate(' + deg + 'deg)',
			            '-moz-transform-origin': '50% 50%',
			            '-webkit-transform': 'rotate(' + deg + 'deg)',
			            '-webkit-transform-origin': '50% 50%'
			        };
			    }
	*/
    if (navigator.appName == 'Microsoft Internet Explorer') {
        var styles = {
            'display': 'block',
            'position': 'relative',
            '-ms-transform': 'rotate(' + deg + 'deg)',
            '-o-transform': 'rotate(' + deg + 'deg)',
            '-moz-transform': 'rotate(' + deg + 'deg)',
            '-webkit-transform': 'rotate(' + deg + 'deg)',
            'margin-left': '5px',
            'margin-top': '24px',
            'width': '20px',
            'height': '20px'
        };
    } else {
        var styles = {
            'display': 'block',
            'position': 'relative',
            'left': '0px',
            'top': '0px',
            'width': '20px',
            'height': '20px',
            '-moz-transform': 'rotate(' + deg + 'deg)',
            '-moz-transform-origin': '50% 50%',
            '-webkit-transform': 'rotate(' + deg + 'deg)',
            '-webkit-transform-origin': '50% 50%'
        };
    }
    return styles;
}
;

function get_alarmImageStyles() {
    var styles = {
        'display': 'block',
        'position': 'absolute',
        'left': '0px',
        'top': '10px',
        'width': '15px',
        'height': '15px'
    };
    return styles;
}
;


/*
    Modified by: Rhalf Wendel D. Caacbay
    Modified on: 20150316

    Note:
    	*Before
			function get_captionStyles() {
			    var styles = {
			        "white-space": "nowrap",
			        "border": "0px",
			        "font-family": "arial",
			        "font-weight": "bold",
			        "color": "white",
			        "background-color": "black",
			        "padding": "0px",
			        "left": "0px",
			        "top": "-5px",
			        "position": "relative",
			        "opacity": ".75",
			        "filter": "alpha(opacity=75)",
			        "-ms-filter": "alpha(opacity=75)",
			        "-khtml-opacity": ".75",
			        "-moz-opacity": ".75"
			    };
			    return styles;
			}
*/

function get_captionStyles() {
    var styles = {
        "font-size" : "10px",
        "white-space": "nowrap",
        "border": "3px",
        "font-family": "calibri",
        "font-weight": "normal",
        "color": "white",
        "background-color": "#000000",

        "padding" : "1x",
        "padding-right" : "4px",
        "padding-left" : "4px",

        "left": "0px",
        "top": "-5px",
        "position": "relative",
        "opacity": "1.0",
        "filter": "alpha(opacity=75)",
        "-ms-filter": "alpha(opacity=75)",
        "-khtml-opacity": "1.0",
        "-moz-opacity": "1.0",

        "-webkit-border-radius" : "10px",
        "-moz-border-radius" : "10px",
        "border-radius" : "10px",
    };
    return styles;
}