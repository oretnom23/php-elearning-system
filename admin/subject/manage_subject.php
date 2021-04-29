<?php
include "../../initialize.php";
include "../../config.php";
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM subjects where id =".$_GET['id']);
	$data = $qry->fetch_array();
	foreach ($data as $key => $value) {
		$$key = $value;
	}
}
?>
<div class="container-fluid">
	<div class="col-lg-12">
		<div id="msg" class="form-group"></div>
		<form action="" id="manage_subject">
			<input type="hidden" name="id" value="<?php echo isset($id) ? $id : ''; ?>">
			<div class="form-group">
				<label for="subject_code" class="control-label">Subject Code</label>
				<input type="text" name="subject_code" id="subject_code" required class="form-control form-control-sm" value="<?php echo isset($subject_code) ? $subject_code : ''; ?>">
			</div>
			<div class="form-group">
				<label for="description" class="control-label">Description</label>
				<textarea name="description" id="description" cols="30" rows="3" class="form-control" required=""><?php echo isset($description) ? $description : ''; ?></textarea>
			</div>
		</form>
	</div>
</div>

<script>
	$(document).ready(function(){
		$('#manage_subject').submit(function(e){
			e.preventDefault();
			start_loader();
			$('#msg').html('')
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_subject",
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
					}else if(resp ==2){
						$('#msg').html('<span class="alert alert-danger w-fluid">subject already Exist.</span>')
						end_loader();
					}else{
						console.log(resp)
						end_loader();
					}
				}
			})

		})
	})
</script>