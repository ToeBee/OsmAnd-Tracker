<?php
if (!class_exists('UTILS')) {
    class UTILS
    {
        function timeAgo($dateTime, $sendUnis = true)
        {
            if ($dateTime == "")
                return "";

            $dateTime = time() - strtotime($dateTime);

            $tokens = array(
                31536000 => array(_YEAR, YEARS),
                2592000 => array(_MONTH, _MONTHS),
                604800 => array(_WEEK, _WEEKS),
                86400 => array(_DAY, _DAYS),
                3600 => array(_HOUR, _HOURS),
                60 => array(_MINUTE, _MINUTES),
                1 => array(_SECOND, _SECONDS)
            );

            foreach ($tokens as $unit => $text) {
                if ($dateTime < $unit) continue;
                $numberOfUnits = floor($dateTime / $unit);
                return $numberOfUnits . "" . ($sendUnis ? (($numberOfUnits > 1) ? " " . $text[1] : " " . $text[0]) : "") . "";
            }
        }

        function convertUnit($meterPerSec,$unit='kilometer_per_hour'){
            $units=array(
                "kilometer_per_hour"=>"0.2777778",
                "mile_per_hour"=>"0.44704"
            );
            $unitsLabels=array(
                "kilometer_per_hour"=>"km/h (kph)",
                "mile_per_hour"=>" mi/h (mph)"
            );
            return number_format(($meterPerSec*$units[$unit]),0,",","")." ".$unitsLabels["kilometer_per_hour"];
        }

        function generateRandomPoint($centre, $radius) {
            $radius_earth = 3959; //miles

            //Pick random distance within $distance;
            $distance = lcg_value()*$radius;

            //Convert degrees to radians.
            $centre_rads = array_map( 'deg2rad', $centre );

            //First suppose our point is the north pole.
            //Find a random point $distance miles away
            $lat_rads = (pi()/2) -  $distance/$radius_earth;
            $lng_rads = lcg_value()*2*pi();


            //($lat_rads,$lng_rads) is a point on the circle which is
            //$distance miles from the north pole. Convert to Cartesian
            $x1 = cos( $lat_rads ) * sin( $lng_rads );
            $y1 = cos( $lat_rads ) * cos( $lng_rads );
            $z1 = sin( $lat_rads );


            //Rotate that sphere so that the north pole is now at $centre.

            //Rotate in x axis by $rot = (pi()/2) - $centre_rads[0];
            $rot = (pi()/2) - $centre_rads[0];
            $x2 = $x1;
            $y2 = $y1 * cos( $rot ) + $z1 * sin( $rot );
            $z2 = -$y1 * sin( $rot ) + $z1 * cos( $rot );

            //Rotate in z axis by $rot = $centre_rads[1]
            $rot = $centre_rads[1];
            $x3 = $x2 * cos( $rot ) + $y2 * sin( $rot );
            $y3 = -$x2 * sin( $rot ) + $y2 * cos( $rot );
            $z3 = $z2;


            //Finally convert this point to polar co-ords
            $lng_rads = atan2( $x3, $y3 );
            $lat_rads = asin( $z3 );

            return array_map( 'rad2deg', array( $lat_rads, $lng_rads ) );
        }

    }
}