<?php
include("_start.php");
$dialogs=
array($module=> 
		array(
			'name'=>$module,
			'height'=>150,
			'width'=>375,
			'htmllink'=>"'contents/{$loc}/_form.php'",
			'imagelink'=>"'images/admin/map.png'",
			'extended'=>"false",
			'hasdiv'=>"true",
			'open'=>"false"
			)			
);
		
foreach ($dialogs as $dialog){
echo	createDialog($dialog);	
}
?>