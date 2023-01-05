<?php
include './header.php';
?>
<div class="i-name">
Customers
</div>
<div class="padding-main">
    <div class="row" style="margin-bottom: 20px;">
      <div class="col-sm-12">
      <input type="text" name="search" id="search" placeholder="Search phone number" class='form-control' required>
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
    </div>
    <div class="modal" id="modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Customers</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alertInfo"></div>
        <form id="formData">
          <div class="mb-3">
              <label class="form-label">Full Name</label>
              <input type="text" name="fullName" id="fullName" class='form-control' required>
          </div>
          <div class="mb-3">
              <label class="form-label">Phone number</label>
              <input type="text" name="phone" id="phone" class='form-control' required>
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
include './footer.php';
?>
<script src="../js/customer.js"></script>