<?php
/**
 * shedrub_network functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package shedrub_network
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.2' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function shedrub_network_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on shedrub_network, use a find and replace
		* to change 'shedrub_network' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'shedrub_network', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'primary_menu' => esc_html__( 'Primary', 'shedrub_network' ),
		)
	);

	function add_class_to_all_menu_anchors( $atts ) {
		$atts['class'] = 'nav-link';	 
		return $atts;
	}
	add_filter( 'nav_menu_link_attributes', 'add_class_to_all_menu_anchors', 10 );

	function wpdocs_channel_nav_class( $classes, $item, $args ) {
 
		if ( 'primary_menu' === $args->theme_location ) {
			$classes[] = "nav-item";
		}	 
		return $classes;
	}
	add_filter( 'nav_menu_css_class' , 'wpdocs_channel_nav_class' , 10, 4 );


	function get_pkb_sub_menu_submenu_button( $direction = 'down', $title ) {
		$button .= ' <i class="fa fa-angle-' . $direction . '" aria-hidden="true"></i>';		
		return $button;
	}
	
	
	/**
	 * Function to add Dropdown Icon for Primary menu items that has submenu.
	 *
	 * @param [type] $title
	 * @param [type] $item
	 * @param [type] $args
	 * @param [type] $depth
	 * @return void
	 */
	function pkb_submenu_dropdown_icon( $title, $item, $args, $depth ) {
	
		if ( 'primary_menu' === $args->theme_location ) {
	
			if ( in_array( 'menu-item-has-children', $item->classes ) ) {
				if ( 0 === $depth ) {
					$title .= get_pkb_sub_menu_submenu_button( 'down', $title );
				} else {
					$title .= get_pkb_sub_menu_submenu_button( 'right', $title );
				}
			}
		}
	
		return $title;
	}
	add_filter( 'nav_menu_item_title', 'pkb_submenu_dropdown_icon', 10, 4 );


	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'shedrub_network_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'shedrub_network_setup' );


function add_additional_class_on_li($classes, $item, $args) {
    if(isset($args->add_li_class)) {
        $classes[] = $args->add_li_class;
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'add_additional_class_on_li', 1, 3);

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function shedrub_network_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'shedrub_network_content_width', 640 );
}
add_action( 'after_setup_theme', 'shedrub_network_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function shedrub_network_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'shedrub_network' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'shedrub_network' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'shedrub_network_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function shedrub_network_scripts() {
	wp_enqueue_style( 'shedrub_network-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'shedrub_network-style', 'rtl', 'replace' );

	
	wp_enqueue_style( 'style-bundle', get_template_directory_uri() . '/dist/css/bundle.min.css', array(), _S_VERSION, 'all' );
	wp_enqueue_style( 'theme-font-google', 'https://fonts.googleapis.com', array(), _S_VERSION, 'all' );
    wp_enqueue_style( 'theme-fonts.gstatic', 'https://fonts.gstatic.com', array(), _S_VERSION, 'all' );
    wp_enqueue_style( 'theme-fonts.googleapis', 'https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;700&family=Roboto+Slab:wght@300;400;600&display=swap', array(), _S_VERSION, 'all' );
	
	wp_enqueue_style( 'fa-icon-v3', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.css', array(), _S_VERSION, 'all' );
	wp_enqueue_script( 'scripts', get_template_directory_uri() . '/dist/js/scripts.min.js', array(), _S_VERSION, true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'shedrub_network_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}



function clean_custom_menu( $theme_location ) {
    if ( ($theme_location) && ($locations = get_nav_menu_locations()) && isset($locations[$theme_location]) ) {
        $menu = get_term( $locations[$theme_location], 'nav_menu' );
        $menu_items = wp_get_nav_menu_items($menu->term_id);
		
		$menu_list  = '';
        // $menu_list  = '<nav>' ."\n";
        $menu_list .= '<ul class="nav">' ."\n";
 
        $count = 0;
        $submenu = false;
         
        foreach( $menu_items as $menu_item ) {
             
            $link = $menu_item->url;
            $title = $menu_item->title;
             
            if ( !$menu_item->menu_item_parent ) {
                $parent_id = $menu_item->ID;
                 
                $menu_list .= '<li class="nav-item">' ."\n";
                $menu_list .= '<a href="'.$link.'" class="nav-link">'.$title.'</a>' ."\n";
            }
 
            if ( $parent_id == $menu_item->menu_item_parent ) {
 
                if ( !$submenu ) {
                    $submenu = true;
                    $menu_list .= '<ul class="sub-menu">' ."\n";
                }
 
                $menu_list .= '<li class="nav-item">' ."\n";
                $menu_list .= '<a href="'.$link.'" class="nav-link">'.$title.'</a>' ."\n";
                $menu_list .= '</li>' ."\n";
                     
 
                if ( $menu_items[ $count + 1 ]->menu_item_parent != $parent_id && $submenu ){
                    $menu_list .= '</ul>' ."\n";
                    $submenu = false;
                } 
            } 
            $count++;
        }
         
        $menu_list .= '</ul>' ."\n";
        // $menu_list .= '</nav>' ."\n";
 
    } else {
        $menu_list = '<!-- no menu defined in location "'.$theme_location.'" -->';
    }
    echo $menu_list;
}

