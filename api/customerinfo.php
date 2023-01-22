<?php
header('content-type: application/json');
include 'conn.php';
session_start();
function registerOutgoing($db){
    $data =array();
    extract($_POST);
    $success = array();
    $error = array();
    include './Outgoing.php';
    $OutgoingSre = OutgoingSreg($db,$names,$qtys);
    if($OutgoingSre['code'] == 321){
        $pro = $OutgoingSre['data'];
        $groupId = groupId($db);
        $query1 = "INSERT INTO `groupproduct`(`id`, `customerId`) VALUES ('$groupId','$customer_id')";
        $coon_group = $db->query($query1);
        if($coon_group){
        for($i = 0; $i < count($pro); $i++){
            $total = $pro[$i]['qty'] * $pro[$i]['price'];
            $namePRO = $pro[$i]['name'];
            $qtyPRO = $pro[$i]['qty'];
            $query = "INSERT INTO `product`( `group_id`, `type`, `customer_id`, `name`, `qty`, `price`) VALUES ('$groupId','outgoing','$customer_id','$namePRO','$qtyPRO','$total')";
            $coon = $db->query($query);
                if($coon){
                    $success [] = array('status' => true,'data' => 'Registered Successfully'); 
                }else{
                    $error [] = array('status' => false, 'data' => $db->error);
                }
        }
       }
    }else{
        $error [] = array('data' => $OutgoingSre['data']);
    }

    if(count($success) > 0 && count($error) == 0){
        $data = array('status' => true,'data' => 'Registered Successfully');
    }elseif(count($error) > 0){
        $data  = array('status' => false, 'data' => $error);
    }
    echo json_encode($data);
}
function groupId($db){
    $new_id ='';
    $data = array();
    $mess = array();
    $query = "SELECT * FROM `groupproduct` ORDER BY id DESC LIMIT 1";
    $coon = $db->query($query);
    if($coon){
            $row = $coon->fetch_assoc();
            if($row > 0){
                $new_id = ++$row['id'];
            }
            else{
                $new_id = 'RPG-01';
            }
    }else{
        $data = array('status' => false, 'data' => $db->error);
    }
    return $new_id;
}
function loadDataBalance($db,$customerId){
    $query = "SELECT balance ('$customerId') balance";
    $coon = $db->query($query);
    $row = $coon->fetch_assoc();
    return $row['balance'];
}
function loadData($db){
    $date = array();
    $mess = array();
    $customerId = $_POST['customerId'];
    $query = "SELECT * FROM `groupproduct` WHERE groupproduct.customerId = '$customerId'";
    $coon = $db->query($query);
    if($coon){
        while($row = $coon->fetch_assoc()){
            $dateArray = array(
                'id' => $row['id'],
                'date' => date_m($row['date'],'d/m/Y'),
                'product' => productNub($db,$row['customerId'],$row['id']),
                'price' => '$'.productPrice($db,$row['customerId'],$row['id']),
            );
            $date [] = $dateArray;
        }
        $mess = array('status' => true,'data' => $date);
    }else{
        $mess = array('status' => false, 'data' => $db->error);
    }
    echo json_encode($mess);
}
function date_m($date_n,$date_type){
    $arr = explode('-',$date_n);
    $da = explode(' ',$arr[2]);
    $das = explode(':',$da[1]);
    $date_se = mktime($das[0],$das[1],$das[2],$arr[1],$da[0],$arr[0]);
    return date($date_type,$date_se);
}
function productNub($db,$id,$group_id){
    $date = array();
    $mess = array();
    $query = "SELECT COUNT(*) nub FROM `product` WHERE customer_id = '$id' AND group_id = '$group_id'";
    $coon = $db->query($query);
    if($coon){
        $row = $coon->fetch_assoc();
        $nub = $row['nub'];
    }else{
        $mess = array('status' => false, 'data' => $db->error);
    }
    return $nub;
}
function productPrice($db,$id,$group_id){
    $date = array();
    $mess = array();
    $query = "SELECT SUM(price)price FROM `product` WHERE customer_id = '$id' AND group_id = '$group_id'";
    $coon = $db->query($query);
    if($coon){
        $row = $coon->fetch_assoc();
        $price = $row['price'];
    }else{
        $mess = array('status' => false, 'data' => $db->error);
    }
    return $price;
}
function groupBalance($db,$group_id){
    $query = "SELECT SUM(price)price FROM `product` WHERE group_id = '$group_id'";
    $coon = $db->query($query);
    $row = $coon->fetch_assoc();
    return $row['price'];
}
function groupCus($db,$group_id){
    $query = "SELECT * FROM `groupproduct` WHERE id = '$group_id'";
    $coon = $db->query($query);
    $row = $coon->fetch_assoc();
    return $row['customerId'];
}
function groupIN($db){
    $date = array();
    $mess = array();
    $group_id = $_POST['group_id'];
    $query = "SELECT * FROM `product` WHERE group_id = '$group_id'";
    $coon = $db->query($query);
    if($coon){
        while($row = $coon->fetch_assoc()){
            $dateArray = array(
                'date' => date_m($row['date'],'d/m/Y'),
                'name' => $row['name'],
                'qty' => $row['qty'],
                'price' => '$'.$row['price'],
                'id' => $row['id'],
            );
            $date [] = $dateArray;
        }
        $mess = array('status' => true,'data' => $date,'groupBalance' => groupBalance($db,$group_id));
    }else{
        $mess = array('status' => false, 'data' => $db->error);
    }
    echo json_encode($mess);
}

