<?php 
require_once('../../config.php');

$class_id = $_GET['id'];
$academic_year_id = $_settings->userdata('academic_id');
$subject_arr= array();
$qry = $conn->query("SELECT * FROM class_subjects where academic_year_id = '{$academic_year_id}' and class_id='{$class_id}' ");
while($row = $qry->fetch_assoc()){
	$subject_arr[] = $row['subject_id'];
}

?>
<div class="container-fluid">
	<div class="col-md-12">
		<form action="" id="manage_class_subject">
			<input type="hidden" name="class_id" value="<?php echo isset($class_id) ? $class_id : ''; ?>">
			<input type="hidden" name="academic_year_id" value="<?php echo isset($academic_year_id) ? $academic_year_id : ''; ?>">
			<div class="form-group">
				<label for="subject_id" class="control-label">Class</label>
				<select name="subject_id[]" id="subject_id" class="custom-select custom-select-sm select2" required="" multiple="multiple">
					<?php 
					$subject = $conn->query("SELECT * FROM subjects");
					while($row = $subject->fetch_assoc()):
					?>
						<option value="<?php echo $row['id'] ?>" <?php echo isset($subject_arr) && (in_array($row['id'], $subject_arr)) ? 'selected' : '' ?>><?php echo $row['subject_code'] . " - ".$row['description'] ?></option>
					<?php endwhile; ?>
				</select>
			</div>
		</form>
	</div>
</div>


<script>
	$(document).ready(function(){
		$('.select2').select2();
		$('#manage_class_subject').submit(function(e){
			e.preventDefault();
			start_loader();
			$('#msg').html('')
			$.ajax({
				url:_base_url_+"classes/Master.php?f=load_class_subject",
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