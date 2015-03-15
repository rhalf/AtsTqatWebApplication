function DrawingGeoFenceClass(){
	this.Paths=[];
	this.Markers=[];
	this.Polys=[];
	this.google_Polygons=[];
	this.osm_Polygons=[];
	this.bing_Polygons=[];
	this.osm_style = { 
		strokeColor: '#1C33FF', 
		strokeOpacity: 0.5,
	//	strokeWidth: 5,
		fillColor : '#1C33FF',
		fillOpacity:0.5	
	};
	this.bing_style = { 
		strokeColor: '#1C33FF', 
		strokeOpacity: 0.5,
		strokeThickness: 5,
		fillColor : '#1C33FF',
		fillOpacity:0.5	
	};
/* disable */
	this.disable=function(){
		if (MapClass.currMap=='gmap'){
			google.maps.event.clearListeners(maps[MapClass.currMapID], 'click');
		}else if (MapClass.currMap=='omap'){
			 var DrawGeoFenceVectors=osmmaps[MapClass.currMapID].getLayer("DrawGeoFence"+MapClass.currMapID);
			DrawGeoFenceVectors.removeAllFeatures();			
		}else if (MapClass.currMap=='bmap'){
			Microsoft.Maps.Events.removeHandler(this.polygonClick);
		}	
	};	


/* draw */
	this.draw=function(){
		this.reset();
		if (MapClass.currMap=='gmap'){
			this.draw_google();	
		}else if (MapClass.currMap=='omap'){	
			this.draw_osm();	
		
		}else if (MapClass.currMap=='bmap'){	
			this.draw_bing();	
		
		}
	};
/* reset */
	this.reset=function(){
		if (MapClass.currMap=='gmap'){
			this.reset_google();
		}else if (MapClass.currMap=='omap'){
			this.reset_osm();
		}else if (MapClass.currMap=='bmap'){
			this.reset_bing();
		}		
	};
/*draw_google*/
	this.draw_google=function (){
		var _this = this;
		var isClosed = false; 
		var poly = new google.maps.Polyline({ 
			map: maps[MapClass.currMapID], 
			path: [], 
			strokeColor: "#1C33FF", 
			strokeOpacity: 1.0, 
			strokeWeight: 2 
		}); 
		_this.Polys.push(poly);			
		google.maps.event.addListener(maps[MapClass.currMapID], 'click', function (clickEvent) { 
			if (isClosed)
				return; 
			var isFirstMarker = poly.getPath().length === 0; 
			var marker = new google.maps.Marker({ 
				map: maps[MapClass.currMapID], 
				position: clickEvent.latLng, 
				draggable: true 
			}); 
			_this.Markers.push(marker); 
				google.maps.event.addListener(marker, 'click', function () { 
					if (isClosed) 
						return; 
					var path = poly.getPath(); 
					poly.setMap(null); 
				var Polygon = new google.maps.Polygon({ 
					map: maps[MapClass.currMapID], 
					path: path, 
					strokeColor: "#1C33FF", 
					strokeOpacity: 0.8, 
					strokeWeight: 2, 
					fillColor: "#1C33FF", 
					fillOpacity: 0.35 }); 
					isClosed = true; 
					_this.google_Polygons.push(Polygon);
	
				}); 	
			google.maps.event.addListener(marker, 'drag', function (dragEvent) {
				poly.getPath().setAt(marker, dragEvent.latLng); 
			}); 
			poly.getPath().push(clickEvent.latLng);
		}); 
		_this.Paths.length=0;
		_this.Paths.push( poly.getPath().getArray()); 
	};
	
/*reset_google*/	
	this.reset_google=function(){
	 if (this.google_Polygons) { 
		 for (i in  this.google_Polygons) {
			 this.google_Polygons[i].setMap(null);
		  } 
		this.google_Polygons.length = 0;
	 }	
	if ( this.Markers) { 
		 for (i in  this.Markers) {
			 this.Markers[i].setMap(null);
		  } 
		this.Markers.length = 0;
	 }	
		 if ( this.Polys) { 
			 for (i in  this.Polys) {
			 this.Polys[i].setMap(null);
			 } 
			this.Polys.length = 0;
		 }	
		this.Paths.length=0;
		this.disable();	
	};	
/*draw_osm*/	
	this.draw_osm=function (){
		var options = {
                hover: true,
                onSelect: serialize
         };
		var DrawGeoFenceVectors=osmmaps[MapClass.currMapID].getLayer("DrawGeoFence"+MapClass.currMapID);
		var selectFeature = new OpenLayers.Control.SelectFeature(DrawGeoFenceVectors, options);
		osmmaps[MapClass.currMapID].addControl(selectFeature);
		selectFeature.activate();
		var polygon= new OpenLayers.Control.DrawFeature(DrawGeoFenceVectors,OpenLayers.Handler.Polygon);
		osmmaps[MapClass.currMapID].addControl(polygon);
		polygon.activate();
		this.osm_Polygons.push(polygon);		   
	};
/*reset_osm*/	
	this.reset_osm=function(){
		for (i in this.osm_Polygons) {					
			 this.osm_Polygons[i].deactivate();
			 this.osm_Polygons[i].destroy();
		} 
			this.osm_Polygons.length=0;
			this.disable();
	};
	
this.polygonClick;
	this.draw_bing=function (){
		var _this = this;
		var isClosed = false; 
		
		var pfillColor = new Microsoft.Maps.Color.fromHex(_this.bing_style.fillColor);
			pfillColor.a=_this.bing_style.fillOpacity * 255;
		var pstrokeColor = new Microsoft.Maps.Color.fromHex(_this.bing_style.strokeColor);
			pstrokeColor.a=_this.bing_style.strokeOpacity * 255;
		var options = {
		fillColor:pfillColor,
		strokeColor: pstrokeColor, 
		strokeThickness: _this.bing_style.strokeThickness 
		};
		var poly = new Microsoft.Maps.Polyline(_this.Paths, options); 
		bmaps[MapClass.currMapID].entities.push(poly);
		_this.Polys.push(poly);		
		
		_this.polygonClick = Microsoft.Maps.Events.addHandler(bmaps[MapClass.currMapID], 'click',function(e){
			if (e.targetType!='map'){
				return	
			}
			if (isClosed)
				return; 			
			var point = new Microsoft.Maps.Point(e.getX(), e.getY());
			
			var loc = e.target.tryPixelToLocation(point);
			
			_this.Paths.push(loc);		
			poly.setLocations(_this.Paths);	
		
			var MarkerOptions = {draggable: true}; 
			var marker= new Microsoft.Maps.Pushpin(loc, MarkerOptions); 
			bmaps[MapClass.currMapID].entities.push(marker);
			_this.Markers.push(marker); 
			 Microsoft.Maps.Events.addHandler(marker, 'click',function(e){
					if (isClosed) 
						return; 
					_this.Paths.push(_this.Paths[0]);
				var pfillColor = new Microsoft.Maps.Color.fromHex(_this.bing_style.fillColor);
					pfillColor.a=_this.bing_style.fillOpacity * 255;
				var pstrokeColor = new Microsoft.Maps.Color.fromHex(_this.bing_style.strokeColor);
					pstrokeColor.a=_this.bing_style.strokeOpacity * 255;
				var polygon = new Microsoft.Maps.Polygon(_this.Paths, { 
					fillColor:pfillColor ,
					strokeColor: pstrokeColor,
					strokeThickness:_this.bing_style.strokeThickness
				});
				bmaps[MapClass.currMapID].entities.push(polygon);
				isClosed = true; 
				_this.bing_Polygons.push(polygon);
	
				}); 	
			markerDrag = Microsoft.Maps.Events.addHandler(marker, 'drag', function (e) {
				_this.Paths.pop(_this.Paths.length);
				_this.Paths.push(e.entity.getLocation());	
				_this.Paths.push(_this.Paths[0]);	
				poly.setLocations(_this.Paths);
				if(_this.bing_Polygons[0]){
				_this.bing_Polygons[0].setLocations(_this.Paths);
				}
			}); 
		}); 
	};
	
 this.reset_bing=function() {
         for (i in this.Markers) {
             	this.Markers[i].setOptions({visible: false});
				bmaps[MapClass.currMapID].entities.remove(this.Markers[i]);
         };
         for (i in this.Polys) {
             	this.Polys[i].setOptions({visible: false});
				bmaps[MapClass.currMapID].entities.remove(this.Polys[i]);
         };
         for (i in this.bing_Polygons) {
             	this.bing_Polygons[i].setOptions({visible: false});
				bmaps[MapClass.currMapID].entities.remove(this.bing_Polygons[i]);
         };
 			this.Markers.length=0;
			this.Polys.length=0;
			this.bing_Polygons.length=0;
			this.Paths.length=0;
			this.disable();
 }; 	
	
	

};

