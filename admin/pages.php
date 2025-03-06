<?php include '../db_connect.php' ?>
<div class="col-lg-12">
	<div class="container-fluid">
		<div class="card card-outline card-primary">
			<div class="card-header">
				List of Pages
			</div>
			<div class="card-body">
				<table class="table table-condensed">
					<colgroup>
						<col width="5%">
						<col width="20%">
						<col width="20%">
						<col width="40%">
					</colgroup>
					<thead>
						<tr>
							<th>#</th>
							<th>Category</th>
							<th>Parent Category</th>
							<th>Link</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$i = 1;
						$categories = $conn->query("SELECT * FROM categories order by order_by asc");
						$cat = array();
						$cat[0]=array('category'=>'---');
						while($row = $categories->fetch_assoc()):
							$cat[$row['id']] = $row;
						endwhile;	
						foreach($cat as $k => $row):
							if($k == 0)
								continue;
						?>
						<tr>
							<td class="text-center"><b><?php echo $i++ ?></b></td>
							<td><?php echo $row['category'] ?></td>
							<td><?php echo $cat[$row['parent_id']]['category'] ?></td>
							<td><p class="truncate-1"><a href="<?php echo APP_PATH.$row['link'] ?>" target="_blank"><?php echo $row['link'] ?></a></p></td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
	$('table').dataTable()
})
</script>
