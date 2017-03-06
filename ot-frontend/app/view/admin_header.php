<head>

    <script src="//code.jquery.com/jquery-1.12.4.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>    
    <script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>   
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>    
    
    <script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
    <link rel="stylesheet" href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css"/>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />

    <?php if($is_admin): ?>
	<script type="text/javascript">
		var Config = (function() {
		    return {
		        BASE_URL: 'http://ot-jobs.com',
		        is_guest: <?php if($is_guest) {echo "true"; } else { echo "false"; } ?>,
		        is_admin: <?php if($is_admin) {echo "true"; } else { echo "false"; } ?>
		    }
		})();
	</script>
    <script src="http://ot-jobs.com/assets/admin.js"></script>
    <?php endif; ?>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>OT-Jobs Admin</title>

    <!-- Bootstrap Core CSS -->
    <link href="http://ot-jobs.com/assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="http://ot-jobs.com/assets/css/simple-sidebar.css" rel="stylesheet">

</head>