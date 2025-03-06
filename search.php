<?php include 'db_connect.php';
$search = strtolower($_GET['s']);
$qry = $conn->query("SELECT * FROM contents where title LIKE '%{$search}%' OR meta_description LIKE '%{$search}%' OR meta_keywords LIKE '%{$search}%' ");
?>
<div class="col-md-12">
    <div class="card card-outline card-primary">
        <div class="card-body">
            <h3><b>Search Result/s</b> (Found:<?php echo number_format($qry->num_rows) ?>)</h3>
            <hr>
            <div class="list-field w-100">
               <?php if($qry->num_rows <= 0): ?>
                <center>Sorry, we didn't found any content using the "<?php echo $search ?>" keyword.</center>
               <?php else: ?>
                <?php while($row=$qry->fetch_array()): ?>
                    <a href="index.php?page=view&cid=<?php echo md5($row['id']) ?>">
                    <h4><b><?php echo $row['title'] ?></b></h4>
                    <hr class="border-info">
                    <div class="col-md-12">
                    <div class="row">
                    <div class="col-sm-4">
                        <img src="assets/uploads/<?php echo $row['banner_img'] ?>" alt="" class="img-fluid img-thumbnail">
                    </div>
                    <div class="col-md-8 text-dark"><small><i><?php echo $row['meta_description'] ?>...</i></small></div>
                    </div>
                    </div>
                    </a>
                    <hr>
               <?php endwhile; ?>
               <?php endif; ?>
            </div>
        </div>
    </div>
</div>