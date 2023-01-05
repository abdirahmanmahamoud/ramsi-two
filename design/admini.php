<?php
include 'header.php';
if($_GET['id'] == null){
    return;
}else{
}
$role = $_SESSION['role'];
if($role == 'super'){
?>
<div class="i-name">User info</div>
<div class="padding">
<input type="hidden" id="userId" value="<?php echo $_GET['id']; ?>">
<button class="btn btn-primary float-right" id="updateBnt"><i class="fas fa-edit"></i></button>
<button class="btn btn-danger float-right" id="deleteBtn"><i class="fas fa-trash"></i></button>
<button class="btn btn-success float-right" id="passwordBtn"><i class="fa-solid fa-key"></i></button>
<div class="col-sm-12" style="margin-top: 10px;">
<div class="user"></div>
</div>
</div>
<div class="modal" id="modal" tabindex="-1">
<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Update user</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alertInfo"></div>
        <form id="from">
        <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="fullname" id="fullname" class='form-control' required>
                </div>
                <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" id="phone" class='form-control' required>
                </div>
                <div class="mb-3">
                <label class="form-label">time to expire</label>
                <input type="date" name="time_to_expire" id="time_to_expire" class='form-control' required>
                </div>
          <div class="mb-3">
          <label for="status">status</label>
            <select name="status" id="status" class="form-control">
                <option value="active">
                active 
                </option>
                <option value="in active">
                in active 
                </option>
            </select>
          </div>
          <input type="hidden" id="id" name="id">
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

<div class="modal" id="modalPass" tabindex="-1">
<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Update Password</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alertInfo"></div>
        <form id="fromPassword">
        <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="passwordForm" id="passwordForm" class='form-control' required>
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
<div class="modal" id="modalPass" tabindex="-1">
<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Update Password</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alertInfo"></div>
        <form id="fromPassword">
        <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="passwordForm" id="passwordForm" class='form-control' required>
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
include 'footer.php';
?>
<script src="../js/admininfo.js"></script>