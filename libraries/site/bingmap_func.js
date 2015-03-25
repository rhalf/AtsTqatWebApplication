var arcgismap=[];
function init_ArcgisMap(div,id){
	require(["esri/map","esri/dijit/BasemapToggle",], function(Map,BasemapToggle) { 
	 arcgismap[id] = new Map(div, {
      center: [DefaultSettings.default_Lon,DefaultSettings.default_Lat],
      zoom: DefaultSettings.default_Zoom,
      basemap: "streets"
    });
	var toggle = new BasemapToggle({
        map: arcgismap[id],
        basemap: "satellite"
      }, "BasemapToggle");
      toggle.startup();
	
	});
};



var ovimap=[];
function init_OviMap(div,id){
	 ovimap[id] = new ovi.mapsapi.map.Display(
        document.getElementById(div),
        {
           components: [ 
                    //behavior collection
                    new ovi.mapsapi.map.component.Behavior(),
                    new ovi.mapsapi.map.component.ZoomBar(),
                    new ovi.mapsapi.map.component.Overview(),
                    new ovi.mapsapi.map.component.TypeSelector(),
                    new ovi.mapsapi.map.component.ScaleBar() ],
                zoomLevel: DefaultSettings.default_Zoom,
                center: [DefaultSettings.default_Lat,DefaultSettings.default_Lon]
            });
	 };


var nokiamap=[];	 
function init_NokiaMap(div,id){
	nokia.Settings.set("app_id", "DemoAppId01082013GAL"); 
nokia.Settings.set("app_code", "AJKnXv84fjrb0KIHawS0Tg");
// Use staging environment (remove the line for production environment)
nokia.Settings.set("serviceMode", "cit");
 nokiamap[id] = new nokia.maps.map.Display(
        document.getElementById(div),
        {
           components: [ 
		// ZoomBar provides a UI to zoom the map in & out
		new nokia.maps.map.component.ZoomBar(), 
		// We add the behavior component to allow panning / zooming of the map
		new nokia.maps.map.component.Behavior(),
		// Creates UI to easily switch between street map satellite and terrain mapview modes
		new nokia.maps.map.component.TypeSelector(),
		// Creates a toggle button to show/hide traffic information on the map
		new nokia.maps.map.component.Traffic(),
		// Creates a toggle button to show/hide public transport lines on the map
		new nokia.maps.map.component.PublicTransport(),
		// Creates a toggle button to enable the distance measurement tool
		new nokia.maps.map.component.DistanceMeasurement(),
		// Shows a min-map in the bottom right corner of the map
		new nokia.maps.map.component.Overview(),
		/* Shows a scale bar in the bottom right corner of the map depicting
		 * ratio of a distance on the map to the corresponding distance in the real world
		 * in either kilometers or miles
		 */ 
		new nokia.maps.map.component.ScaleBar(),
		/* Positioning will show a set "map to my GPS position" UI button
		 * Note: this component will only be visible if W3C geolocation API
		 * is supported by the browser and if you agree to share your location.
		 * If you location can not be found the positioning button will reset
		 * itself to its initial state
		 */
		new nokia.maps.positioning.component.Positioning(),
		// Add ContextMenu component so we get context menu on right mouse click / long press tap
		new nokia.maps.map.component.ContextMenu(),
		// ZoomRectangle component adds zoom rectangle functionality to the map
		new nokia.maps.map.component.ZoomRectangle() ],
                zoomLevel: DefaultSettings.default_Zoom,
                center: [DefaultSettings.default_Lat,DefaultSettings.default_Lon]
            });

	 };	 
////////////////////////////////////////////////////////////  bing map  functions	 
	 
  var bmaps=[]; 	 
	   function init_BingMap(div,id) {
			 var Bingmap=null;
 bmaps[id] = new Microsoft.Maps.Map(document.getElementById(div),{credentials:"AqCqf0QgtemVsoM1XSRDG7P7PBL27yV8xv_wRsLKiL7F-Go_biaEVV1qNgn0mygx",center: new Microsoft.Maps.Location(DefaultSettings.default_Lat,DefaultSettings.default_Lon),mapTypeId: Microsoft.Maps.MapTypeId.road,zoom: DefaultSettings.default_Zoom});     GeoFenceViewer.CreateAll();
	selectAllPois(true);
	selectAllGeoFences(true);

         };


  
 /////////////////////////////// marker only
 
