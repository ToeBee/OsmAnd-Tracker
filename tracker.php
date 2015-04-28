<?php
    require "settings.php";

	if ($key == 'CHANGEME') {
		die('Key not set.');
	}
    $key = $_GET['key'];
    if (md5($key . $secretKey) != md5($secretKey . $secretKey)) { // Constant time comparison
        print 'Invalid key';
        return;
    }

    $info['lat'] = round($_GET['lat'], $accuracy);
    $info['lon'] = round($_GET['lon'], $accuracy);
    $info['timestamp'] = intval($_GET['timestamp']);
    $info['hdop'] = floatval($_GET['hdop']);
    $info['altitude'] = floatval($_GET['altitude']);
    $info['speed'] = floatval($_GET['speed']);

    $fh = fopen($filePath, 'w');
    fwrite($fh, serialize($info));
    fclose($fh);

