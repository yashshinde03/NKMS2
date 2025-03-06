<?php include 'db_connect.php' ?>
<div class="container-fluid" style="position:sticky;top:5rem">
    <div class="d-block w-100">
    <div class="card">
        <div class="card-body">
            <form action="" id="search_content">
                <div class="form-group">
                    <label for="search">Search Here</label>
                    <input type="search" name="search" class="form-control" placeholder="Enter keyword" value="<?php echo isset($_GET['s']) ? $_GET['s'] : '';  ?>" id="search">
                </div>
            </form>
        </div>
    </div>
        <div class="card card-outline card-info">
            <div class="card-header">
                <b>Recent Post/s</b>
            </div>
            <div class="card-body">
                <?php 
                    $qry = $conn->query("SELECT * FROM contents order by unix_timestamp(date_created) desc limit 15");
                    while($row=$qry->fetch_assoc()):
                ?>
                    <div class="callout callout-info px-1 py-0">
                        <dl>
                            <dt class="truncate-1"><a target="_blank" href="./index.php?page=view&cid=<?php echo md5($row['id']) ?>"><?php echo $row['title'] ?></a></dt>
                            <dd><small class="text-muted">Posted Datetime: <?php echo date("M d, Y h:i A",strtotime($row['date_created'])) ?></small></dd>
                        </dl> 
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>
<script>
$('#search_content').submit(function(e){
    e.preventDefault();
    location.href = "./index.php?page=search&s="+encodeURI($('#search').val())
})
</script>