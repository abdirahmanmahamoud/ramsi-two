<?php
include './header.php';
if($_SESSION['role']== 'admin' || $_SESSION['role'] == 'super'){
?>
<div class="i-name">
Bank
</div>
<div class="padding-main">
  <p class="fs-4" id="total"></p>
    <button class="btn btn-primary" id="add">Add New</button>
    <table class="table table-color" id="table">
        <thead>
            <tr>
                <th>Amount</th>
                <th>Type</th>
                <th>Description</th>
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
</div>
<?php
}else{
  header('location: index.php');
}
include './footer.php';
?>
<script src="../js/bank.js"></script>