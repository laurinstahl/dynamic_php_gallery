<? 
/*
Here you have to specify your Database credentials.
$dbhost usually is localhost
$dbuser is your database username
$dbpass is the password of your database user
$dbname is the name of your database
*/
//Database Info
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'root';
$dbname = 'missgenerator';

$connect = mysql_connect($dbhost, $dbuser, $dbpass) or die ;
mysql_select_db($dbname);



?>