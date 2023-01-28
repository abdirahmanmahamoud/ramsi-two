<?php
header('content-type: application/json');
include 'conn.php';
session_start();
function registerStore($db){
    $id = $_SESSION['admin_id'];
    $data =array();
    extract($_POST);
    $query1 = "INSERT INTO `storename`(`storeName`,`storePhone`, `storeBalance`, `userid`) VALUES ('$storeName','$storePhone',0,'$id')";
    $coon1 = $db->query($query1);
    if($coon1){
        $data = array('status' => true,'data' => 'Registered Successfully');
    }else{
        $data = array('status' => false, 'data' => $db->error);
    }
    echo json_encode($data);
}
function updateStore($db){
    $data =array();
    extract($_POST);
    $query1 = "UPDATE `storename` SET `storeName`= '$storeName',`storePhone`='$storePhone' WHERE id = '$id'";
    $coon1 = $db->query($query1);
    if($coon1){
        $data = array('status' => true,'data' => 'Registered Successfully');
    }else{
        $data = array('status' => false, 'data' => $db->error);
    }
    echo json_encode($data);
}
function loadDataStore($db){
    $id = $_SESSION['admin_id'];
    $date = array();
    $mess = array();
    $query = "SELECT `id`, `storeName`,`storePhone`, `storeBalance` FROM `storename` WHERE userid = '$id'";
    $coon = $db->query($query);
    if($coon){
        while($row = $coon->fetch_assoc()){
            $balances = '0.00';
            if(balancePrice($db,$row['id']) == null){
                $balances = '0.00';
            }else{
                $balances = balancePrice($db,$row['id']);
            }
            $dateArray = array(
                'id' => $row['id'],
                'storeName' => $row['storeName'],
                'storePhone' => $row['storePhone'],
                'storeBalance' => '$'. $balances
            );
            $date [] = $dateArray;
        }
        $mess = array('status' => true,'data' => $date,'totalPrice' => totalPrice($db));
    }else{
        $mess = array('status' => false, 'data' => $db->error);
    }
    echo json_encode($mess);
}
function loadDataSte($db){
    $idA = $_SESSION['admin_id'];
    $id = $_POST['id'];
    $date = array();
    $mess = array();
    $query = "SELECT `id`, `storeName`,`storePhone`, `storeBalance` FROM `storename` WHERE userid = '$idA' AND id = '$id'";
    $coon = $db->query($query);
    if($coon){
        while($row = $coon->fetch_assoc()){
            $dateArray = array(
                'id' => $row['id'],
                'storeName' => $row['storeName'],
                'storePhone' => $row['storePhone'],
                'storeBalance' => '$'. balancePrice($db,$row['id'])
            );
            $date [] = $dateArray;
        }
        $mess = array('status' => true,'data' => $date);
    }else{
        $mess = array('status' => false, 'data' => $db->error);
    }
    echo json_encode($mess);
}
function registerOutgoing($db){
    $data =array();
    extract($_POST);
    $success = array();
    $error = array();
    $groupId = groupId($db);
    $query1 = "INSERT INTO `groupproductstore`(`id`, `storeId`) VALUES ('$groupId','$store_id')";
    $coon_group = $db->query($query1);
    if($coon_group){
    for($i = 0; $i < count($names); $i++){
        $total = $qtys[$i] * $prices[$i];
        $query = "INSERT INTO `productstore`( `group_id`, `type`, `store_id`, `name`, `qty`, `price`) VALUES ('$groupId','outgoing','$store_id','$names[$i]','$qtys[$i]','$total')";
        $coon = $db->query($query);
            if($coon){
                $success [] = array('status' => true,'data' => 'Registered Successfully'); 
            }else{
                $error [] = array('status' => false, 'data' => $db->error);
            }
    }
    }
    if(count($success) > 0 && count($error) == 0){
        $data = array('status' => true,'data' => 'Registered Successfully');
    }elseif(count($error) > 0){
        $data  = array('status' => false, 'data' => $error);
    }
    echo json_encode($data);
}

function searchStore($db){
    $date = array();
    $mess = array();
    $id = $_SESSION['admin_id'];
    $search = $_POST['search'];
    $query = "SELECT `id`, `storeName`,`storePhone`, `storeBalance` FROM `storename` WHERE storePhone LIKE '$search%' AND userid = '$id'";
    $coon = $db->query($query);
    if($coon){
        while($row = $coon->fetch_assoc()){
            $dateArray = array(
                'id' => $row['id'],
                'storeName' => $row['storeName'],
                'storePhone' => $row['storePhone'],
                'storeBalance' => '$'.$row['storeBalance']
            );
            $date [] = $dateArray;
        }
        $mess = array('status' => true,'data' => $date);
    }else{
        $mess = array('status' => false, 'data' => $db->error);
    }
    echo json_encode($mess);
}

