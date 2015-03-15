<?php

include("_start.php");
$dialogs = array($module =>
      array(
        'name' => $module,
        'height' => 175,
        'width' => 400,
        'para' => 'id',
        'htmllink' => "'contents/{$loc}/_form.php?id='+id",
        'imagelink' => "''",
        'extended' => "false",
        'open' => "true"
      ),
);

foreach ($dialogs as $dialog) {
    echo createDialog($dialog);
}
?>