#Simple PHP Upload with MySQL Login

This script will allow for an upload of a file behind a login. 

##Installation

1. Place the contents of this folder on your webserver
2. Create a mySQL table with an id, username, password(MD5)
3. There is a file referenced in the index.php (require("../includes/functions.php");) all that file has is a mySQL database connection, you can see the code in my [php-mysql-connection-functions](https://github.com/rbjdbkilla/php-mysql-connect-functions) repo.
4. Change reference to 'table' in functions.php to your table 

