
$(document).ready(function(){
	
	var format_table = function(json){
        //console.log(json.jobs);
        if(!json.jobs)
            return [];
        else
        {
            var returnData = [];
            for ( var i=0, ien=json.jobs.length ; i<ien ; i++ ) {
                returnData[i] = [];
                returnData[i][0] = json.jobs[i].title;
                returnData[i][1] = json.jobs[i].start_date;
                returnData[i][2] = json.jobs[i].end_date;
                returnData[i][3] = json.jobs[i].is_active;
                returnData[i][4] = '<a href="/admin/jobs/update?id='+json.jobs[i].seo_title+'">Edit</a><br/>';
                if(json.jobs[i].is_active === '1')
                {
                	returnData[i][4] += '<a href="/admin/jobs/delete?id='+json.jobs[i].seo_title+'">Delete</a>';
                }
                
            }	
            //console.log(returnData);
            return returnData;
        }
    };

	$('#all_jobs_table').DataTable({
        "ajax": {
            "url": Config.BASE_URL + '/jobs?show_all=true',
            "dataSrc": format_table
        }
    });

    $("#create_job").click(function(){
    	window.location = Config.BASE_URL + '/admin/jobs/create';
    });


    $('#start_date').datetimepicker();
    $('#end_date').datetimepicker();


    $( "#jobs_create" ).on( "submit", function( event ) {
	  	event.preventDefault();
	  	var url_action = $(this).attr("action");
		$.ajax({
		    type: "POST",
		    url: Config.BASE_URL + url_action,
		    data: $( this ).serialize(),
		    success: function(data) {
		    	window.location = Config.BASE_URL + '/admin/jobs';
		    },
		    error: function() {
		        alert('error handing here');
		    }
		});
	});

});
