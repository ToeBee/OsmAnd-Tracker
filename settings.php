<?php
    global $secretKey;
    global $workingDirectory;
    global $fileName;
    global $filePath;
    global $logName;
    global $logPath;
    global $gpxDirectory;
    global $name;
    global $zoom;
    global $accuracy;
    global $height;
    global $width;
    #Change this! Just to prevent random people from being able to change your displayed location
    $secretKey = '4fkw8vxp';
    #used to round the lat/lon values so you aren't sharing your *exact* location
    $accuracy = 2; 
    $workingDirectory = '/tmp/';
    $fileName = 'location';
    $filePath = $fileDirectory . $fileName;
    $logName = $fileName . ".log";
    $logPath = $workingDirectory . $logName;
    $gpxDirectory = $workingDirectory . 'gpx/';

    # Display options

    $name = 'Toby';
    #how far to zoom in on the map
    $zoom = "8";
    $height = "500";
    $width = "600";
?>
