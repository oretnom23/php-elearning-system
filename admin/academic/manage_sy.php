<?php
include "../../initialize.php";
include "../../config.php";
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM academic_year where id =".$_GET['id']);
	$data = $qry->fetch_array();
	foreach ($data as $key => $value) {
		$$key = $value;
	}
}
?>
<div class="container-fluid">
	<div class="col-lg-12">
		<div id="msg" class="form-group"></div>
		<form action="" id="manage_sy">
			<input type="hidden" name="id" value="<?php echo isset($id) ? $id : ''; ?>">
			<div class="form-group">
				<label for="sy" class="control-label">School Year</label>
				<input type="text" name="sy" id="sy" required class="form-control form-control-sm" value="<?php echo isset($sy) ? $sy : ''; ?>">
			</div>
			<div class="form-group">
				<label for="status" class="control-label">Status</label>
				<select name="status" id="status" class="form-control form-control-sm" required="">
					<option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>Active</option>
					<option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Inactive</option>
				</select>
			</div>
		</form>
	</div>
</div>

<script>
	$(document).ready(function(){
		$('#manage_sy').submit(function(e){
			e.preventDefault();
			start_loader();
			$('#msg').html('')
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_academic",
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
						$('#msg').html('<span class="alert alert-danger w-fluid">School Year already Exist.</span>')
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