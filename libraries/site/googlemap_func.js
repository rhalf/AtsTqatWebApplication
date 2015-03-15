// google map functions
 var geocoder;
 var maps = [];
 var trafficLayer;
 var bikeLayer;
 var poly;
 var polyOnly;

 this.init_GoogleMap =function(mapdiv, id) {
     geocoder = new google.maps.Geocoder();
     var latlng = new google.maps.LatLng(DefaultSettings.default_Lat, DefaultSettings.default_Lon);
     var myOptions = {
         zoom: DefaultSettings.default_Zoom,
         center: latlng,
         mapTypeId: google.maps.MapTypeId.ROADMAP
     };
	maps[id] = new google.maps.Map(document.getElementById(mapdiv), myOptions);
	trafficLayer = new google.maps.TrafficLayer();
	bikeLayer = new google.maps.BicyclingLayer();
	addMarkerPolyStyle();
	addPolyStyle();
	GeoFenceViewer.CreateAll();
	selectAllPois(true);
	selectAllGeoFences(true);
 };


 function addMarkerPolyStyle() {
     var MarkerPolyOptions = {
         strokeColor: "#FF0000",
         strokeOpacity: 0.8,
         strokeWeight: 1
     };
     poly = new google.maps.Polyline(MarkerPolyOptions);
 };
 
function addPolyStyle() {
     var polyOnlyOptions = {
         strokeColor: "#FF0000",
         strokeOpacity: 0.8,
         strokeWeight: 1
     };
     polyOnly = new google.maps.Polyline(polyOnlyOptions);
    
}

