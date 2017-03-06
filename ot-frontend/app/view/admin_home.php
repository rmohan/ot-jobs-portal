<?php ?>
<!DOCTYPE html>
<html lang="en">

<?php include('admin_header.php') ?>
<?php if($is_admin): ?>
	<body>

	    <div id="wrapper">

	        <?php include('admin_sidebar.php') ?>

	        <!-- Page Content -->
	        <div id="page-content-wrapper">
	            <div class="container-fluid">
	                <div class="row">
	                    <div class="col-lg-12">
	                        <h1>Dashboard</h1>
	                        <p> Total number of active jobs: <?= (isset($job_count))? $job_count : ''; ?></p>
	                    </div>
	                </div>
	            </div>
	        </div>
	        <!-- /#page-content-wrapper -->

	    </div>
	    <!-- /#wrapper -->

	</body>
<?php endif; ?>
</html>