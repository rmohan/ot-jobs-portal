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
                            <h1> Create New Job</h1>
                        </div>
                        <br />
                        <div>
                            <form id="jobs_create" action="<?php if(isset($action)) echo $action; ?>" method="post">
                              <div class="form-group">
                                <label for="title">Title</label>
                                <input class="form-control" name="job[title]" value="<?php if(isset($job['title'])) echo $job['title']; ?>">
                              </div>
                              <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" name="job[description]" rows="3"><?php if(isset($job['description'])) echo $job['description']; ?></textarea>
                              </div>
                              <div class="form-group row">
                                  <label for="start_date" class="col-lg-2 col-form-label">Start Date</label>
                                  <div class="col-lg-4">
                                    <input type="text" class="form-control" id='start_date' value="<?php if(isset($job['start_date'])) echo date('m/d/Y H:i:s', strtotime($job['start_date'])); ?>" name="job[start_date]">
                                  </div>
                                  <label for="end_date" class="col-lg-2 col-form-label">End Date</label>
                                  <div class="col-lg-4">
                                    <input class="form-control" id='end_date' value="<?php if(isset($job['end_date'])) echo date('m/d/Y H:i:s', strtotime($job['end_date'])); ?>" type="text" name="job[end_date]">
                                  </div>
                              </div>
                              <div class="form-group">
                                <label for="landing_page_url">Landing Page URL</label>
                                <input class="form-control" value="<?php if(isset($job['landing_page_url'])) echo $job['landing_page_url']; ?>" name="job[landing_page_url]">
                              </div>

                              <div class="form-group row">
                                <div class="col-lg-2">
                                    <label for="priority">Priority</label>
                                    <input class="form-control" value="<?php if(isset($job['priority'])) echo $job['priority']; ?>" name="job[priority]">
                                </div>
                              </div>
                              <input type="hidden" name="job[seo_title]" value="<?php if(isset($job['seo_title'])) echo $job['seo_title']; ?>">
                              <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

</body>

</html>