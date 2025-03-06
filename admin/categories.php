<?php include '../db_connect.php' ?>
<div class="col-lg-12">
	<div class="row">
		<div class="col-md-4">
			<div class="card card-solid">
				<div class="card-header">
					<b>Category Form</b>
				</div>
				<div class="card-body">
					<div class="container">
						<form action="" id="manage_category" >
							<input type="hidden" name="id">
							<div id="msg"></div>
						<div class="form-group">
							<label for="category" class="control-label">Category</label>
							<input type="text" name="category" class="form-control form-control-sm" required>
						</div>
						<div class="form-group">
							<div class="icheck-primary d-inline">
		                        <input type="checkbox" id="is_root" name="is_root" value="1" checked="">
		                        <label for="is_root">Root Category</label>
							</div>
						</div>
						<div class="form-group is_not_root" style="display:none">
							<label for="parent_id" class="control-label">Parent Category</label>
							<select name="parent_id" id="parent_id" class="form-control form-control-sm select2" >
								<option value=""></option>
								<?php 
								$cat = $conn->query("SELECT * FROM categories where is_root = 1 order by category asc");
								while($row=$cat->fetch_assoc()):
								?>
								<option value="<?php echo $row['id'] ?>"><?php echo $row['category'] ?></option>
								<?php endwhile; ?>
							</select>
						</div>
						</form>
					</div>
				</div>
				<div class="card-footer">
					<div class="pull-right d-flex w-100 justify-content-end">
					<button class="btn btn-sm btn-primary bg-gradient-primary mx-1" form="manage_category">Save</button>
					<button class="btn btn-sm btn-secondary bg-gradient-secondary mx-1" form="manage_category" type="reset">Cancel</button>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-8">
			<div class="card card-outline card-primary">
				<div class="card-header">
					<b>Categories</b>
					<div class="card-tools">
						<button class="btn btn-sm bbtn-success bg-gradient-success" form="save_order">Save Order</button>
					</div>
				</div>
				<div class="card-body">
					<div class="container-fluid">
						<form id="save_order">
						<?php 
						$categories = $conn->query("SELECT * FROM categories order by order_by asc");
						$cats = array();
						while($row=$categories->fetch_assoc()){
							$cats[$row['parent_id']][]= $row;
						}
						?>
						<ul class="ul-sort" id="cat-list">
							<?php if(count($cats) > 0 ): ?>
							<?php foreach($cats[0] as $k => $row): ?>
								<li class="parent_li" data-id="<?php echo $row['id'] ?>" data-json='<?php echo json_encode($row) ?>'><input type="hidden" name="ids[]" value="<?php echo $row['id'] ?>"><i class="fa fa-bars"></i> <?php echo $row['category'] ?> <span class="badge badge-primary edit_category" data-id="<?php echo $row['id'] ?>"><i class="fa fa-edit"></i></span> <span class="badge badge-danger remove_category" data-id="<?php echo $row['id'] ?>"><i class="fa fa-trash"></i></span>
							<?php if(isset($cats[$row['id']]) && $cats[$row['parent_id']] > 0 ): ?>
									<ul class="ul-sort">
							<?php foreach($cats[$row['id']] as $k => $rrow): ?>
								<li class="parent_li" data-id="<?php echo $rrow['id'] ?>" data-json='<?php echo json_encode($rrow) ?>'><input type="hidden" name="ids[]" value="<?php echo $rrow['id'] ?>"><i class="fa fa-bars"></i> <?php echo $rrow['category'] ?> <span class="badge badge-primary edit_category" data-id="<?php echo $rrow['id'] ?>"><i class="fa fa-edit"></i></span> <span class="badge badge-danger remove_category" data-id="<?php echo $rrow['id'] ?>"><i class="fa fa-trash"></i></span></li>
							<?php endforeach; ?>
									</ul>
							<?php endif; ?>
								</li>
							<?php endforeach; ?>
							<?php endif; ?>
						</ul>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$('#is_root').change(function(){
		if($(this).prop('checked') == true){
			$('.is_not_root').hide()
			$('#parent_id').attr('required',false)
		}else{
			$('.is_not_root').show()
			$('#parent_id').attr('required',true)
		}
	})
	$(document).ready(function(){
		$('.ul-sort').sortable()
	})
	$('#manage_category').on('reset',function(){
		$('#manage_category input:hidden').val('')
	})
	$('#manage_category').submit(function(e){
		e.preventDefault()
		$('#msg').html('')
		start_load()
		$.ajax({
			url:'<?php echo APP_PATH ?>ajax.php?action=save_category',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
				alert_toast("An Error Occured.","error");
				end_load()
			},
			success:function(resp){
				if(resp == 1){
					alert_toast("Data successfully saved.","success");
					setTimeout(function(){
						location.reload();
					},1500)
				}else if(resp == 2){
					$('#msg').html("<div class='alert alert-danger'>Category already Exist.</div>")
					end_load();
				}
			}
		})
	})
	$('#save_order').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'<?php echo APP_PATH ?>ajax.php?action=save_category_order',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
				alert_toast("An Error Occured.","error");
				end_load()
			},
			success:function(resp){
				if(resp == 1){
					alert_toast("Data successfully saved.","success");
					setTimeout(function(){
						end_load()
					},1500)
				}
			}
		})
	})
	$('.edit_category').click(function(){
		var id = $(this).attr('data-id')
		var json = $('#cat-list').find('li[data-id="'+id+'"]').attr('data-json');
		var data = JSON.parse(json)
		var frm = $('#manage_category')
		frm.find('[name="id"]').val(data.id)
		frm.find('[name="category"]').val(data.category)
		if(data.is_root == 1)
			frm.find('#is_root').prop('checked',true).trigger('change')
		else
			frm.find('#is_root').prop('checked',false).trigger('change')
		data.parent_id = data.parent_id > 0 ? data.parent_id : '';
		frm.find('[name="parent_id"]').val(data.parent_id).trigger('change')

	})
	$('.remove_category').click(function(){
	_conf("Are you sure to delete this category?","delete_category",[$(this).attr('data-id')])
	})
