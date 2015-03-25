<?php
header("Cache-Control: no-cache, must-revalidate");
include_once("../settings.php");
include_once("../scripts.php");

$HTTPHostsResult=$session->get('httphosts');
?>
<!DOCTYPE html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="apple-mobile-web-app-capable" content="yes">
<title>T-Qat GPS Tracking System</title>
<link type="text/css" href="lib/cssmob.php" rel="stylesheet">
<script type="text/javascript" src="../libraries/map/OpenLayers-2.12/OpenLayers.js"></script>
<script type="text/javascript" src="lib/jsmob.php?files=map"></script>

<style>

html, body{ 
    height: 100%;
	padding:0;
	margin:0;
	overflow:hidden
}
.ui-content {
    padding: 0;
} 

.ui-content {
	position:relative;
width:100% !important;
height:100% ;
}

#mappage{
width:100% !important;
height:100% !important;
}

#divmaps {
	position:relative;
width:100% !important;
height:100%;
overflow:hidden;
	padding:0;
	margin:0;
}

img[src*="iws3.png"] {
    display: none;
}
</style>
<script type="text/javascript">
function TrackerObject(){
	this.Mobile=false;
	this.Unit;
	this.Driver;
	this.Vehicle;
	this.Type;
	this.TrackerImage;
	this.Inputs;
	this.SpeedLimit;
	this.MileageLimit;
	this.MileageInit;
	this.MileageReset;
	this.Http;
	this.TrackerExpiry;
	this.VehicleregExpiry;
};

function HTTPClass(){
	this.id=[];
	this.name=[];
	this.ip=[];
	this.liveport=[];
	this.cmdport=[];
	
	this.Clear=function(){
		this.id.length=0;	
		this.name.length=0;
		this.ip.length=0;
		this.liveport.length=0;
		this.cmdport.length=0;		
	};
	
	this.add=function(a,b,c,d,e){
		this.id.push(a);	
		this.name.push(b);	
		this.ip.push(c);
		this.liveport.push(d);	
		this.cmdport.push(e);		
	};
	this.getIP=function(i){
		return this.ip[this.id.indexOf(i)];	
	}
	this.getLivePort=function(i){
		return this.liveport[this.id.indexOf(i)];	
	}
	this.getCmdPort=function(i){
		return this.cmdport[this.id.indexOf(i)];	
	}
};
var Http=new HTTPClass();

function removeByIndex(arrayName, arrayIndex) {
    arrayName.splice(arrayIndex, 1);
    return false;
}


function removeByValue(arr, val) {
    for (var i = 0; i < arr.length; i++) {
        if (arr[i] == val) {
            arr.splice(i, 1);
            break;
        }
    }
    return false;
};
</script>

<script type="text/javascript">
<?php
foreach ($HTTPHostsResult as $row){
?>
Http.add('<?php echo $row['httphostid'] ?>','<?php echo $row['httphostname'] ?>','<?php echo $row['httphostip'] ?>','<?php echo $row['httpport'] ?>','<?php echo $row['cmdport'] ?>');

<?php	
}
?>
</script>
</head>
<body>
<script type="text/javascript">
var OFF_LBL='<?php echo Off; ?>';
var ON_LBL ='<?php echo On; ?>';
var HIGH_LBL= '<?php echo High; ?>';
var SHORT_LBL= '<?php echo Short; ?>';
var NORMAL_LBL='<?php echo Normal; ?>';
var ERROR_LBL = '<?php echo Error; ?>';
var LOW_LBL= '<?php echo Low; ?>';
var TimeZone=<?php echo getTimezoneOffset($timezone) / 60 / 60 ?>;
var grouping='1';

function MobileDataClass(){
	this.Units=[];
	this.Drivers=[];
	this.Vehicles=[];
	this.Types=[];
	this.Images=[];
	this.Inputs=[];
	this.SpeedLimits=[];
	this.MileageLimit=[];
	this.MileageInit=[];
	this.MileageReset=[];
	this.Http=[];
};


