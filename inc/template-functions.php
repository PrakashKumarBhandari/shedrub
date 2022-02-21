<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package shedrub_network
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function shedrub_network_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'shedrub_network_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function shedrub_network_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'shedrub_network_pingback_header' );



/**  
 *  Add Advance Custom Fields plugin feature in 
 *  Custom Wordpress theme by including in theme 
 * 
 */
define( 'DS_THEME_PATH', trailingslashit( get_template_directory() ) );
define( 'DS_IMAGE_URI', trailingslashit( get_stylesheet_directory_uri() . '/assets/image/' ) );
define( 'DS_ACF_PATH', trailingslashit( dirname( __FILE__ ) ) . 'lib/advanced-custom-fields-pro' );
define( 'DS_ACF_URL', trailingslashit( get_stylesheet_directory_uri() ) . '/inc/lib/advanced-custom-fields-pro' );


add_filter( 'acf/settings/url', 'ds_acf_settings_url');                 // Customize ACF url setting to fix incorrect asset URLs.
add_filter( 'acf/settings/path', 'ds_acf_settings_path' );              // Customize ACF path
add_filter( 'acf/settings/show_admin', 'ds_acf_settings_show_admin' );  // Hide ACF field group menu item

include_once trailingslashit( DS_ACF_PATH ) . 'acf.php'; // Include ACF

function ds_acf_settings_url( $url ) {
	$url = trailingslashit( DS_ACF_URL );
	return $url;
}
function ds_acf_settings_path( $path ) {
	$path = trailingslashit( DS_ACF_PATH ); // update path
	return $path;
}
function ds_acf_settings_show_admin( $show_admin ) {
	return true;
}

add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
	//if (!current_user_can('administrator') && !is_admin()) {
		//  show_admin_bar(false);
	//}
}

function strlimit($str,$limit=10,$add='...'){
	$str = substr($str, 0,$limit).$add;
	return $str;
}

function wordlimit($text='',$num_words='10',$more=''){
	return wp_trim_words($text,$num_words,$more);
}

function addUrlLink($url, $scheme = 'http://')
{
  return parse_url($url, PHP_URL_SCHEME) === null ?
    $scheme . $url : $url;
}


 /*
* Add Image sizes
*/
if ( !function_exists('smarter_add_image_sizes') ){

	function smarter_add_image_sizes() {
        
        // Add your own image sizes
        add_image_size( 'social_logo', 25, 25);
		add_image_size( 'home_page_slider', 1920,360,true);
    }
}
add_action( 'after_setup_theme', 'smarter_add_image_sizes' );


if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Theme General Settings',
		'menu_title'	=> 'Theme Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Header Settings',
		'menu_title'	=> 'Header',
		'parent_slug'	=> 'theme-general-settings',
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Footer Settings',
		'menu_title'	=> 'Footer',
		'parent_slug'	=> 'theme-general-settings',
	));
	
}



function required_custom_post_types(){
   /*
   register_post_type('news', array(
       'labels' => array('name' => 'News'),
       'public' => true,
       'menu_position'=> 23,
       'supports' => array('title','editor','thumbnail','excerpt'),
       'rewrite'=> array('slug'=> 'news'),
       'menu_icon' => 'dashicons-table-row-before'
   )); 
   */

	register_post_type('tab-feature', array(
		'labels' => array('name' => 'Featured Tab'),
		'public' => true,
		'menu_position'=> 23,
		'supports' => array('title'),
		'rewrite'=> array('slug'=> 'tab-feature'),
		'menu_icon' => 'dashicons-editor-contract'
	)); 
}
add_action('init','required_custom_post_types');
