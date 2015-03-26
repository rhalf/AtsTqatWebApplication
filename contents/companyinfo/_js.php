<?php

include("_start.php");
$dialogs = array($module =>
      array(
        'name' => $module,
        'height' => 350,
        'width' => 400,
        'htmllink' => "'contents/{$loc}/_form.php'",
        'imagelink' => "'images/admin/company.png'",
        'extended' => "true",
        'open' => "true"
      )
);

foreach ($dialogs as $dialog) {
  echo  createDialog($dialog);
}
?>