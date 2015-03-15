<?php

/**
 * 
 * @param array $array
 * @return string
 */
function createDialog(array $array) {
    $result = "";
    $module = $array['name'];
    if (!isset($array['title'])) {
        $title = '';
    } else {
        $title = $array['title'];
    }
    if (!isset($array['para'])) {
        $para = '';
    } else {
        $para = $array['para'];
    }
    $height = $array['height'];
    $width = $array['width'];
    $htmllink = $array['htmllink'];
    $imagelink = $array['imagelink'];
    $extended = $array['extended'];
    if (!isset($array['hasdiv'])) {
        $hasdiv = 'false';
    } else {
        $hasdiv = $array['hasdiv'];
    }
    $open = $array['open'];
    echo "var {$module}Dialog=new dialogClass();";
    if ($para == '') {
        $result.= "function create_{$module}(){";
    } else {
        $result.= "function create_{$module}({$para}){";
    }
    $result.= "var o={";
    $result.= "	name:'{$module}',";
    $result.= "	title:'{$title}',";
    $result.= "	height:{$height},";
    $result.= "	width:{$width},";
    $result.= "	htmllink:{$htmllink},";
    $result.= "	imagelink:{$imagelink},";
    $result.= "	hasdiv:{$hasdiv},";
    $result.= "	extended:{$extended}";
    $result.= "};";
    $result.= "{$module}Dialog.setParams(o);";
    $result.= "	{$module}Dialog.createDialog($open);";
    $result.= "}";
    return $result;
}

/**
 * 
 * @param array $st
 * @param type $privilege
 * @return string
 */
function CreateTracker(array $st, $privilege) {
    $result = '';
    $un = $st["tunit"];
    $drivername = $st["tdrivername"];
    $ureg = $st["tvehiclereg"];
    $uid = $st["tid"];
    $img = $st["timg"];
    $type = $st["ttype"];
    $mileageInit = $st["tmileageInit"];
    $uoverspeed = $st["tspeedlimit"];
    $umileagelimit = $st["tmileagelimit"];
    $uexpiry = $st["ttrackerexpiry"];
    $uregexpiry = $st["tvehicleregexpiry"];
    $uinputs = $st["tinputs"];
    $umileagereset = $st["tmileagereset"];
    $httphost = $st["thttphost"];
    $searchby = strtolower($drivername . $ureg);
    $result.= "<div class='tit$searchby div{$un}  ui-state-default'>";
    $result.= "<table  width='100%' border='0'>";
    $result.= "<tr>";
    $result.= "<td width='10%'>";
    $result.= "<input class='mileage$un' type='hidden' value='$mileageInit' />";
    $result.= "<input class='http$un' type='hidden' value='$httphost' />";
    $result.= "<input class='map$un' type='hidden' value='0' />";
    $result.= "<input class='type$un' type='hidden' value='$type' />";
    $result.= "<input class='speedlimit$un' type='hidden' value='$uoverspeed' />";
    $result.= "<input class='mileagelimit$un' type='hidden' value='$umileagelimit' />";
    $result.= "<input class='expiry$un' type='hidden' value='$uexpiry' />";
    $result.= "<input class='regexpiry$un' type='hidden' value='$uregexpiry' />";
    $result.= "<input class='inputs$un' type='hidden' value='$uinputs' />";
    $result.= "<input class='mileagereset$un' type='hidden' value='$umileagereset' />";
    $result.= "<input class='image$un' type='hidden' value='$img' />";
    $result.= "<span class='context context$un ui-icon ui-icon-gear'></span>";

    $result.= "<div class='ui-widget-content tracker-popup tpopup{$un}' style='width:210px;height:200px;position:fixed;border-radius:5px'>";
    $result.= "</div>";

    $result.= "</td>";

    $result.= "<td width='5%'>";
    $result.= "<img class='img$un' title='$img' src='images/car/icon_" . $img . "_stop.gif' width='15px' height='15px'></img>";
    $result.= "</td>";
    $result.= "<td width='5%'>";
    $result.= "<img class='imgreg$un' src='images/alarmsicons/CRExpired.png' width='15px' height='15px' style='display:none'></img>";
    $result.= "<img class='imgexp$un' src='images/alarmsicons/Expired.png' width='15px' height='15px' style='display:none'></img>";
    $result.= "<img class='imgmileagelimit$un' src='images/alarmsicons/mileagelimit.png' width='15px' height='15px' style='display:none'></img>";
    $result.= "</td>";
    $result.= "<td width='10%'><input class='chb$un chb' type='checkbox' value='$un' ></td>";
    $result.= "<td width='70%'><a href='javascript:void(0)' onClick=\"javascript:selectOption('$un');\" >";
    $result.= "<table width='100%' border='0'>";
    $result.= "<tr>";
    $result.= "<td  width='45%'><div  class='d$un'>$drivername</div></td>";
    $result.= "<td width='45%'><div  class='u$un'>$ureg</div></td>";
    $result.= "<td width='10%'><img class='imgonoff$un'  src='images/admin/off.png' style='border:none' width='16' height='16'></img></td>";
    $result.= "</tr>";
    $result.= "</table>";
    $result.= "</a></td>";
    $result.= "</tr>";
    $result.= "</table>";
    $result.= "</div>";
    return $result;
}

