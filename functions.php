<?php
function colorCloud($text) {
$text = preg_replace_callback('|<a (.+?)>|i', 'colorCloudCallback', $text);

return $text;

}

function colorCloudCallback($matches) {

$text = $matches[1];

$colors=array('ff3300','0517c2','0fc317','e7cc17','601165','ffb900','f74e1e','00a4ef','7fba00');

$color=$colors[dechex(rand(0,3))];

$pattern = '/style=(\'|\")(.*)(\'|\")/i';

$text = preg_replace($pattern, "style=\"color:#{$color};$2;\"", $text);

return "<a $text>";

}

add_filter('wp_tag_cloud', 'colorCloud', 1);

?>
