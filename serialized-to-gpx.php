<?php
    ignore_user_abort("true");
    //enter location of KML file here
    //$u = "http://code.google.com/apis/kml/documentation/KML_Samples.kml";
    $u = $_GET['file'];
     
    function utcdate($timest) {
        return gmdate("Y-m-d\Th:i:s\Z", $timest);
    }
 
     
    $u_parts = pathinfo($u); //array of url parts
    $u_ext = strtoupper($u_parts['extension']);
    if ($u_ext== "LOG") {
 
        //$dom_kml = new DOMDocument();
        //$dom_kml->load($u);
        $strings = file($u, FILE_IGNORE_NEW_LINES);
        $info = unserialize(end($strings));
 
        $dom_gpx = new DOMDocument('1.0', 'UTF-8');
        $dom_gpx->formatOutput = true;
         
        //root node
        $gpx = $dom_gpx->createElement('gpx');
        $gpx = $dom_gpx->appendChild($gpx);

        $gpx_version = $dom_gpx->createAttribute('version');
        $gpx->appendChild($gpx_version);
        $gpx_version_text = $dom_gpx->createTextNode('1.1');
        $gpx_version->appendChild($gpx_version_text);
         
        $gpx_creator = $dom_gpx->createAttribute('creator');
        $gpx->appendChild($gpx_creator);
        $gpx_creator_text = $dom_gpx->createTextNode('OsmAnd-Tracker');
        $gpx_creator->appendChild($gpx_creator_text);
         
        $gpx_xmlns_xsi = $dom_gpx->createAttribute('xmlns:xsi');
        $gpx->appendChild($gpx_xmlns_xsi);
        $gpx_xmlns_xsi_text = $dom_gpx->createTextNode('http://www.w3.org/2001/XMLSchema-instance');
        $gpx_xmlns_xsi->appendChild($gpx_xmlns_xsi_text);
         
        $gpx_xmlns = $dom_gpx->createAttribute('xmlns');
        $gpx->appendChild($gpx_xmlns);
        $gpx_xmlns_text = $dom_gpx->createTextNode('http://www.topografix.com/GPX/1/0');
        $gpx_xmlns->appendChild($gpx_xmlns_text);
         
        $gpx_xsi_schemaLocation = $dom_gpx->createAttribute('xsi:schemaLocation');
        $gpx->appendChild($gpx_xsi_schemaLocation);
        $gpx_xsi_schemaLocation_text = $dom_gpx->createTextNode('http://www.topografix.com/GPX/1/1 http://www.topografix.com/GPX/1/1/gpx.xsd');
        $gpx_xsi_schemaLocation->appendChild($gpx_xsi_schemaLocation_text);
         
        $gpx_url = $dom_gpx->createElement('url');
        $gpx_url = $gpx->appendChild($gpx_url);
        $gpx_url_text = $dom_gpx->createTextNode('https://github.com/alejandroscf/OsmAnd-Tracker');
        $gpx_url->appendChild($gpx_url_text);
         
                    //add the new track
                    $gpx_trk = $dom_gpx->createElement('trk');
                    $gpx_trk = $gpx->appendChild($gpx_trk);
                     
                    /*$gpx_name = $dom_gpx->createElement('name');
                    $gpx_name = $gpx_trk->appendChild($gpx_name);
                    $gpx_name_text = $dom_gpx->createTextNode("track");
                    $gpx_name->appendChild($gpx_name_text);
                    */ 
                    $gpx_trkseg = $dom_gpx->createElement('trkseg');
                    $gpx_trkseg = $gpx_trk->appendChild($gpx_trkseg);
                 
                    foreach ($strings as $point) {
                        //$latlng = explode(",", $coordinate);
                        $info = unserialize($point);
                         
                        if (($lat = $info['lat']) && ($lng = $info['lon'])) {
                            $gpx_trkpt = $dom_gpx->createElement('trkpt');
                            $gpx_trkpt = $gpx_trkseg->appendChild($gpx_trkpt);
                             
                            $gpx_ele = $dom_gpx->createElement('ele');
                            $gpx_ele = $gpx_trkpt->appendChild($gpx_ele);
                            $gpx_ele_text = $dom_gpx->createTextNode($info['altitude']);
                            $gpx_ele->appendChild($gpx_ele_text);
                             
                            $gpx_time = $dom_gpx->createElement('time');
                            $gpx_time = $gpx_trkpt->appendChild($gpx_time);
                            $gpx_time_text = $dom_gpx->createTextNode(utcdate(round($info['timestamp']/1000,0)));
                            $gpx_time->appendChild($gpx_time_text);
                             
                            $gpx_hdop = $dom_gpx->createElement('hdop');
                            $gpx_hdop = $gpx_trkpt->appendChild($gpx_hdop);
                            $gpx_hdop_text = $dom_gpx->createTextNode($info['hdop']);
                            $gpx_hdop->appendChild($gpx_hdop_text);
 
                            $gpx_trkpt_lat = $dom_gpx->createAttribute('lat');
                            $gpx_trkpt->appendChild($gpx_trkpt_lat);
                            $gpx_trkpt_lat_text = $dom_gpx->createTextNode($lat);
                            $gpx_trkpt_lat->appendChild($gpx_trkpt_lat_text);
                             
                            $gpx_trkpt_lon = $dom_gpx->createAttribute('lon');
                            $gpx_trkpt->appendChild($gpx_trkpt_lon);
                            $gpx_trkpt_lon_text = $dom_gpx->createTextNode($lng);
                            $gpx_trkpt_lon->appendChild($gpx_trkpt_lon_text);
                             
                            $gpx_extension = $dom_gpx->createElement('extensions');
                            $gpx_extension = $gpx_trkpt->appendChild($gpx_extension);
                            $gpx_speed = $dom_gpx->createElement('speed');
                            $gpx_speed = $gpx_extension->appendChild($gpx_speed);
                            $gpx_speed_text = $dom_gpx->createTextNode($info['speed']);
                            $gpx_speed->appendChild($gpx_speed_text);
                        }
                    }
        if ($_GET['new_file'] == "true") {
            $fh = fopen(str_replace(".log",".gpx",$u), 'w');
            fwrite($fh, $dom_gpx->saveXML());
            fclose($fh);
        }
        header("Content-Type: text/xml");
        echo $dom_gpx->saveXML();
    }
?>
