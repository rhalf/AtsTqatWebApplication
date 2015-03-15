<?php
include("_start.php");
$dialogs=
array($module=> 
		array(
			'name'=>$module,
			'height'=>350,
			'width'=>425,
			'htmllink'=>"'contents/{$loc}/_form.php'",
			'imagelink'=>"'images/admin/log.png'",
			'extended'=>"true",
			'open'=>"true"
			)			
);
		
foreach ($dialogs as $dialog){
	echo createDialog($dialog);	
}
?>