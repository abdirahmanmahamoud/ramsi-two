<?php
include './header.php';
$role = $_SESSION['role'];
if($role == 'super'){
?>
<div class="i-name">
List user
</div>
<div class="padding-main">
    <table class="table table-color" id="table">
    <thead>
        <tr>
            <th>Full Name</th>
            <th>phone</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        
    </tbody>
</table>
</div>
</div>
<?php
}else{
  header('location: index.php');
}
include './footer.php';
?>
<script src="../js/admin.js"></script>