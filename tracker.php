<?php
    include "settings.php";
    $key = $_GET['key'];
    if($key != $secretKey) {
        print "key doesn't match";
        return;
    }

    $info['lat'] = round($_GET['lat'], $accuracy);
    $info['lon'] = round($_GET['lon'], $accuracy);
    $info['timestamp'] = $_GET['timestamp'];
    $info['hdop'] = $_GET['hdop'];
    $info['altitude'] = $_GET['altitude'];
    $info['speed'] = $_GET['speed'];


    $loc_string = file_get_contents($filePath);
    $old = unserialize($loc_string);
    $diff = round(abs($info['timestamp']-$old['timestamp'])/1000);
    if ($diff > 60) {
       rename($filePath . ".log","gpx/".$filePath . date("YmdHis",round($old['timestamp']/1000)) .".log");
       //TODO Create GPX file
    }
    $fh = fopen($filePath . ".log", 'a');
    fwrite($fh, serialize($info) . "\n");
    fclose($fh);
    $fh = fopen($filePath, 'w');
    fwrite($fh, serialize($info));
    fclose($fh);
?>
