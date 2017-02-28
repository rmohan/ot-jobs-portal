# ot-jobs-portal

This project is a basic job portal with role-based and login-status-based views. Login has been implemented via the facebook API. 

## Architecture

The project is divided into 3 parts.

1. The operations service [ot-operations] - This service provides a REST API for CRUD operations for jobs.
2. The login service [ot-login] - The service provides a REST API for logging in a user, managing logged-in session and logging-out.
3. The frontend [ot-frontend] - This repository acts as a broker that uses the services to display the information in the frontend.

## Built With
* [SLIM](https://www.slimframework.com/docs/) - a micro framework for PHP. Primarily used for processing request and response and for sharing variables/dependencies between various components. The MVC with routing (all files except the vendor files) has been written from scratch. 
* [PHP-View](https://github.com/slimphp/PHP-View) - Used for rendering templates in ot-frontend.
* [Doctrine DBAL 2](http://docs.doctrine-project.org/projects/doctrine-dbal/en/latest/index.html) - Used interacting with database and query-building