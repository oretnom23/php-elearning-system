<?php 
require_once('../../config.php');
if(isset($_GET['id']) && !empty($_GET['id'])){
	$qry = $conn->query("SELECT * FROM students where id = {$_GET['id']}");
	foreach($qry->fetch_array() as $k => $v){
		if(!is_numeric($k)){
			$$k = $v;
		}
	}
}
?>
<form action="" id="student-frm">
	<div class="row">
		<div class="col-md-6">
			<div id="msg" class="form-group"></div>
			<input type="hidden" name='id' value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
			<div class="form-group">
				<label for="student_id" class="control-label">Student ID</label>
				<input type="text" class="form-control form-control-sm" name="student_id" id="student_id" value="<?php echo isset($student_id) ? $student_id : '' ?>" required>
			</div>
			<div class="form-group">
				<label for="firstname" class="control-label">First Name</label>
				<input type="text" class="form-control form-control-sm" name="firstname" id="firstname" value="<?php echo isset($firstname) ? $firstname : '' ?>" required>
			</div>
			<div class="form-group">
				<label for="lastname" class="control-label">Last Name</label>
				<input type="text" class="form-control form-control-sm" name="lastname" id="lastname" value="<?php echo isset($lastname) ? $lastname : '' ?>" required>
			</div>
			<div class="form-group">
				<label for="middlename" class="control-label">Middle Name</label>
				<input type="text" class="form-control form-control-sm" name="middlename" id="middlename" value="<?php echo isset($middlename) ? $middlename : '' ?>" placeholder="(optional)">
			</div>
			<div class="form-group mb-3">
				<label for="dob" class="control-label">Gender</label>
				<input type="date" name ="dob" class="form-control" id="dob" required="" value="<?php echo isset($dob) ? date("Y-m-d",strtotime($dob)) : '' ?>">
			</div>
			<div class="form-group">
				<label for="gender" class="control-label">Gender</label>
				<select name="gender" id="gender" class="custom-select">
				<option value="Male" <?php echo isset($gender) && $gender == 'Male' ? "selected" : '' ?>>Male</option>
				<option value="Female" <?php echo isset($gender) && $gender == 'Female' ? "selected" : '' ?>>Female</option>
				</select>
			</div>
			
		</div>
		<div class="col-md-6">
			<br>
			<div class="form-group">
				<label for="email" class="control-label">Email</label>
				<input type="text" class="form-control form-control-sm" name="email" id="email" value="<?php echo isset($email) ? $email : '' ?>" required>
			</div>
			<div class="form-group">
				<label for="contact" class="control-label">Contact #</label>
				<input type="text" class="form-control form-control-sm" name="contact" id="contact" value="<?php echo isset($contact) ? $contact : '' ?>" required>
			</div>
			<div class="form-group">
				<label for="address" class="control-label">Address</label>
				<textarea type="text" class="form-control form-control-sm" name="address" id="address" required ><?php echo isset($address) ? $address : '' ?></textarea>
			</div>
			<div class="form-group">
				<label for="" class="control-label">Image</label>
				<div class="custom-file">
		          <input type="file" class="custom-file-input rounded-circle" id="customFile" name="img" onchange="displayImg(this,$(this))">
		          <label class="custom-file-label" for="customFile">Choose file</label>
		        </div>
			</div>
			<div class="form-group d-flex justify-content-center">
				<img src="<?php echo validate_image(isset($image_path) ? $image_path : '') ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
			</div>
			<?php if(isset($id) && ($id > 0)): ?>
			<div class="form-group">
				<div class="icheck-primary">
					<input type="checkbox" id="resetP" name="preset">
					<label for="resetP">
						Check to reset password
					</label>
				</div>
			</div>
			<?php endif; ?>
		</div>
	</div>
</form>
<style>
	img#cimg{
		height: 15vh;
		width: 15vh;
		object-fit: cover;
		border-radius: 100% 100%;
	}
</style>
<script>
	function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}
	$(document).ready(function(){
		$('.select2').select2();
		$('#student-frm').submit(function(e){
			e.preventDefault()
			start_loader()
			if($('.err_msg').length > 0)
				$('.err_msg').remove()
			$.ajax({
				url:_base_url_+'classes/Master.php?f=save_student',
				data: new FormData($(this)[0]),
			    cache: false,
			    contentType: false,
			    processData: false,
			    method: 'POST',
			    type: 'POST',
				error:err=>{
					console.log(err)

				},
				success:function(resp){
				if(resp == 1){
					location.reload();
				}else if(resp == 2){
					var _frm = $('#student-frm #msg')
					var _msg = "<div class='alert alert-danger text-white err_msg'><i class='fa fa-exclamation-triangle'></i> Student ID already exists.</div>"
					_frm.prepend(_msg)
					_frm.find('input#student_id').addClass('is-invalid')
					$('[name="student_id"]').focus()
				}else{
					alert_toast("An error occured.",'error');
				}
					end_loader()
				}
			})
		})
	})
</script>