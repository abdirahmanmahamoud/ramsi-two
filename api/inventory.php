<?php
header('content-type: application/json');
include 'conn.php';
session_start();
function registerInventory($db){
    $id = $_SESSION['admin_id'];
    $data =array();
    extract($_POST);
    $query1 = "INSERT INTO `inventory`(`name`, `qty`, `price`, `userId`) VALUES ('$name','$qty','$price','$id')";
    $coon1 = $db->query($query1);
    if($coon1){
        $data = array('status' => true,'data' => 'Registered Successfully');
    }else{
        $data = array('status' => false, 'data' => $db->error);
    }
    echo json_encode($data);
}
function updateInventory($db){
    $data =array();
    extract($_POST);
    $query1 = "UPDATE `inventory` SET `name`='$name',`qty`='$qty',`price`='$price' WHERE id = '$id'";
    $coon1 = $db->query($query1);
    if($coon1){
        $data = array('status' => true,'data' => 'update Successfully');
    }else{
        $data = array('status' => false, 'data' => $db->error);
    }
    echo json_encode($data);
}
function deleteInventory($db){
    $data =array();
    extract($_POST);
    $query1 = "DELETE FROM `inventory` WHERE id = '$id'";
    $coon1 = $db->query($query1);
    if($coon1){
        $data = array('status' => true,'data' => 'Delete Successfully');
    }else{
        $data = array('status' => false, 'data' => $db->error);
    }
    echo json_encode($data);
}
function loadDataInventory($db){
    $id = $_SESSION['admin_id'];
    $date = array();
    $mess = array();
    $query = "SELECT `id`, `name`, `qty`, `price`, `date` FROM `inventory` WHERE userId = '$id'";
    $coon = $db->query($query);
    if($coon){
        while($row = $coon->fetch_assoc()){
            $dateArray = array(
                'id' => $row['id'],
                'name' => $row['name'],
                'qty' => $row['qty'],
                'price' => '$'.$row['price'],
                'date' => date_m($row['date'],'d/m/Y')
            );
            $date [] = $dateArray;
        }
        $mess = array('status' => true,'data' => $date);
    }else{
        $mess = array('status' => false, 'data' => $db->error);
    }
    echo json_encode($mess);
}
function loadDataInventoryId($db){
    $idA = $_SESSION['admin_id'];
    $id = $_POST['id'];
    $date = array();
    $mess = array();
    $query = "SELECT `id`, `name`, `qty`, `price`, `date` FROM `inventory` WHERE userId = '$idA' AND id = '$id'";
    $coon = $db->query($query);
    if($coon){
        while($row = $coon->fetch_assoc()){
            $dateArray = array(
                'id' => $row['id'],
                'name' => $row['name'],
                'qty' => $row['qty'],
                'price' => $row['price'],
                'date' => date_m($row['date'],'d/m/Y')
            );
            $date [] = $dateArray;
        }
        $mess = array('status' => true,'data' => $date);
    }else{
        $mess = array('status' => false, 'data' => $db->error);
    }
    echo json_encode($mess);
}

function searchInventory($db){
    $date = array();
    $mess = array();
    $id = $_SESSION['admin_id'];
    $search = $_POST['search'];
    $query = "SELECT `id`, `name`, `qty`, `price`, `date` FROM `inventory` WHERE name LIKE '$search%' AND userId = '$id'";
    $coon = $db->query($query);
    if($coon){
        while($row = $coon->fetch_assoc()){
            $dateArray = array(
                'id' => $row['id'],
                'name' => $row['name'],
                'qty' => $row['qty'],
                'price' => '$'.$row['price'],
                'date' => date_m($row['date'],'d/m/Y')
            );
            $date [] = $dateArray;
        }
        $mess = array('status' => true,'data' => $date);
    }else{
        $mess = array('status' => false, 'data' => $db->error);
    }
    echo json_encode($mess);
}

function registerBank($db){
    $id = $_SESSION['admin_id'];
    $data =array();
    extract($_POST);
    $query1 = "INSERT INTO `bank`(`amount`, `type`, `description`, `user_id`) VALUES ('$amount','$type','$description','$id')";
    $coon1 = $db->query($query1);
    if($coon1){
        $data = array('status' => true,'data' => 'Registered Successfully');
    }else{
        $data = array('status' => false, 'data' => $db->error);
    }
    echo json_encode($data);
}
function loadDataBank($db){
    $id = $_SESSION['admin_id'];
    $date = array();
    $mess = array();
    $query = "SELECT `id`, `amount`, `type`, `description`, `date` FROM `bank` WHERE user_Id = '$id'";
    $coon = $db->query($query);
    if($coon){
        while($row = $coon->fetch_assoc()){
            $dateArray = array(
                'id' => $row['id'],
                'amount' => '$'.$row['amount'],
                'type' => $row['type'],
                'description' => $row['description'],
                'date' => date_m($row['date'],'d/m/Y')
            );
            $date [] = $dateArray;
        }
        $mess = array('status' => true,'data' => $date);
    }else{
        $mess = array('status' => false, 'data' => $db->error);
    }
    echo json_encode($mess);
}
function loadDataBankId($db){
    $id = $_POST['id'];
    $date = array();
    $mess = array();
    $query = "SELECT `id`, `amount`, `type`, `description`, `date` FROM `bank` WHERE Id = '$id'";
    $coon = $db->query($query);
    if($coon){
        while($row = $coon->fetch_assoc()){
            $dateArray = array(
                'id' => $row['id'],
                'amount' => $row['amount'],
                'type' => $row['type'],
                'description' => $row['description'],
                'date' => date_m($row['date'],'d/m/Y')
            );
            $date [] = $dateArray;
        }
        $mess = array('status' => true,'data' => $date);
    }else{
        $mess = array('status' => false, 'data' => $db->error);
    }
    echo json_encode($mess);
}

function updateBank($db){
    $data =array();
    extract($_POST);
    $query1 = "UPDATE `bank` SET `amount`='$amount',`type`='$type',`description`='$description' WHERE id = '$id'";
    $coon1 = $db->query($query1);
    if($coon1){
        $data = array('status' => true,'data' => 'update Successfully');
    }else{
        $data = array('status' => false, 'data' => $db->error);
    }
    echo json_encode($data);
}

function deleteBank($db){
    $data =array();
    extract($_POST);
    $query1 = "DELETE FROM `bank` WHERE id = '$id'";
    $coon1 = $db->query($query1);
    if($coon1){
        $data = array('status' => true,'data' => 'Delete Successfully');
    }else{
        $data = array('status' => false, 'data' => $db->error);
    }
    echo json_encode($data);
}

function date_m($date_n,$date_type){
    $arr = explode('-',$date_n);
    $da = explode(' ',$arr[2]);
    $das = explode(':',$da[1]);
    $date_se = mktime($das[0],$das[1],$das[2],$arr[1],$da[0],$arr[0]);
    return date($date_type,$date_se);
}

if(isset($_POST['action'])){
    $action = $_POST['action'];
    $action($db);
}
else{
    echo json_encode(array('status' => false, 'data' => 'action ma jiro'));
}
?>