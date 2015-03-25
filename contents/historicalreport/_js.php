<?php

include("_start.php");
$dialogs = array($module =>
      array(
        'name' => $module,
        'height' => 500,
        'width' => 800,
        'htmllink' => "'contents/{$loc}/_form.php'",
        'imagelink' => "'images/admin/historical.png'",
        'extended' => "true",
        'open' => "true"
      )
);

foreach ($dialogs as $dialog) {
  echo  createDialog($dialog);
}
?>