<?php
    require_once __DIR__."/../includes/settings.php";

    //Generate GPS point
    $point = array(
       'x' => random_int(-90, 90 - 1) + (random_int(0, PHP_INT_MAX - 1) / PHP_INT_MAX ),
       'y' => random_int(-180, 180 - 1) + (random_int(0, PHP_INT_MAX - 1) / PHP_INT_MAX )
    );

    $min=1;
    $max=300;
    $hdop=($min+lcg_value()*(abs($max-$min)));
    $altitude=($min+lcg_value()*(abs($max-$min)));
    $speed=($min+lcg_value()*(abs($max-$min)));
    $timestamp=time();

    $info['lat'] = round($point['x'], $accuracy);
    $info['lon'] = round($point['y'], $accuracy);
    $info['timestamp'] = intval($timestamp)."000";
    $info['hdop'] = floatval($hdop);
    $info['altitude'] = floatval($altitude);
    $info['speed'] = floatval($speed);
    $url=$trackerURL."/tracker.php?lat=".$info['lat']."&lon=".$info['lon']."&timestamp=".$info['timestamp']."&hdop=".$info['hdop']."&altitude=".$info['altitude']."&speed=".$info['speed']."&key=".$secretKey;
    echo "<a href='$url' target='_blank'>$url</a>";
    $fh = fopen($filePath, 'w');
    fwrite($fh, serialize($info));
    fclose($fh);