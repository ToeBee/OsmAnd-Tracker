<?php
    require "serialized-to-gpx.php";
    ignore_user_abort("true");
    //enter location of KML file here
    //$u = "http://code.google.com/apis/kml/documentation/KML_Samples.kml";
    $u = $_GET['file'];
    //echo $u;
    $outString="";
    s2g($u,$outString); 
        //echo $outString;
        if ($_GET['new_file'] == "true") {
            $fh = fopen(str_replace(".log","",$u).".gpx", 'w');
            fwrite($fh, $outString);
            fclose($fh);
        }
        header("Content-Type: text/xml");
        echo $outString;
?>
