<?php
$geoip = json_decode(file_get_contents('http://www.geoplugin.net/json.gp?ip='.@$ip));	
$geoValue['countryID'] = $geoip->geoplugin_countryCode;
$geoValue['countryName'] = $geoip->geoplugin_countryName;
$geoValue['domain'] = '';
$geoValue['state'] = $geoip->geoplugin_regionName;
$geoValue['town'] = $geoip->geoplugin_city;
?>