<?
include('connect.php'); 
//Querys
$query = "SELECT * FROM galerie WHERE id = '1'";

//Results
$result = mysql_query($query);

//Arrays
$array = mysql_fetch_assoc($result);

//Variable, does something in case of upload
$upload = "";	//will be set on true in case of upload

//In case of button press "change / submit"
if (isset($_POST['submit'])) {
					
	//Defines variables as entries, closes connection if a field is empty
	if ($_POST['number_columns'] !== "") { $number_columns = $_POST['number_columns'];}
	else {	
			echo "You did not specify the number of columns";
			die($connect);
		 }
	if ($_POST['number_rows'] !== "") { $number_rows = $_POST['number_rows'];}
	else {	
			echo "You did not specify the number of rows";
			die($connect);
		 }
	if ($_POST['width_pic'] !== "") { $width_pic = $_POST['width_pic'];}
	else {	
			echo "You did not specify the width of a picture";
			die($connect);
		 }
	if ($_POST['width_column'] !== "") { $width_column = $_POST['width_column'];}
	else {	
			echo "You did not specify the width of a column";
			die($connect);
		 }
	if ($_POST['height_row'] !== "") { $height_row = $_POST['height_row'];}
	else {	
			echo "You did not specify the height of a row";
			die($connect);
		 }

	//Save entries in database
	mysql_query("UPDATE galerie
					set number_columns = '$number_columns',
						number_rows = '$number_rows',
						width_pic = '$width_pic',
						width_column = '$width_column',
						height_row = '$height_row'
						WHERE id = '1'");
	
	//Reload page
	$page = $_SERVER['PHP_SELF'];
	$sec = "0";
	header("Refresh: $sec; url=$page");
}

?>
<html>
	<center>
	<form action="admin.php" method="POST">
		<div>
			Number of columns
			<input type="text" name="number_columns" value="<?echo $array['number_columns'];?>">
		</div>
		
		<div>
			Number of rows
			<input type="text" name="number_rows" value="<?echo $array['number_rows'];?>">
		</div>
		
		<div>
			Width of a picture
			<input type="text" name="width_pic" value="<?echo $array['width_pic'];?>">px
		</div>
		
		<div>
			Width of a column
			<input type="text" name="width_column" value="<?echo $array['width_column'];?>">
		</div>
					
		<div>
			Height of a row
			<input type="text" name="height_row" value="<?echo $array['height_row'];?>">
		</div>
			
		<div>
			<input type="submit" name="submit" value="Change settings">
		<div>
	</form>
	<div>
	<form action="admin.php" method="post" enctype="multipart/form-data">
		Choose an image file<br>
		<input name="file" type="file" size="50" accept="image/*"><br>
		<input type="submit" value="Upload" name="upload"> 
	</form>
		<?
		if($upload == "false"){
			echo "Please upload a .jpg, .png or .gif file.";
		}
		if($upload == "false2"){
			echo "The file size may not exceed 4MB";
		}
		
		//On button press "upload"
		if (isset($_POST['upload'])) {
			$upload = "true";
			if(isset($_FILES['file']['type']))
				{
					if($_FILES['file']['size'] < 4096000)
					{
			
							if($_FILES['file']['type'] == "image/jpeg")
							{
								move_uploaded_file($_FILES['file']['tmp_name'], "pictures/".$_FILES['file']['name']);
								echo "The pictures has been uploaded to pictures/".$_FILES['file']['name']."";
							}
							elseif($_FILES['file']['type'] == "image/png")
							{
								move_uploaded_file($_FILES['file']['tmp_name'], "pictures/".$_FILES['file']['name']);
								echo "The pictures has been uploaded to pictures/".$_FILES['file']['name']."";
							}
							elseif($_FILES['file']['type'] == "image/gif")
							{
								move_uploaded_file($_FILES['file']['tmp_name'], "pictures/".$_FILES['file']['name']);
								echo "The pictures has been uploaded to pictures/".$_FILES['file']['name']."";
							}
							else {	$upload = "false"; }
							
					}
					else{	$upload = "false2";	}
				}
			else{}
		}
		else {}
		?>
	</div>	
	</center>
</html>