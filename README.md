# ot-jobs-portal

This project is a basic job portal with role-based and login-status-based views. Login has been implemented via the facebook API. 

## Architecture

The project is divided into 3 parts.

1. The operations service [ot-operations] - This service provides a REST API for CRUD operations for jobs.
2. The login service [ot-login] - The service provides a REST API for logging in a user, managing logged-in session and logging-out.
3. The frontend [ot-frontend] - This repository acts as a broker that uses the services to display the information in the frontend.