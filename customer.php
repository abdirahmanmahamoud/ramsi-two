<?php
header('content-type: application/json');
include 'conn.php';
session_start();
function register($db){
    $id = $_SESSION['admin_id'];
    $data =array();
    extract($_POST);
    $query = "SELECT * FROM customer WHERE phone ='$phone' AND userid = '$id'";
    $conn = mysqli_query($db,$query);
    $sax = (mysqli_num_rows($conn));
    if($sax){
        $data = array('status' => false, 'data' => 'The phone  is registered');
    }else{
    $query1 = "INSERT INTO `customer`(`fullName`, `phone`, `userid`) VALUES ('$fullName','$phone','$id')";
    $coon1 = $db->query($query1);
    if($coon1){
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
    $query = "SELECT id,fullName,phone FROM `customer` WHERE userid = '$id'";
    $coon = $db->query($query);
    if($coon){
        while($row = $coon->fetch_assoc()){
            $dateArray = array(
                'id' => $row['id'],
                'fullName' => $row['fullName'],
                'phone' => $row['phone'],
                'Balance' => '$'.CustomersBalance($db,$row['id']),
            );
            $date [] = $dateArray;
        }
        $mess = array('status' => true,'data' => $date);
    }else{
        $mess = array('status' => false, 'data' => $db->error);
    }
    echo json_encode($mess);
}

function deleteCustomer($db){
    $data = array();
    $role = $_SESSION['role'];
    if($role == 'word'){
        $data = array('status' => false, 'data' => 'not allowed to delete');
    }else{
    $id = $_POST['id'];
    $query = "DELETE FROM `customer` WHERE id = '$id'";
    $coon = $db->query($query);
    if($coon){
        $query1 = "DELETE FROM `product` WHERE customer_Id = '$id'";
        $coon1 = $db->query($query1);
        if($coon1){
            $data = array('status' => true,'data' => 'Delete Successfully');
        }else{
            $data = array('status' => false, 'data' => $db->error);
        }
    }else{
        $data = array('status' => false, 'data' => $db->error);
    }
    }
    echo json_encode($data);
}
function fethCustomerInfo($db){
    $adminId = $_SESSION['admin_id'];
    $date = array();
    $mess = array();
    $id = $_POST['id'];
    $query = "SELECT id,fullName,phone FROM `customer` WHERE userid = '$adminId' AND id = '$id'";
    $coon = $db->query($query);
    if($coon){
        while($row = $coon->fetch_assoc()){
            $dateArray = array(
                'id' => $row['id'],
                'fullName' => $row['fullName'],
                'phone' => $row['phone'],
                'Balance' => '$'.CustomersBalance($db,$row['id']),
            );
            $date [] = $dateArray;
        }
        $mess = array('status' => true,'data' => $date);
    }else{
        $mess = array('status' => false, 'data' => $db->error);
    }
    echo json_encode($mess);
}

function update($db){
    extract($_POST);
    $query = "UPDATE `customer` SET `fullName`='$fullName',`phone`='$phone' WHERE id = '$id'";
    $coon = $db -> query($query);
    if($coon){
        $data = array('status' => true,'data' => 'Update Successfully');
    }
    else{
        $data = array('status' => false, 'data' => $db->error);
    }
    echo json_encode($data);
}

function searchCustomer($db){
    $date = array();
    $mess = array();
    $id = $_SESSION['admin_id'];
    $search = $_POST['search'];
    $query = "SELECT id,fullName,phone FROM `customer` WHERE phone LIKE '$search%' AND userid = '$id'";
    $coon = $db->query($query);
    if($coon){
        while($row = $coon->fetch_assoc()){
            $dateArray = array(
                'id' => $row['id'],
                'fullName' => $row['fullName'],
                'phone' => $row['phone'],
                'Balance' => '$'.CustomersBalance($db,$row['id']),
            );
            $date [] = $dateArray;
        }
        $mess = array('status' => true,'data' => $date);
    }else{
        $mess = array('status' => false, 'data' => $db->error);
    }
    echo json_encode($mess);
}
function CustomersBalance($db,$customerId){
    $query = "SELECT balance ('$customerId') balance";
    $coon = $db->query($query);
    $row = $coon->fetch_assoc();
    return $row['balance'];
}

if(isset($_POST['action'])){
    $action = $_POST['action'];
    $action($db);
}
else{
    echo json_encode(array('status' => false, 'data' => 'action ma jiro'));
}

?>