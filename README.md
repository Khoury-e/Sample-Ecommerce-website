# Sample-Ecommerce-website
Sample of an ecommerce website for men products

# Tech Stack
* HTML
* CSS
* JavaScript
* PHP
* MySQL

# Run project
To run the project, you need to have either XAMPP, WAMP, or MAMP on your device, as well as MySQL. Once these are installed on your device, pull this repository on your laptop and place the files in the correct folder in either XAMPP, MAMP, or WAMP. 
Run the apache server, and mysql. Go to localhost:[PortNumber] and the website would appear

# Configuration
Open your MySQL database manager (DBeaver, MySQL workbench, etc...) and set the port number of the database, I had set it to the default MySQL port 3306. Then go to the apache server and do the same. After that, create a groomifydb database. Go to the php files in the project and change this code:
`$host = "127.0.0.1";
    $username = "root";
    $password = "";
    $db = "groomifydb";`
to your configuration. Host refers to the ip of your server/computer, username and password should match the one of your database, and the db variable is the name of your database. In my case I am hosting the website on localhost with my root mysql user and the groomifydb database
