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


function my_theme_enqueue_styles() {

    $parent_style = 'parent-style'; 

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );


?>



