<?
include('connect.php');
if(isset($_POST['install']))
	{
	
	$dbhost = $_POST['dbhost'];
	$dbuser = $_POST['dbuser'];
	$dbpass = $_POST['dbpass'];
	$dbname = $_POST['dbname'];
	
	$connect = mysql_connect($dbhost, $dbuser, $dbpass) or die ;
	mysql_select_db($dbname);
	
	
	mysql_query("CREATE TABLE `galerie` (
	  `id` int(11) NOT NULL DEFAULT '1',
	  `width_pic` varchar(10) DEFAULT NULL,
	  `number_columns` varchar(10) DEFAULT NULL,
	  `number_rows` varchar(10) DEFAULT NULL,
	  `width_column` int(11) NOT NULL,
	  `height_row` int(11) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
	mysql_query("INSERT INTO `galerie` (`id`, `width_pic`, `number_columns`, `number_rows`, `width_column`, `height_row`) VALUES
	(1, '60', '2', '2', 9, 2);");
	}
?>
<html>
	<center>
		<form method="POST" action="install.php">
			<div>Your host:<input type="text" name="dbhost" value="<? echo $dbhost; ?>"/></div>
			<div>Username:<input type="text" name="dbuser" value="<? echo $dbuser; ?>"/></div>
			<div>Password:<input type="text" name="dbpass" value="<? echo $dbpass; ?>"/></div>
			<div>DB Name: <input type="text" name="dbname" value="<? echo $dbname; ?>"/></div>
		<input type="submit" name="install" value="Install">
		</form>
		<b>Please note:</b> If you change anything here, it will not change the values in your connect.php. You will need to change them manually!<br><br>
	
		<?
			if(isset($_POST['install'])) {
				$query = mysql_query("SELECT * FROM galerie WHERE id = 1");
				$result = mysql_fetch_array($query);
				if(!empty($result)) {
					?><div>Installation complete</div><? 
				}
				else {
					?><div>Something went wrong. Please check your login credentials</div><?
				}
			}
		?>
		<br><br><a href="index.php">To the gallery</a>
	</center>
</html>
