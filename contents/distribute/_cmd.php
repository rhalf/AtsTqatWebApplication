<?php

header("Cache-Control: no-cache, must-revalidate");
include_once("../../settings.php");
include_once("../../scripts.php");
include("_start.php");

if (!isset($_REQUEST['dist'])) {
    die;
}

include(ROOT_DIR . "/connect/connection.php");

$TrackersResult = $session->get('trackers');
$UsersResult = $session->get('users');
$UsersArray = get_AllUsers($UsersResult, $userid);
$UsersIDs = array();
foreach ($UsersArray as $User) {
    $UsersIDs[] = $User['uid'];
}

if (isset($_REQUEST['td_list_right'])) {
    foreach ($_REQUEST['td_list_right'] as $val) {
        $values[] = $val;
    }
} else {
    $values = array();
}
foreach ($_REQUEST['dist'] as $k => $v) {
    if ($_POST['td_type'] == 0) {
        $users = '';
        foreach ($TrackersResult as $row) {
            if ($row['tunit'] == $v) {
                $users = $row['tusers'];
            }
        }
        $newUsers = array();

        $oldUsers = explode(',', $users);
        $oldUsers = array_diff($oldUsers, $UsersIDs);

        $newUsers = array_unique(array_merge($oldUsers, $values));
        $newUsers = array_fix($newUsers);
        $DistArray = array(
          '`tusers`' => implode(',', $newUsers)
        );
        /* foreach($TrackersResult as $row){
          if($row['tunit']==$v)
          $users=$row['tusers'];
          };

          $newUsers=array();
          if (is_array(json_decode($users))){
          $exist=false;
          foreach(json_decode($users,true) as $crow){
          if ($crow['id']==$userid){
          $exist=true;
          if (empty($values)){
          $new_Array=array('id'=>$userid,'value'=>"");
          }else{
          $new_Array=array('id'=>$userid,'value'=>implode(',',$values));
          }
          $newUsers[]=$new_Array;
          }else{
          $newUsers[]=$crow;
          }
          }
          if ($exist==false){
          if (empty($values)){
          $new_Array=array('id'=>$userid,'value'=>"");
          }else{
          $new_Array=array('id'=>$userid,'value'=>implode(',',$values));
          }
          $newUsers[]=$new_Array;
          }
          }else{
          if (empty($values)){
          $new_Array=array('id'=>$userid,'value'=>"");
          }else{
          $new_Array=array('id'=>$userid,'value'=>implode(',',$values));
          }
          $newUsers[]=$new_Array;
          }


          $DistArray=array(
          '`tusers`'=> json_encode($newUsers)
          ); */
    } else if ($_POST['td_type'] == 1) {
        foreach ($TrackersResult as $row) {
            if ($row['tunit'] == $v) {
                $collections = $row['tcollections'];
                break;
            }
        }
        $newCollections = array();

        if (is_array(json_decode($collections))) {
            $exist = false;
            foreach (json_decode($collections, true) as $crow) {
                if ($crow['id'] == $userid) {
                    $exist = true;
                    if (empty($values)) {
                        $new_Array = array('id' => $userid, 'value' => "");
                    } else {
                        $new_Array = array('id' => $userid, 'value' => implode(',', $values));
                    }
                    $newCollections[] = $new_Array;
                } else {
                    $newCollections[] = $crow;
                }
            }
            if ($exist == false) {
                if (empty($values)) {
                    $new_Array = array('id' => $userid, 'value' => "");
                } else {
                    $new_Array = array('id' => $userid, 'value' => implode(',', $values));
                }
                $newCollections[] = $new_Array;
            }
        } else {
            if (empty($values)) {
                $new_Array = array('id' => $userid, 'value' => "");
            } else {
                $new_Array = array('id' => $userid, 'value' => implode(',', $values));
            }
            $newCollections[] = $new_Array;
        }


        $DistArray = array(
          '`tcollections`' => json_encode($newCollections)
        );
    } else if ($_POST['td_type'] == 2) {
        $DistArray = array(
          '`tcmp`' => implode(',', $values)
        );
    }
    $sql = build_update('`trks`', $DistArray, "`tunit`='$v'");
    $SQLStatment = $Conn->query($sql);
    if (!$SQLStatment) {
        print_r($Conn->errorInfo());
    }
}

$session->un_set('trackers');
include("../trackers/_sql.php");
$session->set('trackers', $TrackersResult);
echo "Done";
$Conn = null;
?>