<?php 
require_once('../../config.php');
$student_id = $_GET['student_id'];
$qry = $conn->query("SELECT * FROM `student_class` where student_id = '$student_id' ");
if($qry->num_rows > 0){
	$data = $qry->fetch_array();
	foreach ($data as $key => $value) {
		$$key = $value;
	}
}
$academic_year_id = isset($academic_year_id) ? $academic_year_id : $_settings->userdata('academic_id');

?>
<div class="container-fluid">
	<div class="col-md-12">
		<form action="" id="manage_class">
			<input type="hidden" name="id" value="<?php echo isset($id) ? $id : ''; ?>">
			<input type="hidden" name="student_id" value="<?php echo isset($student_id) ? $student_id : ''; ?>">
			<input type="hidden" name="academic_year_id" value="<?php echo isset($academic_year_id) ? $academic_year_id : ''; ?>">
			<div class="form-group">
				<label for="class_id" class="control-label">Class</label>
				<select name="class_id" id="class_id" class="custom-select custom-select-sm select2" required="">
					<?php 
					$class = $conn->query("SELECT c.*,d.department, CONCAT(co.course, ' ', c.level, '-',c.section) as class FROM class c inner join department d on d.id = c.department_id inner join course co on co.id = c.course_id order by d.department asc, CONCAT(co.course, ' ', c.level, '-',c.section) asc");
					while($row = $class->fetch_assoc()):
					?>
						<option value="<?php echo $row['id'] ?>" <?php echo isset($class_id) && $class_id == $row['id'] ? 'selected' : '' ?>><?php echo $row['class'] ?></option>
					<?php endwhile; ?>
				</select>
			</div>
		</form>
	</div>
</div>


<script>
	$(document).ready(function(){
		$('.select2').select2();
		$('#manage_class').submit(function(e){
			e.preventDefault();
			start_loader();
			$('#msg').html('')
			$.ajax({
				url:_base_url_+"classes/Master.php?f=student_class",
				method:"POST",
				data:$(this).serialize(),
				error:err=>{
					console.log(err)
					alert_toast("An error occured.","error")
					end_loader();
				},
				success:function(resp){
					if(resp == 1){
						location.reload()
					}else{
						console.log(resp)
						end_loader();
					}
				}
			})

		})
	})
</script>