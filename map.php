<?php
    require "settings.php";
	if ($secretKey == 'CHANGEME') {
		die('This application is not functional yet. See the README how to set it up (hint: edit settings.php).');
	}

    $loc_string = file_get_contents($filePath);
    $info = unserialize($loc_string);
    $timestampSeconds = round($info['timestamp']/1000,0);
    $minutesAgo = round((time() - $timestampSeconds)/60,1);
    $lat = $info['lat'];
    $lon = $info['lon'];
    $staticUrl = 'http://open.mapquestapi.com/staticmap/v4/getmap?';
    $staticUrl = $staticUrl."size=$width,$height&type=map&imagetype=JPEG&key=$apikey";
    $staticUrl = $staticUrl . "&pois=mcenter,$lat,$lon|&zoom=$zoom&center=$lat,$lon";
    $mapUrl = 'https://www.openstreetmap.org';
    $mapUrl = $mapUrl . "?mlat=$lat&mlon=$lon";
?>

<html>
<head>
    <title><?php echo $name?>'s Location</title>
    <meta http-equiv="refresh" content="60" />
</head>
<body>
    <h3><?php echo $name?>'s status as of <?php echo $minutesAgo?> minutes ago:</h3>
    <h3>Speed: <?php echo $info['speed']?> m/s</h3>
    <a href=<?php echo $mapUrl?>><img src="<?php echo $staticUrl?>"></a><br/>
    <p>Click for an interactive map</p>
	<?php /* Note that you can embed an interactive map using:

		$bbox = 0.01; // Zoom. 0.1 gives an overview, 0.01 is quite zoomed in, 0.001 is street-level.
		$bboxleft = $lon - $bbox;
		$bboxbottom = $lat - $bbox;
		$bboxright = $lon + $bbox;
		$bboxtop = $lat + $bbox;
		$bb = urlencode($bboxleft . ',' . $bboxbottom . ',' . $bboxright . ',' . $bboxtop);
		<iframe src="http://www.openstreetmap.org/export/embed.html?m&bbox=<?php echo $bb; ?>&amp;layer=mapnik" width=800 height=600></iframe>

		The issue is that you cannot place a marker (not that I have found).
	*/
	?>

</body>
</html>

