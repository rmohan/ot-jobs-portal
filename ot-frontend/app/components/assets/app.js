

var socialLogin = (function () {

    function facebookPopup() {
        socialPopup('facebook');
    }

    function googlePopup() {
        socialPopup('google');
    }

    function socialPopup(param) {
        var url = Config.BASE_URL + '/login/' + param;
        window.open(url, '_blank', 'height=500, width=600, status=yes, toolbar=no, menubar=no, location=no,addressbar=no');
    }

    function logOut()
    {
        $.post(Config.BASE_URL + '/logout', [],
            function (data) {
               console.log(data);
                if (data.success == 'true') {
                    location.reload();
                }
                else {
                        alert('Logout failed');
                    }
            }, "json"
        );        
    }

    function setFacebookAccessToken(accessToken) {
        // Ajax Request for Facebook Login
        var post_data = {
            source: 'facebook',
            social_access_token: accessToken
        };

        if(post_data.social_access_token == '')
        {
            alert('Unable to login');
        }

        $.post(Config.BASE_URL + '/login', post_data,
                function (data) {
                   console.log(data);
                    if (data.success == 'true') {
                        location.reload();
                    }
                    else {
                            alert('Login failed');
                        }
                }, "json"
            );
        }

    return {
        facebookPopup: facebookPopup,
        socialPopup: socialPopup,
        googlePopup: googlePopup,
        logOut: logOut,
        setFacebookAccessToken: setFacebookAccessToken
    };

})();

function init() {    
    $('#facebook-sign-in').click(socialLogin.facebookPopup);
    $('#log-out').click(socialLogin.logOut);

    var format_table = function(json){
        //console.log(json.jobs);
        if(!json.jobs)
            return [];
        else
        {
            var returnData = [];
            for ( var i=0, ien=json.jobs.length ; i<ien ; i++ ) {
                returnData[i] = [];
                returnData[i][0] = '<span class="row-title">'+json.jobs[i].title+'</span><p>'+ json.jobs[i].description+'</p>';
            }
            //console.log(returnData);
            return returnData;
        }
    };

    $('#all_jobs_table').DataTable({
        "ajax": {
            "url": "http://ot-jobs.com/jobs",
            "dataSrc": format_table
        }
    });
    
    if(!Config.is_guest)
    {
        $('#my_jobs_table').DataTable({
            "ajax": {
                "url": "http://ot-jobs.com/jobs/me",
                "dataSrc": format_table
            }
        });        
    }

    $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
        $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
    } );

}

$(document).ready(init);
