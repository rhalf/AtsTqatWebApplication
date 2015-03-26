<?php
/*common*/
define('text_direction', "ltr");
define('_List', "List");
define('Ok', "OK");
define('Edit', "Edit");
define('Add', "New");
define('Save', "Save");
define('Delete', "Delete");
define('Hide', "Hide");
define('Show', "Show");
define('Reset', "Reset");
define('Close', "Close");
define('Cancel', "Cancel");
define('Export', "Export");
define('Reload', "Reload");
define('CheckAll', "Check All");
define('CheckInvert', "Invert");
define('UncheckAll', "Uncheck All");
define('Search', "Search");
define('Yes', "yes");
define('No', "no");
define('On', "on");
define('Off', "off");
define('High', "high");
define('Short', "short");
define('Normal', "normal");
define('Error', "error");
define('Low', "low");
define('Auto', "Auto");
define('From',"From");
define('To',"To");
define('Resume', "Resume");
define('Play', "Play");
define('Pause', "Pause");
define('Stop', "Stop");
define('Clear', "Clear");
define('GroupBy', "Group by");
define('SearchTip', "Search here...");
define('FreezeColumns','Freeze columns');
define('System', "System");
define('Help', "Help");
define('Settings', "Settings");

/*users*/
include_once(ROOT_DIR."/contents/users/lang/en.php");
define('Users', "Users");
define('SelectUser', "Select User");
define('ShowAllUsers', "Show All Users");
define('NewUser', "New User");
define('UsersCount', "User(s)");
define('MyAccount', "My Account");

/*privilege*/
define('pr_Master', "Master");
define('pr_Admin', "Admin");
define('pr_Normal', "Normal");
define('pr_Limited', "Limited");

/*trackers*/
include_once(ROOT_DIR."/contents/trackers/lang/en.php");
define('Trackers', "Trackers");
define('ShowAllTrackers', "Show All Trackers");
define('AddTracker', "Add tracker");
define('EditTracker', "Edit tracker");
define('TrackerCount', "Tracker(s)");

include_once(ROOT_DIR."/contents/alltrackers/lang/en.php");
define('AllTrackers', "All Trackers");
/*grouping*/

define('CompaniesGrouping', "Companies");
define('UsersGrouping', "Users");
define('StateGrouping', "State");
define('CollectionsGrouping', "Collections");

define('Administration', "Administration");

define('MapTools', "Map Tools");

define('Weather','Weather');
define('DisableUI', "Disable Map Tools");
define('EnableUI', "Enable Map Tools");

define('GMLANG', "en");
define('GoogleMap', "Google Map");
define('BingMap',"Bing Map");
define('OpenstreetMap', "Open street Map");
define('OviMap',"Ovi Map");
define('NokiaMap',"Nokia Map");
define('ArcGISMap',"ArcGIS Map");
/*reports*/
define('Reports', "Reports");
define('HistoricalReport', "Historical Data Report");
define('LogReport', "Log Report");
define('Download', "Download");


define('Support', "Support");
define('About',"About");
define('ABOUTDESC', "Advanced technologies and solutions");

define('Realtime', "Realtime");

include_once(ROOT_DIR."/contents/poi/lang/en.php");
define('POIs',"Point of interest");

include_once(ROOT_DIR."/contents/geofence/lang/en.php");
define('Geofence', "Geo-fence");

define('Geofences', "Geo-fences");
define('Pois',"Points of interest");


define('Drawing', "Drawing");
define('Coloring', "Coloring");


define('TrackingReplay', "Tracking Replay");
////////////// main buttom
define('VehicleReg', "Vehicle Reg");
define('DriverName', "Driver Name");
define('SimNo', "Sim No");
define('Unit', "Unit");
define('Time', "Time");
define('Lat', "Lat");
define('Long', "Long");
define('Address', "Address");
define('Speed', "Speed");
define('Direction', "Direction");
define('Signal', "GPS Signal");
define('State', "GPS State");
define('Power', "Power");
define('Input1', "Urgent");
define('Input2', "Acc");
define('Input3', "Input3");
define('Input4', "Input4");
define('Input5', "Input5");
define('Output1', "CutOff");
define('Output2', "output2");
define('Output3', "output3");
define('Output4', "output4");
define('Output5', "output5");

define('AD1', "Fuel");
define('AD2', "AD2");
define('Mileage', "Distance");
define('Interval', "Interval");
define('Overspeed', "Speed Limit");
define('GPSQSignal', "GPS Signal");
define('GSMQSignal', "GSM Signal");
define('Inputs', "Inputs");
define('IconCaption', "Icons Caption");






////////////////////////////// main top
define('TimeZone', "Time Zone");
define('Title', "GPS Tracking System");
define('Logout', "Logout");
define('Welcome', "Welcome");
///////////////////////////// Right layout