/**
 * 
 * @param type $sectionName
 * @param type $sectionid
 * @param integer $count
 * @param type $countLabel
 * @param integer $group
 * @param integer $privilege
 * @return type
 */
function AddSection($sectionName, $sectionid, $count, $countLabel, $group, $privilege) {
    $result = '';
    if ($group == 0 || $group == 1 || $sectionid == 'All') {
        $result.= "<h3><a id=\"{$sectionid}Section\" href=\"javascript:void(0){$sectionid}Section\">$sectionName</a><font size='-3' style='padding-right:40px;float: right;'>$count&nbsp;$countLabel</font>";
        $result.= "<input class='count{$sectionid}' type='hidden' value='$count' />";
        $result.= "	</h3>";
    } else if ($group == 2 && $sectionid != 'All') {
        $result.= "<h3><a id=\"{$sectionid}Section\" href=\"javascript:void(0){$sectionid}Section\">$sectionName</a></h3>";
    }
    $result.= "<div class='section_holder'>";
    $result.= "<div class='section_top ui-state-default'>";
    $result.= "  <table width='100%' border='0'>";
    $result.= "    <tr width='100%'>";
    $result.= "      <td align='left' style='padding:0;margin:0' width='75%'>";
    if ($privilege == 1) {
        $result.= "<button style=\"float:right\" class=\"abutton loadmore load{$sectionid}\" type=\"button\" value=\"0\" ";
        if ($count == 0) {
            $result.= "disabled=\"disabled\"";
        }
        $result.=">Load More</button>";
    }


    $result.= "<span class=\"ui-icon ui-icon-wrench\"  style=\"float:left\"></span>";
    $result.= "<div class='ui-widget-content section-popup' style='position:fixed;border-radius:5px'>";
    $result.= "<ul style='width:200px;padding-left:5px'>";
    $result.= "  <li style='background:none'>";
    $result.= "    <table width='100%' border='0'>";
    $result.= "      <tr>";
    $result.= "        <td><a class='mapchooser' href='javascript:void(0)' ></a></td>";
    $result.= "<td><select class='section-map' onchange='setSectionMap({$sectionid},$(this).val())' style='width:150px'>
          </select></td>";
    $result.= "     </tr>";
    $result.= "   </table>";
    $result.= "  </li>";
    $result.= " <li style='background: none'>";
    $result.= "  <button class='abutton uedit' type='button' value='' onclick='EditUser(" . $sectionid . ")' style='width:100%;height:25px'>";
    $result.= "<div style='padding-left:5px ;float:left;vertical-align:middle' align='center'>";
    $result.= "</div>";
    $result.= "   <span class='ui-icon ui-icon-pencil' style='float:right'></span></button>";
    $result.= "  </li> ";
    $result.= "</ul>      ";
    $result.= "</div>";




    $result.= "<input id=\"umap{$sectionid}\" type=\"hidden\" value=\"0\" />";
    $result.= "</td>";
    $result.= "      <td align='right' width='65px'><div>";
    $result.= "          <div  style=\"height:26px\">";
    $result.= "            <button style=\"height:26px;width:35px;vertical-align:top\" class=\"checktoggle\"><span id=\"topcheck{$sectionid}\" class=\"ui-icon ui-icon-minus\"></span></button>";
    $result.= "            <button style=\"height:26px;width:25px;vertical-align:top\" class=\"select\"></button>";
    $result.= "          </div>";
    $result.= "          <ul style=\"text-align:center\">";
    $result.= "            <li class=\"ui-widget-content\" style=\"border:none\" onclick=\"$('javascript:void(0)topcheck{$sectionid}').attr('class','ui-icon ui-icon-check');SearchSectionCheck(true,'result$sectionid');\"><a class='checkall' href=\"javascript:void(0)\"></a></li>";
    $result.= "            <li class=\"ui-widget-content\" style=\"border:none\" onclick=\"$('javascript:void(0)topcheck{$sectionid}').attr('class','ui-icon ui-icon-minus');SearchSectionCheck(false,'result$sectionid');\"><a class='uncheckall' href=\"javascript:void(0)\"></a></li>";
    $result.= "            <li class=\"ui-widget-content\" style=\"border:none\" onclick=\"$('javascript:void(0)topcheck{$sectionid}').attr('class','ui-icon ui-icon-transferthick-e-w');SearchSectionCheck(-1,'result$sectionid');\"><a class='checkinvert' href=\"javascript:void(0)\"></a></li>";
    $result.= "          </ul>";
    $result.= "        </div></td>";
    $result.= "    </tr>";
    $result.= "  </table>";
    $result.= "</div>";
    $result.= "  <div id=\"result$sectionid\" style=\"width:100%;height:100%\">";
    return $result;
}

