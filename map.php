<?php
    include "settings.php";

    $loc_string = file_get_contents($filePath);
    $info = unserialize($loc_string);
    $timestampSeconds = round($info['timestamp']/1000,0);
    $minutesAgo = round((time() - $timestampSeconds)/60,1);
    $lat = $info['lat'];
    $lon = $info['lon'];
    $staticUrl = 'http://open.mapquestapi.com/staticmap/v4/getmap?';
    $staticUrl = $staticUrl."size=$width,$height&type=map&imagetype=JPEG";
    $staticUrl = $staticUrl . "&pois=mcenter,$lat,$lon|&zoom=$zoom&center=$lat,$lon";
    $mapUrl = 'http://www.openstreetmap.org';
    $mapUrl = $mapUrl . "?mlat=$lat&mlon=$lon";
?>

<html>
<head>
    <title><?php echo $name?>'s Location</title>
    <meta http-equiv="refresh" content="600" />
</head>
<body>
    <h3><?php echo $name?>'s status as of <?php echo $minutesAgo?> minutes ago:</h3>
    <h3>Speed: <?php echo $info['speed']?> m/s</h3>
    <a href=<?php echo $mapUrl?>><img src="<?php echo $staticUrl?>"></a><br/>
    <p>Click for an interactive map</p>

</body>
</html>

