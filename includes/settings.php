<?php

    include_once(__DIR__."/class.utils.php");
    $ClassUtils = new UTILS();

    //Getting the Language from the browser
    $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    $acceptLang = ['pt', 'en'];
    $lang = in_array($lang, $acceptLang) ? $lang : 'en';
    require_once(__DIR__ . "/../languages/" . $lang . ".php");

    // This key must be entered in OsmAnd's tracking URL as &key=
    $secretKey = 'CHANGEME';

	// API key from MapQuest. Get one from developer.mapquest.com
	$apikey = '';

	//Where the Tracker is
	$trackerURL="https://url.com/";

    // Used to round the lat/lon values so you aren't sharing your *exact* location
    $accuracy = 3; // in number of decimal positions

	// Random name for the file to avoid being downloaded ( Change this value )
    $fileName="filename_location";
    // Where to store your last location
    $filePath = __DIR__ . "/../" .$fileName;

    //Default Unit for speed
    $unitForSpeed="kilometer_per_hour";
    //$unitForSpeed="mile_per_hour";

    //Time in seconds when the page gets updates automatically. Zero means no refresh
    $refreshTime=0;

	// Used in page title
    $pageTitle = 'Page Title Example';
	// Used in page title
    $yourName = 'Jonh Doe';

	// Zoom on the map
	// 8 gives a high overview; 12 gives a more zoomed-in map. Lower or higher values also possible.
    $zoom = "8";

    $height = "500";
    $width = "600";


