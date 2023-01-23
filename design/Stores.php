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
  $query = "SELECT * FROM `storename` WHERE id = '$idC' AND userid = '$admin'";
  $conn = mysqli_query($db,$query);
  $sax = (mysqli_num_rows($conn));
  if($sax){
?>
<div class="i-name">Vendors info</div>
<div class="padding">
<input type="hidden" id="customerId" value="<?php echo $_GET['id']; ?>">
<button class="btn btn-primary float-right" id="updateBnt"><i class="fas fa-edit"></i></button>
<button class="btn btn-danger float-right" id="deleteBtn"><i class="fas fa-trash"></i></button>
<div class="col-sm-11" style="margin-top: 20px; ">
    <div class="row" style="border: 1px solid #000; margin-left: 1px;">
      <div class="col-sm-2  py-1" style="border-right: 1px solid #000;">Name</div>
      <span class="col-sm-9 py-1" id="customerName"></span>
  </div>
    <div class="row" style="border: 1px solid #000; margin-left: 1px;">
      <div class="col-sm-2  py-1" style="border-right: 1px solid #000;">Phone number</div>
      <span class="col-sm-9 py-1" id="customerPhone"></span>
  </div>
    <div class="row" style="border: 1px solid #000; margin-left: 1px;">
      <div class="col-sm-2  py-1" style="border-right: 1px solid #000;">Balance</div>
      <span class="col-sm-9 py-1" id="customerBalance"></span>
  </div>
</div>
<div style="margin-top: 30px;">
  <button class="btn btn-primary" id="aadOutgoing">Outgoing</button>
  <button class="btn btn-success" id='Payment'>Payment</button>
</div>
<h4 class="fs-4 p-3">Reading</h4>
<table class="table" style="margin-top: 15px; margin-left: 5px;" id="table">
<thead>
  <tr>
      <th>Date</th>
      <th>product number</th>
      <th>price</th>
  </tr>
</thead>
<tbody>
</tbody>
</table>
<h4 class="fs-4 p-3">Payment</h4>
<table class="table" style="margin-top: 15px; margin-left: 5px;" id="tablePayment">
<thead>
  <tr>
      <th>Date</th>
      <th>Amount</th>
      <th>Action</th>
  </tr>
</thead>
<tbody>
</tbody>
</table>
</div>
<div class="modal" id="modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Update Customer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alertInfo"></div>
        <form id="fromUpdateCustomer">
        <div class="mb-3">
              <label class="form-label">store Name</label>
              <input type="text" name="storeName" id="storeName" class='form-control' required>
          </div>
          <div class="mb-3">
              <label class="form-label">store phone</label>
              <input type="text" name="storePhone" id="storePhone" class='form-control' required>
          </div>
          <input type="hidden" name="id" id="id" value="<?php echo $_GET['id'];?>">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="modal" id="modalOutgoing" tabindex="-1" role="dialog">
<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Outgoing</h5>
        <button type="button" class="btn-close" id="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alertInfo"></div>
        <form id="fromOutgoing">
          <h5 class="mb-2">product</h5>
          <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="namePr" id="namePr" class='form-control' required>
          </div>
          <div class="mb-3">
            <label class="form-label">Qty</label>
            <input type="text" name="QtyPr" id="QtyPr" class='form-control' required>
          </div>
          <div class="mb-3">
            <label class="form-label">Price</label>
            <input type="text" name="PricePr" id="PricePr" class='form-control' required>
          </div>
          <div class="formAdd">
        <!--  <div class="mb-3"></div>
          <h5 class="mb-2">product #1</h5>
          <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="namePr" id="namePr" class='form-control' required>
          </div>
          <div class="mb-3">
            <label class="form-label">Qty</label>
            <input type="text" name="QtyPr" id="QtyPr" class='form-control' required>
          </div>
          <div class="mb-3">
            <label class="form-label">Price</label>
            <input type="text" name="PricePr" id="PricePr" class='form-control' required>
          </div>
  -->
          </div>
          <button type = 'button' id="addFrom" class="btn btn-secondary" style="width: 100%;">Add product</button>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" id="btn-close-hea" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
<div class="modal" id="modalPayment" tabindex="-1" role="dialog">
<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Payment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alertInfo"></div>
        <form id="fromPayment">
          <div class="mb-3">
            <label class="form-label">Amount</label>
            <input type="text" name="Amount" id="Amount" class='form-control' required>
          </div>
          <input type="hidden" name="idPay" id="idPay" class='form-control' required>
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
  header('location: ./');
}
}else{
  header('location: index.php');
}
include 'footer.php';
?>
<script src="../js/Stores.js"></script>