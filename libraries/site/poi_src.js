function POIClass() {

    this.id = [];
    this.lat = [];
    this.lon = [];
    this.name = [];
    this.image = [];
    this.desc = [];

    this.google_PoiLabelArray = [];
    this.google_MarkersPOIArray = [];
    this.google_getMarkerPOIArray = [];
    this.google_getLabelPOIArray = [];

    this.bing_getMarkerPOIArray = [];

    /*_clear*/
    this._clear = function () {
        this.id.length = 0;
        this.lat.length = 0;
        this.lon.length = 0;
        this.name.length = 0;
        this.image.length = 0;
        this.desc.length = 0;
    };

    /*_draw*/
    this._draw = function (code) {
        if (MapClass.currMap == 'gmap') {
            this._google_draw(code);
        } else if (MapClass.currMap == 'omap') {
            this._osm_draw(code);
        } else if (MapClass.currMap == 'bmap') {
            this._bing_draw(code);
        }
    };


    /* _reset */
    this._reset = function () {
        if (MapClass.currMap == 'gmap') {
            this._google_reset();
        } else if (MapClass.currMap == 'omap') {
            this._osm_reset();
        } else if (MapClass.currMap == 'bmap') {
            this._bing_reset();
        }
    };
    /*_google_draw*/
    this._google_draw = function (code) {
        var _this = this;
        google.maps.event.addListener(maps[MapClass.currMapID], 'click', function (event) {
            _this._google_delete();
            _this._google_reset();

            var image = DefaultSettings.poiimgsrc + $('#' + code + 'img').val() + '.png';
            var marker = new google.maps.Marker({
                position: event.latLng,
                map: maps[MapClass.currMapID],
                icon: image
            });
            var latlong = event.latLng;
            _this.google_MarkersPOIArray.push(marker);

            $('#' + code + 'lat').val(latlong.lat());
            $('#' + code + 'long').val(latlong.lng());
            var Markerlabel = new Label({
                map: maps[MapClass.currMapID]
            });
            Markerlabel.bindTo('position', marker, 'position');
            Markerlabel.set('text', $('#' + code + 'name').val());
            _this.google_PoiLabelArray.push(Markerlabel);

        });
    };

    /*_disable*/
    this._disable = function () {
        if (MapClass.currMap == 'gmap') {
            google.maps.event.clearListeners(maps[MapClass.currMapID], 'click');
        } else if (MapClass.currMap == 'omap') {
            var DrawPOILayer = osmmaps[MapClass.currMapID].getLayer("POIDrwing" + MapClass.currMapID);
            if (osmmaps[MapClass.currMapID].getLayerIndex(DrawPOILayer) != -1) {
                osmmaps[MapClass.currMapID].removeLayer(DrawPOILayer);
            }
        } else if (MapClass.currMap == 'bmap') {
            Microsoft.Maps.Events.removeHandler(this.mapClick);
        }
    };

    /*_google_reset*/
    this._google_reset = function () {
        if (this.google_MarkersPOIArray) {
            for (i in this.google_MarkersPOIArray) {
                this.google_MarkersPOIArray[i].setMap(null);
            }
            this.google_MarkersPOIArray.length = 0;
        }
        if (this.google_PoiLabelArray) {
            for (i in this.google_PoiLabelArray) {
                this.google_PoiLabelArray[i].setMap(null);
            }
            this.google_PoiLabelArray.length = 0;
        }
    };



    /*_osm_draw*/
    this._osm_draw = function (code) {
        var _this = this;
        var DrawPOILayer = new OpenLayers.Layer.Markers("POI Drawing");
        DrawPOILayer.id = "POIDrwing" + MapClass.currMapID;
        osmmaps[MapClass.currMapID].addLayer(DrawPOILayer);
        osmmaps[MapClass.currMapID].events.register("click", osmmaps[MapClass.currMapID], function (e) {

            _this._osm_reset();
            var size = new OpenLayers.Size(25, 25);
            var offset = new OpenLayers.Pixel(-(size.w / 2), -size.h);
            var icon = new OpenLayers.Icon(null, size, offset);

            var richMarkerContent = $('<div/>');
            var arrowImage = $('<img/>', {
                src: DefaultSettings.poiimgsrc + $('#' + code + 'img').val() + '.png',
                height: '32px',
                width: '32px'
            });
            var rotationElement = $('<div/>').css(get_rotationStyles(0));
            arrowImage.appendTo(rotationElement);
            var TextElement = $('<span/>').html($('#' + code + 'name').val()).css(get_captionStyles());
            TextElement.appendTo(rotationElement);
            rotationElement.appendTo(richMarkerContent);
            icon.imageDiv = richMarkerContent.get(0);

            var lonlat = osmmaps[MapClass.currMapID].getLonLatFromPixel(e.xy);
            var pos = osmmaps[MapClass.currMapID].getLonLatFromPixel(e.xy).transform(osmmaps[MapClass.currMapID].baseLayer.projection, new OpenLayers.Projection("EPSG:4326"));
            var marker = new OpenLayers.Marker(lonlat, icon);
            DrawPOILayer.addMarker(marker);
            $('#' + code + 'lat').val(pos.lat);
            $('#' + code + 'long').val(pos.lon);
        });
    };
    /*_osm_reset*/
    this._osm_reset = function () {
        var DrawPOILayer = osmmaps[MapClass.currMapID].getLayer("POIDrwing" + MapClass.currMapID);
        if (osmmaps[MapClass.currMapID].getLayerIndex(DrawPOILayer) != -1) {
            DrawPOILayer.clearMarkers();
        }
    };


    this.mapClick;
    this.bingMarkers = [];
    /*_bing_draw*/
    this._bing_draw = function (code) {
        var _this = this;
        _this.mapClick = Microsoft.Maps.Events.addHandler(bmaps[MapClass.currMapID], 'click', function (e) {

            _this._bing_reset();

            var richMarkerContent = $('<div/>');
            var arrowImage = $('<img/>', {
                src: DefaultSettings.poiimgsrc + $('#' + code + 'img').val() + '.png',
                height: '32px',
                width: '32px'
            });
            var rotationElement = $('<div/>').css(get_rotationStyles(0));
            arrowImage.appendTo(rotationElement);
            var TextElement = $('<span/>').html($('#' + code + 'name').val()).css(get_captionStyles());
            TextElement.appendTo(rotationElement);
            rotationElement.appendTo(richMarkerContent);
            icon = richMarkerContent.html();

            var point = new Microsoft.Maps.Point(e.getX(), e.getY());
            var loc = e.target.tryPixelToLocation(point);
            var markerOptions = {
                width: null,
                height: null,
                htmlContent: icon
            };
            var marker = new Microsoft.Maps.Pushpin(loc, markerOptions);
            bmaps[MapClass.currMapID].entities.push(marker);
            _this.bingMarkers.push(marker);
            $('#' + code + 'lat').val(loc.latitude);
            $('#' + code + 'long').val(loc.longitude);
        });
    };
    /*_bing_reset*/
    this._bing_reset = function () {
        for (i in this.bingMarkers) {
            bmaps[MapClass.currMapID].entities.remove(this.bingMarkers[i]);
        }
        this.bingMarkers.length = 0;
    };
    // viewer

    /* _view */
    this._view = function (Lat, Lang, lbltext, image) {
        if (MapClass.currMap == 'gmap') {
            this._google_view(Lat, Lang, lbltext, image);
        } else if (MapClass.currMap == 'omap') {
            this._osm_view(Lat, Lang, lbltext, image);
        } else if (MapClass.currMap == 'bmap') {
            this._bing_view(Lat, Lang, lbltext, image);
        }
    };

    /* _delete */
    this._delete = function () {
        if (MapClass.currMap == 'gmap') {
            this._google_delete();
        } else if (MapClass.currMap == 'omap') {
            this._osm_delete();
        } else if (MapClass.currMap == 'bmap') {
            this._bing_delete();
        }
    };

    /*_google_view*/
    this._google_view = function (Lat, Lang, lbltext, image) {
        var latlng = new google.maps.LatLng(Lat, Lang);

        var marker = new google.maps.Marker({
            position: latlng,
            map: maps[MapClass.currMapID],
            title: Lat + ',' + Lang,
            icon: DefaultSettings.poiimgsrc + image + '.png'
        });
        this.google_getMarkerPOIArray.push(marker);
        var Markerlabel = new Label({
            map: maps[MapClass.currMapID]
        });
        Markerlabel.bindTo('position', marker, 'position');
        Markerlabel.set('text', lbltext);
        this.google_getLabelPOIArray.push(Markerlabel);
    };

    this._google_delete = function () {
        if (this.google_getMarkerPOIArray) {
            for (i in this.google_getMarkerPOIArray) {
                this.google_getMarkerPOIArray[i].setMap(null);
            }
            this.google_getMarkerPOIArray.length = 0;
        }
        if (this.google_getLabelPOIArray) {
            for (i in this.google_getLabelPOIArray) {
                this.google_getLabelPOIArray[i].setMap(null);
            }
            this.google_getLabelPOIArray.length = 0;
        }
    };


    /*_osm_view*/
    this._osm_view = function (Lat, Lon, lbltext, image) {
        var size = new OpenLayers.Size(25, 25);
        var offset = new OpenLayers.Pixel(-(size.w / 2), -size.h);
        var icon = new OpenLayers.Icon(null, size, offset);
        var richMarkerContent = $('<div/>');
        var arrowImage = $('<img/>', {
            src: DefaultSettings.poiimgsrc + image + '.png',
            height: '32px',
            width: '32px'
        });
        var rotationElement = $('<div/>').css(get_rotationStyles(0));
        arrowImage.appendTo(rotationElement);
        var TextElement = $('<span/>').html(lbltext).css(get_captionStyles());
        TextElement.appendTo(rotationElement);
        rotationElement.appendTo(richMarkerContent);
        icon.imageDiv = richMarkerContent.get(0);
        var lonlat = new OpenLayers.LonLat(Lon, Lat).transform(
            new OpenLayers.Projection("EPSG:4326"),
            osmmaps[MapClass.currMapID].getProjectionObject()
        );

        var marker = new OpenLayers.Marker(lonlat, icon);
        osmmaps[MapClass.currMapID].getLayer("POI" + MapClass.currMapID).addMarker(marker);
    };
    /*_osm_delete*/
    this._osm_delete = function () {
        osmmaps[MapClass.currMapID].getLayer("POI" + MapClass.currMapID).clearMarkers();
    };
	
    /*_bing_view*/
    this._bing_view = function (Lat, Lon, lbltext, image) {
        var richMarkerContent = $('<div/>');
        var arrowImage = $('<img/>', {
            src: DefaultSettings.poiimgsrc + image + '.png',
            height: '32px',
            width: '32px'
        });
        var rotationElement = $('<div/>').css(get_rotationStyles(0));
        arrowImage.appendTo(rotationElement);
        var TextElement = $('<span/>').html(lbltext).css(get_captionStyles());
        TextElement.appendTo(rotationElement);
        rotationElement.appendTo(richMarkerContent);
        var icon = richMarkerContent.html();
        var lonlat = new Microsoft.Maps.Location(Lat, Lon);
        var markerOptions = {
            width: null,
            height: null,
            htmlContent: icon
        };
        var marker = new Microsoft.Maps.Pushpin(lonlat, markerOptions);
        bmaps[MapClass.currMapID].entities.push(marker);
        this.bing_getMarkerPOIArray.push(marker);
    };
    /*_bing_delete*/
    this._bing_delete = function () {
        if (this.bing_getMarkerPOIArray) {
            for (i in this.bing_getMarkerPOIArray) {
                bmaps[MapClass.currMapID].entities.remove(bing_getMarkerPOIArray[i]);
            }
            this.google_getMarkerPOIArray.length = 0;
        }
    };

}
var MarkerPOI = new POIClass();

function getPOIOptions() {
    var poptions = '';
    for (var i = 0; i <= 20; i++) {
        poptions += "<option value = '" + i + "' data-imagesrc= " + DefaultSettings.poiimgsrc + i + '.png' + " ></option>";
    }
    return poptions;
};