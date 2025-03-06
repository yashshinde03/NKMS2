<?php include('../db_connect.php') ?>
<?php
$twhere ="";
if($_SESSION['admin_type'] != 1)
  $twhere = "  ";
?>


<!-- Info boxes -->
<?php if($_SESSION['admin_type'] == 1): ?>
        <div class="row">
          <div class="col-12 col-sm-6 col-md-4">
            <div class="small-box bg-light shadow-sm border">
              <div class="inner">
                <h3><?php echo $conn->query("SELECT * FROM categories ")->num_rows; ?></h3>

                <p>Total Categories</p>
              </div>
              <div class="icon">
                <i class="fa fa-columns"></i>
              </div>
            </div>
          </div>
           <div class="col-12 col-sm-6 col-md-4">
            <div class="small-box bg-light shadow-sm border">
              <div class="inner">
                <h3><?php echo $conn->query("SELECT * FROM contents")->num_rows; ?></h3>

                <p>Total Contents</p>
              </div>
              <div class="icon">
                <i class="fa fa-file-contract"></i>
              </div>
            </div>
          </div>
      </div>

<?php else: ?>
   <div class="col-12">
          <div class="card">
            <div class="card-body">
              Welcome <?php echo $_SESSION['admin_name'] ?>!
            </div>
          </div>
      </div>
          
<?php endif; ?>
