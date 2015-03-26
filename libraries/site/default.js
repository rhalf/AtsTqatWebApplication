//settings
DefaultSettingsClass = function() {
    this.default_map = 3;			// 1 Google map, 2 Bing map , 3 Open Street map
    this.default_Lat = 25.30;
    this.default_Lon = 51.49;
    this.default_Zoom = 10;

    this.inLostMode = 6;			// Hours

    this.imgsrc = 'images/car/';
    this.alarmimgsrc = 'images/alarmsicons/';
    this.poiimgsrc = 'images/pois/';
};
var DefaultSettings = new DefaultSettingsClass();


if (DefaultSettings.default_map == 1) {
    default_mapLabel = 'Google Map';
} else if (DefaultSettings.default_map == 2) {
    default_mapLabel = 'Bing Map';
} else if (DefaultSettings.default_map == 3) {
    default_mapLabel = 'Open street Map';
} else if (DefaultSettings.default_map == 4) {
    default_mapLabel = 'Ovi Map';
}