/**
 * 
 * @param array $array
 * @param type $col
 * @param type $value
 * @param type $ColResult
 * @return array
 */
function search_AssocArray(array $array, $col, $value, $ColResult) {
    $result = '';
    foreach ($array as $item) {
        if ($value == $item[$col]) {
            $result = $item[$ColResult];
            break;
        }
    }
    return $result;
}

/**
 * 
 * @param type $array
 * @param type $uid
 * @return type
 */
function get_subUsers(array $array, $uid) {
    $ResultArray = array();
    foreach ($array as $item) {
        if ($item['umain'] == $uid && $item['uid'] != $uid) {
            $ResultArray[] = $item;
        } else {
            if ($uid == GetParentID($item['umain'], $array) && $item['uid'] != $uid) {
                $ResultArray[] = $item;
            } else if ($uid == GetParentID(GetParentID($item['umain'], $array), $array) && $item['uid'] != $uid) {
                $ResultArray[] = $item;
            }
        }
    }
    return $ResultArray;
}

/**
 * 
 * @param type $array
 * @param type $uid
 * @return type
 */
function get_allUsers(array $array, $uid) {
    $ResultArray = array();
    foreach ($array as $item) {
        if ($uid == $item['uid']) {
            $ResultArray[] = $item;
        } else {
            if ($item['umain'] == $uid) {
                $ResultArray[] = $item;
            } else {
                if ($uid == GetParentID($item['umain'], $array)) {
                    $ResultArray[] = $item;
                } else if ($uid == GetParentID(GetParentID($item['umain'], $array), $array)) {
                    $ResultArray[] = $item;
                }
            }
        }
    }
    return $ResultArray;
}

/**
 * 
 * @param type $array
 * @param type $uid
 * @param type $priv
 * @return type
 */
function trackers_array(array $array, $uid, $priv) {
    $ResultArray = array();
    $hasid = false;
    if ($priv == 1) {
        $ResultArray = $array;
    } else {
        foreach ($array as $row) {
            if (in_array($uid, explode(',', $row['tusers']))) {
                $ResultArray[] = $row;
            }
        }
    }
    return $ResultArray;
}

/**
 * 
 * @param type $array
 * @param type $uarray
 * @param type $uid
 * @return type
 */
function subUsersTrackers_array(array $array, $uarray, $uid) {
    $ResultArray = array();
    foreach ($array as $item) {
        if (is_array(json_decode($item['tusers']))) {
            foreach (json_decode($item['tusers'], true) as $crow) {
                if ($crow['id'] == GetParentID($uid, $uarray)) {
                    if (in_array($uid, explode(',', $crow['value']))) {
                        $ResultArray[] = $item;
                    }
                }
            }
        }
    }
    return $ResultArray;
}

/**
 * 
 * @param type $array
 * @param type $uid
 * @param type $userid
 * @return type
 */
function trackers_coll_array(array $array, $uid, $userid) {
    $ResultArray = array();
    foreach ($array as $item) {
        if (is_array(json_decode($item['tcollections']))) {
            foreach (json_decode($item['tcollections'], true) as $crow) {
                if ($crow['id'] == $userid) {
                    if (in_array($uid, explode(',', $crow['value']))) {
                        $ResultArray[] = $item;
                    }
                }
            }
        }
    }
    return $ResultArray;
}

/**
 * 
 * @param type $id
 * @param type $array
 * @return type
 */
function GetPrivilegeByID($id, array $array) {
    foreach ($array as $row) {
        if ($id == $row['uid']) {
            return $row['upriv'];
            break;
        }
    }
}

/**
 * 
 * @param type $id
 * @param type $array
 * @return type
 */
function GetParentID($id, array $array) {
    foreach ($array as $row) {
        if ($row['uid'] == $id) {
            return $row['umain'];
            break;
        }
    }
}

/**
 * 
 * @param type $id
 * @param type $array
 * @return boolean
 */