var DrawingGeoFence=new DrawingGeoFenceClass();



//////////////////////GFViewer
function GFViewer(){	
	this.Name=[];
	this.ID=[];
	this.Data=[];
	this.Data_google=[];
	this.Data_osm=[];
	this.Data_bing=[];
	this.CenterMarkers=[];
	this.CenterMarkers_osm=[];
	this.CenterMarkers_bing=[];
	this.Objects_google=[];
	this.Objects_osm=[];
	this.Objects_bing=[];
	
	this.PolygonOptions_view={
		strokeColor: "#1C33FF", 
		strokeOpacity: 0.8, 
		strokeWeight: 2, 
		fillColor: "#1C33FF", 
		fillOpacity: 0.35 	
	};
	this.PolygonOptions_track={
		strokeColor: "#FF0000", 
		strokeOpacity: 0.8, 
		strokeWeight: 2, 
		fillColor: "#FF0000", 
		fillOpacity: 0.35 
	};
	this.osm_PolygonOptions_view = { 
		strokeColor: '#1C33FF', 
		strokeOpacity: 0.5,
	//	strokeWidth: 5,
		fillColor : '#1C33FF',
		fillOpacity:0.5	
	};
	this.osm_PolygonOptions_track = { 
		strokeColor: '#FF3414', 
		strokeOpacity: 0.5,
		fillColor : '#FF3414',
		fillOpacity:0.5	
	};
	
	this.bing_PolygonOptions_view = { 
		strokeColor: '#1C33FF', 
		strokeOpacity: 0.5,
		strokeThickness: 5,
		fillColor : '#1C33FF',
		fillOpacity:0.5	
	};
	this.bing_PolygonOptions_track = { 
		strokeColor: '#FF3414', 
		strokeOpacity: 0.5,
		fillColor : '#FF3414',
		fillOpacity:0.5	
	};
	/*Clear*/
	this.Clear=function(){
		this.Delete();
		this.Name.length=0;
		this.ID.length=0;
		this.Data.length=0;
		this.Data_osm.length=0;
		this.Data_bing.length=0;
	};
	/*CreateAll*/
	this.CreateAll=function(){
		this.Delete();
		for (i in this.ID){
			if (MapClass.currMap=='gmap'){
				this.Data_google.push(strToArray(this.Data[i]));
				this.Objects_google.push(this.Create_google(this.Data_google[i]));
				var CenterMarker = new RichMarker({
					position: getPolygonCenter(this.Data_google[i]) , 
					map: maps[MapClass.currMapID], 
					flat:true,
					content:'<span class="polygonlabel">'+this.Name[i]+'</span>'
				}); 
				this.CenterMarkers.push(CenterMarker); 
				this.Objects_google[i].setMap(maps[MapClass.currMapID]);
							
			}else if (MapClass.currMap=='omap'){
				this.Data_osm.push(osm_strToArray(this.Data[i]));
				
				this.Objects_osm.push(this.Create_osm(this.Data_osm[i]));				
				var size = new OpenLayers.Size(50,50);
				var offset = new OpenLayers.Pixel(-(size.w/2), -size.h);
				var icon = new OpenLayers.Icon(null, size, offset);   
				icon.imageDiv=CreatePolygonLabel(this.ID[i],this.Name[i]);
				var point  = this.Objects_osm[i].geometry.getCentroid();
				var lonlat=(new OpenLayers.LonLat(point.x,point.y));			
				var CenterMarker=new OpenLayers.Marker(lonlat,icon);
				geoFenceMarkers.addMarker(CenterMarker);
				this.CenterMarkers_osm.push(CenterMarker); 
			}else if (MapClass.currMap=='bmap'){
				this.Data_bing.push(bing_strToArray(this.Data[i]));
				this.Objects_bing.push(this.Create_bing(this.Data_bing[i]));
				var markerOptions = {
					width: null,
					height: null,
					htmlContent: '<span class="polygonlabel">'+this.Name[i]+'</span>'
				};
				bmaps[MapClass.currMapID].entities.push(this.Objects_bing[i]);
				var CenterMarker = new Microsoft.Maps.Pushpin(getPolygonCenter_bing(this.Data_bing[i]), markerOptions);
				bmaps[MapClass.currMapID].entities.push(CenterMarker);
				this.CenterMarkers_bing.push(CenterMarker); 
							
			}
		}
	};

	 /* Delete */
	this.Delete=function(){
		if (MapClass.currMap=='gmap'){
			this.Delete_google();
		}else if (MapClass.currMap=='omap'){
			this.Delete_osm();
		}else if (MapClass.currMap=='bmap'){
			this.Delete_bing();
		}		
	};
	
	
	/* Create */
	this.Create=function(paths){
		if (MapClass.currMap=='gmap'){
			Create_google(paths);	
		}else if (MapClass.currMap=='omap'){
			Create_osm(paths);	
		}else if (MapClass.currMap=='bmap'){
			Create_bing(paths);	
		}
	};	
	
	/*Create_google*/
	this.Create_google= function(paths){
   		var Polygon = new google.maps.Polygon({ 
			path: paths, 
			strokeColor: "#1C33FF", 
			strokeOpacity: 0.8, 
			strokeWeight: 2, 
			fillColor: "#1C33FF", 
			fillOpacity: 0.35 
		});
		return Polygon;	
	};
	
	/*Delete_google*/
	this.Delete_google=function(){
		for (i in this.Objects_google) {				
			this.Objects_google[i].setMap(null);
		 } 
		for (i in this.CenterMarkers) {				
			this.CenterMarkers[i].setMap(null);
		 } 	
		 this.Objects_google.length=0; 
		this.CenterMarkers.length=0; 
	};		
	
	
	/*Create_osm*/
	this.Create_osm=function(paths){
		var linear_ring = new OpenLayers.Geometry.LinearRing(paths);
		var polygonFeature = new OpenLayers.Feature.Vector(
		new OpenLayers.Geometry.Polygon([linear_ring]), null, this.osm_PolygonOptions_view);
		return polygonFeature;
	};

	/*Delete_osm*/
	this.Delete_osm=function(){
		for (i in this.Objects_osm) {				
			geoFenceViewerVector[MapClass.currMapID].removeFeatures([ this.Objects_osm[i]]);	
		 }
		 this.Objects_osm.length=0; 
		if(geoFenceMarkers){
			geoFenceMarkers.clearMarkers();
			this.CenterMarkers_osm.length=0;
		}
	};
	
	/*Create_bing*/
	this.Create_bing= function(paths){
		var pfillColor = new Microsoft.Maps.Color.fromHex(this.bing_PolygonOptions_view.fillColor);
		pfillColor.a=this.PolygonOptions_view.fillOpacity * 255;
		var pstrokeColor = new Microsoft.Maps.Color.fromHex(this.bing_PolygonOptions_view.strokeColor);
		pstrokeColor.a=this.PolygonOptions_view.strokeOpacity  * 255;
		var polygon = new Microsoft.Maps.Polygon(paths, { 
			fillColor: pfillColor,
			strokeColor: pstrokeColor ,
			strokeThickness: this.bing_PolygonOptions_view.strokeThickness,
		});
		return polygon;	
	};	
	
	/*Delete_bing*/
	this.Delete_bing=function(){
		for (i in this.Objects_bing) {				
			bmaps[MapClass.currMapID].entities.remove(this.Objects_bing[i]);
		 } 
		for (i in this.CenterMarkers_bing) {
			bmaps[MapClass.currMapID].entities.remove(this.CenterMarkers_bing[i]);				
		 } 	
		 this.Objects_bing.length=0; 
		this.CenterMarkers_bing.length=0; 
	};	
	
	/*View*/
	this.View=function(id,show,track){
		if (MapClass.currMap=='gmap'){
			this.View_google(id,show,track);
		}else if (MapClass.currMap=='omap'){
			this.View_osm(id,show,track);		
		}else if (MapClass.currMap=='bmap'){
			this.View_bing(id,show,track);		
		}
	};

	/*View_google*/
	this.View_google=function(id,show,track){
		if (show){
			if (track){
				this.Objects_google[this.ID.indexOf(id)].setOptions(this.PolygonOptions_track);
			}else{
				this.Objects_google[this.ID.indexOf(id)].setOptions(this.PolygonOptions_view);
			}
			this.CenterMarkers[this.ID.indexOf(id)].setMap(maps[MapClass.currMapID]);		
			this.Objects_google[this.ID.indexOf(id)].setMap(maps[MapClass.currMapID]);
		}else{
			this.Objects_google[this.ID.indexOf(id)].setMap(null);	
			this.CenterMarkers[this.ID.indexOf(id)].setMap(null);
		}
	};
	/*View_osm*/
	this.View_osm=function(id,show,track){
		if(typeof(this.Objects_osm[this.ID.indexOf(id)])!=='undefined'){	
			if (show){
				if (track){
					this.Objects_osm[this.ID.indexOf(id)].style =this.osm_PolygonOptions_track;
				}else{
					this.Objects_osm[this.ID.indexOf(id)].style =this.osm_PolygonOptions_view;
				}
				geoFenceViewerVector[MapClass.currMapID].addFeatures([this.Objects_osm[this.ID.indexOf(id)]]);
			}else{
				geoFenceViewerVector[MapClass.currMapID].removeFeatures([this.Objects_osm[this.ID.indexOf(id)]]);
			}
		}
	};
	
	/*View_bing*/
	this.View_bing=function(id,show,track){
		if(typeof(this.Objects_bing[this.ID.indexOf(id)])==='undefined'){
			return;
		};
		if(typeof(this.CenterMarkers_bing[this.ID.indexOf(id)])==='undefined'){
			return;
		};
			if (show){
				if (track){
					var pfillColor = new Microsoft.Maps.Color.fromHex(this.bing_PolygonOptions_track.fillColor);
					pfillColor.a=this.PolygonOptions_track.fillOpacity  * 255;
					var pstrokeColor = new Microsoft.Maps.Color.fromHex(this.bing_PolygonOptions_track.strokeColor);
					pstrokeColor.a=this.PolygonOptions_track.strokeOpacity  * 255;
					this.Objects_bing[this.ID.indexOf(id)].setOptions( { 
						strokeColor: pstrokeColor, 
						strokeThickness: this.PolygonOptions_track.strokeThickness,
						fillColor : pfillColor,
					});
				}else{
					var pfillColor = new Microsoft.Maps.Color.fromHex(this.bing_PolygonOptions_view.fillColor);
					pfillColor.a=this.PolygonOptions_view.fillOpacity * 255;
					var pstrokeColor = new Microsoft.Maps.Color.fromHex(this.bing_PolygonOptions_view.strokeColor);
					pstrokeColor.a=this.PolygonOptions_view.strokeOpacity * 255;
					this.Objects_bing[this.ID.indexOf(id)].setOptions( { 
						strokeColor: pstrokeColor, 
						strokeThickness: this.PolygonOptions_view.strokeThickness,
						fillColor : pfillColor,
					});
				}
				this.CenterMarkers_bing[this.ID.indexOf(id)].setOptions({visible:true});
				this.Objects_bing[this.ID.indexOf(id)].setOptions({visible:true});
			}else{
				this.CenterMarkers_bing[this.ID.indexOf(id)].setOptions({visible:false});
				this.Objects_bing[this.ID.indexOf(id)].setOptions({visible:false});
			}
	};
	/*setPolygonCenter*/
	this.setPolygonCenter=function(id){
		if (MapClass.currMap=='gmap'){
			if (maps[MapClass.currMapID] != undefined){
				maps[MapClass.currMapID].setCenter(getPolygonCenter(this.Data_google[this.ID.indexOf(id)]));
			}
		}
	};
			

};
var GeoFenceViewer=new GFViewer();


