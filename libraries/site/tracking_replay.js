
function TrackingReplayObjectClass(){
	this.Items = [];
	this.Paths=[];
	this.OSM_MarkersLonLat=[];
	this.OSM_LonLat=[]; 
	this.Polys=[];
	this.Obj;
	this.Marker;
	this.Map=1;
	this.MapName='gmap';
	this.fromdate;
	this.todate;
	this.exclude=true;
	
	this.AddPaths=function(obj){
		this.Paths.push(obj);
	};
	this.DeletePaths=function(){
		this.Paths.length=0;
	};
	this.AddOSM_MarkersLonLat=function(obj){
		this.OSM_MarkersLonLat.push(obj);
	};
	this.DeleteOSM_MarkersLonLat=function(){
		this.OSM_MarkersLonLat.length=0;
	};
	
	this.AddOSM_LonLat=function(obj){
		this.OSM_LonLat.push(obj);
	};
	this.DeleteOSM_LonLat=function(){
		this.OSM_LonLat.length=0;
	};

	this.DeleteMarker=function(){
		if (this.MapName=='gmap'){	
			this.Marker.setMap(null);	
		}else if (this.MapName=='omap'){
			MarkerReplayLayer.clearMarkers();
		}else if (this.MapName=='bmap'){
			bmaps[Map].entities.remove(this.Marker);
		}
	};
	this.AddPolys=function(obj){
		this.Polys.push(obj);
	};
	this.DeletePolys=function(){
		if (this.MapName=='gmap'){
			for (i in this.Polys){
				this.Polys[i].setMap(null);	
			}
		}else if (this.MapName=='omap'){
			lineLayer.removeFeatures([lineFeature]);	
		}else if (this.MapName=='bmap'){
			for (i in this.Polys){
				bmaps[this.Map].entities.remove(this.Polys[i]);	
			}	
		}
		this.Polys.length=0;
	};
	this.Remove=function(){
		this.DeletePolys();
		this.DeleteMarker();
		this.DeletePaths();
		this.DeleteOSM_MarkersLonLat();
		this.DeleteOSM_LonLat();
		this.Items.length=0;
	};
};


function TrackingReplyClass(){
	
	this.GeoFenceID=[];
	this.GeoFenceUnit=[];

	this.OSMGeoFenceID=[];
	this.OSMGeoFenceUnit=[];	
	
	this.bingGeoFenceID=[];
	this.bingGeoFenceUnit=[];
	
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
		if (this.bingGeoFenceID.indexOf(ID) != -1){
			GeoFenceViewer.View(ID,true,true); 
		}else{
			GeoFenceViewer.View(ID,true,false); 	
		}
	}				
};
	
this.Excute=function(un,MapID,MapName,TimeZone) {
	_this=this;
	TRObj=new TrackingReplayObjectClass();
	TRObj.Map=MapID;
	TRObj.MapName=MapName;
	
	
	if ($('#ExcludeData').is(":checked")){
		TRObj.exclude='1'	
	}else {
		TRObj.exclude='0'	
	}
	
    var u = 'contents/tracking_replay/_xml.php?uin=' + un + '&exclude=' + TRObj.exclude

    + '&fdate=' + _this.fromdate + '&tdate=' + _this.todate;

    ShowMessage('Loading..');
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
				TRObj.Obj=TrackerObj;		
            $.each(json.rows, function (i, item) {
                var trVariable = {};
                trVariable.length = 0;
                trVariable = eval("({" + item.cell + "})");
				trVariable.gm_unit=un;
				
                if (MapName == 'gmap') {
                    _this.Add(trVariable.gm_lat, trVariable.gm_lng,TRObj);
                }else if (MapName == 'omap') {
                    _this.Add_osm(trVariable.gm_lat, trVariable.gm_lng,TRObj);
                }else if (MapName == 'bmap') {
                    _this.Add_bing(trVariable.gm_lat, trVariable.gm_lng,TRObj);
                }
				TRObj.Items.push(trVariable);
            });
			TrackingReplayArray.push(TRObj);
			 if (MapName == 'gmap') {
                    _this.addMarker(0);
              }else if (MapName == 'omap') {
                    _this.addMarker_osm(0);
              }else if (MapName == 'bmap') {
                    _this.addMarker_bing(0);
              }
            if (MapName == 'omap') {
                _this.Apply_osm();
            }else if (MapName == 'gmap'){
				_this.Apply();
			}else if (MapName == 'bmap'){
				_this.Apply_bing();
			}

            $('#treplay').load("main/tracking_replay_tab.php");
        }else{
			ShowMessage('No tracking data.');
			_this.Clear();
		}
    });
};	
	

