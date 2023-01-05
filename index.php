<?php
session_start();
if(isset($_SESSION['role'])){
    header('location: ./design');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login | rasmi</title>
    <link rel="icon" href="assets/images/logo.png">
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="assets/bootstrap-5.2.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="login">
        <div class="alertInfo"></div>
            <div class="header">
                <h2>Login</h2>
            </div>
            <div class="body">
                <form id="form">
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" id="phone" class='form-control' required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" id="password" class='form-control' required>
                    </div>
                    <button type="submit" class="btn btn-primary mt-1" style="width: 100%" >Login</button>
                </form>
            </div>
            <div class="footer">
                <p>Don’t have an account? <a href="register.php">Register</a></p>
            </div>
        </div>
    </div>
    <script src="assets/jquery/jquery-3.6.1.min.js"></script>
    <script src="login.js"></script>
</body>
</html>