function delete_category($id){
		start_load()
		$.ajax({
			url:'<?php echo APP_PATH ?>ajax.php?action=delete_category',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>
<style>
	.edit_category,.remove_category{
		cursor: pointer;
	}
	.tree li i.fa.fa-bars{
		cursor: move !important;
	}
	.tree {
    min-height:20px;
    padding:19px;
    margin-bottom:20px;
    background-color:#fbfbfb;
    border:1px solid #999;
    -webkit-border-radius:4px;
    -moz-border-radius:4px;
    border-radius:4px;
    -webkit-box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05);
    -moz-box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05);
    box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05)
}
.tree li {
    list-style-type:none;
    margin:0;
    padding:10px 5px 0 5px;
    position:relative
}
.tree li::before, .tree li::after {
    content:'';
    left:-20px;
    position:absolute;
    right:auto
}
.tree li::before {
    border-left:1px solid #999;
    bottom:50px;
    height:100%;
    top:0;
    width:1px
}
.tree li::after {
    border-top:1px solid #999;
    height:20px;
    top:25px;
    width:25px
}
.tree li span:not(.glyphicon) {
    -moz-border-radius:5px;
    -webkit-border-radius:5px;
    border-radius:5px;
    display:inline-block;
    padding:4px 9px;
    text-decoration:none
}
.tree li.parent_li>span:not(.glyphicon) {
    cursor:pointer
}
.tree>ul>li::before, .tree>ul>li::after {
    border:0
}
.tree li:last-child::before {
    height:30px
}
.tree li.parent_li>span:not(.glyphicon):hover, .tree li.parent_li>span:not(.glyphicon):hover+ul li span:not(.glyphicon) {
    background:#eee;
    border:1px solid #999;
    padding:3px 8px;
    color:#000
}
</style>
