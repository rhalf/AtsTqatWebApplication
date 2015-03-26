<?php

include("_start.php");
$dialogs = array($module =>
  array(
    'name' => $module,
    'height' => 475,
    'width' => 600,
    'htmllink' => "'contents/{$loc}/_form.php'",
    'imagelink' => "'images/admin/commands.png'",
    'extended' => "false",
    'open' => "true"
  )
);

foreach ($dialogs as $dialog) {
    echo createDialog($dialog);
}
?>