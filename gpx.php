<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Tracks</title>
  </head>
  <body>
<?php
include "settings.php";
$dir=$gpxDirectory;
$directorio=opendir($dir);
echo "<b>Files:</b><br><ul>";
while (false !== ($archivo = readdir($directorio)))
{
  //if ($archivo!="." & $archivo!=".." & $archivo!="index.php")
  if (strpos($archivo,"log"))
  {
    echo "
<li><a href=\"$gpxDirectory$archivo\">$archivo</a> 
<br>

";
  }
}
echo "</ul>";
closedir($directorio);
?>
  </body>
</html>

