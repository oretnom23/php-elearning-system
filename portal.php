<style>
	.portial-icon {
	    font-size: 5rem;
	    height: 8.5rem;
	    width: 8.5rem;
	    align-items: center;
	    justify-content: center;
	    display: flex;
	    border: 4px solid #fffafadb;
	    color: #ffffffb8;
	}
	.portal-link{
		color:unset;
	}
	.portal-link:hover{
		color:unset;
	}
	.widget-user .widget-user-image {
		position: absolute;
		top: 50px;
		display: flex;
		justify-content: center;
		align-items: center;
		width: 100%;
		margin: unset;
		left: unset;
	}
	.portal-link .card:hover {
	    color: unset;
	    position: relative;
	    top: -3px;
	    box-shadow: 0 9px #0201010d;
	}
</style>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-md-4">
					<a href="<?php echo base_url.'admin' ?>" class="portal-link">
						<div class="card card-widget widget-user">
			              <!-- Add the bg color to the header using any of the bg-* classes -->
			              <div class="widget-user-header bg-info">
			                <h3 class="widget-user-username">Admin</h3>
			              </div>
			              <div class="widget-user-image">
			                <span class="img-circle elevation-2 fa fa-user-cog portial-icon"></span>
			              </div>
			              <div class="card-footer bg-info">
			                <div class="container">
			                	<p class="text-center text-white-50"><small><i>Click here to Admin Side</i></small></p>
			                </div>
			              </div>
			            </div>
					</a>
				</div>
				<div class="col-md-4">
					<a href="<?php echo base_url.'faculty' ?>" class="portal-link">
						<div class="card card-widget widget-user">
			              <!-- Add the bg color to the header using any of the bg-* classes -->
			              <div class="widget-user-header bg-info">
			                <h3 class="widget-user-username">Faculty</h3>
			              </div>
			              <div class="widget-user-image">
			                <span class="img-circle elevation-2 fa fa-user-tie portial-icon"></span>
			              </div>
			              <div class="card-footer bg-info">
			                <div class="container">
			                	<p class="text-center text-white-50"><small><i>Click here to Establishment Side</i></small></p>
			                </div>
			              </div>
			            </div>
					</a>
				</div>
				<div class="col-md-4">
					<a href="<?php echo base_url.'student' ?>" class="portal-link">
						<div class="card card-widget widget-user">
			              <!-- Add the bg color to the header using any of the bg-* classes -->
			              <div class="widget-user-header bg-info border-info">
			                <h3 class="widget-user-username">Student</h3>
			              </div>
			              <div class="widget-user-image">
			                <span class="img-circle elevation-2 fa fa-users portial-icon"></span>
			              </div>
			              <div class="card-footer bg-info border-info">
			                <div class="container">
			                	<p class="text-center text-white-50"><small><i>Click here to Signin or Register</i></small></p>
			                </div>
			              </div>
			            </div>
					</a>
				</div>
			</div>
		
		<div>
	</div>

	<section>
		<div class="col-lg-12">
			<h1 class="text-center">Welcome</h1>
			<hr class="border-info">
			<?php
			if(is_file(base_app.'welcome.html'))
			 include 'welcome.html' ;
			else{
				echo "Edit the About Content in admin panel.";
			}
			 ?>
		</div>
	</section>
</div>