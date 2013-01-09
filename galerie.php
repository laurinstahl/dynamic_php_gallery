<html><nobr><div>
<?
include('connect.php');

//Querys
$query = "SELECT * FROM galerie WHERE id = '1'";

//Results
$result = mysql_query($query);

//Arrays
$array = mysql_fetch_assoc($result);//Array, das die Daten aus der Datenbank enthält
$array_seitenzahl = array(1);		//Array das später benötigt wird, enthält Seitenzahlen


//Daten, die in Datenbank definiert sind
$width = $array['number_columns'];			//Anzahl der Bilder in der Breite
$height = $array['number_rows'];		//Anzahl der Bilder in der Höhe
$anzahl_bilder = $width*$height;		//Anzahl der Bilder pro Seite
$bild_width = $array['width_pic'];		//Breite der einzelnen Bilder
$spalt_breite = $array['width_column'];	//Multiplikator für die Spaltenbreite
$height_zeile = $array['height_row'];	//Multiplikator für die Zeilenhöhe

//Verschiedene Variablen die hochzählen:
$a = 1;		//Anzahl der Bilder insgesamt (+1)
$b = 0;		//Hilfsvariable zwischen 0 und Breite, jedes Breite. Bild = 0
$c = 0;		//Anzahl der Bilder der letzten Seite
$d = 0;		//Hilfsvariable um die galerie mit leeren Feldern aufzufüllen
$e = 1;		//Anzahl der Seiten
$f = 1;		//Anzahl der Seiten für Anzeige Seitenzahl
$g = 0;		//Anzahl der Zeilen der Seite
$h = 0;		//Anzahl der Bilder der Seite
$i = 0;		//Gibt die Anzahl der aktuellen Bilder der Zeile an
$j = 0;		//Anzahl der Bilder insgesamt
$k = 0;		//Hilfsvariable um den Spalt zwischen Spalten zu bestimmen.
$l = 0;		//Hilfsvariable um den Spalt zwischen Zeilen zu bestimmen.
$m = 0;		//Hilfsvariable um den Spalt zwischen Zeilen zu bestimmen. (Filler)
$n = 0;		//Hilfsvariable um den Spalt zwischen Spalten zu bestimmen. (Filler)

$ordner = "pictures";					//Speicherort der Bilder
$bilder = scandir($ordner);			//Array aller Dateien, sortiert von A-Z, durchnummeriert

//Überprüft Seitenzahl und definiert sie. Ohne Seitenzahl = 1
if(isset($_GET['page'])){
	$seitenzahl = $_GET['page'];}
	else {$seitenzahl = 1;}
	
//Abfrage, die die richtigen Bilder basierend auf der Seite anzeigt
$range_start = 1+($anzahl_bilder*($seitenzahl-1));			//Nummer des ersten Bildes der Seite
$range_end = ($anzahl_bilder*$seitenzahl)+1;
				//Nummer des max. letzten Bildes der Seite

//Schleife, die alle Bilder durchzählt

