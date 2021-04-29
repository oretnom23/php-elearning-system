<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif; ?>
<div class="card card-outline cardprimary w-fluid">
	<div class="card-header">
		<h3 class="card-title">My Class List</h3>
		<div class="card-tools">
			<a class="btn btn-block btn-sm btn-default btn-flat border-primary new_class" href="javascript:void(0)"><i class="fa fa-plus"></i> Add New Lesson</a>
		</div>
	</div>
	<div class="card-body">
		<table class="table table-bordered table-compact table-stripped">
			<thead>
				<tr>
					<th>#</th>
					<th>Department</th>
					<th>Class</th>
					<th>Subject</th>
					<!-- <th>Action</th> -->
				</tr>
			</thead>
			<tbody>
				<?php 
				$i =1;
				$academic_year_id= $_settings->userdata('academic_id');
				$faculty_id= $_settings->userdata('faculty_id');

				$qry = $conn->query("SELECT cs.*,d.department,CONCAT(co.course,' ',c.level,'-',c.section) as class,s.subject_code,s.description FROM class_subjects_faculty cs inner join class c on c.id = cs.class_id inner join subjects s on s.id = cs.subject_id inner join department d on d.id = c.department_id inner join course co on co.id = c.course_id where cs.faculty_id = '{$faculty_id}' and cs.academic_year_id = '{$academic_year_id}' ");
				while($row=$qry->fetch_assoc()):
				?>
				<tr>
					<td><?php echo $i++ ?></td>
					<td><?php echo $row['department'] ?></td>
					<td><?php echo $row['class'] ?></td>
					<td><span class="truncate"><?php echo $row['subject_code'] . ' - '. $row['description'] ?></span></td>
					<!-- <td class="text-center">
						<div class="btn-group">
		                    <button type="button" class="btn btn-default btn-block btn-flat dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown" aria-expanded="false">
		                    	Action
		                      <span class="sr-only">Toggle Dropdown</span>
		                    </button>
		                    <div class="dropdown-menu" role="menu" style="">
	                    	 <a class="dropdown-item action_load" href="javascript:void(0)" data-id="<?php echo $row['class_id'].'_'.$row['subject_id'] ?>">View Lesson</a>
		                    </div>
		                </div>
					</td>	 -->
				</tr>
				<?php endwhile; ?>
			</tbody>
		</table>
	</div>
</div>

<script>
	$(document).ready(function(){
		$('.new_class').click(function(){
			uni_modal("New Class","./class/manage_class.php")
		})
		$('.action_edit').click(function(){
			uni_modal("Edit Class","./class/manage_class.php?id="+$(this).attr('data-id'));
		})
		$('.action_load').click(function(){
			uni_modal("Load Class Subjects","./class/load_subject.php?id="+$(this).attr('data-id'));
		})
		$('.action_delete').click(function(){
		_conf("Are you sure to delete class?","delete_class",[$(this).attr('data-id')])
		})
		$('table').dataTable();
	})
	function delete_class($id){
		start_loader()
		$.ajax({
			url:_base_url_+'classes/Master.php?f=delete_class',
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