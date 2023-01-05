<?php
include './header.php';
if($_SESSION['role']== 'admin' || $_SESSION['role'] == 'super'){
?>
<div class="i-name">
User list
</div>
<div class="padding-main">
    <button class="btn btn-primary" id="add">Add New</button>
    <table class="table table-color" id="table">
    <thead>
        <tr>
            <th>Full Name</th>
            <th>Phone</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        
    </tbody>
</table>
    <div class="modal" id="modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add user</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alertInfo"></div>
        <form id="from">
        <div class="form-group  mb-3">
            <label for="fullname">Full name</label>
            <input type="text" name="fullname" class="form-control" id="fullname" required>
        </div>
        <div class="form-group  mb-3">
            <label for="phone">Phone</label>
            <input type="text" name="phone" class="form-control" id="phone" required>
        </div>
        <div class="form-group  mb-3">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" id="password" required>
        </div>
    </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
<?php
}else{
  header('location: index.php');
}
include './footer.php';
?>
<script src="../js/user.js"></script>