foreach ($bilder as $bild) {
	//Array der für jedes Bild folgendes enthält: (Bsp: /bilder/1.png):
	//[dirname] => bilder [basename] => 1.png [extension] => png [filename] => 1
	$bildinfo = pathinfo($ordner."/".$bild);
	//Schließt ungewünschte Dateien und Dateitypen aus
	if ($bild != "." && $bild != ".." && $bild != "_notes" && $bild != ".DS_Store" && $bildinfo['basename'] != "Thumbs.db" && $bildinfo['filename'] != "fill") {
		
		$a++; 	//Zählt fortlaufend hoch, entspricht immer der Anzahl der Bilder insgesamt
		$c++; 	//Zählt fortlaufend hoch, entspricht immer der Anzahl der Bilder der letzten Seite
		$i++; 	//Anzahl der Bilder der Zeile
		$j++; 	//Anzahl der Bilder insgesamt
		$k = 0;	//Setzt den Zähler für Spaltbreite wieder zurück
		$l = 0;	//Setzt den Zähler für die Zeilenhöhe wieder zurück
		$m = 0;	//Setzt den Zähler für die Zeilenhöhe wieder zurück (Filler)
		
		//Definition, wann Bild ausgegeben wird
		if ($a<=$range_start){}		//wenn die genaue Anzahl kleiner-gleich Range ist, keine Ausgabe
		elseif($a>$range_end){}		//wenn die genaue Anzahl größer als Range ist, keine Ausgabe
		else{						//Für alle anderen Fälle (also genau im Range)
			$b++; //"--", entspricht immer der Anzahl der Bilder in einer Zeile der Seite
			$h++; //entspricht Anzahl der Bilder der Seite
			
			//Anzeige der Bilder
			?><img style="width:<?echo $bild_width;?>;" src="<?php echo $ordner."/".$bildinfo['basename'];?>"/>
				<? 
				//Breite der Spalte zwischen Spalten
				while($k < $spalt_breite){			//Solange die Hilfsvariable kleiner ist als die definierte Spaltbreite
				$k++;								//wird die Hilfsvariable größer
				echo "&nbsp;";						//Und gibt ein Leerzeichen aus
				}
				
			//Generiert den Zeilenumbruch, wenn $width erreicht ist			
			if($b == $width){
				$b = 0;			//setzt den Wert zurück
				$i = 0;			//setzt den Wert zurück
				
				//Breite der Spalte zwischen Zeilen
				while($l < $height_zeile){ 			//Solange die Hilfsvariable kleiner ist als die definierte Zeilenhöhe
				$l++;								//wird die Hilfsvariable größer
				echo "<br>";						//Zeilenumbruch immer wenn die Zeile voll ist
				}
				$g++;								//+1 wenn Zeilenumbruch ist
			}
			
		}
		//Lässt die Seitenzahl höher werden
		if(($c/$anzahl_bilder) >= 1) {			//wenn die Anzahl der Bilder der aktuellen Seite der Maximalanzahl pro Seite entspricht
			$e++;								//wird die Seitenzahl um 1 erhöht
			$c=0;								//und die Anzahl der Bilder der aktuellen Seite zurückgesetzt
			array_push($array_seitenzahl, $e);	//und die neue Seitenzahl in den Array geschrieben			
		}	
	}
}
$am = $a-1; //Da $a als Grundwert +1 hat wird hier -1 abgezogen, um wieder auf die richtige Anzahl zu kommen
//löscht den letzten Wert aus dem Array, falls die Anzahl der Bilder genau die Seiten auffüllt
if ($am == ((max($array_seitenzahl)-1)*$anzahl_bilder))
	{ unset($array_seitenzahl[count($array_seitenzahl)-1]);	
}  

//Garantiert immer die gleiche Größe der galerie
if($seitenzahl == max($array_seitenzahl)){	

	$d=$h;	//weist den Wert der Anzahl der Bilder der aktuellen Seite der Variable $d zu
	//Schleife die so oft läuft, wie zu "Feldern" der Maximalzahl fehlen
	
	while ($d<=$anzahl_bilder-1){
		$n = 0;	//Setzt den Zähler für Spaltbreite wieder zurück (Filler)
		$d++;	//erhöht die Anzahl der "Felder" pro Seite
		$i++;	//erhöht die Anzahl der "Bilder" (also auch Leerbilder)
		?><img style="width:<?echo $bild_width;?>" src="/bilder/fill/filler.png"/><?
		
		//Breite der Spalte zwischen Spalten (Filler)
		while($n < $spalt_breite){			//Solange die Hilfsvariable kleiner ist als die definierte Spaltbreite
		$n++;								//wird die Hilfsvariable größer
		echo "&nbsp;";						//Und gibt ein Leerzeichen aus
		}
		
		//Abfrage, die bestimmt, wieviele Zeilen noch fehlen		
		if($i >= $width){
			$i = 0;
			$g++;
			echo "<br>";		
			
		//Breite der Spalte zwischen Zeilen (Filler)
		while($m < $height_zeile){ 			//Solange die Hilfsvariable kleiner ist als die definierte Zeilenhöhe
		$m++;								//wird die Hilfsvariable größer
		echo "<br>";						//Zeilenumbruch immer wenn die Zeile voll ist
		}
		$g++;								//+1 wenn Zeilenumbruch ist
		}
	}
}
echo "<br>";	//Gibt am Ende der Schleife einen Zeilenumbruch aus
//Schleife, die die Seitenzahl ausgibt, solange Werte im Array sind - entsprechen Seitenzahl
?> <div><? while(each($array_seitenzahl)){
	echo "<a href=index.php?page=$f>Page $f</a> &nbsp;";	//gibt den Link zur Seite aus
	$f++;	//Addiert 1 auf die Seitenzahl drauf
	
}
?>
</div>
</div>
</nobr>