function HasUser($id, array $array) {
    $check = false;
    foreach ($array as $row) {
        if ($row['umain'] == $id) {
            return true;
            break;
        }
    }
    return $check;
}

/**
 * 
 * @param type $userid
 * @param type $trkarray
 * @return boolean
 */
function HasTracker($userid, array $trkarray) {
    $check = false;
    foreach ($trkarray as $item) {
        if (in_array($userid, explode(',', $item['tusers']))) {
            return true;
            break;
        }
    }
    return $check;
}

/**
 * 
 * @param type $cmpdb
 * @param type $trkarray
 * @return boolean
 */
function cmpHasTracker($cmpdb, $trkarray) {
    $check = false;
    foreach ($trkarray as $item) {
        if ($cmpdb == $item['tcmp']) {
            return true;
            break;
        }
    }
    return $check;
}

/**
 * 
 * @param type $name
 * @return int
 */
function checkValidPrivilege($name) {
    if (HasUser($name) == 1 && GetPrivilegeByName($name) == 2) {
        return -1;
    } else if (HasUser($name) == 1 && GetPrivilegeByName($name) == 3) {
        return 0;
    } else if (HasUser($name) == 0 && GetPrivilegeByName($name) == 4) {
        return 1;
    } else {
        return 2;
    }
}

/**
 * 
 * @param type $exp_date
 * @return type
 */
function user_expire_date($exp_date) {
    if ($exp_date != '') {
        $exp_day = explode('/', $exp_date);
        $exp_date = mktime(0, 0, 0, $exp_day[1], $exp_day[0], $exp_day[2]);
        $cur_date = strtotime(date('d-m-Y'));
        $leftdays = ($exp_date - $cur_date) / (60 * 60 * 24);
        if ($leftdays <= 0) {
            return $expire_date_state = 1;
        } else if ($leftdays > 0) {
            return $expire_date_state = 2;
        }
    } else {
        return $expire_date_state = 3;
    }
}

/**
 * 
 * @param type $exp_date
 * @return type
 */
function user_left_days($exp_date) {
    $exp_day = explode('/', $exp_date);
    $exp_date = mktime(0, 0, 0, $exp_day[1], $exp_day[0], $exp_day[2]);
    $cur_date = strtotime(date('d-m-Y'));
    $leftdays = ($exp_date - $cur_date) / (60 * 60 * 24);
    return $leftdays;
}

/**
 * 
 * @param type $timestamp
 * @param type $timezone
 * @return type
 */
function setTime($timestamp, $timezone) {
    $dtzone = new DateTimeZone($timezone);
    $dtime = new DateTime();
    $dtime->setTimestamp($timestamp);
    $dtime->setTimeZone($dtzone);
    $time = $dtime->format('d/m/Y H:i:s');
    return $time;
}

function getTimezoneOffset($timez) {
    $timezone = new DateTimeZone($timez);
    $offset = $timezone->getOffset(new DateTime("now"));
    return $offset;
}

/**
 * 
 * @param type $timestamp
 * @param type $timezone
 * @return type
 */
function setdate($timestamp, $timezone) {
    $dtzone = new DateTimeZone($timezone);
    $dtime = new DateTime();
    $dtime->setTimestamp($timestamp);
    $dtime->setTimeZone($dtzone);
    $time = $dtime->format('d-m-Y_H-i-s');
    return $time;
}

/**
 * 
 * @param type $path
 * @param type $array
 */
function loadlib($path, $array) {
    foreach ($array as $js) {
        include("$path$js");
    }
}

/**
 * 
 * @return type
 */
function is_ajax() {
    return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');
}

function is_form() {
    return (
        strtolower($_SERVER['CONTENT_TYPE']) === 'application/x-www-form-urlencoded' || strtolower($_SERVER['CONTENT_TYPE']) === 'application/x-www-form-urlencoded; charset=utf-8');
}

/**
 * 
 * @param type $string
 * @param type $force_lowercase
 * @param type $anal
 * @return type
 */
function sanitize($string, $force_lowercase = true, $anal = false) {
    $strip = array("~", "`", "!", "@", "javascript:void(0)", "$", "%", "^", "&", "*", "(", ")", "=", "+", "[", "{", "]", "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;", "â€”", "â€“", ",", "<", ".", ">", "/", "?");
    $clean = trim(str_replace($strip, "", strip_tags($string)));
    $clean = preg_replace('/\s+/', "-", $clean);
    $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean;
    return
        ($force_lowercase) ?
        (function_exists('mb_strtolower')) ?
            mb_strtolower($clean, 'UTF-8') :
            strtolower($clean)  :
        $clean;
}

