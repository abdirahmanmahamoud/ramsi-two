<?php
include './header.php';
if($_SESSION['role']== 'admin' || $_SESSION['role'] == 'super'){
?>
<div class="i-name">
Vendor List
</div>
<div class="padding-main">
<div class="row" style="margin-bottom: 20px;">
      <div class="col-sm-12">
      <input type="text" name="search" id="search" placeholder="Search Vendors phone" class='form-control' required>
      </div>
    </div>
    <button class="btn btn-primary" id="add">Add New</button>
    <button class="btn btn-success" id="export">Export</button>
    <table class="table table-color" id="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <p class='fs-4' id='totals' style ='text-align: center;'></p>
    <div id="export-table" class="d-none">
    <table class="table table-color" id="tableExport">
        <thead>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <p class='fs-4' id='totalsE'></p>
    </div>
    <div class="modal" id="modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New Vendor</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alertInfo"></div>
        <form id="formData">
          <div class="mb-3">
              <label class="form-label">Name</label>
              <input type="text" name="storeName" id="storeName" class='form-control' required>
          </div>
          <div class="mb-3">
              <label class="form-label">Phone</label>
              <input type="text" name="storePhone" id="storePhone" class='form-control' required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
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
<script src="../js/Store.js"></script>