function bing_tools_class(){
	
this.Disable=function() {
	Microsoft.Maps.Events.removeHandler(this.markerOnlyClick); 
	Microsoft.Maps.Events.removeHandler(this.markerPolyClick);
	Microsoft.Maps.Events.removeHandler(this.polyOnlyClick);
	Microsoft.Maps.Events.removeHandler(this.circleClick);
	Microsoft.Maps.Events.removeHandler(this.circleDrag);
	Microsoft.Maps.Events.removeHandler(this.polygonClick);
};


this.GetEntityByProperty=function(collection, propertyName, propertyValue){
	var len = collection.getLength(), entity;

	for(var i = 0; i < len; i++){
		entity = collection.get(i);

		if(entity[propertyName] && entity[propertyName] == propertyValue){
			return entity;
		}else if (entity.getLength){
			//Entity collections have this property and we want to look inside these collections
			var layer = GetEntityByProperty(entity, propertyName, propertyValue);

			if(layer != null){
				return layer;
			}
		}
	}

	return null;
 };	
	
	
// marker only
this.MarkersOnlyArrays=[];
this.markerOnlyClick;

this.EnableMarkerOnly=function() {
	 var _this=this;
	_this.markerOnlyClick = Microsoft.Maps.Events.addHandler(bmaps[MapClass.currMapID], 'click',function(e){
		var point = new Microsoft.Maps.Point(e.getX(), e.getY());
		var loc = e.target.tryPixelToLocation(point);
		var MarkerOptions = {draggable: true}; 
		var marker= new Microsoft.Maps.Pushpin(loc, MarkerOptions); 
		bmaps[MapClass.currMapID].entities.push(marker);
	
		_this.MarkersOnlyArrays.push(marker);	
	})
};	
	
 this.opeMarkersOnly=function(ope) {
         for (i in this.MarkersOnlyArrays) {
			 if (ope==1){
			 	this.MarkersOnlyArrays[i].setOptions({visible: true});
			 }else if (ope==2){
             	this.MarkersOnlyArrays[i].setOptions({visible: false});
			 }else if (ope==3){
				 this.MarkersOnlyArrays[i].setOptions({visible: false});
				bmaps[MapClass.currMapID].entities.remove(this.MarkersOnlyArrays[i]); 
			 }
         };
		 if (ope==3){
			 this.MarkersOnlyArrays.length = 0;
		 }
 };	
	

// MarkerPoly 
this.markerPolyClick;
this.MarkersPolyPos=[];
this.MarkersPolyMarkers=[];
this.MarkersPolyPolys=[]; 

this.EnableMarkerPoly=function() { 
var _this=this;
_this.markerPolyClick = Microsoft.Maps.Events.addHandler(bmaps[MapClass.currMapID], 'click',function(e){
	var point = new Microsoft.Maps.Point(e.getX(), e.getY());
	var loc = e.target.tryPixelToLocation(point);
	var MarkerPolyOptions = {draggable: false}; 
	var markerPoly= new Microsoft.Maps.Pushpin(loc, MarkerPolyOptions); 
	bmaps[MapClass.currMapID].entities.push(markerPoly);
	
	_this.MarkersPolyPos.push(loc);
	_this.MarkersPolyMarkers.push(markerPoly);
	
	var thickness = Math.round(5*Math.random()+1); 
	var options = {
		strokeColor: new Microsoft.Maps.Color(Math.round(255*Math.random()),Math.round(255*Math.random()),Math.round(255*Math.random()),Math.round(255*Math.random())), 
		strokeThickness: 3 
		}; 
	var poly = new Microsoft.Maps.Polyline(_this.MarkersPolyPos, options); 
	bmaps[MapClass.currMapID].entities.push(poly);
	_this.MarkersPolyPolys.push(poly);	
	
	
	
}); 
    
};

 this.opeMarkerPoly=function(ope) {
         for (i in this.MarkersPolyMarkers) {
			 if (ope==1){
			 	this.MarkersPolyMarkers[i].setOptions({visible: true});
			 }else if (ope==2){
             	this.MarkersPolyMarkers[i].setOptions({visible: false});
			 }else if (ope==3){
             	this.MarkersPolyMarkers[i].setOptions({visible: false});
				bmaps[MapClass.currMapID].entities.remove(this.MarkersPolyMarkers[i]);
			 }
         };
         for (i in this.MarkersPolyPolys) {
			 if (ope==1){
			 	this.MarkersPolyPolys[i].setOptions({visible: true});
			 }else if (ope==2){
             	this.MarkersPolyPolys[i].setOptions({visible: false});
			 }else if (ope==3){
             	this.MarkersPolyPolys[i].setOptions({visible: false});
				bmaps[MapClass.currMapID].entities.remove(this.MarkersPolyPolys[i]);
			 }
         };
		 if (ope==3){
			 this.MarkersPolyMarkers.length = 0;
			 this.MarkersPolyPolys.length=0;
			 this.MarkersPolyPos.length=0;
		 };
 };


// PolyOnly 
this.polyOnlyClick;
this.PolyOnlyPos=[];
this.PolyOnlyArray=[]; 

this.EnablePolyOnly=function() { 
var _this=this;
_this.polyOnlyClick = Microsoft.Maps.Events.addHandler(bmaps[MapClass.currMapID], 'click',function(e){
	var point = new Microsoft.Maps.Point(e.getX(), e.getY());
	var loc = e.target.tryPixelToLocation(point);
	_this.PolyOnlyPos.push(loc);
	
	var thickness = Math.round(5*Math.random()+1); 
	var options = {
		strokeColor: new Microsoft.Maps.Color(Math.round(255*Math.random()),Math.round(255*Math.random()),Math.round(255*Math.random()),Math.round(255*Math.random())), 
		strokeThickness: 3 
		}; 
	var poly = new Microsoft.Maps.Polyline(_this.PolyOnlyPos, options); 
	bmaps[MapClass.currMapID].entities.push(poly);
	_this.PolyOnlyArray.push(poly);	
	
	
	
}); 
    
};

 this.opePolyOnly=function(ope) {
         for (i in this.PolyOnlyArray) {
			 if (ope==1){
			 	this.PolyOnlyArray[i].setOptions({visible: true});
			 }else if (ope==2){
             	this.PolyOnlyArray[i].setOptions({visible: false});
			 }else if (ope==3){
             	this.PolyOnlyArray[i].setOptions({visible: false});
				bmaps[MapClass.currMapID].entities.remove(this.PolyOnlyArray[i]);
			 }
         }
		 if (ope==3){
			this.PolyOnlyArray.length=0; 
			this.PolyOnlyPos.length=0;
		 }
 };
 
 
// Circle
this.circleClick;
this.circleDrag;
this.CirclesArr=[]; 
this.CirclesMarkersArr=[]; 
  
this.EnableCircles=function() { 
_this=this;
this.circleClick = Microsoft.Maps.Events.addHandler(bmaps[MapClass.currMapID], 'click',function(e){
	try {
	var point = new Microsoft.Maps.Point(e.getX(), e.getY());
	
	var loc = e.target.tryPixelToLocation(point);
	
	var MarkerOptions = {draggable: true}; 
	var marker= new Microsoft.Maps.Pushpin(loc, MarkerOptions); 
	bmaps[MapClass.currMapID].entities.push(marker);
	_this.CirclesMarkersArr.push(marker);
	var latitude=loc.latitude;
	var longitude=loc.longitude;
	_this.circleDrag= Microsoft.Maps.Events.addHandler(marker, 'drag', function(e){
		var loc = e.entity.getLocation();
		var latitude=loc.latitude;
		var longitude=loc.longitude;
		bmaps[MapClass.currMapID].entities.remove(_this.CirclesArr[_this.CirclesMarkersArr.indexOf(marker)]);
		_this.drawBingCircle (latitude,longitude,_this.CirclesMarkersArr.indexOf(marker))        		
	});
	_this.drawBingCircle (latitude,longitude,_this.CirclesMarkersArr.length-1);
	}catch(e) {
	}	
	
	
}); 

}

this.drawBingCircle=function (latitude,longitude,pos){
	try {
		var radius = 5;
		var R = 6371; // earth's mean radius in km
		var lat = (latitude * Math.PI) / 180; 
		//rad
		var lon = (longitude * Math.PI) / 180; 
		//rad
		var d = parseFloat(radius) / R; 
		// d = angular distance covered on earth's surface
		circlePoints = new Array();
		for (x = 0; x <= 360; x++) {
		var p2 = new Microsoft.Maps.Location(0, 0);
		brng = x * Math.PI / 180; //rad
		p2.latitude = Math.asin(Math.sin(lat) * Math.cos(d) + Math.cos(lat) * Math.sin(d) * Math.cos(brng));
		p2.longitude = ((lon + Math.atan2(Math.sin(brng) * Math.sin(d) * Math.cos(lat), Math.cos(d) - Math.sin(lat) * Math.sin(p2.latitude))) * 180) / Math.PI;
		p2.latitude = (p2.latitude * 180) / Math.PI;
		circlePoints.push(p2);
		}
		
		var polygoncolor = new Microsoft.Maps.Color(100, 100, 0, 100);
		var polygon = new Microsoft.Maps.Polygon(circlePoints, { 
			fillColor: polygoncolor,
			strokeColor: polygoncolor 
		});
		
		// Add the polygon to the map
		bmaps[MapClass.currMapID].entities.push(polygon);
		this.CirclesArr[pos]=polygon;
		// Center the map on the location
		//bmaps[u].setView({ center: new Microsoft.Maps.Location(latitude, longitude), zoom: 8});
	
	}catch(e) {
	}		


}; 
 this.opeCircles=function(ope) {
         for (i in this.CirclesArr) {
			 if (ope==1){
			 	this.CirclesArr[i].setOptions({visible: true});
			 }else if (ope==2){
             	this.CirclesArr[i].setOptions({visible: false});
			 }else if (ope==3){
             	this.CirclesArr[i].setOptions({visible: false});
				bmaps[MapClass.currMapID].entities.remove(this.CirclesArr[i]);
			 }
         };
         for (i in this.CirclesMarkersArr) {
			 if (ope==1){
			 	this.CirclesMarkersArr[i].setOptions({visible: true});
			 }else if (ope==2){
             	this.CirclesMarkersArr[i].setOptions({visible: false});
			 }else if (ope==3){
             	this.CirclesMarkersArr[i].setOptions({visible: false});
				bmaps[MapClass.currMapID].entities.remove(this.CirclesMarkersArr[i]);
			 }
         };
		 if (ope==3){
 			this.CirclesArr.length=0;
			this.CirclesMarkersArr.length=0;
		 }
 }; 
this.polygonClick;
this.polygons=[]; 
this.polygonPolys=[]; 
this.polygonLocs=[];
this.polygonMarkers=[]; 
	this.EnablePolygons=function (){
		var _this = this;
		var isClosed = false; 
		
		var pstrokeColor = new Microsoft.Maps.Color.fromHex("#"+document.getElementById('bstrokecolor').value);
			pstrokeColor.a=document.getElementById('bstrokeopacity').value * 255;
		var options = {
		strokeColor:pstrokeColor, 
		strokeThickness: document.getElementById('bstrokewidth').value 
		};
		var poly = new Microsoft.Maps.Polyline(_this.polygonLocs, options); 
		bmaps[MapClass.currMapID].entities.push(poly);
		_this.polygonPolys.push(poly);		
		
		_this.polygonClick = Microsoft.Maps.Events.addHandler(bmaps[MapClass.currMapID], 'click',function(e){
			if (e.targetType!='map'){
				return	
			}
			if (isClosed)
				return; 
			var isFirstMarker = _this.polygonLocs.length === 0; 
			
			var point = new Microsoft.Maps.Point(e.getX(), e.getY());
			
			var loc = e.target.tryPixelToLocation(point);
			
			_this.polygonLocs.push(loc);		
			poly.setLocations(_this.polygonLocs);	
		
			var MarkerOptions = {draggable: true}; 
			var marker= new Microsoft.Maps.Pushpin(loc, MarkerOptions); 
			bmaps[MapClass.currMapID].entities.push(marker);
			_this.polygonMarkers.push(marker); 
			 Microsoft.Maps.Events.addHandler(marker, 'click',function(e){
					if (isClosed) 
						return; 
					_this.polygonLocs.push(_this.polygonLocs[0]);
				var pfillColor = new Microsoft.Maps.Color.fromHex("#"+document.getElementById('bfillColor').value);
					pfillColor.a=document.getElementById('bfillopacity').value * 255;
				var pstrokeColor = new Microsoft.Maps.Color.fromHex("#"+document.getElementById('bstrokecolor').value);
					pstrokeColor.a=document.getElementById('bstrokeopacity').value * 255;
				var polygon = new Microsoft.Maps.Polygon(_this.polygonLocs, { 
					fillColor:pfillColor ,
					strokeColor: pstrokeColor,
					strokeThickness:document.getElementById('bstrokewidth').value
				});
				bmaps[MapClass.currMapID].entities.push(polygon);
				isClosed = true; 
				_this.polygons.push(polygon);
	
				}); 	
			markerDrag = Microsoft.Maps.Events.addHandler(marker, 'drag', function (e) {
				_this.polygonLocs.pop(_this.polygonLocs.length);
				_this.polygonLocs.push(e.entity.getLocation());	
				_this.polygonLocs.push(_this.polygonLocs[0]);	
				poly.setLocations(_this.polygonLocs);
				_this.polygons[0].setLocations(_this.polygonLocs);
			}); 
		}); 
	};
	
 this.opePolygons=function(ope) {
         for (i in this.polygonMarkers) {
			 if (ope==1){
			 	this.polygonMarkers[i].setOptions({visible: true});
			 }else if (ope==2){
             	this.polygonMarkers[i].setOptions({visible: false});
			 }else if (ope==3){
             	this.polygonMarkers[i].setOptions({visible: false});
				bmaps[MapClass.currMapID].entities.remove(this.polygonMarkers[i]);
			 }
         };
         for (i in this.polygonPolys) {
			 if (ope==1){
			 	this.polygonPolys[i].setOptions({visible: true});
			 }else if (ope==2){
             	this.polygonPolys[i].setOptions({visible: false});
			 }else if (ope==3){
             	this.polygonPolys[i].setOptions({visible: false});
				bmaps[MapClass.currMapID].entities.remove(this.polygonPolys[i]);
			 }
         };
         for (i in this.polygons) {
			 if (ope==1){
			 	this.polygons[i].setOptions({visible: true});
			 }else if (ope==2){
             	this.polygons[i].setOptions({visible: false});
			 }else if (ope==3){
             	this.polygons[i].setOptions({visible: false});
				bmaps[MapClass.currMapID].entities.remove(this.polygons[i]);
			 }
         };
		 if (ope==3){
 			this.polygonMarkers.length=0;
			this.polygonPolys.length=0;
			this.polygons.length=0;
			this.polygonLocs.length=0;
		 }
 }; 
 
 
this.bing_code;
this.AddressCodeLatLng=function(lat,lng) {
	var u="http://dev.virtualearth.net/REST/v1/Locations/"+lat+","+lng+"?&key=AqCqf0QgtemVsoM1XSRDG7P7PBL27yV8xv_wRsLKiL7F-Go_biaEVV1qNgn0mygx";
	$.getJSON(u, function(json) {    
	bing_code=json.results[1].formatted_address;
	})
};
	
} 
var bing_tools=new bing_tools_class(); 