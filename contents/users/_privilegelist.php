<?php

header("Cache-Control: no-cache, must-revalidate");
include_once("../../settings.php");
include_once("../../scripts.php");

if (!isset($_GET['id']))
    die;
$id = $_GET['id'];

if (!isset($_GET['type']))
    die;
$type = $_GET['type'];

$UsersResult = $session->get('users');
$parentPri = GetPrivilegeByID($id, $UsersResult);

if ($type == 1) {
    if ($privilege == 1) {
        if ($parentPri == 1) {
            while ($priv = current($Privileges)) {
                if ($priv != 1) {
                    echo "<option class='ui-widget-content' value='$priv'>" . key($Privileges) . "</option>";
                }
                next($Privileges);
            }
        } else if ($parentPri == 2) {
            while ($priv = current($Privileges)) {
                if ($priv == 3 || $priv == 4) {
                    echo "<option class='ui-widget-content' value='$priv'>" . key($Privileges) . "</option>";
                }
                next($Privileges);
            }
        } else if ($parentPri == 3) {
            while ($priv = current($Privileges)) {
                if ($priv == 4) {
                    echo "<option class='ui-widget-content' value='$priv'>" . key($Privileges) . "</option>";
                }
                next($Privileges);
            }
        }
    } else if ($privilege == 2) {
        if ($parentPri == 2) {
            while ($priv = current($Privileges)) {
                if ($priv == 3 || $priv == 4) {
                    echo "<option class='ui-widget-content' value='$priv'>" . key($Privileges) . "</option>";
                }
                next($Privileges);
            }
        } else if ($parentPri == 3) {
            while ($priv = current($Privileges)) {
                if ($priv == 4) {
                    echo "<option class='ui-widget-content' value='$priv'>" . key($Privileges) . "</option>";
                }
                next($Privileges);
            }
        }
    } else if ($privilege == 3) {
        while ($priv = current($Privileges)) {
            if ($priv == 4) {
                echo "<option class='ui-widget-content' value='$priv'>" . key($Privileges) . "</option>";
            }
            next($Privileges);
        }
    }
} else if ($type == 2) {
    if (!isset($_GET['currPrivilege'])) {
        die;
    }
    $currPrivilege = $_GET['currPrivilege'];
    if ($privilege == 1 && $parentPri == 1) {
        if ($currPrivilege == 1) {
            while ($priv = current($Privileges)) {
                if ($priv == 1) {
                    echo "<option class='ui-widget-content' value='$priv' selected='selected'>" . key($Privileges) . "</option>";
                }
                next($Privileges);
            }
        } else {
            while ($priv = current($Privileges)) {
                if ($priv != 1) {
                    if ($currPrivilege == $priv) {
                        echo "<option class='ui-widget-content' value='$priv' selected='selected'>" . key($Privileges) . "</option>";
                    } else {
                        echo "<option class='ui-widget-content' value='$priv'>" . key($Privileges) . "</option>";
                    }
                }
                next($Privileges);
            }
        }
    } else if ($privilege == 1 && $parentPri == 2) {
        while ($priv = current($Privileges)) {
            if ($priv == 3 || $priv == 4) {
                if ($currPrivilege == $priv) {
                    echo "<option class='ui-widget-content' value='$priv' selected='selected'>" . key($Privileges) . "</option>";
                } else {
                    echo "<option class='ui-widget-content' value='$priv'>" . key($Privileges) . "</option>";
                }
            }
            next($Privileges);
        }
    } else if ($privilege == 1 && $parentPri == 3) {
        while ($priv = current($Privileges)) {
            if ($priv == 4) {
                echo "<option class='ui-widget-content' value='$priv'>" . key($Privileges) . "</option>";
            }
            next($Privileges);
        }
    } else if ($privilege == 1 && $parentPri == 4) {
        while ($priv = current($Privileges)) {
            if ($priv == 4) {
                echo "<option class='ui-widget-content' value='$priv'>" . key($Privileges) . "</option>";
            }
            next($Privileges);
        }
    } else if ($privilege == 2 && $parentPri == 1) {
        while ($priv = current($Privileges)) {
            if ($priv == 2) {
                echo "<option class='ui-widget-content' value='$priv'>" . key($Privileges) . "</option>";
            }
            next($Privileges);
        }
    } else if ($privilege == 2 && $parentPri == 2) {
        while ($priv = current($Privileges)) {
            if ($priv == 3 || $priv == 4) {
                if ($currPrivilege == $priv) {
                    echo "<option class='ui-widget-content' value='$priv' selected='selected'>" . key($Privileges) . "</option>";
                } else {
                    echo "<option class='ui-widget-content' value='$priv'>" . key($Privileges) . "</option>";
                }
            }
            next($Privileges);
        }
    } else if ($privilege == 2 && $parentPri == 3) {
        while ($priv = current($Privileges)) {
            if ($priv == 3 || $priv == 4) {
                if ($currPrivilege == $priv) {
                    echo "<option class='ui-widget-content' value='$priv' selected='selected'>" . key($Privileges) . "</option>";
                } else {
                    echo "<option class='ui-widget-content' value='$priv'>" . key($Privileges) . "</option>";
                }
            }
            next($Privileges);
        }
    } else if ($privilege == 2 && $parentPri == 4) {
        while ($priv = current($Privileges)) {
            if ($priv == 3 || $priv == 4) {
                if ($currPrivilege == $priv) {
                    echo "<option class='ui-widget-content' value='$priv' selected='selected'>" . key($Privileges) . "</option>";
                } else {
                    echo "<option class='ui-widget-content' value='$priv'>" . key($Privileges) . "</option>";
                }
            }
            next($Privileges);
        }
    } else if ($privilege == 3 && $parentPri == 1) {
        while ($priv = current($Privileges)) {
            if ($priv == 4) {
                echo "<option class='ui-widget-content' value='$priv'>" . key($Privileges) . "</option>";
            }
            next($Privileges);
        }
    } else if ($privilege == 3 && $parentPri == 2) {
        while ($priv = current($Privileges)) {
            if ($priv == 3) {
                echo "<option class='ui-widget-content' value='$priv'>" . key($Privileges) . "</option>";
            }
            next($Privileges);
        }
    } else if ($privilege == 3 && $parentPri == 3) {
        while ($priv = current($Privileges)) {
            if ($priv == 4) {
                echo "<option class='ui-widget-content' value='$priv'>" . key($Privileges) . "</option>";
            }
            next($Privileges);
        }
    } else if ($privilege == 4 && $parentPri == 1) {
        while ($priv = current($Privileges)) {
            if ($priv == 3 || $priv == 4) {
                if ($currPrivilege == $priv) {
                    echo "<option class='ui-widget-content' value='$priv' selected='selected'>" . key($Privileges) . "</option>";
                } else {
                    echo "<option class='ui-widget-content' value='$priv'>" . key($Privileges) . "</option>";
                }
            }
            next($Privileges);
        }
    } else if ($privilege == 4 && $parentPri == 2) {
        while ($priv = current($Privileges)) {
            if ($priv == 3 || $priv == 4) {
                if ($currPrivilege == $priv) {
                    echo "<option class='ui-widget-content' value='$priv' selected='selected'>" . key($Privileges) . "</option>";
                } else {
                    echo "<option class='ui-widget-content' value='$priv'>" . key($Privileges) . "</option>";
                }
            }
            next($Privileges);
        }
    } else if ($privilege == 4 && $parentPri == 3) {
        while ($priv = current($Privileges)) {
            if ($priv == 4) {
                echo "<option class='ui-widget-content' value='$priv'>" . key($Privileges) . "</option>";
            }
            next($Privileges);
        }
    }
}
?>