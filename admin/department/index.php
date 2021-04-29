<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif; ?>
<div class="card card-outline cardprimary w-fluid">
	<div class="card-header">
		<h3 class="card-title">Department List</h3>
		<div class="card-tools">
			<a class="btn btn-block btn-sm btn-default btn-flat border-primary new_department" href="javascript:void(0)"><i class="fa fa-plus"></i> Add New</a>
		</div>
	</div>
	<div class="card-body">
		<table class="table table-bordered table-compact table-stripped">
			<thead>
				<tr>
					<th>#</th>
					<th>Department</th>
					<th>Description</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$i =1;
				$qry = $conn->query("SELECT * FROM department order by department asc");
				while($row=$qry->fetch_assoc()):
				?>
				<tr>
					<td><?php echo $i++ ?></td>
					<td><?php echo $row['department'] ?></td>
					<td><span class="truncate"><?php echo $row['description'] ?></span></td>
					<td class="text-center">
						<div class="btn-group">
		                    <button type="button" class="btn btn-default btn-block btn-flat dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown" aria-expanded="false">
		                    	Action
		                      <span class="sr-only">Toggle Dropdown</span>
		                    </button>
		                    <div class="dropdown-menu" role="menu" style="">
		                      <a class="dropdown-item action_edit" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Edit</a>
		                      <div class="dropdown-divider"></div>
		                      <a class="dropdown-item action_delete" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Delete</a>
		                    </div>
		                </div>
					</td>	
				</tr>
				<?php endwhile; ?>
			</tbody>
		</table>
	</div>
</div>

<script>
	$(document).ready(function(){
		$('.new_department').click(function(){
			uni_modal("New department","./department/manage_department.php")
		})
		$('.action_edit').click(function(){
			uni_modal("Edit department","./department/manage_department.php?id="+$(this).attr('data-id'));
		})
		$('.action_delete').click(function(){
		_conf("Are you sure to delete Department?","delete_department",[$(this).attr('data-id')])
		})
		$('table').dataTable();
	})
	function delete_department($id){
		start_loader()
		$.ajax({
			url:_base_url_+'classes/Master.php?f=delete_department',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					location.reload()
				}
			}
		})
	}
</script>