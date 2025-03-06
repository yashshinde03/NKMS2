<?php 
if(!isset($conn))
include 'db_connect.php';
$qry = $conn->query("SELECT * FROM contents where md5(id) = '{$_GET['cid']}' ")->fetch_array();
foreach($qry as $k => $v){
    if($k == 'title')
    $k = 'ctitle';
    if(is_numeric($k))
    continue;
 $$k = $v;
}
?>
<div class="col-md-12">
    <div class="card card-outline card-primary">
        <div class="card-body">
        <h2><b><?php echo $ctitle ?></b></h2>
        <hr>
        <center>
        <img src="assets/uploads/<?php echo $banner_img ?>" class='img-fluid img-thumbnail' alt="">
        </center>
        <br>
        <div class="px-1">
        <?php echo is_file($link) ? file_get_contents($link) : 'No Content' ?>
        </div>
        </div>
        <div id="tfield" class="mb-1 mx-2">Tags:
        <?php
        if(isset($meta_keywords)){
            foreach(explode(',', $meta_keywords) as $k => $v){
                echo '<span class="badge badge-info bg-gradient-info px-2 py2 tag-item mx-2 ">'.$v.' <input type="hidden" name="tags[]" value="'.$v.'"></span>';
            }
        }
        ?>
        </div>
        <hr class="border-primary">
        <div class="container-fluid">
        <h4><b>Comments</b></h4>
        <hr>
        <div class="d-block w-100 card-comments">
        <?php
        $comments = $conn->query("SELECT c.*,concat(u.firstname,' ',u.lastname) as name,u.avatar FROM comments c inner join users u on u.id = c.user_id where c.content_id = $id order by unix_timestamp(c.date_created) asc");
        while($row= $comments->fetch_assoc()):
        ?>
        <div class="card-comment">
        <!-- User image -->
        <img class="img-circle img-sm" src="assets/uploads/<?php echo $row['avatar'] ?>" alt="User Image">

        <div class="comment-text">
        <span class="username">
        <?php echo $row['name'] ?>
            <span class="text-muted float-right"><?php echo date("M d, Y h:i A",strtotime($row['date_created'])) ?></span>
        </span><!-- /.username -->
        <?php echo html_entity_decode($row['comment']) ?>
        </div>
        <!-- /.comment-text -->
    </div>
        <?php endwhile; ?>
        </div>
        <?php if(isset($_SESSION['login_id'])): ?>
        <form action="" id="manage_comment">
        <input type="hidden" name="content_id" value="<?php echo $id ?>">
            <div class="form-group">
                <textarea name="comment" id="comment" cols="30" rows="4" class="form-control summernote"></textarea>
            </div>
            <div class="form-group">
                <div class="d-flex w-100 justify-content-end">
                    <button class="btn btn-flat btn-primary bg-gradient-primary mx-1" type="submit" form="manage_comment">Submit</button>
                    <button class="btn btn-flat btn-secondary bg-gradient-secondary mx-1" type="reset">Cancel</button>
                </div>
            </div>
        </form>
        <?php else: ?>
        <a href="login.php">Login to Write Comment</a>
        <?php endif; ?>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
    $('#comment').summernote({
        height: "15vh",
        toolbar: [
            // [ 'style', [ 'style' ] ],
            [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough'] ],
            // [ 'fontname', [ 'fontname' ] ],
            [ 'fontsize', [ 'fontsize' ] ],
            [ 'color', [ 'color' ] ],
            [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
            [ 'view', [ 'undo', 'redo'] ]
        ]
    })
$('#manage_comment').submit(function(e){
		e.preventDefault()
        start_load();
		$.ajax({
			url:'ajax.php?action=save_comment',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
            error:err=>{
                console.log(err)
                alert_toast("An Error Occured.",'danger')
                end_load()
            },
			success:function(resp){
				if(resp == 1){
					alert_toast('Data successfully saved.',"success");
					setTimeout(function(){
						location.reload()
					},750)
				}
			}
		})
	})
})
</script>