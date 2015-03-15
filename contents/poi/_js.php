<?php

include("_start.php");
$dialogs = array($module =>
      array(
        'name' => $module,
        'height' => 375,
        'width' => 375,
        'htmllink' => "'contents/{$loc}/_widget.php'",
        'imagelink' => "'images/admin/pois.png'",
        'extended' => "false",
        'hasdiv' => 'true',
        'open' => "false"
      )
);

foreach ($dialogs as $dialog) {
    echo createDialog($dialog);
}
?>