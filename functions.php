<?php
/**
 * Genesis Starter Theme.
 *
 * This file adds functions to the Genesis Starter Theme.
 *
 * @package Genesis Starter Theme
 * @author  Eneko Amieva
 * @license GPL-2.0+
 * @link    http://www.enekoamieva.com/
 */

// Start the Genesis Framework engine.
include_once( get_template_directory() . '/lib/init.php' );

// Setup Theme.
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

// Set Localization (do not remove).
add_action( 'after_setup_theme', 'genesis_starter_localization_setup' );
function genesis_starter_localization_setup(){
	load_child_theme_textdomain( 'genesis-starter', get_stylesheet_directory() . '/languages' );
}


// Child theme (do not remove).
define( 'CHILD_THEME_NAME', 'Genesis Starter Theme' );
define( 'CHILD_THEME_URL', 'http://www.enekoamieva.com/' );
define( 'CHILD_THEME_VERSION', '1.0.0' );

// Enqueue Scripts and Styles.
add_action( 'wp_enqueue_scripts', 'genesis_starter_enqueue_scripts_styles' );
function genesis_starter_enqueue_scripts_styles() {

	wp_enqueue_style( 'genesis-starter-fonts', '//fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'dashicons' );

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script( 'genesis-starter-responsive-menu', get_stylesheet_directory_uri() . "/js/responsive-menus{$suffix}.js", array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_localize_script(
		'genesis-starter-responsive-menu',
		'genesis_responsive_menu',
		genesis_starter_responsive_menu_settings()
	);

}

// Define our responsive menu settings.
function genesis_starter_responsive_menu_settings() {

	$settings = array(
		'mainMenu'          => __( 'Menu', 'genesis-starter' ),
		'menuIconClass'     => 'dashicons-before dashicons-menu',
		'subMenu'           => __( 'Submenu', 'genesis-starter' ),
		'subMenuIconsClass' => 'dashicons-before dashicons-arrow-down-alt2',
		'menuClasses'       => array(
			'combine' => array(
				'.nav-primary',
				'.nav-header',
			),
			'others'  => array(),
		),
	);

	return $settings;

}

// Add HTML5 markup structure.
add_theme_support( 'html5', array( 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ) );

// Add Accessibility support.
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'rems', 'search-form', 'skip-links' ) );

// Add viewport meta tag for mobile browsers.
add_theme_support( 'genesis-responsive-viewport' );

// Add support for custom header.
add_theme_support( 'custom-header', array(
	'width'           => 600,
	'height'          => 160,
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'flex-height'     => true,
) );

// Add support for after entry widget.
add_theme_support( 'genesis-after-entry-widget-area' );

// Add support for 3-column footer widgets.
add_theme_support( 'genesis-footer-widgets', 3 );

// Add Image Sizes.
add_image_size( 'featured-image', 720, 400, TRUE );

// Rename primary and secondary navigation menus.
add_theme_support( 'genesis-menus', array( 'primary' => __( 'After Header Menu', 'genesis-starter' ), 'secondary' => __( 'Footer Menu', 'genesis-starter' ) ) );

// Reposition the secondary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 5 );

// Reduce the secondary navigation menu to one level depth.
add_filter( 'wp_nav_menu_args', 'genesis_starter_secondary_menu_args' );
function genesis_starter_secondary_menu_args( $args ) {

	if ( 'secondary' != $args['theme_location'] ) {
		return $args;
	}

	$args['depth'] = 1;

	return $args;

}

// Modify size of the Gravatar in the author box.
add_filter( 'genesis_author_box_gravatar_size', 'genesis_starter_author_box_gravatar' );
function genesis_starter_author_box_gravatar( $size ) {
	return 90;
}

// Modify size of the Gravatar in the entry comments.
add_filter( 'genesis_comment_list_args', 'genesis_starter_comments_gravatar' );
function genesis_starter_comments_gravatar( $args ) {

	$args['avatar_size'] = 60;

	return $args;

}
