<?php
    require_once "../settings.php";

    //Generate GPS point$randomFloat =
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
    $info['timestamp'] = intval($timestamp);
    $info['hdop'] = floatval($hdop);
    $info['altitude'] = floatval($altitude);
    $info['speed'] = floatval($speed);
    print_r($info);
    $fh = fopen($filePath, 'w');
    fwrite($fh, serialize($info));
    fclose($fh);