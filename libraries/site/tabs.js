MapTabClass = function(){
	this.currMap="gmap";
	this.currMapID=0;
	this.counter=0;	
	this.tabs=[];	
}

var MapClass= new MapTabClass();


if (DefaultSettings.default_map==1){
	MapClass.currMap = 'gmap';
}else if (DefaultSettings.default_map==2){
	MapClass.currMap = 'bmap';	
}else if (DefaultSettings.default_map==3){
	MapClass.currMap = 'omap';	
}else if (DefaultSettings.default_map==4){
	MapClass.currMap = 'vmap';	
}else if (DefaultSettings.default_map==5){
	MapClass.currMap = 'nmap';	
}else if (DefaultSettings.default_map==6){
	MapClass.currMap = 'amap';	
}

function create_map_tab(tabname, maptype) {
	
 MapClass.counter++;
    var $tabs = $("#maptabs").tabs({
		 activate: function (event, ui) {
			MapClass.currMapID = ui.newPanel.selector.split('map')[1];
			//var label = $(ui.tab).text().split('_')[0];
			var label=$('div #map'+MapClass.currMapID);
			if (label.hasClass('googlemap')){
				MapClass.currMap = 'gmap';
			}else if (label.hasClass('osmmap')){
				MapClass.currMap = 'omap';	
			}else if (label.hasClass('bingmap')){
				MapClass.currMap = 'bmap';
			}else if (label.hasClass('ovimap')){	
				MapClass.currMap = 'vmap';
			}else if (label.hasClass('nokiamap')){	
				MapClass.currMap = 'nmap';
			}else if (label.hasClass('arcgismap')){	
				MapClass.currMap = 'amap';
			}
					
			/*if (label == 'Google Map') {
				 MapClass.currMap = 'gmap';
			} else if (label == 'Bing Map') {
				 MapClass.currMap = 'bmap';
			} else if (label == 'Open street Map') {
				 MapClass.currMap = 'omap';
			}*/
			//console.log(ui.newPanel);
			var i = 0;
			for (i = 0; i < MapClass.counter; i++) {
				if(i==MapClass.currMapID){
					$('#map' + MapClass.currMapID).show();					
				}else{
					$('#map' + i).hide();
				}
			}
		},
       // tabTemplate: "<li><a href='#{href}'>#{label}</a> <span class='ui-icon ui-icon-close' style='float:left;'>Remove Tab</span></li>",
       /* add: function (event, ui) {
            MapClass.currMapID = MapClass.counter;
			console.log(MapClass.currMapID);
            $tabs.tabs('select', '#map' + MapClass.counter);
		   $('#map' + MapClass.counter).show();
            $('#divmaps').append("<div id=" + 'map' + MapClass.counter + " ></div>");

            if (maptype == 1) {
                $('#map' + MapClass.counter).toggleClass("googlemap");
                init_GoogleMap("map" + MapClass.counter, MapClass.counter);
                MapClass.currMap = 'gmap';
                $('#map' + MapClass.counter).click(function () {
                    if (MapClass.currMap == 'gmap') {
                        google.maps.event.trigger(maps[MapClass.currMapID], 'resize');
					}
                });
            } else if (maptype == 2) {
                $('#map' + MapClass.counter).toggleClass('BingMap');
                init_BingMap("map" + MapClass.counter, MapClass.counter);
                MapClass.currMap = 'bmap';
            } else if (maptype == 3) {
                $('#map' + MapClass.counter).toggleClass('googlemap');
                init_OsmMap("map" + MapClass.counter, MapClass.counter,'website');
                MapClass.currMap = 'omap';
            } else if (maptype == 4) {
                $('#map' + MapClass.counter).toggleClass('googlemap');
                init_OviMap("map" + MapClass.counter);
                MapClass.currMap = 'vmap';
            }
			MapClass.tabs.push('map'+MapClass.counter);
            if (typeof getMapOptions == 'function') {
                getMapOptions();
            }
        }*/
    });
	
	//$tabs.tabs("add", "#map" + MapClass.counter, tabname + "_" + MapClass.counter);
	var ul = $tabs.find( "ul" );
	$("<li><a href='"+"#map" + MapClass.counter+"'>"+tabname + "_" + MapClass.counter+"</a> <span class='ui-icon ui-icon-close mapclose"+MapClass.counter+"' style='float:left;'>Remove Tab</span></li>").appendTo( ul );
//$( "<li><a href='/url_for_tab/'>"+tabname + "_" + MapClass.counter+"</a></li>" ).appendTo( ul );
$tabs.tabs( "refresh" );

$('#maptabs').append("<div id=" + 'map' + MapClass.counter + " ></div>");
 MapClass.currMapID = MapClass.counter;
//console.log(MapClass.currMapID);
            //$tabs.tabs('select', '#map' + MapClass.counter);
			$tabs.tabs({ active: 1 });
		  $tabs.tabs( "option", "active", MapClass.counter-1 );
		   $('#map' + MapClass.counter).show();
            $('#divmaps').append("<div id=" + 'map' + MapClass.counter + " ></div>");

            if (maptype == 1) {
                $('#map' + MapClass.counter).addClass("googlemap");
				MapClass.currMap = 'gmap';
                init_GoogleMap("map" + MapClass.counter, MapClass.counter);
                $('#map' + MapClass.counter).click(function () {
                    if (MapClass.currMap == 'gmap') {
                        google.maps.event.trigger(maps[MapClass.currMapID], 'resize');
					}
                });
            } else if (maptype == 2) {
                $('#map' + MapClass.counter).addClass('bingmap');
                MapClass.currMap = 'bmap';
                init_BingMap("map" + MapClass.counter, MapClass.counter);
            } else if (maptype == 3) {
                $('#map' + MapClass.counter).addClass('osmmap');
                MapClass.currMap = 'omap';
                init_OsmMap("map" + MapClass.counter, MapClass.counter,'website');
            } else if (maptype == 4) {
                MapClass.currMap = 'vmap';
                $('#map' + MapClass.counter).addClass('ovimap');
                init_OviMap("map" + MapClass.counter,MapClass.counter);
            }else if (maptype == 5) {
                MapClass.currMap = 'nmap';
                $('#map' + MapClass.counter).addClass('nokiamap');
                init_NokiaMap("map" + MapClass.counter,MapClass.counter);
            }else if (maptype == 6) {
                MapClass.currMap = 'amap';
                $('#map' + MapClass.counter).addClass('arcgismap');
                init_ArcgisMap("map" + MapClass.counter,MapClass.counter);
            }
			
			MapClass.tabs.push('map'+MapClass.counter);
            if (typeof getMapOptions == 'function') {
                getMapOptions();
            };
					
        
	$(".mapclose"+MapClass.counter).click(function(e) {
     if (MapClass.tabs.length!==1){
			var l = $(this).parent().find("a").attr("href").split("#")[1];	
			$('#' + l).hide();
			$(this).parent().remove();	
			removeByValue(MapClass.tabs, l);
			//$("#maptabs").tabs('select', "#" + MapClass.tabs[0]);
			$("#maptabs").tabs( "option", "active", 0 );
			if (MapClass.tabs[0] != null) {
			   MapClass.currMapID = MapClass.tabs[0].split('map')[1];
			}
			if (typeof getMapOptions == 'function') {
				getMapOptions();
			}
		}   
    });
	/*$("#maptabs span.ui-icon-close").live('click', function () {       
		if (MapClass.tabs.length!==1){
			var l = $(this).parent().find("a").attr("href").split("#")[1];	
			$('#' + l).hide();
			$(this).parent().remove();	
			removeByValue(MapClass.tabs, l);
			$("#maptabs").tabs('select', "#" + MapClass.tabs[0]);
			if (MapClass.tabs[0] != null) {
			   MapClass.currMapID = MapClass.tabs[0].split('map')[1]
			}
			if (typeof UpdateSectionMap == 'function') {
				UpdateSectionMap();
			}
		}
	});*/
}