function getPolygonCenter(paths){
    var f;
    var x = 0;
    var y = 0;
    var nPts = paths.length;
    var j = nPts-1;
    var area = 0;
    
    for (var i = 0; i < nPts; j=i++) {   
        var pt1 = paths[i];
        var pt2 = paths[j];
        f = pt1.lat() * pt2.lng() - pt2.lat() * pt1.lng();
        x += (pt1.lat() + pt2.lat()) * f;
        y += (pt1.lng() + pt2.lng()) * f;
        
        area += pt1.lat() * pt2.lng();
        area -= pt1.lng() * pt2.lat();        
    }
    area /= 2;
    f = area * 6;
    return new google.maps.LatLng(x/f, y/f);
};

function getPolygonCenter_osm(paths){
	console.log(paths);
    var f;
    var x = 0;
    var y = 0;
    var nPts = paths.length;
    var j = nPts-1;
    var area = 0;
    for (var i = 0; i < nPts; j=i++) {   
        var pt1 = paths[i];
        var pt2 = paths[j];
        f = pt1.lat * pt2.lon - pt2.lat * pt1.lon;
        x += (pt1.lat + pt2.lat) * f;
        y += (pt1.lon + pt2.lon) * f;
        
        area += pt1.lat * pt2.lon;
        area -= pt1.lon * pt2.lat;        
    }
    area /= 2;
    f = area * 6;
	
	 return transform(new OpenLayers.LonLat(y/f, x/f));
};

