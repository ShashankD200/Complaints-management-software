Requirements To run this app :

-Your machine must have xampp installed on it.

How to run the app :

-Copy this complete folder into xampp/htdocs/
-Now start the xampp control panel and start apache, MySQL server
-Now open MySQL database, then create a new database and copy the database name
-Inside this database import the sql file that is provided in this folder /sql/
-Now in this folder structure open the backend/config.php file and change name of $database with your database name
-In you config.php file required variables $servername,$username and $password is added. Please change them according to your system.
-Now project is ready to run, open the chrome and paste the URL http://localhost/complaints-management-system/  or according to machine you may need to change this.
-Further you can update sendmail.php (backend/mailer_code/sendmail.php) file with you email and app password 

Folder structure:
-Backend folder handle all the backend work. In backend folder there are admin folder(That manage the backend for admin), login_signup folder(That manage login and signup activity), and user folder (that manage the user activity)
-Frontend folder handle all the frontend of the project inside this there are admin folder (All the files related to admin), user folder (all the files related to user)
-SQL folder contains the sql file for the database

Live Example:

- Credentials for Admin : email - superadmin@gmail.com  password - Admin@123
- Credentials for user : email - amar@gmail.com  password - Test@123

