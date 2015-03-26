// Open Street Map Functions
/////////////////////
var osmmaps=[];
var vectors, controls;
var renderer;
var markersLayer;
var trackingLayer;
//var poiLayer;
//var DrawPOILayer;
var replayLayer;
var MarkerReplayLayer;
var geoFenceViewerVector=[];
//var DrawGeoFenceVectors;
var geoFenceMarkers;
var TargetProjection=new OpenLayers.Projection("EPSG:4326");
var BaseProjection=new OpenLayers.Projection("EPSG:900913");

	this.init_OsmMap =function(div,id,version){
		osmmaps[id] = new OpenLayers.Map(div,{
			projection: BaseProjection,
			displayProjection: TargetProjection,
			// ratio: 1,
			// maxResolution: 10000,
			// units: 'm',
			// numZoomLevels: 19, 
			transitionEffect : "map-resize",
			buffer : 100
			// singleTile: true,
			//tileSize: new OpenLayers.Size(1000,1000)
		/*	, 
          controls: [
            new OpenLayers.Control.Navigation(),
            new OpenLayers.Control.PanZoomBar(),
            new OpenLayers.Control.Attribution()
          ]
        */  
		});
		//==================================================================================
		arrayOSM = ["http://otile1.mqcdn.com/tiles/1.0.0/map/${z}/${x}/${y}.png",
                    "http://otile2.mqcdn.com/tiles/1.0.0/map/${z}/${x}/${y}.png",
                    "http://otile3.mqcdn.com/tiles/1.0.0/map/${z}/${x}/${y}.png",
                    "http://otile4.mqcdn.com/tiles/1.0.0/map/${z}/${x}/${y}.png"];
        arrayAerial = ["http://oatile1.mqcdn.com/tiles/1.0.0/sat/${z}/${x}/${y}.png",
                        "http://oatile2.mqcdn.com/tiles/1.0.0/sat/${z}/${x}/${y}.png",
                        "http://oatile3.mqcdn.com/tiles/1.0.0/sat/${z}/${x}/${y}.png",
                        "http://oatile4.mqcdn.com/tiles/1.0.0/sat/${z}/${x}/${y}.png"];
        
        fraunhofer = "http://tile.iosb.fraunhofer.de/tiles/osmde/${z}/${x}/${y}.png";

        baseOSM = new OpenLayers.Layer.OSM("MapQuest-OSM Tiles", arrayOSM);
        baseAerial = new OpenLayers.Layer.OSM("MapQuest Open Aerial Tiles", arrayAerial);
        baseFraunhofer =  new OpenLayers.Layer.OSM("Fraunhofer Map", fraunhofer);
        
        //osmmaps[id].addLayer(baseCycle);
        osmmaps[id].addLayer(new OpenLayers.Layer.OSM("OpenLayers WMS"));
        osmmaps[id].addLayer(baseOSM);
        osmmaps[id].addLayer(baseAerial);
        osmmaps[id].addLayer(baseFraunhofer);
        osmmaps[id].addControl(new OpenLayers.Control.LayerSwitcher());
		//==================================================================================
		//osmmaps[id].addLayer(new OpenLayers.Layer.OSM("OpenLayers WMS"));
		osmmaps[id].setCenter(transform(new OpenLayers.LonLat(DefaultSettings.default_Lon,DefaultSettings.default_Lat ))
	 	 , DefaultSettings.default_Zoom // Zoom
	 	 );
		//osmmaps[id].addControl(new OpenLayers.Control.LayerSwitcher());

		OpenLayers.Feature.Vector.style['default']['strokeWidth'] = '2';

		renderer = OpenLayers.Util.getParameters(window.location.href).renderer;
		renderer = (renderer) ? [renderer] : OpenLayers.Layer.Vector.prototype.renderers;
		
		markersLayer = new OpenLayers.Layer.Markers( "Markers" );
		markersLayer.id = "Markers"+id;
		osmmaps[id].addLayer(markersLayer);

		trackingLayer= new OpenLayers.Layer.Markers( "Tracking" );
		trackingLayer.id = "Tracking"+id;
		osmmaps[id].addLayer(trackingLayer);
		trackingLayer.setZIndex( 1001 ); 

		var poiLayer= new OpenLayers.Layer.Markers( "POI" );
		poiLayer.id = "POI"+id;
		osmmaps[id].addLayer(poiLayer);
		poiLayer.setZIndex( 1001 ); 

		MarkerReplayLayer= new OpenLayers.Layer.Markers( "MarkerReplayLayer" );
		MarkerReplayLayer.id = "MarkerReplayLayer"+id;
		osmmaps[id].addLayer(MarkerReplayLayer);
		MarkerReplayLayer.setZIndex( 1001 ); 

		vectors = new OpenLayers.Layer.Vector("Vector Layer", {
			renderers: renderer
			,style: {
				pointRadius: 10,
				 strokeColor :'#FF3414',
				fillColor : '#BF9643',
				strokeOpacity:.5,
				fillOpacity:.5	
				}
			});
		osmmaps[id].addLayer(vectors);
		
		
		 geoFenceViewerVector[id] = new OpenLayers.Layer.Vector("geoFenceViewer", {
			renderers: renderer
			,style: {
				pointRadius: 10,
				strokeColor :'#1C33FF',
				fillColor : '#1C33FF',
				strokeOpacity:.5,
				fillOpacity:.5	
			}
			});
		osmmaps[id].addLayer(geoFenceViewerVector[id]);
		
		geoFenceMarkers = new OpenLayers.Layer.Markers( "geoFenceMarkers" );
		geoFenceMarkers.id = "geoFenceMarkers"+id;
		osmmaps[id].addLayer(geoFenceMarkers);
		
		var DrawGeoFenceVectors = new OpenLayers.Layer.Vector("Drwaing geofence Layer", {
               style: { 
				strokeColor: '#1C33FF', 
				strokeOpacity: 0.5,
			//	strokeWidth: 5,
				fillColor : '#1C33FF',
				fillOpacity:0.5	
			}
			});
			DrawGeoFenceVectors.id = "DrawGeoFence"+id;
			osmmaps[id].addLayer(DrawGeoFenceVectors);	
  
		var options = {
			hover: true,
			onSelect: serialize
		};
		var selectFeature = new OpenLayers.Control.SelectFeature(vectors, options);
		osmmaps[id].addControl(selectFeature);
		selectFeature.activate();
		
		updateFormats(id);

		controls = {
			point: new OpenLayers.Control.DrawFeature(vectors,OpenLayers.Handler.Point),
			line: new OpenLayers.Control.DrawFeature(vectors,OpenLayers.Handler.Path),
			polygon: new OpenLayers.Control.DrawFeature(vectors,OpenLayers.Handler.Polygon),
			regular: new OpenLayers.Control.DrawFeature(vectors,OpenLayers.Handler.RegularPolygon,
						{handlerOptions: {sides: 5}}),
			modify: new OpenLayers.Control.ModifyFeature(vectors)
			
		};
		
		for(var key in controls) {
			osmmaps[id].addControl(controls[key]);
		}  
};

