<?php
include 'header.php';
?>
 <div class="i-name">
            Dashboard
        </div>
        <div class="values">
            <div class="val-box">
                <i class="fas fa-users"></i>
                <div>
                    <h3 id="Customers"></h3>
                    <span>All Customers</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fas fa-dollar-sign"></i>
                <div>
                    <h3 id="Reading"></h3>
                    <span>General debt</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fas fa-dollar-sign"></i>
                <div>
                    <h3 id="Payment"></h3>
                    <span>Paid debt</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fas fa-dollar-sign"></i>
                <div>
                    <h3 id="user"></h3>
                    <span>Unpaid debt</span>
                </div>
            </div>
        </div>
        <div class="padding-main" style="margin-top: 20px;">
            <table class="table" style="margin-top: 15px; margin-left: 5px;" id="table">
            <thead>
            <tr>
                <th>Full Name</th>
                <th>Phone</th>
                <th>Amount</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
            </table>
        </div>
<?php
include 'footer.php';
?>
<script src="../js/dashboard.js"></script>