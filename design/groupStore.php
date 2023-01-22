<?php
include './header.php';
if($_GET['id'] == null){
    return;
}
$idC = $_GET['id'];
?>
<div class="i-name">
Product Group Info
</div>
<div class="padding-main">
<input type="hidden" id="customerId" value="<?php echo $_GET['id']; ?>">
<button class="btn btn-primary float-right" id="updateBnt"><i class="fas fa-edit"></i></button>
<button class="btn btn-danger float-right" id="deleteBtn"><i class="fas fa-trash"></i></button>
    <table class="table table-color" id="table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Name</th>
                <th>Qty</th>
                <th>price</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <p class='fs-4' id='totals' style ='text-align: center;'></p>
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
         <div class="fromhtml">
            
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
<script src="../js/groupStore.js"></script>