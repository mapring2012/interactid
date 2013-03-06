<?php
$url = file_get_contents('http://maps.google.com/maps/geo?q=Takeo,%20Cambodia');
//print_r($url);
$geo = explode('[', $url);
$geo = explode(']', $geo[2]);
$geo = explode(',', $geo[0]);
echo $geo[0];
echo '<br/>';
echo $geo[1];