define('Selectstate', "Select State");
define('SelectCollection', "Select Collection");



define('POI', "POI");



define('Name', "Name");
define('Description', "Description");
define('choose', "choose");



define('DisplayonMap', "Display geo-fences on Map");
define('FreeHand', "FreeHand");
define('Polygon', "Polygon");




define('Columns', "Columns");
define('ShowHideColumns', "Show/Hide Columns");

////
define('Distribute', "Distribute");
define('Company', "Company");

define('GroupingBy', "Grouping trackers By");

/*sections*/
define('RunningSection', "Running");
define('ParkingSection', "Parking");
define('IdleSection', "Idle");
define('OverSpeedSection', "Over Speed");
define('UrgentSection', "Urgent");
define('GeoFenceSection', "Geo-Fence");
define('BreakDownSection', "Break Down");
define('LostSection', "Lost");
define('AllSection', "All");

define('Options', "Options");
/*notification*/
define('Notification', "Notification");
define('RunningMode', "is in running mode.");
define('ParkingMode', "is in parking mode.");
define('IdleMode', "is in idle mode.");
define('UrgentAlarmMode', "has urgent alarm");
define('geoFenceAlarmMode', "has geo fence alarm in");
define('OverSpeedAlarmMode', "has over speed alarm");
define('BreakDownAlarmMode', "has breakdown alarm");
define('LostMode', "has been lost.");
define('TrackersConnected',"Trackers Connected");
/////


include_once(ROOT_DIR."/contents/setmileage/lang/en.php");
define('SetMileage', "Set Initial distance");

/*commands*/
define('Commands',"Commands");
define('Command', "Command");
define('Type', "Type");
define('User', "User");
define('Vehicles', "Vehicles");
define('Send',"Send");
define('Value',"Value");
define('Select',"Select");


include_once(ROOT_DIR."/contents/commands/lang/en.php");

define('Locate',"Locate");
define('LastMsg',"Last Position");
define('Map',"Map");

define('MapsManager',"Maps Manager");


define('ShowSpeed',"Show Speed");
define('GeoFenceList',"Geo-Fence List");

define('ExcludeData',"Exclude incorrect Data");
define('Logo',"Logo");
define('VehicleModel',"Vehicle Model");

define('General',"General");
define('Parameters',"Parameters");
define('Configuration',"Configuration");
define('Note',"Note");
define('MileageLimit',"Distance Limit");
define('VehicleregExpiry',"Vehicle reg Expiry");
define('TrackerExpiry',"Tracker Expiry");
define('InitialMielage',"Initial Distance");
define('IdlingTime',"Idling Time");

/*IconsChart*/
define('IconsChart',"Icons chart");
include_once(ROOT_DIR."/contents/iconschart/lang/en.php");


define('Collections',"Collections");
include_once(ROOT_DIR."/contents/collections/lang/en.php");
/*Company*/
include_once(ROOT_DIR."/contents/companies/lang/en.php");
define('Companies',"Companies");
define('AddCompany',"Add Company");
define('EditCompany',"Edit Company");
define('CompaniesCount', "Company(s)");

define('CompanyInfo',"Company Info");
include_once(ROOT_DIR."/contents/companyinfo/lang/en.php");
define('Themes',"Themes");

/*dbhosts*/
include_once(ROOT_DIR."/contents/dbhost/lang/en.php");
define('DBHosts',"Databases Hosts");
define('AddDBHost',"Add Database Host");
define('EditDBHost',"Edit Database Host");
define('DBHostsCount',"Host(s)");
/*httphosts*/
include_once(ROOT_DIR."/contents/httphost/lang/en.php");
define('HTTPHosts',"HTTP Hosts");
define('AddHTTPHost',"Add HTTP Host");
define('EditHTTPHost',"Edit HTTP Host");
define('HTTPHostCount',"Host(s)");


include_once(ROOT_DIR."/contents/dbsize/lang/en.php");
define('DBSize',"Database Size");

include_once(ROOT_DIR."/contents/serverstatus/lang/en.php");
define('ServerStatus',"Server Status");

include_once(ROOT_DIR."/contents/usersonline/lang/en.php");
define('UsersOnline',"Users Online");

/*messages*/
define("WrongCredentials","Wrong credentials");
define("AccountDeactivated","Your account has been deactivated.");
define("AccountExpired","Your account has been expired.");
define("CompanyAccountDeactivated","The company account has been deactivated.");
define("CompanyAccountExpired","The company account has been expired.");
define("UserLeftDays","Your account will expire after %s Day(s)");
define("CompanyLeftDays","The Company account will expire after %s Day(s)");
?>