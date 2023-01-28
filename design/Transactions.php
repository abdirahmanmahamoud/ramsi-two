<?php
include './header.php';
?>
<div class="i-name">Transactions</div>
<div class="padding">
<form id="form">
    <div class="row">
        <div class="col-sm-4">
            <select name="type" id="type" class="form-control mt-2">
                <option value="0">All</option>
                <option value="custon">Custom</option>
            </select>
        </div>
        <div class="col-sm-4">
        <input type="date" name="fromdate" id="fromdate" class='form-control mt-2'>
        </div>
        <div class="col-sm-4">
        <input type="date" name="todate" id="todate" class='form-control mt-2'>
        </div>
    </div>
    <button type="submit" class="btn btn-primary  mt-2" id='add'>Refresh</button>
</form>
<table class="table mt-4" id="table">

</table>
</div>
<?php
include './footer.php';
?>
<script src="../js/Transactions.js"></script>