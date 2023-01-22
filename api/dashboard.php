<?php
header('content-type: application/json');
include 'conn.php';
session_start();
function dashboard($db){
    $date = array();
    $mess = array();
    $admin_ID = $_SESSION['admin_id']; 
    $query = "SELECT COUNT(*)customersNumber FROM `customer` WHERE userid = '$admin_ID'";
    $coon = $db->query($query);
    if($coon){
        $row = $coon->fetch_assoc();
        $query_ = "SELECT SUM(product.price)price FROM `customer` JOIN product ON product.customer_id = customer.id WHERE customer.userid = '$admin_ID' AND product.type = 'outgoing'";
        $coon_ = $db->query($query_);
        if($coon_){
            $row_ = $coon_->fetch_assoc();
            $query_2 = "SELECT SUM(product.price)price FROM `customer` JOIN product ON product.customer_id = customer.id WHERE customer.userid = '$admin_ID' AND product.type = 'Incoming'";
            $coon_2 = $db->query($query_2);
            if($coon_2){
                $row_2 = $coon_2->fetch_assoc();
                $dataArr =  array(
                    'customersNumber' => $row['customersNumber'],
                    'outgoing' => $row_['price'],
                    'Incoming' => $row_2['price'],
                    'bank' => bank($admin_ID,$db) + $row_2['price']
                );
                $mess = array('status' => true,'data' => $dataArr);
            }
        }

      
    }else{
        $mess = array('status' => false, 'data' => $db->error);
    }
    echo json_encode($mess);
}
function bank($admin_ID,$db){
    $query = "SELECT SUM(amount)amount FROM `bank` WHERE user_id = '$admin_ID' AND type = 'deposit'";
    $coon = $db->query($query);
    if($coon){
        $row = $coon->fetch_assoc(); 
        $query1 = "SELECT SUM(amount)amount FROM `bank` WHERE user_id = '$admin_ID' AND type = 'withdraw'";
        $coon1 = $db->query($query1);  
        if($coon1){
            $row11 = $coon1->fetch_assoc();
            $re = $row['amount'] - $row11['amount'];
            return $re;
        }
    }
}
function Customers($db){
    $date = array();
    $mess = array();
    $admin_ID = $_SESSION['admin_id'];
    $query = "SELECT fullName,phone,balance(id)balance FROM `customer` WHERE userid = '3' ORDER BY balance DESC LIMIT 5";
    $coon = $db->query($query);
    if($coon){
        while($row = $coon->fetch_assoc()){
            $dateArray = array(
                'fullName' => $row['fullName'],
                'phone' => $row['phone'],
                'balance' => '$'.$row['balance'],
            );
            $date [] = $dateArray;
        }
        $mess = array('status' => true,'data' => $date);
    }else{
        $mess = array('status' => false, 'data' => $db->error);
    }
    echo json_encode($mess);
}
if(isset($_POST['action'])){
    $action = $_POST['action'];
    $action($db);
}
else{
    echo json_encode(array('status' => false, 'data' => 'action ma jiro'));
}
?>