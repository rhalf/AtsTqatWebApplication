      function clearall(){
		vectors.removeFeatures(vectors.features);
         }
		    function clearSelected(){
         	vectors.removeFeatures(vectors.selectedFeatures);
         }
/*<script type="text/ecmascript">*/
function operation_toggleControl(obj,operation){
	//////////////////////pointToggle
	if (obj==3 && operation=='hide'){
			for (var i=0;i<document.getElementsByTagName('circle').length;i++){
				document.getElementsByTagName('circle')[i].setAttributeNS(null,"display",'none')
			}			
	}else if (obj==3 && operation=='show'){
			for (var i=0;i<document.getElementsByTagName('circle').length;i++){
				document.getElementsByTagName('circle')[i].setAttributeNS(null,"display",'block')
			}		
	}else if (obj==3 && operation=='delete'){
			for (var i=vectors.features.length; i-- > 0;){
				if (vectors.features[i].geometry.id.indexOf("OpenLayers.Geometry.Point") !=-1){
					vectors.removeFeatures(vectors.features[i]);
				}
			}
	}
		//////////////lineToggle
	else if (obj==2 && operation=='hide'){
			for (var i=0;i<document.getElementsByTagName('polyline').length;i++){
				document.getElementsByTagName('polyline')[i].setAttributeNS(null,"display",'none')
			}			
	}else if (obj==2 && operation=='show'){
			for (var i=0;i<document.getElementsByTagName('polyline').length;i++){
				document.getElementsByTagName('polyline')[i].setAttributeNS(null,"display",'block')
			}		
	}else if (obj==2 && operation=='delete'){
			for (var i=vectors.features.length; i-- > 0;){
				if (vectors.features[i].geometry.id.indexOf("OpenLayers.Geometry.LineString") !=-1){
					vectors.removeFeatures(vectors.features[i]);
				}
			}
	}
		/////////////////////////polygonToggle
	else if ((obj==4 || obj==5) && operation=='hide'){
			for (var i=0;i<document.getElementsByTagName('path').length;i++){
				document.getElementsByTagName('path')[i].setAttributeNS(null,"display",'none')
			}			
	}else if ((obj==4 || obj==5) && operation=='show'){
			for (var i=0;i<document.getElementsByTagName('path').length;i++){
				document.getElementsByTagName('path')[i].setAttributeNS(null,"display",'block')
			}		
	}else if ((obj==4 || obj==5) && operation=='delete'){
			for (var i=vectors.features.length; i-- > 0;){
				if (vectors.features[i].geometry.id.indexOf("OpenLayers.Geometry.Polygon") !=-1){
					vectors.removeFeatures(vectors.features[i]);
				}
			}
	}
	////////////////////////markersToggle
	else if (obj==1 && operation=='hide'){
			markersLayer.display(false);
	}	
	else if (obj==1 && operation=='show'){
			markersLayer.display(true);
			alert("markersLayer");
	}
	else if (obj==1 && operation=='delete'){
			markersLayer.clearMarkers();
	
	}
}


function osm_remove_geofence(){
for (var i=document.getElementsByTagName('path').length; i-- > 0;){
				document.getElementsByTagName('path')[i].parentNode.removeChild(document.getElementsByTagName('path')[i]);
			}			
	
}