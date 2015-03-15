<?php
include("_start.php");
$dialogs=
array($module=> 
		array(
			'name'=>$module,
			'height'=>375,
			'width'=>475,
			'htmllink'=>"'contents/{$loc}/_form.php'",
			'imagelink'=>"'images/admin/options.png'",
			'extended'=>"true",
			'hasdiv'=>"true",
			'open'=>"false"
			)			
);
		
foreach ($dialogs as $dialog){
echo	createDialog($dialog);	
}
?>