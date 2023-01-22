<?php
include 'header.php';
include '../api/conn.php';
if($_GET['id'] == null){
    return;
}else{
}
if($_SESSION['role']== 'admin' || $_SESSION['role'] == 'super'){
  $idC = $_GET['id'];
  $admin = $_SESSION['admin_id'];
  $query = "SELECT * FROM `bank` WHERE id = '$idC' AND user_Id = '$admin'";
  $conn = mysqli_query($db,$query);
  $sax = (mysqli_num_rows($conn));
  if($sax){
?>
<div class="i-name">Customer info</div>
<div class="padding">
<input type="hidden" id="customerId" value="<?php echo $_GET['id']; ?>">
<button class="btn btn-primary float-right" id="updateBnt"><i class="fas fa-edit"></i></button>
<button class="btn btn-danger float-right" id="deleteBtn"><i class="fas fa-trash"></i></button>
<div class="col-sm-11" style="margin-top: 20px; ">
    <div class="row" style="border: 1px solid #000; margin-left: 1px;">
      <div class="col-sm-2  py-1" style="border-right: 1px solid #000;">Amount</div>
      <span class="col-sm-9 py-1" id="name"></span>
  </div>
    <div class="row" style="border: 1px solid #000; margin-left: 1px;">
      <div class="col-sm-2  py-1" style="border-right: 1px solid #000;">Type</div>
      <span class="col-sm-9 py-1" id="qty"></span>
  </div>
    <div class="row" style="border: 1px solid #000; margin-left: 1px;">
      <div class="col-sm-2  py-1" style="border-right: 1px solid #000;">Description</div>
      <span class="col-sm-9 py-1" id="price"></span>
  </div>
    <div class="row" style="border: 1px solid #000; margin-left: 1px;">
      <div class="col-sm-2  py-1" style="border-right: 1px solid #000;">Date</div>
      <span class="col-sm-9 py-1" id="date"></span>
  </div>
</div>
<div class="modal" id="modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Update inventory</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alertInfo"></div>
        <form id="formData">
        <div class="mb-3">
              <label class="form-label">Amount</label>
              <input type="text" name="amount" id="amount" class='form-control' required>
          </div>
          <div class="mb-3">
              <label class="form-label">Type</label>
              <select name="type" id="type" class="form-control">
                    <option value="deposit">deposit the money</option>
                    <option value="withdraw">withdraw the money</option>
                </select>
          </div>
          <div class="mb-3">
              <label class="form-label">Description</label>
              <input type="text" name="description" id="description" class='form-control' required>
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
  header('location: ./');
}
}else{
  header('location: index.php');
}
include 'footer.php';
?>
<script src="../js/bankS.js"></script>