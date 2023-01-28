<?php
header('content-type: application/json');
include 'conn.php';
session_start();
function register($db){
    $data =array();
    extract($_POST);
    $month = strtotime('+1 month');
    $expire = date('Y-m-d',$month);
    $query = "SELECT * FROM user WHERE phone ='$phone'";
    $conn = mysqli_query($db,$query);
    $sax = (mysqli_num_rows($conn));
    if($sax){
        $data = array('status' => false, 'data' => 'The phone address is registered');
    }else{
        $query2 = "INSERT INTO `user`(`fullname`, `phone`, `password`, `role`, `time_to_expire`) VALUES ('$fullName','$phone',md5('$password'),'admin','$expire')";
        $coon2 = $db->query($query2);
        if($coon2){
            $data = array('status' => true,'data' => 'Registered Successfully');
        }else{
            $data = array('status' => false, 'data' => $db->error);
        }
    }
    echo json_encode($data);
}

function login($db){
    extract($_POST);
    $data = array();
    $query = "SELECT * FROM user WHERE phone ='$phone' AND password = md5('$password')";
    $conn = mysqli_query($db,$query);
    $sax = (mysqli_num_rows($conn));
    if($sax){
        $query1 = "SELECT * FROM user WHERE phone = '$phone'";
        $conn1 = $db ->query($query1);
        if($conn1){
            $row = $conn1->fetch_assoc();
            $date = $row['time_to_expire'];
            $days = date('Y-m-d');
            if($date <= $days){
                $data = array('status' => false,'data' => 'This account has expired Please call 0617666664');
            }else{
                if($row['status'] == 'active'){
                    $_SESSION['admin_id'] = $row['id'];
                    $_SESSION['role'] = $row['role'];
                    $_SESSION['fullName'] = $row['fullname'];
                    $data = array('status' => true,'data' => 'sax');
                }else{
                    $data = array('status' => false,'data' => 'Your account is blocked Please Call 0617666664');
                }
               
            }
        }
    }else{
            $query2 = "SELECT * FROM word WHERE phone = '$phone' AND password = md5('$password')";
            $conn2 = mysqli_query($db,$query2);
            $sax2 = (mysqli_num_rows($conn2));
            if($sax2){
                $query3 = "SELECT * FROM word WHERE phone = '$phone' ";
                $conn3 = $db ->query($query3);
                $row1 = $conn3 ->fetch_assoc();
                $user_id = $row1['admin_id'];
                $query4 = "SELECT * FROM user WHERE id = '$user_id'";
                $conn4 = $db ->query($query4);
                $row2 = $conn4 ->fetch_assoc();
                $date2 = $row2['time_to_expire'];
                $days2 = date('Y-m-d');
                if($date2 <= $days2){
                    $data = array('status' => false,'data' => 'This account has expired please call 0617666664');
                }else{
                     if($row2['status'] == 'active'){
                    if($row1['status'] == 'Action'){
                        $_SESSION['admin_id'] = $user_id;
                        $_SESSION['role'] = $row1['role'];
                        $_SESSION['fullName'] = $row1['fullname'];
                        $data = array('status' => true,'data' => 'sax');
                    }else{
                        $data = array('status' => false,'data' => 'Your account is blocked please contact your admin');
                    }
                     }else{
                          $data = array('status' => false,'data' => 'Your admin account is blocked');
                     }
                }
            }else{
                $data = array('status' => false,'data' => 'Phone and Password are incorrect try again');
            }

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