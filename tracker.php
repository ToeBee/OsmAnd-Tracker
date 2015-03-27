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


    $fh = fopen($filePath, 'w');
    fwrite($fh, serialize($info));
    fclose($fh);
    $loc_string = file_get_contents($filePath);
    $old = unserialize($loc_string);
    if (round(abs($info['timestamp']-$old['timestamp'])/1000) > 60) {
       rename($filePath . ".log",$filePath . date("YmdHis",round($old['timestamp']/1000)) .".log");
    }
    $fh = fopen($filePath . ".log", 'a');
    fwrite($fh, serialize($info) . "\n");
    fclose($fh);
?>
