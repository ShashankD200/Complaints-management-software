 Requirements: 

- Ensure that XAMPP is installed on your machine.

 How to Run the App: 

1. Copy the entire folder and paste it into the 'xampp/htdocs/' directory.
2. Start the XAMPP control panel and initiate Apache and MySQL servers.
3. Open the MySQL database, create a new database, and note down the database name.
4. Import the provided SQL file located in the 'sql/' folder into the newly created database.
5. In the 'backend/config.php' file, update the `$database` variable with your database name.
6. Adjust the values of `$servername`, `$username`, and `$password` in the config.php file according to your system.
7. The project is now set up. Open Chrome and enter the URL 'http://localhost/complaints-management-system/' (modify if needed).
8. Optionally, update the 'sendmail.php' file in 'backend/mailer_code/' with your email and app password.

 Folder Structure: 

-  Backend:  Manages all backend operations, including admin, login/signup, and user activities.
  -  Admin:  Handles backend functions for admin.
  -  Login_Signup:  Manages login and signup activities.
  -  User:  Manages user activities.

-  Frontend:  Manages the entire frontend of the project.
  -  Admin:  Contains files related to admin functionality.
  -  User:  Contains files related to user functionality.

-  SQL:  Contains the SQL file for database setup.

 Live Example: 

-  Admin Credentials:  
  - Email: superadmin@gmail.com 
  - Password: Admin@123

-  User Credentials: 
  - Email: amar@gmail.com
  - Password: Test@123
