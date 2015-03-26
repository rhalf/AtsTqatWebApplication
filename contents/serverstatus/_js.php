<?php

include("_start.php");
$dialogs = array($module =>
      array(
        'name' => $module,
        'height' => 500,
        'width' => 550,
        'htmllink' => "'contents/{$loc}/_list.php'",
        'imagelink' => "'images/admin/info.png'",
        'extended' => "true",
        'open' => "true"
      )
);

foreach ($dialogs as $dialog) {
    echo createDialog($dialog);
}
?>