<?php include'../db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-success">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_content"><i class="fa fa-plus"></i> Add New Content</a>
			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Date Posted</th>
						<th>Title</th>
						<th>Author Details</th>
						<th>Date Modified</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$users = $conn->query("SELECT *,concat(firstname,' ',lastname) as name FROM users order by concat(firstname,' ',lastname) asc");
					$usr[0] = array('name'=>"---","email"=>'---');
					while($row= $users->fetch_assoc()):
						$usr[$row['id']] = array('name'=>ucwords($row['name']),"email"=>$row['email']);
					endwhile;
					$qry = $conn->query("SELECT * FROM contents order by unix_timestamp(date_created) desc");
					while($row= $qry->fetch_assoc()):
					?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						<td><b><?php echo date("M d, Y",strtotime($row['date_created'])) ?></b></td>
						<td><b><?php echo ucwords($row['title']) ?></b></td>
						<td>
							<p><b>Name: <?php echo $usr[$row['author_id']] ? $usr[$row['author_id']]['name'] : '---' ?></b></p>
							<p><b>Email: <?php echo $usr[$row['author_id']] ? $usr[$row['author_id']]['email'] : '---' ?></b></p>
						</td>
						<td><b><?php echo !empty($row['date_modified']) ? date("M d, Y",strtotime($row['date_modified'])) : ' ---' ?></b></td>
						<td class="text-center">
							<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		                      Action
		                    </button>
		                    <div class="dropdown-menu" style="">
		                      <a class="dropdown-item view_content" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">View</a>
		                      <div class="dropdown-divider"></div>
		                      <a class="dropdown-item" href="./index.php?page=edit_content&id=<?php echo $row['id'] ?>">Edit</a>
		                      <div class="dropdown-divider"></div>
		                      <a class="dropdown-item delete_content" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Delete</a>
		                    </div>
						</td>
					</tr>	
				<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('#list').dataTable()
	// $('.view_content').click(function(){
	// 	uni_modal("<i class='fa fa-id-card'></i> User Details","view_content.php?id="+$(this).attr('data-id'))
	// })
	$('.delete_content').click(function(){
	_conf("Are you sure to delete this content?","delete_content",[$(this).attr('data-id')])
	})
	})
	function delete_content($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_content',
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