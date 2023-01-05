<?php
header('content-type: application/json');
include 'conn.php';
session_start();
function register($db){
    $id = $_SESSION['admin_id'];
    $data =array();
    extract($_POST);
    $query = "SELECT * FROM word WHERE phone ='$phone'";
    $conn = mysqli_query($db,$query);
    $sax = (mysqli_num_rows($conn));
    if($sax){
        $data = array('status' => false, 'data' => 'The phone address is registered');
    }else{
        $query2 = "INSERT INTO `word`(`fullname`, `phone`, `password`,`admin_id`) VALUES ('$fullname','$phone',md5('$password'),'$id')";
        $coon2 = $db->query($query2);
        if($coon2){
            $data = array('status' => true,'data' => 'Registered Successfully');
        }else{
            $data = array('status' => false, 'data' => $db->error);
        }
    }
    echo json_encode($data);
}

function loadData($db){
    $id = $_SESSION['admin_id'];
    $date = array();
    $mess = array();
    $query = "SELECT id,fullname,phone,status FROM `word` WHERE admin_id = '$id'";
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

function deleteUser($db){
    $data = array();
    $id = $_POST['id'];
    $query = "DELETE FROM `word` WHERE id = '$id'";
    $coon = $db->query($query);
    if($coon){
        $data = array('status' => true,'data' => 'Delete Successfully');
    }else{
        $data = array('status' => false, 'data' => $db->error);
    }
    echo json_encode($data);
}
function updatePassword($db){
    extract($_POST);
    $query = "UPDATE `word` SET `password`= md5('$password') WHERE id = '$id'";
    $coon = $db -> query($query);
    if($coon){
        $data = array('status' => true,'data' => 'Update Password Successfully');
    }
    else{
        $data = array('status' => false, 'data' => $db->error);
    }
    echo json_encode($data);
}
function updatePasswordAdmin($db){
    extract($_POST);
    $query = "UPDATE `user` SET `password`= md5('$password') WHERE id = '$id'";
    $coon = $db -> query($query);
    if($coon){
        $data = array('status' => true,'data' => 'Update Password Successfully');
    }
    else{
        $data = array('status' => false, 'data' => $db->error);
    }
    echo json_encode($data);
}
function fethUserInfo($db){
    $date = array();
    $mess = array();
    $id = $_POST['id'];
    $query = "SELECT id,fullname,phone,status FROM `word` WHERE id = '$id'";
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

function update($db){
    extract($_POST);
    $query = "UPDATE `word` SET `fullname`='$fullname',`phone`='$phone',`status`='$status' WHERE id = '$id'";
    $coon = $db -> query($query);
    if($coon){
        $data = array('status' => true,'data' => 'Update Successfully');
    }
    else{
        $data = array('status' => false, 'data' => $db->error);
    }
    echo json_encode($data);
}

function loadDataUser($db){
    $date = array();
    $mess = array();
    $query = "SELECT id,fullname,phone,status FROM `user`";
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

function fethAdminInfo($db){
    $date = array();
    $mess = array();
    $id = $_POST['id'];
    $query = "SELECT id,fullname,phone,status,time_to_expire FROM `user`WHERE id = '$id'";
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

function updateUser($db){
    extract($_POST);
    $query = "UPDATE `user` SET `fullname`='$fullname',`phone`='$phone',`status`='$status',`time_to_expire` = '$time_to_expire' WHERE id = '$id'";
    $coon = $db -> query($query);
    if($coon){
        $data = array('status' => true,'data' => 'Update Successfully');
    }
    else{
        $data = array('status' => false, 'data' => $db->error);
    }
    echo json_encode($data);
}

function deleteUserAdmin($db){
    extract($_POST);
    $query = "DELETE FROM `user` WHERE id = '$id'";
    $coon = $db -> query($query);
    if($coon){
        $data = array('status' => true,'data' => 'Delete Successfully');
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