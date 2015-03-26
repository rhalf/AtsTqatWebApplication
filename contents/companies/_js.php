<?php

include("_start.php");
$dialogs = array($module =>
   array(
    'name' => $module,
    'height' => 500,
    'width' => 800,
    'htmllink' => "'contents/{$loc}/_list.php'",
    'imagelink' => "'images/admin/company.png'",
    'extended' => "true",
    'open' => "true"
   ),
   array(
    'name' => $module_add,
    'height' => 300,
    'width' => 650,
    'htmllink' => "'contents/{$loc}/_form.php?type=1'",
    'imagelink' => "'images/admin/company.png'",
    'extended' => "true",
    'open' => "true"
   ),
   array(
    'name' => $module_edit,
    'height' => 300,
    'width' => 650,
    'para' => 'id',
    'htmllink' => "'contents/{$loc}/_form.php?type=2&id='+id",
    'imagelink' => "'images/admin/company.png'",
    'extended' => "true",
    'open' => "true"
   ),
);

foreach ($dialogs as $dialog) {
   echo createDialog($dialog);
}
?>