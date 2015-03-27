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
    $fh = fopen($filePath . ".log", 'a');
    fwrite($fh, serialize($info) . "\n");
    fclose($fh);
?>
