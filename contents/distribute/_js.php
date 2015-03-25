<?php

include("_start.php");
$dialogs = array($module =>
      array(
        'name' => $module,
        'height' => 400,
        'width' => 625,
        'htmllink' => "'contents/{$loc}/_form.php'",
        'imagelink' => "'images/admin/logo.png'",
        'extended' => "false",
        'open' => "true"
      )
);

foreach ($dialogs as $dialog) {
   echo createDialog($dialog);
}
?>