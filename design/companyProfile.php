<?php
include 'header.php';
$admin = 'admin';
if($admin == 'admin' || $admin == 'super'){
?>
<div class="i-name">
Company Profile
</div>
<div class="padding">
<button class="btn btn-success float-right" id="passwordBtn"><i class="fa-solid fa-key"></i></button>
<div class="col-sm-12" style="margin-top: 10px;">
<div class="user"></div>

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
<?php
}else{
  header('location: index.php');
}
include 'footer.php';
?>
<script src="../js/CompanyProfile.js"></script>