function transform(latlon){
	return latlon.transform(TargetProjection,BaseProjection);
	
}
function retransform(latlon){
	return latlon.transform(BaseProjection,TargetProjection);
	
}
	
function handler(e) {
	var size = new OpenLayers.Size(21,25);
	var offset = new OpenLayers.Pixel(-(size.w/2), -size.h);
	var icon = new OpenLayers.Icon('libraries/map/OpenLayers-2.12/img/marker.png', size, offset);   
	var lonlat = osmmaps[MapClass.currMapID].getLonLatFromPixel(e.xy);
	var marker=new OpenLayers.Marker(lonlat,icon);
	markersLayer.addMarker(marker);
	OSMMarkersArr.push(marker);
} 
	
var OSMMarkersArr=[];	
function Enable_OSM_Markers(){
	osmmaps[MapClass.currMapID].events.register("click", osmmaps[MapClass.currMapID], handler)
}

function Disable_OSM_Markers(){
	osmmaps[MapClass.currMapID].events.unregister("click",osmmaps[MapClass.currMapID], handler)
}

function deleteMarkers(i) {
	var marker=markersLayer.markers[i];
	markersLayer.removeMarker(marker);
}


	
	
function update() {
	// reset modification mode
	controls.modify.mode = OpenLayers.Control.ModifyFeature.RESHAPE;
	var rotate = document.getElementById("rotate").checked;
	if(rotate) {
		controls.modify.mode |= OpenLayers.Control.ModifyFeature.ROTATE;
	}
	var resize = document.getElementById("resize").checked;
	if(resize) {
		controls.modify.mode |= OpenLayers.Control.ModifyFeature.RESIZE;
		var keepAspectRatio = document.getElementById("keepAspectRatio").checked;
		if (keepAspectRatio) {
			controls.modify.mode &= ~OpenLayers.Control.ModifyFeature.RESHAPE;
		}
	}
	var drag = document.getElementById("drag").checked;
	if(drag) {
		controls.modify.mode |= OpenLayers.Control.ModifyFeature.DRAG;
	}
	if (rotate || drag) {
		controls.modify.mode &= ~OpenLayers.Control.ModifyFeature.RESHAPE;
	}
	controls.modify.createVertices = document.getElementById("createVertices").checked;
	var sides = parseInt(document.getElementById("sides").value);
	sides = Math.max(3, isNaN(sides) ? 0 : sides);
	controls.regular.handler.sides = sides;
	var irregular =  document.getElementById("irregular").checked;
	controls.regular.handler.irregular = irregular;
}
	