function groupFrom($db){
    $date = array();
    $mess = array();
    $group_id = $_POST['group_id'];
    $query = "SELECT * FROM `product` WHERE group_id = '$group_id'";
    $coon = $db->query($query);
    if($coon){
        while($row = $coon->fetch_assoc()){
            $dateArray = array(
                'date' => date_m($row['date'],'d/m/Y'),
                'name' => $row['name'],
                'qty' => $row['qty'],
                'id' => $row['id'],
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
    $data =array();
    extract($_POST);
    $success = array();
    $error = array();
    include 'Outgoing.php';
    $OutgoingSre = OutgoingUp($db,$names,$qtys,$id);
    if($OutgoingSre['code'] == 321){
    $pro = $OutgoingSre['data'];
    for($i = 0; $i < count($pro); $i++){
        $total = $pro[$i]['qty'] * $pro[$i]['price'];
        $namePRO = $pro[$i]['name'];
        $qtyPRO = $pro[$i]['qty'];
        $query = "UPDATE `product` SET `name`='$namePRO',`qty`='$qtyPRO',`price`='$total' WHERE id = '$id[$i]'";
        $coon = $db->query($query);
            if($coon){
                $success [] = array('status' => true,'data' => 'Registered Successfully'); 
            }else{
                $error [] = array('status' => false, 'data' => $db->error);
            }
    }
    }else{
        $error [] = array('data' => $OutgoingSre['data']);
    }

    if(count($success) > 0 && count($error) == 0){
        $data = array('status' => true,'data' => 'update Successfully');
    }elseif(count($error) > 0){
        $data  = array('status' => false, 'data' => $error);
    }
    echo json_encode($data);
}

function delete($db){
    $data = array();
    $role = $_SESSION['role'];
    if($role == 'word'){
        $data = array('status' => false, 'data' => 'not allowed to delete');
    }else{
        $id = $_POST['id'];
        $groupCus = groupCus($db,$id);
        include 'Outgoing.php';
        $pro = OutgoingDele($db,$id);
        if($pro == 321){
            $query = "DELETE FROM `product` WHERE group_id = '$id'";
            $coon = $db->query($query);
            if($coon){
                $query1 = "DELETE FROM `groupproduct` WHERE id = '$id'";
                $coon1 = $db->query($query1);
                if($coon1){
                    $data = array('status' => true,'data' => 'Delete Successfully','id' => $groupCus);
                }
            }else{
                $data = array('status' => false, 'data' => $db->error);
            }
        }
       
    }
    echo json_encode($data);
}

function Transactions($db){
    $id = $_SESSION['admin_id'];
    $date = array();
    $mess = array();
    extract($_POST);
    if($fordate == null){
        $query = "SELECT product.date,customer.fullName,product.type,product.price FROM `product` LEFT JOIN customer ON product.customer_id = customer.id WHERE customer.userid = '$id'";
    }else{
        $query = "SELECT product.date,customer.fullName,product.type,product.price FROM `product` LEFT JOIN customer ON product.customer_id = customer.id WHERE customer.userid = '$id' AND product.date BETWEEN '$fordate' and '$todate'";
    }
    $coon = $db->query($query);
    if($coon){
        while($row = $coon->fetch_assoc()){
            $dateArray = array(
                'date' => date_m($row['date'],'d/m/Y'),
                'fullName' => $row['fullName'],
                'type' => $row['type'],
                'price' => '$'.$row['price']
            );
            $date [] = $dateArray;
        }
        $mess = array('status' => true,'data' => $date);
    }else{
        $mess = array('status' => false, 'data' => $db->error);
    }
    echo json_encode($mess);
}

function registerPay($db){
    $data =array();
    extract($_POST);
    $query1 = "INSERT INTO `product`(`type`, `customer_id`, `name`, `qty`, `price`) VALUES ('Incoming','$customer_id','null','null','$amount')";
    $coon1 = $db->query($query1);
    if($coon1){
        $data = array('status' => true,'data' => 'Registered Successfully');
    }else{
        $data = array('status' => false, 'data' => $db->error);
    }
    echo json_encode($data);
}
function deletePay($db){
    $data =array();
    extract($_POST);
    $query1 = "DELETE FROM `product` WHERE id = '$id'";
    $coon1 = $db->query($query1);
    if($coon1){
        $data = array('status' => true,'data' => 'Delete Successfully');
    }else{
        $data = array('status' => false, 'data' => $db->error);
    }
    echo json_encode($data);
}
function updatePay($db){
    $data =array();
    extract($_POST);
    $query1 = "UPDATE `product` SET `price`='$amount' WHERE id = '$id'";
    $coon1 = $db->query($query1);
    if($coon1){
        $data = array('status' => true,'data' => 'Update Successfully');
    }else{
        $data = array('status' => false, 'data' => $db->error);
    }
    echo json_encode($data);
}

function loadDataPay($db){
    $date = array();
    $mess = array();
    $customer_id = $_POST['customer_id'];
    $id = $_POST['id'];
    if($id == null){
        $query = "SELECT id,date,price FROM `product` WHERE type = 'Incoming' AND customer_id = '$customer_id'";
    }else{
        $query = "SELECT id,date,price FROM `product` WHERE type = 'Incoming' AND id = '$id'";
    }
    $coon = $db->query($query);
    if($coon){
        while($row = $coon->fetch_assoc()){
            $dateArray = array(
                'id' => $row['id'],
                'date' => date_m($row['date'],'d/m/Y'),
                'price' => '$'.$row['price']
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