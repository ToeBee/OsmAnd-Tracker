<?php
    include "settings.php";

    //$loc_string = file_get_contents($filePath);
    //$info = unserialize($loc_string);
    $strings = file($logPath, FILE_IGNORE_NEW_LINES);
    $info = unserialize(end($strings));
    $timestampSeconds = round($info['timestamp']/1000,0);
    $minutesAgo = round((time() - $timestampSeconds)/60,1);
    $lat = $info['lat'];
    $lon = $info['lon'];
    $mapUrl = 'http://www.openstreetmap.org';
    $mapUrl = $mapUrl . "?mlat=$lat&mlon=$lon#map=$zoom/$lat/$lon";
    $bbox_offset = 360/(pow(2,$zoom+1));
    $bbox = ($lon-$bbox_offset)."%2C".($lat-$bbox_offset)."%2C".($lon+$bbox_offset)."%2C".($lat+$bbox_offset);
    $marker = "$lat%2C$lon";
    $embedUrl = 'http://www.openstreetmap.org/export/embed.html';
    $embedUrl = $embedUrl . "?bbox=$bbox&layer=mapnik&marker=$marker"; 
?>

<html>
<head>
    <title><?php echo $name; ?>'s Location</title>
    <meta http-equiv="refresh" content="30" />
</head>
<body>
    <h3><?php echo $name?>'s status as of <?php echo $minutesAgo?> minutes ago:</h3>
    <h3>Speed: <?php echo $info['speed']?> m/s</h3>
    <iframe width="<?php echo $width?>" height="<?php echo $height?>" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="<?php echo $embedUrl?>" style="border: 1px solid black"></iframe>
    <br/>
    <small><a href="<?=$mapUrl?>">View Larger Map</a></small>

</body>
</html>
