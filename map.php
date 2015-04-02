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
    <title><?=$name?>'s Location</title>
    <meta http-equiv="refresh" content="30" />
    <meta charset="utf-8" />
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0">-->
    <link rel="stylesheet" href="leaflet/leaflet.css" />
    <script type="text/javascript" src="leaflet/leaflet.js"></script>
    <script type="text/javascript" src="leafletembed.js"></script>
    <script type="text/javascript" src="leaflet-omnivore/leaflet-omnivore.min.js"></script>

</head>
<body>
    <h3><?=$name?>'s status as of <?=$minutesAgo?> minutes ago:</h3>
    <h3>Speed: <?=$info['speed']?> m/s</h3>
    <!-- <iframe width="<?=$width?>" height="<?=$height?>" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="<?=$embedUrl?>" style="border: 1px solid black"></iframe> -->
    <div id="map" style="width: <?=$width?>px; height: <?=$height?>px"></div>
    <br/>
    <small><a href="<?=$mapUrl?>">View Larger Map</a></small>
        <script>
            initmap();
            L.marker([<?=$lat?>, <?=$lon?>]).addTo(map)
            map.setView(new L.LatLng(<?=$lat?>, <?=$lon?>),<?=$zoom?>);
            omnivore.gpx('serialized-to-gpx.php?file=tmplocation.log').addTo(map);
        </script>

</body>
</html>
