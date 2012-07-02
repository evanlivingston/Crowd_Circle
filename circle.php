<?php

// Return number of items in a directory
function fileCounter($dir){
    $counter = 0;
    if ($handle = opendir($dir)) {
      //echo "Directory handle: $handle\n";
      //echo "Files:\n";
      /* This is the correct way to loop over the directory. */
      while (false !== ($file = readdir($handle))) {
          //echo "<BR>".$counter." - $file";
          $counter++;
      }
      closedir($handle);
    }
    $counter -= 1; // in order to exclude '.' and '..', as well as start the counter on 1
    return $counter;
}

function makePicture() {
	$handle = opendir('uploads'); 
	$count = 1;
	while (false !== ($file = readdir($handle))){ 
		echo $i + "\n";
		$percent = 100 / ($count);
                $src = (100 - $percent);
                $cmd = " -blend ".(float)$src."x".(float)$percent +" 11.png " +$filename."";
                exec("composite $cmd 11.png");
                $cmd = "convert 11.png -size 600x600 xc:white +swap -compose over -composite 11.jpg";
                exec("$cmd");
		$i++;
    // now use $file as you like 
  } 
} 

function contrast($image) {
	$cmd1 = "convert ".$image."  -contrast-stretch 2%x20% ".$image;
        exec("$cmd1");
}
//makePicture();
contrast('11.jpg');
?>
