OsmAnd-Tracker
=========

OsmAnd-Tracker is a small bit of PHP to accept location pings from
[OsmAnd](http://www.osmand.net) and display a static map with that location. 

The map is suitable for placement inside of an iframe element on a personal
website or such. The functionality is similar to the Google Latitude "location
badge" feature but allows you to control your own information and uses the
MapQuest Open [static map API](http://open.mapquestapi.com/staticmap/) to
generate a simple image with a location pin on it.

## Deployment instructions

Copy the files and edit settings.php. Namely $apikey needs to be set to get an
interactive map. Alternatively, you could use an interactive map from osm.org
(see the commented code in map.php).

After configuring the settings to your liking, you must point OsmAnd to where
tracker.php is located. The full URL is:

http://example.org/tracker.php?lat={0}&lon={1}&timestamp={2}&hdop={3}&altitude={4}&speed={5}&key=SECRETKEY

Don't forget to replace example.org with your site AND set SECRETKEY to your
secret key!

