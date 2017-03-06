<?php ?>
<!DOCTYPE html>
<html lang="en">

    <?php include('admin_header.php') ?>

<body>

    <div id="wrapper">

        <?php include('admin_sidebar.php') ?>

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div>
                            <h1>Jobs</h1>
                            <button type="button" class="btn btn-primary navbar-btn" id="create_job">
                                Create New Job
                            </button> 
                        </div>
                        <br />
                        <table id="all_jobs_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Active</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

</body>

</html>