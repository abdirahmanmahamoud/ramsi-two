<?php
header('content-type: application/json');
include 'conn.php';
session_start();

function loadDataUser($db){
    $id = $_SESSION['admin_id'];
    $date = array();
    $mess = array();
    $query = "SELECT id,fullname,phone,status,time_to_expire FROM `user` WHERE id = '$id'";
    $coon = $db->query($query);
    if($coon){
        while($row = $coon->fetch_assoc()){
            $date [] = $row;
        }
        $mess = array('status' => true,'data' => $date);
    }else{
        $mess = array('status' => false, 'data' => $db->error);
    }
    echo json_encode($mess);
}
function updatePassword($db){
    extract($_POST);
    $admin_id = $_SESSION['admin_id'];
    $query = "UPDATE `user` SET `password`= md5('$password') WHERE id = '$admin_id'";
    $coon = $db -> query($query);
    if($coon){
        $data = array('status' => true,'data' => 'Update Password Successfully');
    }
    else{
        $data = array('status' => false, 'data' => $db->error);
    }
    echo json_encode($data);
}

if(isset($_POST['action'])){
    $action = $_POST['action'];
    $action($db);
}
else{
    echo json_encode(array('status' => false, 'data' => 'action ma jiro'));
}

?>