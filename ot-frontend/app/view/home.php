<?php ?>
<html>
<head>
	<script src="//code.jquery.com/jquery-1.12.4.js"></script>
	<script type="text/javascript">
		var Config = (function() {
		    return {
		        BASE_URL: 'http://ot-jobs.com',
		        is_guest: <?php if($is_guest) {echo "true"; } else { echo "false"; } ?>,
		        is_admin: <?php if($is_admin) {echo "true"; } else { echo "false"; } ?>
		    }
		})();
	</script>
	<title>OT-Jobs</title>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css"/>
	<script src="../../assets/app.js"></script>
	<!--<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
	<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>  
	<style type="text/css">
		.main-ctr
		{
			margin-right: auto; margin-left: auto; width: 1170px;
		}

		.navbar-btn
		{
			margin: 8px;
		}
		.tab-content
		{
			margin: 30px 10px 10px 10px;
		}

		#all_jobs_table, #my_jobs_table
		{
			font-family: "Helvetica Neue",Helvetica,Arial,sans-serif !important;
    		font-size: 14px !important;
		}

		.row-title
		{
			font-weight: 200;
		    margin-bottom: 10px;
		    display: block;
		}
	</style>
</head>
<body>
	<div class="main-ctr">
		<nav class="navbar navbar-default">
			<div class="navbar-header">
				<a class="navbar-brand">
					<?php if($is_guest) {
						echo "Welcome! New here? Sign up & Begin!"; 
					} else { 
						echo "Welcome, ".$user_data['name']."!"; 
					} ?>
				</a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-right">
					<?php if($is_admin): ?>				  
						<li>
							<button type="button" class="btn btn-primary navbar-btn" id="admin">
								View Admin
						    </button>
						</li>		
					<?php endif; ?>				  			
				  <li>
				  	<?php if($is_guest): ?>
						<button type="button" class="btn btn-primary navbar-btn login-btn" id="facebook-sign-in">
							Login With Facebook
			            </button>
					<?php else: ?>
						<button type="button" class="btn btn-primary navbar-btn" id="log-out">
			                Logout
			            </button> 
					<?php endif; ?>
				  </li>
				</ul>
			</div>
		</nav>
		<div>	
			<div style="height: 30px; display: block;">&nbsp;</div>

			<ul class="nav nav-tabs" role="tablist">
				<li class="active">
					<a href="#tab_all_jobs" data-toggle="tab" aria-expanded="true">All Jobs</a>
				</li>
			<?php if(!$is_guest): ?>	
				<li class="">
					<a href="#tab_my_jobs" data-toggle="tab" aria-expanded="false">My Saved Jobs</a>
				</li>
			<?php endif; ?>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab_all_jobs">
					<table id="all_jobs_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
			            <thead>
			                <tr>
			                    <th>All Jobs</th>
			                    <?php if(!$is_guest): ?>
			                    	<th>Action</th>
			                	<?php endif; ?>
			                </tr>
			            </thead>

			        </table>	
				</div>
			<?php if(!$is_guest): ?>					
				<div class="tab-pane" id="tab_my_jobs">
					<table id="my_jobs_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
			            <thead>
			                <tr>
			                    <th>My Jobs</th>
		                    	<th>Action</th>
			                </tr>
			            </thead>

			        </table>
				</div>
			<?php endif; ?>
			</div>
		</div>
	</div>
</body>
</html>