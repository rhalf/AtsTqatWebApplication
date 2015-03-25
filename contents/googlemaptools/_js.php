<?php

include("_start.php");
$dialogs = array($module =>
      array(
        'name' => $module,
        'height' => 300,
        'width' => 375,
        'htmllink' => "'contents/{$loc}/_widget.php'",
        'imagelink' => "'images/admin/maptools.png'",
        'extended' => "false",
        'open' => "true"
      )
);

foreach ($dialogs as $dialog) {
  echo  createDialog($dialog);
}
?>