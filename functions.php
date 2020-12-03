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


function mynote_social_links_icons_child() {

	$social_links_icons = array(
	    'youtube.com'     => 'fab fa-youtube youtube',
	    'github.com'      => 'fab fa-github-alt github',
	    'mailto:'         => 'far fa-envelope envelope',
        'qq.com'     => 'fab fa-qq qq',
        'wx.qq.com'     => 'fab fa-weixin weixin',
        'weibo.com'     => 'fab fa-weibo weibo', 
	);

	return $social_links_icons;
}

function mynote_nav_menu_social_icons_child( $item_output, $item, $depth, $args ) {

	// Get supported social icons.
	$social_icons = mynote_social_links_icons_child();
	$size_type    = get_theme_mod( 'layout_cols_footer_icon_size' );

	if ( 'md' === $size_type ) {
		$size_css = 'brand-md';
	} elseif ( 'lg' === $size_type ) {
		$size_css = 'brand-lg';
	} elseif ( 'xl' === $size_type ) {
		$size_css = 'brand-xl';
	} else {
		$size_css = 'brand-sm';
	}

	// Replace title with font icon inside social links menu.
	if ( 'social' === $args->theme_location ) {
		$is_icon_found = false;
		foreach ( $social_icons as $attr => $value ) {
			if ( false !== strpos( $item_output, $attr ) ) {
				$is_icon_found = true;
				$item_output = preg_replace( '#' . $args->link_before . '(.+)' . $args->link_after . '#i', '<span class="' . $size_css . '"><i class="' . esc_attr( $value ) . ' brand-link"></i></span>', $item_output );
			}
		}
		if ( !$is_icon_found ) {
			$item_output = preg_replace( '#' . $args->link_before . '(.+)' . $args->link_after . '#i', '<i class="fas fa-link"></i>', $item_output );
		}
	}
	
	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'mynote_nav_menu_social_icons_child', 10, 4 );


function remove_mynote_nav_menu_social_icons(){ 
	remove_filter( 'walker_nav_menu_start_el', 'mynote_nav_menu_social_icons', 10, 4 );
}
add_action( 'after_setup_theme', 'remove_mynote_nav_menu_social_icons' );

?>



