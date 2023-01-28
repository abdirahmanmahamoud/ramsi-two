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
    $role = $_SESSION['role'];
    if($role == 'word'){
        $data = array('status' => false, 'data' => 'not allowed to delete');
    }else{
    $query1 = "DELETE FROM `inventory` WHERE id = '$id'";
    $coon1 = $db->query($query1);
    if($coon1){
        $data = array('status' => true,'data' => 'Delete Successfully');
    }else{
        $data = array('status' => false, 'data' => $db->error);
    }
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
    extract($_POST);
    if($fordate == null){
        $query = "SELECT `id`, `amount`, `type`, `description`, `date` FROM `bank` WHERE user_Id = '$id'";
    }else{
    $query = "SELECT `id`, `amount`, `type`, `description`, `date` FROM `bank` WHERE user_Id = '$id' AND date BETWEEN '$fordate' and '$todate'";
    }
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
        $mess = array('status' => true,'data' => $date,'total' => bank($db));
    }else{
        $mess = array('status' => false, 'data' => $db->error);
    }
    echo json_encode($mess);
}
function bank($db){
    $admin_ID = $_SESSION['admin_id'];
    $query = "SELECT SUM(amount)amount FROM `bank` WHERE user_id = '$admin_ID' AND type = 'deposit'";
    $coon = $db->query($query);
    if($coon){
        $row = $coon->fetch_assoc(); 
        $query1 = "SELECT SUM(amount)amount FROM `bank` WHERE user_id = '$admin_ID' AND type = 'withdraw'";
        $coon1 = $db->query($query1);  
        if($coon1){
            $row11 = $coon1->fetch_assoc();
            $query_2 = "SELECT SUM(product.price)price FROM `customer` JOIN product ON product.customer_id = customer.id WHERE customer.userid = '$admin_ID' AND product.type = 'Incoming'";
            $coon_2 = $db->query($query_2);
            if($coon_2){
                $row_2 = $coon_2->fetch_assoc();
                $query_3= "SELECT SUM(productstore.price)price FROM `storename` JOIN productstore ON productstore.store_id = storename.id WHERE storename.userid = '$admin_ID' AND productstore.type = 'Incoming'";
                $coon_3 = $db->query($query_3);
                if($coon_3){
                    $row_3 = $coon_3->fetch_assoc();
                    $re = $row['amount'] - $row11['amount']  + $row_2['price'] - $row_3['price'];
                    return $re;
                }
                
            }
        }
    }
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
    $role = $_SESSION['role'];
    if($role == 'word'){
        $data = array('status' => false, 'data' => 'not allowed to delete');
    }else{
    $query1 = "DELETE FROM `bank` WHERE id = '$id'";
    $coon1 = $db->query($query1);
    if($coon1){
        $data = array('status' => true,'data' => 'Delete Successfully');
    }else{
        $data = array('status' => false, 'data' => $db->error);
    }
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