function groupId($db){
    $new_id ='';
    $data = array();
    $mess = array();
    $query = "SELECT * FROM `groupproductstore` ORDER BY id DESC LIMIT 1";
    $coon = $db->query($query);
    if($coon){
            $row = $coon->fetch_assoc();
            if($row > 0){
                $new_id = ++$row['id'];
            }
            else{
                $new_id = 'RSG-01';
            }
    }else{
        $data = array('status' => false, 'data' => $db->error);
    }
    return $new_id;
}

function loadData($db){
    $date = array();
    $mess = array();
    $storeId = $_POST['storeId'];
    $query = "SELECT * FROM `groupproductstore` WHERE groupproductstore.storeId = '$storeId'";
    $coon = $db->query($query);
    if($coon){
        while($row = $coon->fetch_assoc()){
            $dateArray = array(
                'id' => $row['id'],
                'date' => date_m($row['date'],'d/m/Y'),
                'product' => productNub($db,$row['storeId'],$row['id']),
                'price' => '$'.productPrice($db,$row['storeId'],$row['id']),
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
    $query = "SELECT COUNT(*) nub FROM `productstore` WHERE store_id = '$id' AND group_id = '$group_id'";
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
    $query = "SELECT SUM(price)price FROM `productstore` WHERE store_id = '$id' AND group_id = '$group_id'";
    $coon = $db->query($query);
    if($coon){
        $row = $coon->fetch_assoc();
        $price = $row['price'];
    }else{
        $mess = array('status' => false, 'data' => $db->error);
    }
    return $price;
}
function totalPrice($db){
    $date = array();
    $mess = array();
    $AdminId = $_SESSION['admin_id'];
    $query = "SELECT SUM(productstore.price)price FROM `storename`JOIN productstore ON storeName.id = productstore.store_id WHERE productstore.type = 'outgoing' AND storeName.userid = '$AdminId'";
    $coon = $db->query($query);
    if($coon){
        $row = $coon->fetch_assoc();
        $query1 = "SELECT SUM(productstore.price)price FROM `storename`JOIN productstore ON storeName.id = productstore.store_id WHERE productstore.type = 'Incoming' AND storeName.userid = '$AdminId'";
        $coon1 = $db->query($query1);
        $row1 = $coon1->fetch_assoc();
        $priceoutgoing = '0';
        if($row['price'] == null){
            $priceoutgoing = '0';
        }else{
            $priceoutgoing = $row['price'];
        }
        $priceIncoming = '0';
        if($row1['price'] == null){
            $priceIncoming = '0';
        }else{
            $priceIncoming = $row['price'];
        }
        $price = $priceoutgoing - $priceIncoming;
    }else{
        $mess = array('status' => false, 'data' => $db->error);
    }
    return $price;
}
function balancePrice($db,$id){
    $date = array();
    $mess = array();
    $query = "SELECT SUM(price)price FROM `productstore` WHERE store_id = '$id' AND type = 'outgoing'";
    $coon = $db->query($query);
    if($coon){
        $row = $coon->fetch_assoc();
        $query1 = "SELECT SUM(price)price FROM `productstore` WHERE store_id = '$id' AND type = 'Incoming'";
        $coon1 = $db->query($query1);
        $row1 = $coon1->fetch_assoc();
        $price = $row['price'] - $row1['price'];
    }else{
        $mess = array('status' => false, 'data' => $db->error);
    }
    return $price;
}
function registerPay($db){
    $data =array();
    extract($_POST);
    if(balancePrice($db,$store_id) >= $amount){
        $query1 = "INSERT INTO `productstore`(`type`, `store_id`, `name`, `qty`, `price`) VALUES ('Incoming','$store_id','null','null','$amount')";
        $coon1 = $db->query($query1);
        if($coon1){
            $data = array('status' => true,'data' => 'Registered Successfully');
        }else{
            $data = array('status' => false, 'data' => $db->error);
        }
    }else{
        $data = array('status' => false, 'data' => 'The amount owed is too much');
    }
    echo json_encode($data);
}
function deletePay($db){
    $data =array();
    $role = $_SESSION['role'];
    extract($_POST);
    if($role == 'word'){
        $data = array('status' => false, 'data' => 'not allowed to delete');
    }else{
    $query1 = "DELETE FROM `productstore` WHERE id = '$store_id'";
    $coon1 = $db->query($query1);
    if($coon1){
        $data = array('status' => true,'data' => 'Delete Successfully');
    }else{
        $data = array('status' => false, 'data' => $db->error);
    }
}
    echo json_encode($data);
}
function updatePay($db){
    $data =array();
    extract($_POST);
    $query1 = "UPDATE `productstore` SET `price`='$amount' WHERE id = '$id'";
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
    $store_id = $_POST['store_id'];
    $id = $_POST['id'];
    if($id == null){
        $query = "SELECT id,date,price FROM `productstore` WHERE type = 'Incoming' AND store_id = '$store_id'";
    }else{
        $query = "SELECT id,date,price FROM `productstore` WHERE type = 'Incoming' AND id = '$id'";
    }
    $coon = $db->query($query);
    if($coon){
        function idNull($id,$p){
            if($id == null){
                return '$'. $p;
            }else{
                return $p;
            }
        }
        while($row = $coon->fetch_assoc()){
            $dateArray = array(
                'id' => $row['id'],
                'date' => date_m($row['date'],'d/m/Y'),
                'price' => idNull($id,$row['price'])
            );
            $date [] = $dateArray;
        }
        $mess = array('status' => true,'data' => $date);
    }else{
        $mess = array('status' => false, 'data' => $db->error);
    }
    echo json_encode($mess);
    
}

function deleteStore($db){
    $data = array();
    $role = $_SESSION['role'];
    $AdminId = $_SESSION['admin_id'];
    if($role == 'word'){
        $data = array('status' => false, 'data' => 'not allowed to delete');
    }else{
        $id = $_POST['id'];
        $query = "DELETE FROM `groupproductstore` WHERE storeId = '$id'";
        $coon = $db->query($query);
        if($coon){
            $query1 = "DELETE FROM `productstore` WHERE store_id = '$id'";
            $coon1 = $db->query($query1);
            if($coon1){
                $query2 = "DELETE FROM `storename` WHERE id = '$id'";
                $coon2 = $db->query($query2);
                if($coon2){
                    $data = array('status' => true,'data' => 'Delete Successfully');
                }
            }
        }
        else{
            $data = array('status' => false, 'data' => $db->error);
        }
    }
    echo json_encode($data);
}
function groupIN($db){
    $date = array();
    $mess = array();
    $group_id = $_POST['group_id'];
    $query = "SELECT * FROM `productstore` WHERE group_id = '$group_id'";
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
    $query = "SELECT * FROM `productstore` WHERE group_id = '$group_id'";
    $coon = $db->query($query);
    if($coon){
        while($row = $coon->fetch_assoc()){
            $dateArray = array(
                'date' => date_m($row['date'],'d/m/Y'),
                'name' => $row['name'],
                'qty' => $row['qty'],
                'price' => $row['price'] / $row['qty'],
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
function groupBalance($db,$group_id){
    $query = "SELECT SUM(price)price FROM `productstore` WHERE group_id = '$group_id'";
    $coon = $db->query($query);
    $row = $coon->fetch_assoc();
    return $row['price'];
}
function update($db){
    $data =array();
    extract($_POST);
    $success = array();
    $error = array();
    for($i = 0; $i < count($names); $i++){
        $total = $qtys[$i] * $prices[$i];
        $query = "UPDATE `productstore` SET `name`='$names[$i]',`qty`='$qtys[$i]',`price`='$total' WHERE id = '$id[$i]'";
        $coon = $db->query($query);
            if($coon){
                $success [] = array('status' => true,'data' => 'update Successfully'); 
            }else{
                $error [] = array('status' => false, 'data' => $db->error);
    }
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
        $groupUrl = groupCus($db,$id);
        $query = "DELETE FROM `productstore` WHERE group_id = '$id'";
        $coon = $db->query($query);
        if($coon){
            $query1 = "DELETE FROM `groupproductstore` WHERE id = '$id'";
            $coon1 = $db->query($query1);
            if($coon1){
                $data = array('status' => true,'data' => 'Delete Successfully','id' => $groupUrl);
            }
        }else{
            $data = array('status' => false, 'data' => $db->error);
        }
    }
    echo json_encode($data);
}
function groupCus($db,$group_id){
    $query = "SELECT * FROM `groupproductstore` WHERE id = '$group_id'";
    $coon = $db->query($query);
    $row = $coon->fetch_assoc();
    return $row['storeId'];
}

if(isset($_POST['action'])){
    $action = $_POST['action'];
    $action($db);
}
else{
    echo json_encode(array('status' => false, 'data' => 'action ma jiro'));
}
?>