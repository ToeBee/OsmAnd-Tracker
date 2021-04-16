<?php
    require_once "includes/settings.php";

	if ($key == 'CHANGEME') {
		die(_WARNING_NEED_TO_CHANGE_SECRET_KEY);
	}
    $key = $_GET['key'];
    if (md5($key . $secretKey) != md5($secretKey . $secretKey)) { // Constant time comparison
        die(_WARNING_INVALID_SECRET_KEY);
    }
    $atualLongitude=round($_GET['lat'], 9);
    $atualLatitude=round($_GET['lon'], 9);

    $info['reallat'] = $atualLongitude;
    $info['reallon'] = $atualLatitude;

    $fakeGPS=$ClassUtils->generateRandomPoint(array($atualLongitude,$atualLatitude),"0,5");
    $info['fakelat'] = round($fakeGPS[0], $accuracy);
    $info['fakelon'] = round($fakeGPS[1], $accuracy);

    $info['timestamp'] = intval($_GET['timestamp']);
    $info['hdop'] = floatval($_GET['hdop']);
    $info['altitude'] = floatval($_GET['altitude']);
    $info['speed'] = floatval($_GET['speed']);

    $fh = fopen($filePath, 'w');
    fwrite($fh, serialize($info));
    fclose($fh);