this.Add=function(Lat,Long,TRObject) { 
   var latlng = new google.maps.LatLng(Lat,Long);
   TRObject.AddPaths(latlng);
 };
 
this.Add_osm=function(Lat,Long,TRObject) { 
	var latlng =  new OpenLayers.Geometry.Point(Long,Lat).transform(
				new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
				  osmmaps[TRObject.Map].getProjectionObject()//,
			//   new OpenLayers.Projection("EPSG:900913") // to Spherical Mercator Projection
			  );
	var markerLatLon= new OpenLayers.LonLat(Long,Lat).transform(
				new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
				  osmmaps[TRObject.Map].getProjectionObject()//,
			//   new OpenLayers.Projection("EPSG:900913") // to Spherical Mercator Projection
			  );	
	var NormalLatLon= new OpenLayers.LonLat(Long,Lat);	  
	TRObject.AddPaths(latlng);
	TRObject.AddOSM_MarkersLonLat(markerLatLon);
	TRObject.AddOSM_LonLat(NormalLatLon);
 }; 
 
 this.Add_bing=function(Lat,Long,TRObject) { 
   var latlng = new Microsoft.Maps.Location(Lat,Long);
   TRObject.AddPaths(latlng);
 };
 
 this.Apply=function(){
	 var lineSymbol = {path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW};
	 var TrackingReplayOptions = {
	  strokeColor: "#FF0000",
      strokeOpacity: 1,
      strokeWeight:2,
		 };
	 for (var i=1; i<TrackingReplayArray[0].Paths.length; i++){
		 if (TrackingReplayArray[0].Paths.length-i != 1){
	TrackingReplay = new google.maps.Polyline(TrackingReplayOptions); 
	TrackingReplay.setOptions({path:[TrackingReplayArray[0].Paths[i-1],TrackingReplayArray[0].Paths[i]]});
	if (TrackingReplayArray[0].Items[i].gm_speed>0){
	TrackingReplay.setOptions({icons:[{
    	icon: lineSymbol,
   	 offset: '100%'
 		 }]});
	}
	TrackingReplay.setMap(maps[TrackingReplayArray[0].Map]);
	TrackingReplayArray[0].AddPolys(TrackingReplay);
		 }else{
	TrackingReplay = new google.maps.Polyline(TrackingReplayOptions); 
	TrackingReplay.setOptions({path:[TrackingReplayArray[0].Paths[i-1],TrackingReplayArray[0].Paths[i]]});
	if (TrackingReplayArray[0].Items[i].gm_speed>0){
	TrackingReplay.setOptions({icons:[{
    	icon: lineSymbol,
   	 offset: '100%'
 		 }]});
	}
	TrackingReplay.setMap(maps[TrackingReplayArray[0].Map]);
	TrackingReplayArray[0].AddPolys(TrackingReplay);		 
		 }
	 }
	 
 };
 
  this.Apply_osm=function() { 
	lineLayer = new OpenLayers.Layer.Vector("Line Layer"); 
	osmmaps[TrackingReplayArray[0].Map].addLayer(lineLayer); 
	var replay_line=new OpenLayers.Control.DrawFeature(lineLayer, OpenLayers.Handler.Path) 	                   
	osmmaps[TrackingReplayArray[0].Map].addControl(replay_line);                                     
	var line = new OpenLayers.Geometry.LineString(TrackingReplayArray[0].Paths);	                
	var style = { 
		strokeColor: '#0000ff', 
		strokeOpacity: 0.5,
		strokeWidth: 5
	};
	lineFeature = new OpenLayers.Feature.Vector(line, null, style);
	lineLayer.addFeatures([lineFeature]);
  };
  
  this.Apply_bing=function() { 
		var pstrokeColor = new Microsoft.Maps.Color.fromHex("#0000ff");
			pstrokeColor.a=0.5 * 255;
		var options = {
		strokeColor:pstrokeColor, 
		strokeThickness: 5 
		};
		var line = new Microsoft.Maps.Polyline(TrackingReplayArray[0].Paths, options);                                     
	bmaps[TrackingReplayArray[0].Map].entities.push(line);
  };
  
 this.addMarker=function(i) {  
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
  
  
  
   this.addMarker_osm=function(i) { 
    var tvar=Parse_tvar(TrackingReplayArray[0].Items[i],TrackingReplayArray[0].Obj);	
	var richMarkerContent =CreateMarker(tvar);
	
  var size = new OpenLayers.Size(25,25);
   var offset = new OpenLayers.Pixel(-(size.w/2), -size.h);
 var icon = new OpenLayers.Icon(null, size, offset);   
icon.imageDiv=richMarkerContent.get(0);   
var lonlat =TrackingReplayArray[0].OSM_MarkersLonLat[i];

 var marker=new OpenLayers.Marker(lonlat,icon);
   MarkerReplayLayer.addMarker(marker);
osmmaps[TrackingReplayArray[0].Map].setCenter(lonlat);
TrackingReplayArray[0].Marker=marker; 
}
   
 this.addMarker_bing=function(i) {  
 var latlng = new Microsoft.Maps.Location(TrackingReplayArray[0].Items[i].gm_lat,TrackingReplayArray[0].Items[i].gm_lng);
 var tvar=Parse_tvar(TrackingReplayArray[0].Items[i],TrackingReplayArray[0].Obj);	
	var richMarkerContent =CreateMarker(tvar);
	var markerOptions = {
		width: null,
		height: null,
		htmlContent: richMarkerContent.html()
	};
	var marker = new Microsoft.Maps.Pushpin(latlng, markerOptions);
	bmaps[MapClass.currMapID].entities.push(marker);
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




this.UpdateMarker=function(tvar){
    var GFArea = '';
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
	
	if (TrackingReplayArray[0].MapName=='gmap'){
		TrackingReplayArray[0].Marker.setPosition(new google.maps.LatLng(tvar.gm_lat, tvar.gm_lng));
	}else if (TrackingReplayArray[0].MapName=='omap'){
		var lonlat =transform(new OpenLayers.LonLat(tvar.gm_lng, tvar.gm_lat));
		setLonLat_osm(TrackingReplayArray[0].Marker,lonlat);	
	}else if (TrackingReplayArray[0].MapName=='bmap'){
		TrackingReplayArray[0].Marker.setLocation(new Microsoft.Maps.Location(tvar.gm_lat, tvar.gm_lng));	
	}

	var imgid=tvar.imgid;	


	if (GeoFenceViewer.ID.length!=0){
	//setGridvalue(tvar.pos,tvar.geoFArea);
	//this.ViewGeoFence(tvar.geoFID,unitName,tvar.geoFAlarm);
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
	
};

var TrackingReply=new TrackingReplyClass();

var TrackingReplayArray=[];

function pointInPolygon(points, strlat, strlon) {
    var i;
    var j = points.length - 1;
    var inPoly = false;
    lon = parseFloat(strlon);
    lat = parseFloat(strlat);
    var Plati, Plngi, Platj, Plngj;

    for (i = 0; i < points.length; i++) {
        Plati = parseFloat(latlongPaths(points[i])[0]);
        Plngi = parseFloat(latlongPaths(points[i])[1]);
        Platj = parseFloat(latlongPaths(points[j])[0]);
        Plngj = parseFloat(latlongPaths(points[j])[1]);  
        if (Plngi < lon && Plngj >= lon || Plngj < lon && Plngi >= lon) {
            if (Plati + (lon - Plngi) / (Plngj - Plngi) * (Platj - Plati) < lat) {
                inPoly = !inPoly;
            }
        }
        j = i;
    }
    return inPoly;
}

function latlongPaths(str) {
    var newArr = new Array();
    str = str.toString();
	str =str.replace(/\s/g, '');
    str = str.replace(/\(/g, "[");
    str = str.replace(/\)/g, "]");
    newArr = eval("[" + (str) + "]");
    return newArr;

};


function CreateMarker(tobj){ 
	var richMarkerContent=$('<div/>', {id: 'marker'+tobj.gm_unit});
	
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





function setTrackingReplayGridvalue(pos,val){
 $("#TrackingReplaydata").jqGrid('setRowData', pos, {
		gm_geofence: val
	});	
};