//google_tools_class 
function google_tools_class (){
	this.MarkersOnlyArrays=[];
	this.MarkersLines=[];
	this.PolysLines = [];
	this.PolysOnlyArray = [];
	
	
// marker only
 this.EnableMarkerOnly=function() {
	 var _this=this;
     google.maps.event.addListener(maps[MapClass.currMapID], 'click',function(event){
		  var marker = new google.maps.Marker({
         position: event.latLng,
         map: maps[MapClass.currMapID],
         draggable: true
     });
     _this.MarkersOnlyArrays.push(marker);
		 
		 });
 };

 this.opeMarkersOnly=function(ope) {
     if (this.MarkersOnlyArrays) {
         for (i in this.MarkersOnlyArrays) {
			 if (ope==1){
			 	this.MarkersOnlyArrays[i].setMap(maps[MapClass.currMapID]);	 
			 }else if (ope==2 || ope==3){
             	this.MarkersOnlyArrays[i].setMap(null);
			 }
         }
		 if (ope==3){
        	this.MarkersOnlyArrays.length = 0;
		 }
     };
 }	
 
 
// Lines
 this.EnableMarkerPoly= function() {
	
	 var _this=this;
     google.maps.event.addListener(maps[MapClass.currMapID], 'click', function(event){
		var polyOptions = {
			strokeColor: "#"+document.getElementById('gstrokecolor').value,
			strokeOpacity: document.getElementById("gstrokeopacity").value,
			strokeWeight: document.getElementById("gstrokewidth").value 
		};	 
		poly.setOptions(polyOptions);
		poly.setMap(maps[MapClass.currMapID]); 
		var path = poly.getPath();
		path.push(event.latLng);
		var markerLine = new google.maps.Marker({
			position: event.latLng,
			title: '#' + path.getLength(),
			map: maps[MapClass.currMapID]
		});
		_this.MarkersLines.push(poly);
		_this.PolysLines.push(markerLine);	 
	 });
 };

 
this.opeMarkersPolys=function(ope) {
	if (this.MarkersLines) {
	 for (i in this.MarkersLines) {
		 if (ope==1){
		 this.MarkersLines[i].setMap(maps[MapClass.currMapID]);
		  this.PolysLines[i].setMap(maps[MapClass.currMapID]);
		 }else if (ope==2 || ope ==3){
			 this.MarkersLines[i].setMap(null);
			 this.PolysLines[i].setMap(null); 
		 }
	 }
	 if (ope==3){
		 this.MarkersLines.length = 0;
		 poly.setPath([]);
		 this.PolysLines.length = 0;
	 }
	}
};
 
 // Poly Only 
this.EnablePoly=function() {
	 _this=this;
     google.maps.event.addListener(maps[MapClass.currMapID], 'click', function(event){
		 
		 var polyOnlyOptions = {
          strokeColor:  "#"+document.getElementById('gstrokecolor').value,
         strokeOpacity: document.getElementById("gstrokeopacity").value,
          strokeWeight: document.getElementById("gstrokewidth").value 
     };	 
	 
	polyOnly.setOptions(polyOnlyOptions);
	 polyOnly.setMap(maps[MapClass.currMapID]); 
    var  pathOnly = polyOnly.getPath();
     pathOnly.push(event.latLng);
     _this.PolysOnlyArray.push(polyOnly); 	 
		 
	 });
 }

 this.opePolyOnly=function(ope) {
      if (this.PolysOnlyArray) {
         for (i in this.PolysOnlyArray) {
			 if (ope==1){
				 this.PolysOnlyArray[i].setMap(maps[MapClass.currMapID]);
			 }else if (ope==2 || ope==3){
				 
             this.PolysOnlyArray[i].setMap(null);
			 }
         }
     }
	 if (ope==3){
	 polyOnly.setPath([]);
     this.PolysOnlyArray.length = 0;
	 }
 };



 ///////// Circle  
 this.startMarkerArr = [];
 this.endMarkerArr = [];
 this.circleArr = [];
 this.circleStyles = [];
	

 this.CreateCircleStyleObject=function() {
     var cirstyle = {
		 fillColor: '#'+ document.getElementById('gfillColor').value,
         fillOpacity: document.getElementById('gfillopacity').value,
         strokeColor: '#'+document.getElementById('gstrokecolor').value,
         strokeOpacity: document.getElementById('gstrokeopacity').value,
         strokeWeight: document.getElementById('gstrokewidth').value	 
		 
	 };
      this.circleStyles .push(cirstyle);
 }

 this.activateCircle=function() {
	 this.CreateCircleStyleObject();
     circle = new google.maps.Circle({
         map: maps[MapClass.currMapID]
     });
	circle.setOptions( this.circleStyles [ this.circleStyles .length-1]);
 }

 this.EnableCircle=function(event) {
	 _this=this;
     google.maps.event.clearListeners(maps[MapClass.currMapID], 'click');
     google.maps.event.addListener(maps[MapClass.currMapID], 'click', function(event) {
		 
		var startMarker = new google.maps.Marker({
         position: event.latLng,
         draggable: true,
         map: maps[MapClass.currMapID]
     });
     _this.startMarkerArr.push(startMarker);
     google.maps.event.clearListeners(maps[MapClass.currMapID], 'click');
     google.maps.event.addListener(maps[MapClass.currMapID], 'click', function(event) {
    var  nemarker = new google.maps.Marker({
         position: event.latLng,
         draggable: true,
         raiseOnDrag: false,
         map: maps[MapClass.currMapID]
     });
     _this.endMarkerArr.push(nemarker);
     _this.activateCircle();
      google.maps.event.clearListeners(maps[MapClass.currMapID], 'click');
     google.maps.event.addListener(startMarker, 'drag', function() {
     for (i in _this.startMarkerArr) {
        var  centerPoint =  _this.startMarkerArr[i].getPosition();
        var  radiusPoint =  _this.endMarkerArr[i].getPosition();
         _this.circleArr[i].bindTo('center',  _this.startMarkerArr[i], 'position');
         calc = CalcDistance(centerPoint.lat(), centerPoint.lng(), radiusPoint.lat(), radiusPoint.lng());
         _this.circleArr[i].setRadius(calc);
	 }
	 });
     google.maps.event.addListener(nemarker, 'drag', function() {
     for (i in _this.startMarkerArr) {
        var  centerPoint =  _this.startMarkerArr[i].getPosition();
        var  radiusPoint =  _this.endMarkerArr[i].getPosition();
         _this.circleArr[i].bindTo('center',  _this.startMarkerArr[i], 'position');
         calc = CalcDistance(centerPoint.lat(), centerPoint.lng(), radiusPoint.lat(), radiusPoint.lng());
         _this.circleArr[i].setRadius(calc);
		 }
     });
     startMarker.setDraggable(true);
     startMarker.setAnimation(null);
     _this.circleArr.push(circle);

     for (i in _this.startMarkerArr) {
        var  centerPoint =  _this.startMarkerArr[i].getPosition();
        var  radiusPoint =  _this.endMarkerArr[i].getPosition();
         _this.circleArr[i].bindTo('center',  _this.startMarkerArr[i], 'position');
         calc = CalcDistance(centerPoint.lat(), centerPoint.lng(), radiusPoint.lat(), radiusPoint.lng());
         _this.circleArr[i].setRadius(calc);
     }
	 });  
	 });	 
 }

 this.opeCircle=function(ope) {
     if (this.startMarkerArr) {
         for (i in this.startMarkerArr) {
			 if (ope==1 ){
			this.startMarkerArr[i].setMap(maps[MapClass.currMapID]);	 
			 }else if (ope ==2 || ope==3){
             this.startMarkerArr[i].setMap(null);
			 }
         }
		 if (ope==3){
         this.startMarkerArr.length = 0;
		 }
     }
     if (this.endMarkerArr) {
         for (i in this.endMarkerArr) {
			  if (ope==1 ){
			this.endMarkerArr[i].setMap(maps[MapClass.currMapID]); 
			 }else if (ope ==2 || ope==3){	
			 this.endMarkerArr[i].setMap(null);			  
			  }
             
         }
		  if (ope==3){
         this.endMarkerArr.length = 0;
		  }
     }
     if (this.circleArr) {
         for (i in this.circleArr) {
			 if (ope==1 ){
				this.circleArr[i].setMap(maps[MapClass.currMapID]); 
			}else if (ope ==2 || ope==3){		 
             this.circleArr[i].setMap(null);
			}
         }
		   if (ope==3){
         this.circleArr.length = 0;
		 this.circlestyles.length=0;
		   }
     }
 };


// polygon
this.PolygonPaths=[];
this.PolygonMarkers=[];
this.PolygonPolys=[];
this.Polygons=[];

this.EnableFreeHandPolygon=function (){
	_this=this;
    var isClosed = false; 
    var poly = new google.maps.Polyline({ 
	map: maps[MapClass.currMapID], 
	path: [], 
	strokeColor: "#FF0000", 
	strokeOpacity: 1.0, 
	strokeWeight: 2 
	}); 
 	_this.PolygonPolys.push(poly);			
    google.maps.event.addListener(maps[MapClass.currMapID], 'click', function (clickEvent) { 
        if (isClosed)
            return; 
        var isFirstMarker = poly.getPath().length === 0; 
        var marker = new google.maps.Marker({ 
		map: maps[MapClass.currMapID], 
		position: clickEvent.latLng, 
		draggable: true 
		}); 
		_this.PolygonMarkers.push( marker); 
       // if (isFirstMarker) { 
            google.maps.event.addListener(marker, 'click', function () { 
                if (isClosed) 
                    return; 
                var path = poly.getPath(); 
                poly.setMap(null); 
            var  Polygon = new google.maps.Polygon({ 
				map: maps[MapClass.currMapID], 
				path: path, 
				strokeColor: "#FF0000", 
				strokeOpacity: 0.8, 
				strokeWeight: 2, 
				fillColor: "#FF0000", 
				fillOpacity: 0.35 }); 
                isClosed = true; 
				_this.Polygons.push(Polygon);
            }); 	
        google.maps.event.addListener(marker, 'drag', function (dragEvent) {
			  
            poly.getPath().setAt(marker, dragEvent.latLng); 
			
        }); 
        poly.getPath().push(clickEvent.latLng);
		
    }); 
	_this.PolygonPaths.length=0;
	_this.PolygonPaths.push( poly.getPath().getArray()); 
	
	}
	
this.opeFreeHandPolygon=function(ope){
	if (this.Polygons) { 
		for (i in  this.Polygons) {
			if (ope==1){	
			this.Polygons[i].setMap(maps[MapClass.currMapID]);	
			}else if (ope==2 || ope==3)
			this.Polygons[i].setMap(null);
		} 
		if (ope==3){
		this.Polygons.length = 0;
		}
	}	
	if ( this.PolygonMarkers) { 
		for (i in  this.PolygonMarkers) {
			if (ope==1){	
			this.PolygonMarkers[i].setMap(maps[MapClass.currMapID]);	
			}else if (ope==2 || ope==3){
			this.PolygonMarkers[i].setMap(null);	
			}
		} 
		if (ope==3){
		this.PolygonMarkers.length = 0;
		}
	}	
	if ( this.PolygonPolys) { 
		for (i in  this.PolygonPolys) {
			if (ope==1){
			this.PolygonPolys[i].setMap(maps[MapClass.currMapID]);	
			}else if (ope==2 || ope==3){
			this.PolygonPolys[i].setMap(null);
			}
		} 
		if (ope==3){
	this.PolygonPolys.length = 0;
		}
	}	
	if (ope==3){
	this.PolygonPaths.length=0;	
	}
	};
	
// direction
this.Directions=[];
this.oldDirections = [];
this.currentDirections = null;
this.directionsDisplay;
this.directionsService = new google.maps.DirectionsService();
  this.EnableDirection=function() {
	  _this=this;
     google.maps.event.addListener(maps[MapClass.currMapID], 'click', function (event) {
              _this.directionsDisplay = new google.maps.DirectionsRenderer({
         'map': maps[MapClass.currMapID],
         'preserveViewport': true,
         'draggable': true
     });
     _this.directionsDisplay.setPanel(document.getElementById("directions_panel"));
     _this.Directions.push(_this.directionsDisplay);
     google.maps.event.addListener(_this.directionsDisplay, 'directions_changed',

     function () {
         if (_this.currentDirections) {
             _this.oldDirections.push(_this.currentDirections);
         }
         _this.currentDirections = _this.directionsDisplay.getDirections();
     });
     var start = event.latLng;
     var end = event.latLng;
     var request = {
         origin: start,
         destination: end,
         travelMode: google.maps.DirectionsTravelMode.DRIVING
     };
     _this.directionsService.route(request, function (response, status) {
         if (status == google.maps.DirectionsStatus.OK) {
             _this.directionsDisplay.setDirections(response);
         }
     });
     });
 };

 function undo() {
     currentDirections = null;
     directionsDisplay.setDirections(oldDirections.pop());
     if (!oldDirections.length) {}
 }

 this.opeDirections=function(ope) {
     if (this.Directions) {
         for (i in this.Directions) {
			 if (ope==1){
			this.Directions[i].setMap(maps[MapClass.currMapID]);	 
			 }else if (ope==2 || ope==3){
             this.Directions[i].setMap(null);
			 }
         }
		 if (ope==3){
         this.Directions.length = 0;
		 document.getElementById("directions_panel").innerHTML="";
		 }
     }
 };
	
// ruler

this.ruler1Arr = [];
this.ruler2Arr = [];
this.rulerpolyArr = [];
this.ruler1labelArr = [];
this.ruler2labelArr = [];


this.EnableRuler=function() {
	var _this=this;
    google.maps.event.addListener(maps[MapClass.currMapID], "click", function(event){
 	var ruler1 = new google.maps.Marker({
        position: event.latLng,
        map: maps[MapClass.currMapID],
        draggable: true
    });
    var ruler2 = new google.maps.Marker({
        position: event.latLng,
        map: maps[MapClass.currMapID],
        draggable: true
    });
    _this.ruler1Arr.push(ruler1);
    _this.ruler2Arr.push(ruler2);
    var ruler1label = new Label({
        map: maps[MapClass.currMapID]
    });
    var ruler2label = new Label({
        map: maps[MapClass.currMapID]
    });
    ruler1label.bindTo("position", ruler1, "position");
    ruler2label.bindTo("position", ruler2, "position");
    var rulerpoly = new google.maps.Polyline({
        path: [ruler1.position, ruler2.position],
        strokeColor: "#FFFF00",
        strokeOpacity: 0.7,
        strokeWeight: 7
    });
    rulerpoly.setMap(maps[MapClass.currMapID]);
    ruler1label.set("text", _this.distance(ruler1.getPosition().lat(), ruler1.getPosition().lng(), ruler2.getPosition().lat(), ruler2.getPosition().lng()));
    ruler2label.set("text", _this.distance(ruler1.getPosition().lat(), ruler1.getPosition().lng(), ruler2.getPosition().lat(), ruler2.getPosition().lng()));
    _this.rulerpolyArr.push(rulerpoly);
    _this.ruler1labelArr.push(ruler1label);
    _this.ruler2labelArr.push(ruler2label);
    google.maps.event.addListener(ruler1, "drag",function () {
		rulerpoly.setPath([ruler1.getPosition(), ruler2.getPosition()]);
		ruler1label.set("text", _this.distance(ruler1.getPosition().lat(), ruler1.getPosition().lng(), ruler2.getPosition().lat(), ruler2.getPosition().lng()));
		ruler2label.set("text", _this.distance(ruler1.getPosition().lat(), ruler1.getPosition().lng(), ruler2.getPosition().lat(), ruler2.getPosition().lng()))
    });
    google.maps.event.addListener(ruler2, "drag", function () {
        rulerpoly.setPath([ruler1.getPosition(), ruler2.getPosition()]);
        ruler1label.set("text", _this.distance(ruler1.getPosition().lat(), ruler1.getPosition().lng(), ruler2.getPosition().lat(), ruler2.getPosition().lng()));
        ruler2label.set("text", _this.distance(ruler1.getPosition().lat(), ruler1.getPosition().lng(), ruler2.getPosition().lat(), ruler2.getPosition().lng()))
    })			
	})
}


this.distance=function(lat1, lon1, lat2, lon2) {
    var R = 6371;
    var dLat = (lat2 - lat1) * Math.PI / 180;
    var dLon = (lon2 - lon1) * Math.PI / 180;
    var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) + Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * Math.sin(dLon / 2) * Math.sin(dLon / 2);
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    var d = R * c;
    if (d > 1) return Math.round(d) + "km";
    else if (d <= 1) return Math.round(d * 1E3) + "m";
    return d
}

 this.opeRuler=function(ope) {
    if (this.ruler1Arr) {
		for (i in this.ruler1Arr) {
			if (ope==1){
				this.ruler1Arr[i].setMap(maps[MapClass.currMapID]	);
			}else if (ope==2 || ope==3){
				this.ruler1Arr[i].setMap(null);
			}
		}
	}
    if (this.ruler2Arr) {
		for (i in this.ruler2Arr) {
			if (ope==1){
				this.ruler2Arr[i].setMap(maps[MapClass.currMapID]	);
			}else if (ope==2 || ope==3){
				this.ruler2Arr[i].setMap(null);
			}
		}
	}
    if (this.rulerpolyArr){
		for (i in this.rulerpolyArr) {
			if (ope==1){
				this.rulerpolyArr[i].setMap(maps[MapClass.currMapID]	);
			}else if (ope==2 || ope==3){
				this.rulerpolyArr[i].setMap(null);
			}
		}
	}
    if (this.ruler1labelArr){ 
		for (i in this.ruler1labelArr) {
			if (ope==1){
				this.ruler1labelArr[i].setMap(maps[MapClass.currMapID]	);
			}else if (ope==2 || ope==3){
				this.ruler1labelArr[i].setMap(null);
			}
		}
	}
    if (this.ruler2labelArr){
		for (i in this.ruler2labelArr) {
			if (ope==1){
				this.ruler2labelArr[i].setMap(maps[MapClass.currMapID]	);
			}else if (ope==2 || ope==3){
				this.ruler2labelArr[i].setMap(null);
			}
		}
	}
	if (ope==3){
		this.ruler1Arr.length = 0;	
		this.ruler2Arr.length = 0;
		this.rulerpolyArr.length = 0;
		this.ruler1labelArr.length = 0;	
		this.ruler2labelArr.length = 0;
	}
}

	 
}
var google_tools=new google_tools_class(); 
 
 
function DisableClick() {
     google.maps.event.clearListeners(maps[MapClass.currMapID], 'click');
};




 function CalcDistance(lat1, lon1, lat2, lon2) {
     var R = 6371000;
     var dLat = (lat2 - lat1) * Math.PI / 180;
     var dLon = (lon2 - lon1) * Math.PI / 180;
     var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) + Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * Math.sin(dLon / 2) * Math.sin(dLon / 2);
     var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
     var d = R * c;
     return d;
 }





 var MarkerPolygonArr = [];
 var MarkerPolygonArray = [];
 var triangleCoords = []
 var PolygonArr = []
 var triangleCoordsArr = []

     function EnableMarkerPolygon(event) {
         google.maps.event.clearListeners(maps[MapClass.currMapID], 'click');
         google.maps.event.addListener(maps[MapClass.currMapID], 'click', setMarkerPolygon);
     }

     function setMarkerPolygon(event) {
         MarkerPolygonArr.length = 0;
         MarkerPolygon = new google.maps.Marker({
             position: event.latLng,
             draggable: false,
             map: maps[MapClass.currMapID]
         });
         MarkerPolygonArr.push(MarkerPolygon);
         MarkerPolygonArray.push(MarkerPolygon);
         settriangleCoordsArr()
     }

     function settriangleCoordsArr() {
         for (i in MarkerPolygonArr) {
             triangleCoords.push(MarkerPolygonArr[i].position);
         }
         drawPolygon()
     }
 var g = google.maps.geometry.spherical;
 var AreaLatLng = []
 var points = new google.maps.MVCArray();
 var length, Area, radius = 6371000;


 var MarkersAddress = [];

 function codeAddress(address) {
     if (geocoder) {
         geocoder.geocode({
             address: address
         }, function (results, status) {
             if (status == google.maps.GeocoderStatus.OK) {
                 map.setCenter(results[0].geometry.location);
                 var marker = new google.maps.Marker({
                     map: maps[MapClass.currMapID],
                     position: results[0].geometry.location,
                     title: address
                 });
                 MarkersAddress.push(marker);
             } else {
                 alert('Geocode was not successful for the following reason: ' + status);
             }
         });
     }
 }


 function deleteMarkersAddress() {
     if (MarkersAddress) {
         for (i in MarkersAddress) {
             MarkersAddress[i].setMap(null);
         }
         MarkersAddress.length = 0;
     }
 }
 var markersArr = [];

