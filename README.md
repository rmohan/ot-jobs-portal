# ot-jobs-portal

This project is a basic job portal with role-based and login-status-based views. Login has been implemented via the facebook API. 

## Architecture

The project is divided into 3 parts.

1. The operations service [ot-operations] - This service provides a REST API for CRUD operations for jobs.
2. The login service [ot-login] - The service provides a REST API for logging in a user, managing logged-in session and logging-out.
3. The frontend [ot-frontend] - This repository acts as a broker that uses the services to display the information in the frontend.

The REST APIs use HTTP Basic Authentication. The operations and the login services, both require the Authorization header to be set. A guest-token is issued by the login-service, as soon as a user lands on the homepage. For all subsequent API requests, this guest-token is passed as the auth-user in the Authorization header.

### Login Service

The following API endpoints are available in the login service.

    POST /user/login 
    POST /user/logout
    GET /user/data
    GET /user/guest

A guest-token is generated and sent back to the frontend application that saves the token in the user's PHP session. This guest-token is also stored in a MySQL table which is essentially being used as a cache. Instead of a MySQL table, the ideal solution would be to use an in-memory cache like Redis. When a user logs in/signs-up, after the user's FB-authentication, the user-id is saved against the token in the MySQL table. To check whether a user is logged-in, this MySQL table is used and when a user logs out, the corresponding token and it's row are removed from the MySQL table. A new guest-token is generated post this. 

Note: The user-id is never shared with the front-end application. The operations service has to pass a special request parameter in the header to recieve the user-id corresponding to the token.

To Do:	
* Write a cron to delete the tokens which have been inactive for more than 10 minutes.
* Implement a refresh-token, using which a user's session can be refreshed/extended if the his guest-token has expired. The refresh-token would have a longer lifespan.
* Store signup_platform, user-details (gender, dob, city) and utm-source/utm-medium for the purpose of analytics.
* Admin panel for adding new roles and their access-controls.
* Improve exception handling

### Operations Service

The following API endpoints are available in the operations service.

    POST /jobs/create 
    POST /jobs/{seo_title}/update
    GET /jobs 
    GET /jobs/me               
    GET /jobs/{seo_title}
    DELETE /jobs/{seo_title}
    POST /jobs/{seo_title}/save
    POST /jobs/{seo_title}/unsave 

The POST and DELETE APIs have restricted access. Only users with role = admin can access these APIs. "Deleting" a job means that the 'is_active' status of the job row in the DB is set to 0. No job is actually deleted, so that the Admin has the history of all jobs that have been added ever. 

To Do:	
* Implement a Redis cache, to cache the results for GET /jobs/me, GET /jobs/{seo_title} and GET /jobs.
* Save a log of all changes made to the job table. This can help in keeping track of admin activity. Also, the cases where the same job is updated with a new start-date and end-date post it's expiration, this log can help track which user applied/saved the job during which period.
Alternatively, we can also never delete a particular job row. On update, only clone the existing row with new details.
* Write a cron to activate and schedule jobs.
* Implement attributes of job like company, years of experience, technologies, salary, job-type etc and filter based on them
* Improve exception handling

### Main frontend

To Do:
* Admin panel pages and save/unsave feature
* Separate header and include in home and admin-home 
* Minimize js and css
* Improve exception handling

## Built With

* [SLIM](https://www.slimframework.com/docs/) - A micro framework for PHP; primarily used for processing request and response and for sharing variables/dependencies between various components. The MVC with routing (all files except the vendor files) has been written from scratch. 
* [PHP-View](https://github.com/slimphp/PHP-View) - Used for rendering templates in ot-frontend.
* [Doctrine DBAL 2](http://docs.doctrine-project.org/projects/doctrine-dbal/en/latest/index.html) - Used interacting with database and query-building
* [Facebook PHP-SDK-v4](https://developers.facebook.com/docs/php/gettingstarted) - Used for user-authentication and login
* [Bootstrap 3](http://getbootstrap.com/getting-started/) - Used for front-end tabs, tables etc.


