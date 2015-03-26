<?php
    include "settings.php";

    $loc_string = file_get_contents($filePath);
    $info = unserialize($loc_string);
    $timestampSeconds = round($info['timestamp']/1000,0);
    $minutesAgo = round((time() - $timestampSeconds)/60,1);
    $lat = $info['lat'];
    $lon = $info['lon'];
    #$staticUrl = 'http://open.mapquestapi.com/staticmap/v4/getmap?';
    #$staticUrl = $staticUrl."size=$width,$height&type=map&imagetype=JPEG";
    #$staticUrl = $staticUrl . "&pois=mcenter,$lat,$lon|&zoom=$zoom&center=$lat,$lon";
    $mapUrl = 'http://www.openstreetmap.org';
    $mapUrl = $mapUrl . "?mlat=$lat&mlon=$lon#map=$zoom/$lat/$lon";
    #$bbox = "-0.8910351991653442%2C41.68302861364519%2C-0.8846622705459595%2C41.686045314074164";
    $bbox = ($lon-0.003)."%2C".($lat-0.003)."%2C".($lon+0.003)."%2C".($lat+0.003);
    $marker = "$lat%2C$lon";
    $embedUrl = 'http://www.openstreetmap.org/export/embed.html';
    $embedUrl = $embedUrl . "?bbox=$bbox&layer=mapnik&marker=$marker"; 
?>

<html>
<head>
    <title><?php echo $name; ?>'s Location</title>
    <meta http-equiv="refresh" content="600" />
</head>
<body>
    <h3><?php echo $name?>'s status as of <?php echo $minutesAgo?> minutes ago:</h3>
    <h3>Speed: <?php echo $info['speed']?> m/s</h3>
    <iframe width="<?php echo $width?>" height="<?php echo $height?>" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="<?php echo $embedUrl?>" style="border: 1px solid black"></iframe><br/><small><a href="<?php echo $mapUrl?>">View Larger Map</a></small>

</body>
</html>

