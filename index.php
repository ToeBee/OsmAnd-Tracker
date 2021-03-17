<?php
    require_once __DIR__."/includes/settings.php";

	if ($secretKey == 'CHANGEME') {
		die(_WARNING_NEED_TO_CHANGE_SECRET_KEY);
	}
	if ($apikey == '') {
		die(_WARNING_NEED_TO_GET_APIKEY);
	}

	if(file_exists($filePath)){
        $loc_string = file_get_contents($filePath);
        $info = unserialize($loc_string);
        $timeAgo=$ClassUtils->timeAgo(date("Y-m-d H:i:s",substr($info['timestamp'],0,-3)));
        $speed=$ClassUtils->convertUnit($info['speed'],$unitForSpeed);

        if($_GET['realgpskey']==$secretRealGPSKey){
            $lat = $info['reallat'];
            $lon = $info['reallon'];
        }else{
            $lat = $info['fakelat'];
            $lon = $info['fakelon'];
        }

        $staticUrl = 'https://www.mapquestapi.com/staticmap/v5/map?';
        $staticUrl = $staticUrl."size=$width,$height&type=map&imagetype=jpeg&key=$apikey";
        $staticUrl = $staticUrl . "&locations=$lat,$lon|&zoom=$zoom&center=$lat,$lon";
        $mapUrl = 'https://www.openstreetmap.org';
        $mapUrl = $mapUrl . "?mlat=$lat&mlon=$lon";
    }else{
	    die(_LOCATION_FILE_DOES_NOT_EXIST);
    }

    /* Note that you can embed an interactive map using:
		$bbox = 0.01; // Zoom. 0.1 gives an overview, 0.01 is quite zoomed in, 0.001 is street-level.
		$bboxleft = $lon - $bbox;
		$bboxbottom = $lat - $bbox;
		$bboxright = $lon + $bbox;
		$bboxtop = $lat + $bbox;
		$bb = urlencode($bboxleft . ',' . $bboxbottom . ',' . $bboxright . ',' . $bboxtop);
		<iframe src="http://www.openstreetmap.org/export/embed.html?m&bbox=$bb&amp;layer=mapnik" width=800 height=600></iframe>
		The issue is that you cannot place a marker (not that I have found).
	*/
    $date = new DateTime();
    $timeZone = $date->getTimezone();
    echo "<html>
            <head>
                <title>$pageTitle</title>
                ".($refreshTime>0?"<meta http-equiv='refresh' content='$refreshTime'/>":"")."
            </head>
            <body>
                <center>
                    ".($timeAgo>0?"<h3>".$yourName." "._STATUS_AS_OF." ".$timeAgo."</h3><small>"._TIMEZONE." ".$timeZone->getName()."</small>":"")."
                    ".($speed>0?"<h3>"._SPEED.": ".$speed."</h3>":"<h3>"._IT_IS_STOPPED."</h3>")."
                    <a href=".$mapUrl."><img src='".$staticUrl."'></a><br/>
                    <p>"._CLICK_TO_SEE_INTERACTIVE_MAP."</p>
                    <small>"._PAGE_GENERATED_AT." ".date("H:i")."</small>
                </center>
            </body>
         </html>";


