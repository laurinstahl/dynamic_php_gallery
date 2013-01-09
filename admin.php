<?
include('connect.php'); 
//Querys
$query = "SELECT * FROM galerie WHERE id = '1'";

//Results
$result = mysql_query($query);

//Arrays
$array = mysql_fetch_assoc($result);

//Variable, die ausgibt ob Upload erfolgt
$upload = "";	//wird später auf true gesetzt

//Wenn ändern gedrückt wurde
if (isset($_POST['absenden'])) {
					
	//Definiert die Einträge, bricht ab wenn was nicht eingetragen wurde
	if ($_POST['width_table'] !== "") { $width_table = $_POST['width_table'];}
	else {	
			echo "Es wurde keine Spaltenzahl eingetragen";
			die($connect);
		 }
	if ($_POST['height_table'] !== "") { $height_table = $_POST['height_table'];}
	else {	
			echo "Es wurde keine Zeilenzahl eingetragen";
			die($connect);
		 }
	if ($_POST['width_pic'] !== "") { $width_pic = $_POST['width_pic'];}
	else {	
			echo "Es wurde keine Bildbreite eingetragen";
			die($connect);
		 }
	if ($_POST['width_spalt'] !== "") { $width_spalt = $_POST['width_spalt'];}
	else {	
			echo "Es wurde keine Spaltbreite eingetragen";
			die($connect);
		 }
	if ($_POST['height_zeile'] !== "") { $height_zeile = $_POST['height_zeile'];}
	else {	
			echo "Es wurde keine Zeilenh&ouml;he eingetragen";
			die($connect);
		 }

	//Einträge in die DB speichern
	mysql_query("UPDATE galerie
					set width_table = '$width_table',
						height_table = '$height_table',
						width_pic = '$width_pic',
						width_spalt = '$width_spalt',
						height_zeile = '$height_zeile'
						WHERE id = '1'");
	
	//Seite neuladen
	$page = $_SERVER['PHP_SELF'];
	$sec = "0";
	header("Refresh: $sec; url=$page");
	
}
			
?>
<html>
	<center>
	<form action="admin.php" method="POST">
		<div>
			Spalten
			<input type="text" name="width_table" value="<?echo $array['width_table'];?>">
		</div>
		
		<div>
			Zeilen
			<input type="text" name="height_table" value="<?echo $array['height_table'];?>">
		</div>
		
		<div>
			Bildbreite
			<input type="text" name="width_pic" value="<?echo $array['width_pic'];?>">px
		</div>
		
		<div>
			Spaltenbreite
			<input type="text" name="width_spalt" value="<?echo $array['width_spalt'];?>">
		</div>
					
		<div>
			Zeilenhoehe
			<input type="text" name="height_zeile" value="<?echo $array['height_zeile'];?>">
		</div>
			
		<div>
			<input type="submit" name="absenden" value="Einstellungen &uuml;bernehmen">
		<div>
	</form>
	<div>
		<?
		if($upload == "false"){
			echo "<div style=position: absolute;top:50%;>Bitte nur Bilder im .gif, .jpg oder .png Format hochladen</div>";
		}
		if($upload == "false2"){
			echo "<div style=position: absolute;top:50%;>Das Bild darf nicht größer als 4 MB sein</div>";
		}
		
		//Wenn hochladen gedrückt wurde
		if (isset($_POST['upload'])) {
			$upload = "true";
			if(isset($_FILES['datei']['type']))
				{
					if($_FILES['datei']['size'] < 4096000)
					{
			
							if($_FILES['datei']['type'] == "image/jpeg")
							{
								move_uploaded_file($_FILES['datei']['tmp_name'], "../galerie/bilder/".$_FILES['datei']['name']);
								echo "Das Bild wurde Erfolgreich nach ../galerie/bilder/".$_FILES['datei']['name']." hochgeladen";
							}
							elseif($_FILES['datei']['type'] == "image/png")
							{
								move_uploaded_file($_FILES['datei']['tmp_name'], "../galerie/bilder/".$_FILES['datei']['name']);
								echo "Das Bild wurde Erfolgreich nach ../galerie/bilder/".$_FILES['datei']['name']." hochgeladen";
							}
							elseif($_FILES['datei']['type'] == "image/gif")
							{
								move_uploaded_file($_FILES['datei']['tmp_name'], "../galerie/bilder/".$_FILES['datei']['name']);
								echo "Das Bild wurde Erfolgreich nach ../galerie/bilder/".$_FILES['datei']['name']." hochgeladen";
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