<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif; ?>
<?php
$academic_year_id= $_settings->userdata('academic_id');
$faculty_id= $_settings->userdata('faculty_id');

if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM lessons where id = {$_GET['id']}");
	foreach($qry->fetch_array() as $k =>$v){
		if(!is_numeric($k))
		$$k = $v;
	}
	if(isset($description))
	$description = html_entity_decode(stripslashes($description));
	$class_arr = array();
	$qry2 = $conn->query("SELECT * FROM lesson_class where lesson_id = {$_GET['id']}");
	while($row = $qry2->fetch_assoc()){
		$class_arr[] = $row['class_id'];
	}
}
?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title"></h3>
	</div>
	<div class="card-body">
		<div class="container-fluid">
			<form action="" id="manage-lesson">
				<input type="hidden" name="id" value="<?php echo isset($id) ? $id :'' ?>">
				<input type="hidden" name="faculty_id" value="<?php echo $faculty_id ?>">
				<input type="hidden" name="academic_year_id" value="<?php echo $academic_year_id ?>">
				<div class="form-group">
					<label for="" class="control-label">Title</label>
					<input type="text" class="form-control" name="title" value="<?php echo isset($title) ? $title : "" ?>" required="">
				</div>

				<div class="form-group">
					<label for="subject_id" class="control-label">Subject</label>
					<select name="subject_id" id="subject_id" class="custom-select custom-select-sm select2" required="">
						<option></option>
						<?php 
						$subject = $conn->query("SELECT * from subjects order by subject_code asc");
						while($row = $subject->fetch_assoc()):
						?>
							<option value="<?php echo $row['id'] ?>" <?php echo isset($subject_id) && $subject_id == $row['id'] ? 'selected' : '' ?>><?php echo $row['subject_code'].' - '.$row['description'] ?></option>
						<?php endwhile; ?>
					</select>
				</div>
				<div class="form-group">
					<label for="class_id" class="control-label">Class</label>
					<select name="class_ids[]" id="class_id" class="custom-select custom-select-sm select2" required="" multiple="multiple">
						<?php 
						$class = $conn->query("SELECT cs.*,d.department,CONCAT(co.course,' ',c.level,'-',c.section) as class,s.subject_code,s.description FROM class_subjects_faculty cs inner join class c on c.id = cs.class_id inner join subjects s on s.id = cs.subject_id inner join department d on d.id = c.department_id inner join course co on co.id = c.course_id where cs.faculty_id = '{$faculty_id}' and cs.academic_year_id = '{$academic_year_id}' group by cs.class_id ");
						while($row = $class->fetch_assoc()):
						?>
							<option value="<?php echo $row['class_id'] ?>" <?php echo isset($class_arr) && (in_array($row['class_id'],$class_arr)) ? 'selected' : '' ?>><?php echo $row['class'] ?></option>
						<?php endwhile; ?>
					</select>
				</div>
				<div class="form-group">
					<label for="" class="control-label">Description</label>
		             <textarea name="description" id="" cols="30" rows="10" class="form-control summernote"><?php echo isset($description) ? $description : ""; ?></textarea>
				</div>
				<div class="form-group">
					<label for="" class="control-label">Slide Images (<i>Exported from PPT</i>)</label>
					<input type="file" class="form-control" name="ppt_slide[]" multiple="" accept="image/x-png,image/gif,image/jpeg" required="">
				</div>
			</form>
		</div>
	</div>
	<div class="card-footer">
		<div class="col-md-12">
			<button class="btn btn-flat btn-primary" form="manage-lesson">Save</button>
			<a type="cutton" class="btn btn-flat btn-default" href="./?page=lesson">Cancel</a>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.select2').select2();
		 $('.summernote').summernote({
		        height: 200,
		        toolbar: [
		            [ 'style', [ 'style' ] ],
		            [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
		            [ 'fontname', [ 'fontname' ] ],
		            [ 'fontsize', [ 'fontsize' ] ],
		            [ 'color', [ 'color' ] ],
		            [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
		            [ 'table', [ 'table' ] ],
		            [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
		        ]
		    })

		 $('#manage-lesson').submit(function(e){
		 	e.preventDefault();
		 	start_loader();
		 	$.ajax({
				url:_base_url_+'classes/Master.php?f=save_lesson',
				data: new FormData($(this)[0]),
			    cache: false,
			    contentType: false,
			    processData: false,
			    method: 'POST',
			    type: 'POST',
				error:err=>{
					console.log(err)
					alert_toast('An error occured');
					end_loader();
				},
				success:function(resp){
					if(resp>0){
						location.href = "./?page=lesson/view_lesson&id="+resp;
					}else{
						alert_toast('An error occured');
						end_loader();
					}
				}
			})
		 })
	})
</script>