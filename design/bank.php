<?php
include './header.php';
if($_SESSION['role']== 'admin' || $_SESSION['role'] == 'super'){
?>
<div class="i-name">
Bank
</div>
<div class="padding-main">
<form id="formDataBank">
    <div class="row">
        <div class="col-sm-4">
            <select name="typeSelect" id="typeSelect" class="form-control mt-2">
                <option value="0">All</option>
                <option value="custon">Custon</option>
            </select>
        </div>
        <div class="col-sm-4">
        <input type="date" name="fromdate" id="fromdate" class='form-control mt-2'>
        </div>
        <div class="col-sm-4">
        <input type="date" name="todate" id="todate" class='form-control mt-2'>
        </div>
    </div>
    <button type="submit" class="btn btn-primary mt-2">summit</button>
</form>
    <div id="total" style="margin: auto; width: 160px; height: 30px;"></div>
    <button class="btn btn-primary" id="add">Add New</button>
    <button class="btn btn-success" id="export">Export</button>
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
    <div id="export-table" class="d-none">
    <table class="table table-color" id="tableExport">
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
    </div>
    <div class="modal" id="modalBank" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Bank</h5>
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