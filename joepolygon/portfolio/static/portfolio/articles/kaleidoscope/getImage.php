<?php
  $url=$_GET['url'];

  $isImage = getimagesize($url);
  if ($isImage != false) {
    $img = file_get_contents($url);

    //open db
    $db = fopen("./imageCounter.txt", "r+") or die("Unable to open file!");
    //read db
    $counter = ord(fgetc($db));
    //increment db
    fseek($db, 0, SEEK_SET); //go to start of file
    fwrite($db, chr(($counter + 1) & 0xFF), 1);
    //close db
    fclose($db);

    $fn = "./tempImages/".$counter.".jpg";

    file_put_contents($fn,$img);
    echo "/assets/articles/kaleidoscope/".$fn;
  } else {
    echo "0";
  }
?>
