<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="main.css" />
<title>Perfect : View</title> 
<body>
<div id="wrapper">
	<?php
	include 'circle.php';
	if(isset($_POST['imageData'])&&$_POST['imageData']!="") {
		$data = $_POST['imageData'];
		if(substr($data,0,14)!="data:image/png") {
			echo "Invalid Image Format. Please try again. Click here to go back to Circle";
		} else {
			// Remove the starting characters,"data:image/jpg;base64,". Rest left is the PNG data
			$imageData = substr($data,22,strlen($data)-22);

			//as the data is base64 encoded. We decode it to get the raw data first.
			$finalImageData = base64_decode($imageData);
			
			//we assign the name to the file based upon the timestamp
			$filename = "uploads/".time().".png";
			// In our example we're creating a new file, $filename in write mode.
			// that's where $finalImageData will go when we fwrite() it.
			$handle = fopen($filename, 'w+');
			if (!$handle) {
			    echo "Cannot open file ($filename)";
			    exit;
			}
			// Write $finalImageData to our opened file.
			if (fwrite($handle, $finalImageData) === FALSE) {
			    echo "Cannot write to file ($filename)";
			    exit;
			} else {
				$count = fileCounter('uploads');
				$percent = 100 / ($count);
				$src = (100 - $percent);
				$cmd = " -blend ".(float)$src."x".(float)$percent." 10.png ".$filename."";
				exec("composite $cmd 10.png");
				$cmd = "convert 10.png -size 600x600 xc:white +swap -compose over -composite output.jpg";
				$makethumb = "convert output.jpg -resize 100x100  thumb.jpg";
				exec("$cmd");
				$cmd1 = "convert output.jpg -contrast-stretch 2%x20% output.jpg";
				exec("$cmd1");
				exec("$makethumb");
			    
				
         
			
				//echo '<br/> Blend percentage for this image is ';
				//echo $percent ;
			    	echo '<img src=output.jpg /> <br/>';
				echo 'Image Number: ';
				echo $count;
				echo ' <br/>';
				echo ' <a class="myButton" href="./">Again</a> ' ;
				echo ' <a class="myButton" href="http://benjaminvalentine.com/circle/uploads/display.php">View All Submissions</a> ';
				//echo $filename;
	
			}
			//exec("rm $filename");
			fclose($handle);
		}
	} else {
		echo "There was an internal problem, your circle was not added.";
	}
	?>
</div>
  <p id="footer"> Concept by Ben Valentine<br />
Designed by <a href="http://www.evan-livingston.com">Evan Livingston</a> &copy;  2011</p>
</body>
</html>