function toggleControl(element) {
if (element=='markers'){
	Enable_OSM_Markers();	
	}else{
	Disable_OSM_Markers();
	}
	for(key in controls) {
		var control = controls[key];
		if(element == key) {
			vectors.style={	
				pointRadius: document.getElementById('Radius').value,
				strokeColor :'#'+ document.getElementById('strokecolor').value,
				fillColor : '#'+document.getElementById('fillColor').value,
				strokeOpacity:document.getElementById('strokeopacity').value,
				fillOpacity:document.getElementById('fillopacity').value,
				strokeWidth:document.getElementById('strokewidth').value
			}
			control.activate();
		} else {
			control.deactivate();
		}
	}
}
	
function osm_enable_geofence(value) {
	for(key in controls) {
		var control = controls[key];
		if(value == key ) {
			vectors.style={	
				pointRadius: document.getElementById('Radius').value,
				strokeColor :'#'+ document.getElementById('strokecolor').value,
				fillColor : '#'+document.getElementById('fillColor').value,
				strokeOpacity:document.getElementById('strokeopacity').value,
				fillOpacity:document.getElementById('fillopacity').value,
				strokeWidth:document.getElementById('strokewidth').value}
			control.activate();
		} else {
			control.deactivate();
		}
	}
}	
	
	
	

var formats;
function updateFormats(mapid) {
	var in_options = {
		'internalProjection': osmmaps[mapid].baseLayer.projection,
		'externalProjection': new OpenLayers.Projection("EPSG:4326")
	};   
	var out_options = {
		'internalProjection': osmmaps[mapid].baseLayer.projection,
		'externalProjection': new OpenLayers.Projection("EPSG:4326")
	};
	
	formats = {
	  'in': {
		geojson: new OpenLayers.Format.GeoJSON(in_options)
	  }, 
	  'out': {
		geojson: new OpenLayers.Format.GeoJSON(out_options)
	  } 
	};
}
function serialize(feature) {
	var type = "geojson";
	var pretty = true;
	var str = formats['out'][type].write(feature, pretty);
	str = str.replace(/,/g, ', ');
	str= eval('('+str+')');
	
	str= str.geometry.coordinates[0];
	var res='';
	for (var i=0;i<str.length;i++){
	res=res+'('+str[i][1]+','+str[i][0]+')';	
	}
	res=res.split(')(').join('),( ')
	
	$('#a_geofencespolyarr').val(res);
	$('#e_geofencespolyarr').val(res);
	return res;
}
	
function get_coordinates(str){
var type = 'geojson';
		var features = formats['in'][type].read(str);
		var bounds;
		if(features) {
			if(features.constructor != Array) {
				features = [features];
			}
			for(var i=0; i<features.length; ++i) {
				console.log(features);
				if (!bounds) {
					bounds = features[i].geometry.transform(osmmaps[1].baseLayer.projection, new OpenLayers.Projection("EPSG:4326")).getBounds();
				} else {
					bounds.extend(features[i].geometry.transform(osmmaps[1].baseLayer.projection, new OpenLayers.Projection("EPSG:4326")).getBounds());
				}

			}
		   document.getElementById('area').innerHTML=bounds;
		} else {
			alert('Bad input ' + type);
		}	
}
	


function deserialize(str) {
		var type = 'geojson';
		var features = formats['in'][type].read(str);
		var bounds;
		if(features) {
			if(features.constructor != Array) {
				features = [features];
			}
			for(var i=0; i<features.length; ++i) {
				if (!bounds) {
					bounds = features[i].geometry.getBounds();
				} else {
					bounds.extend(features[i].geometry.getBounds());
				}

			}
			vectors.addFeatures(features);
			map.zoomToExtent(bounds);
			var plural = (features.length > 1) ? 's' : '';
			element.value = features.length + ' feature' + plural + ' added';
		} else {
			element.value = 'Bad input ' + type;
		}
	}


var osm_code;
function osm_AddressCodeLatLng(lat,lng) {
	$.getJSON("http://nominatim.openstreetmap.org/reverse?format=json&lat="+lat+'&lon='+lng, function(json) {    
	osm_code=json.display_name;
	})
};
