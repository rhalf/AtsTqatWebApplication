<?php

include("_start.php");
$dialogs = array($module =>
      array(
        'name' => $module,
        'height' => 200,
        'width' => 400,
        'htmllink' => "'contents/{$loc}/_form.php'",
        'imagelink' => "'images/admin/download.png'",
        'extended' => "false",
        'open' => "true"
      )
);

foreach ($dialogs as $dialog) {
   echo createDialog($dialog);
}
?>