/**
 * 
 * @return string
 */
function getIP() {
    $ip = "";
    if (getenv("HTTP_CLIENT_IP")) {
        $ip = getenv("HTTP_CLIENT_IP");
    } else if (getenv("HTTP_X_FORWARDED_FOR")) {
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    } else if (getenv("REMOTE_ADDR")) {
        $ip = getenv("REMOTE_ADDR");
    } else {
        $ip = "";
    }
    return $ip;
}

/**
 * 
 * @param type $table
 * @param type $array_of_values
 * @return null
 */
function build_insert($table = null, $array_of_values = array()) {
    if ($table === null || empty($array_of_values) || !is_array($array_of_values)) {
        return null;
    }
    $fields = array();
    $values = array();
    foreach ($array_of_values as $id => $value) {
        $fields[] = $id;
        if (is_array($value) && !empty($value[0])) {
            $values[] = $value[0];
        } else {
            $values[] = "'" . $value . "'";
        }
    }
    return "INSERT INTO $table (" . implode(',', $fields) . ') VALUES (' . implode(',', $values) . ')';
}

/**
 * 
 * @param type $table
 * @param type $array_of_values
 * @param type $conditions
 * @return null
 */
function build_update($table = null, $array_of_values = array(), $conditions = 'FALSE') {
    if ($table === null || empty($array_of_values)) {
        return null;
    }
    $what_to_set = array();
    foreach ($array_of_values as $field => $value) {
        if (is_array($value) && !empty($value[0])) {
            $what_to_set[] = "$field='{$value[0]}'";
        } else {
            $what_to_set [] = "$field='" . $value . "'";
        }
    }
    $what_to_set_string = implode(',', $what_to_set);
    return "UPDATE $table SET $what_to_set_string WHERE $conditions";
}

/**
 * 
 * @param type $table
 * @param type $columns
 * @param type $conditions
 * @return null
 */
function build_select($table = null, $columns = '*', $conditions = 'FALSE') {
    if ($table === null || empty($columns)) {
        return null;
    }
    return "SELECT $columns from $table WHERE $conditions";
}

/**
 * 
 * @param type $field
 * @param type $arr
 * @param type $sorting
 * @param type $case_insensitive
 * @return boolean
 */
function sort_by($field, &$arr, $sorting = SORT_ASC, $case_insensitive = true) {
    if (is_array($arr) && (count($arr) > 0) && ( ( is_array($arr[0]) && isset($arr[0][$field]) ) || ( is_object($arr[0]) && isset($arr[0]->$field) ) )) {
        if ($case_insensitive == true) {
            $strcmp_fn = "strnatcasecmp";
        } else {
            $strcmp_fn = "strnatcmp";
        }

        if ($sorting == SORT_ASC) {
            $fn = create_function('$a,$b', '
                if(is_object($a) && is_object($b)){
                    return ' . $strcmp_fn . '($a->' . $field . ', $b->' . $field . ');
                }else if(is_array($a) && is_array($b)){
                    return ' . $strcmp_fn . '($a["' . $field . '"], $b["' . $field . '"]);
                }else return 0;
            ');
        } else {
            $fn = create_function('$a,$b', '
                if(is_object($a) && is_object($b)){
                    return ' . $strcmp_fn . '($b->' . $field . ', $a->' . $field . ');
                }else if(is_array($a) && is_array($b)){
                    return ' . $strcmp_fn . '($b["' . $field . '"], $a["' . $field . '"]);
                }else return 0;
            ');
        }
        usort($arr, $fn);
        return true;
    } else {
        return false;
    }
}

/**
 * 
 * @param type $array
 * @param type $val
 * @return type
 */
function from_array_keys($array, $val) {
    return implode(',', array_keys($array, $val));
}

/**
 * 
 * @param type $array
 * @return type
 */
function array_fix($array) {
    $ResultArray = array();
    foreach ($array as $item) {
        if ($item != '') {
            $ResultArray[] = $item;
        }
    }
    return $ResultArray;
}

/**
 * 
 * @param type $path
 * @return string
 */
function getImage($path) {
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    return $base64;
}

/**
 * 
 * @param type $key
 * @param type $array
 * @return type
 */
function get_setting($key, $array) {
    $setting = '';
    foreach ($array as $item) {
        if ($item['skey'] == $key) {
            $setting = $item['svalue'];
            break;
        }
    }
    return $setting;
}

/**
 * 
 * @param type $seconds
 * @return type
 */
function secondsToFormatedTime($seconds) {
    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds / 60) % 60);
    $seconds = $seconds % 60;
    $formatedtime = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
    return $formatedtime;
}
?>