<?php 
require_once('../../config.php');
$faculty_id = $_GET['faculty_id'];
$qry = $conn->query("SELECT *,CONCAT(class_id,'_',subject_id) as class_subj FROM `class_subjects_faculty` where faculty_id = '$faculty_id' ");
$class_subj_arr = array();
while($row= $qry->fetch_assoc()){
	$class_subj_arr[] = $row['class_subj'];
}

$academic_year_id = isset($academic_year_id) ? $academic_year_id : $_settings->userdata('academic_id');

?>
<div class="container-fluid">
	<div class="col-md-12">
		<form action="" id="manage_class">
			<input type="hidden" name="faculty_id" value="<?php echo isset($faculty_id) ? $faculty_id : ''; ?>">
			<input type="hidden" name="academic_year_id" value="<?php echo isset($academic_year_id) ? $academic_year_id : ''; ?>">
			<div class="form-group">
				<label for="class_subj" class="control-label">Class</label>
				<select name="class_subj[]" id="class_subj" class="custom-select custom-select-sm select2" required="" multiple="multiple">
					<?php 
					$class = $conn->query("SELECT *,concat(co.course,' ',c.level,'-',c.section,' [',s.subject_code,']') as subj FROM class_subjects cs inner join class c on c.id = cs.class_id inner join subjects s on cs.subject_id = s.id inner join course co on co.id = c.course_id");
					while($row = $class->fetch_assoc()):
					?>
						<option value="<?php echo $row['class_id']."_".$row['subject_id'] ?>" <?php echo isset($class_subj_arr) && (in_array($row['class_id']."_".$row['subject_id'], $class_subj_arr)) ? 'selected' : '' ?>><?php echo $row['subj'] ?></option>
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
				url:_base_url_+"classes/Master.php?f=faculty_class",
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