function getPolygonCenter_bing(paths){
    var f;
    var x = 0;
    var y = 0;
    var nPts = paths.length;
    var j = nPts-1;
    var area = 0;
    
    for (var i = 0; i < nPts; j=i++) {   
        var pt1 = paths[i];
        var pt2 = paths[j];
        f = pt1.latitude * pt2.longitude - pt2.latitude * pt1.longitude;
        x += (pt1.latitude + pt2.latitude) * f;
        y += (pt1.longitude + pt2.longitude) * f;
        
        area += pt1.latitude * pt2.longitude;
        area -= pt1.longitude * pt2.latitude;        
    }
    area /= 2;
    f = area * 6;
    return new Microsoft.Maps.Location(x/f, y/f);
};

function CreatePolygonLabel(id,label){
	var divContent= document.createElement('div'); 
	
	var TextElement = document.createElement('span');
	TextElement.id='polygonlbl'+id;
	TextElement.innerHTML=label;
	TextElement.className='polygonlabel'	;
	
	divContent.appendChild(TextElement);

	return divContent;
};

function osm_strToArray(str){  
	var latlng;
		latLngs = [], 
		pairs = str.replace(/^\(|\)$/g,'').split('),('); 
	for(var i=0,pair;pair=pairs[i];i++) { 
		pair = pair.split(',');
		latlng=transform( new OpenLayers.Geometry.Point(pair[1], pair[0]));
		latLngs.push(latlng);   
	} 
	return 	latLngs;
};

function bing_strToArray(str){  
	var latlng;
		latLngs = [], 
		pairs = str.replace(/^\(|\)$/g,'').split('),('); 
	for(var i=0,pair;pair=pairs[i];i++) { 
		pair = pair.split(',');
		latlng= new Microsoft.Maps.Location(pair[0], pair[1]);
		latLngs.push(latlng);   
	} 
	return 	latLngs;
};