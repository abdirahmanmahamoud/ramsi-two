<?php
session_start();
if(!$_SESSION['role']){
    $role = $_SESSION['role'];
    header('location: ../');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rasmi</title>
    <link rel="icon" href="../assets/images/logo.png">
    <link rel="stylesheet" href="../assets/fontawesome/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/bootstrap-5.2.1/css/bootstrap.min.css">
</head>
<body>
    <section id="menu">
        <div class="logo">
            <h2><a href="./">Rasmi</a></h2>
        </div>
        <div class="item">
            <?php if($_SESSION['role'] == 'word'){?>
            <li><a href="./"><i class="fa-solid fa-users"></i>Customers</a></li>
            <li><a href="Transactions.php"><i class="fa-regular fa-credit-card"></i>Transactions</a></li>
            <?php }else if($_SESSION['role'] == 'admin'){?>
            <li><a href="./"><i class="fa-solid fa-users"></i>Customers</a></li>
            <li><a href="Transactions.php"><i class="fa-regular fa-credit-card"></i>Transactions</a></li>
            <li><a href="user.php"><i class="fa-solid fa-user"></i>users</a></li>
            <li><a href="companyProfile.php"><i class="fa-solid fa-tv"></i>My Profile</a></li>
            <?php }else if($_SESSION['role'] == 'super'){?>
            <li><a href="./"><i class="fa-solid fa-users"></i>Customers</a></li>
            <li><a href="Transactions.php"><i class="fa-regular fa-credit-card"></i>Transactions</a></li>
            <li><a href="user.php"><i class="fa-solid fa-user"></i>users</a></li>
            <li><a href="admin.php"><i class="fa-solid fa-user"></i>Super admin</a></li>
            <li><a href="companyProfile.php"><i class="fa-solid fa-tv"></i>My Profile</a></li>
            <?php }?>
        </div>
    </section>
    <section id="interface">
        <div class="navgation">
            <div class="n1">
                <div>
                    <i class="fas fa-bars" id="menu_butt"></i>
                </div>
                <div class="search">
                </div>
            </div>
            <div class="profile">
                <img src="../assets/images/logo.png" id="img-clink">
            </div>
        </div>
        <div class="profile-info" id="profile-clink">
            <div class="name"><?php echo $_SESSION['fullName'];?></div>
            <a href="loginin.php" class="link-profile">
                <i class="fa-solid fa-right-to-bracket"></i>
                <div class="link-name">login out</div>
            </a>
        </div>