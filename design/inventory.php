<?php
include './header.php';
?>
<div class="i-name">
inventory
</div>
<div class="padding-main">
<div class="row" style="margin-bottom: 20px;">
      <div class="col-sm-12">
      <input type="text" name="search" id="search" placeholder="Search inventory name" class='form-control' required>
      </div>
    </div>
    <button class="btn btn-primary" id="add">Add New</button>
    <table class="table table-color" id="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <div class="modal" id="modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add inventory</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="alertInfo"></div>
        <form id="formData">
          <div class="mb-3">
              <label class="form-label">Name</label>
              <input type="text" name="name" id="name" class='form-control' required>
          </div>
          <div class="mb-3">
              <label class="form-label">Qty</label>
              <input type="text" name="qty" id="qty" class='form-control' required>
          </div>
          <div class="mb-3">
              <label class="form-label">Price</label>
              <input type="text" name="price" id="price" class='form-control' required>
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
<script src="../js/inventory.js"></script>