/* function GotoLatLng(Lat, Lang) {
     var image = 'D:/Delphi Programming/Fleetm/images/location.png';
     var latlng = new google.maps.LatLng(Lat, Lang);
     maps[MapClass.currMapID].setCenter(latlng);
     var marker = new google.maps.Marker({
         position: latlng,
         map: maps[MapClass.currMapID],
         title: Lat + ',' + Lang,
         icon: image
     });
     markersArr.push(marker);
 }*/

 function deletGotoLatLng() {
     if (markersArr) {
         for (i in markersArr) {
             markersArr[i].setMap(null);
         }
         markersArr.length = 0;
     }
 }


 function TrafficOn() {
     trafficLayer.setMap(maps[MapClass.currMapID]);
 }

 function TrafficOff() {
     trafficLayer.setMap(null);
 }

 function BicyclingOn() {
     bikeLayer.setMap(maps[MapClass.currMapID]);
 }

 function BicyclingOff() {
     bikeLayer.setMap(null);
 }

 function StreetViewOn() {
     maps[MapClass.currMapID].set('streetViewControl', true);
 }

 function StreetViewOff() {
     maps[MapClass.currMapID].set('streetViewControl', false);
 }
 var markersAr = [];

 function codeLatLng(lat, lng) {
     var latlng = new google.maps.LatLng(lat, lng);
     geocoder.geocode({
         'latLng': latlng
     }, function (results, status) {
         if (status == google.maps.GeocoderStatus.OK) {
             if (results[1]) {
                 maps[MapClass.currMapID].setZoom(14);
                 maps[MapClass.currMapID].setCenter(latlng);
                 marker = new google.maps.Marker({
                     position: latlng,
                     map: maps[MapClass.currMapID],
                     draggable: false
                 });
                 markersAr.push(marker);
                 document.getElementById("address").value = results[1].formatted_address;
             } else {
                 document.getElementById("address").value = "No results found";
             }
         } else {
             document.getElementById("address").value = "Geocoder failed due to: " + status;
         }
     });
 }

 function deletecodeLatLng() {
     if (markersAr) {
         for (i in markersAr) {
             markersAr[i].setMap(null);
         }
         markersAr.length = 0;
     }
 }

 function disableUI(id) {
     maps[id].set('disableDefaultUI', true);
     maps[id].set('mapTypeControl', false);
 }

 function EnableUI(id) {
     maps[id].set('disableDefaultUI', false);
     maps[id].set('mapTypeControl', true);
 }
 var markersArray = [];

 function ClearMap() {
     if (markersArray) {
         for (i in markersArray) {
             markersArray[i].setMap(null);
         }
         markersArray.length = 0;
     }
     if (markersArr) {
         for (i in markersArr) {
             markersArr[i].setMap(null);
         }
         markersArr.length = 0;
     }
     if (markersAr) {
         for (i in markersAr) {
             markersAr[i].setMap(null);
         }
         markersAr.length = 0;
     }
     if (MarkersAddress) {
         for (i in MarkersAddress) {
             MarkersAddress[i].setMap(null);
         }
         MarkersAddress.length = 0;
     }
 }