var MobileData=new MobileDataClass();
<?php
  foreach($_REQUEST['chb'] as $k => $v) 
        { 
		$Sv =explode(",", $v);
		?>
	MobileData.Units.push(<?php echo $Sv[0] ?>);
	MobileData.Drivers.push(<?php echo $Sv[1] ?>);
	MobileData.Vehicles.push(<?php echo $Sv[2] ?>);
	MobileData.Types.push(<?php echo $Sv[3] ?>);
	MobileData.Images.push(<?php echo $Sv[4] ?>);
	MobileData.Inputs.push(<?php echo $Sv[5] ?>);
	MobileData.SpeedLimits.push(<?php echo $Sv[6] ?>);
	MobileData.MileageLimit.push(<?php echo $Sv[7] ?>);
	MobileData.MileageInit.push(<?php echo $Sv[8] ?>);
	MobileData.MileageReset.push(<?php echo $Sv[9] ?>);
	MobileData.Http.push(<?php echo $Sv[10] ?>);
	<?php
		}
		?>
RealTimeClass.LiveObjects.length=0;		
for (i in MobileData.Units){
	var RTobj=new TrackerObject();
	RTobj.Mobile=true;
	RTobj.Unit=MobileData.Units[i];
	RealTimeClass.LiveIDs.push(RTobj.Unit);
	RTobj.Driver=MobileData.Drivers[i];
	RTobj.Vehicle=MobileData.Vehicles[i];
	RTobj.Type=MobileData.Types[i];
	RTobj.TrackerImage=MobileData.Images[i];
	RTobj.Inputs=MobileData.Inputs[i];
	RTobj.SpeedLimit=MobileData.SpeedLimits[i];
	RTobj.MileageLimit=MobileData.MileageLimit[i];
	RTobj.MileageInit=MobileData.MileageInit[i];
	RTobj.MileageReset=MobileData.MileageReset[i];
	RTobj.Http=MobileData.Http[i];
	RTobj.TrackerExpiry='';
	RTobj.VehicleregExpiry='';
	
	RealTimeClass.LiveObjects.push(RTobj);
	RealTimeClass.StartLive(RTobj,false,1000);
}		
</script>        
<div data-role="page" id="mappage">
  <div data-theme="a" data-role="header" data-position="fixed" data-tap-toggle="false">
    <div class="ui-grid-b">
      <div align="left" class="ui-bar ui-block-a">
      <a  data-rel="back" data-role="button" data-mini="true" data-icon="back" data-iconpos="left" data-theme="b">Back</a>
      </div>
      <div class="ui-block-b"></div>
      <div align="right" class="ui-block-c">
      <a  href="../connect/userlogout.php/?mob" data-role="button" data-mini="true" data-icon="delete" data-iconpos="left" data-theme="a" data-ajax="false">Logout</a>
      </div>
    </div>   
  </div>
    <div data-role="content">
    	<div id="divmaps" style="width:100%;height:100%"></div>
    </div>  
    <div data-theme="c" data-role="footer" data-position="fixed" data-tap-toggle="false">
        <div class="ui-block-a">
          <select name="vehicles" id="vehicles" >
          <script>
		  document.write('<option value="0">None</option>');
		  for (i in MobileData.Vehicles){
           document.write('<option value='+MobileData.Units[i]+'>'+ MobileData.Vehicles[i] +'</option>');
		  }
			</script>
			          </select>
        </div>
        <div id="info" class="ui-block-b"></div>
      </div>  
</div>

</body>
</html>
<script>
init_OsmMap("divmaps",0,'mobile');
$('#vehicles').change(function(e) {
    $('#info').html("");
});

$(document).delegate('#mappage', 'pageshow', function () {
    var the_height = ($(window).height() - $(this).find('[data-role="header"]').height() - $(this).find('[data-role="footer"]').height());
    $(this).height($(window).height()).find('[data-role="content"]').height(the_height);
	
})

$(document).delegate('#mappage', 'resize', function () {
    var the_height = ($(window).height() - $(this).find('[data-role="header"]').height() - $(this).find('[data-role="footer"]').height());
    $(this).height($(window).height()).find('[data-role="content"]').height(the_height);
	
})
</script>