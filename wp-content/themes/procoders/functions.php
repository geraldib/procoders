<?php

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

function procoders_setup() {
	load_theme_textdomain( 'procoders', get_template_directory() . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_post_type_support('page', 'excerpt');

	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'procoders' ),
		)
	);
	register_nav_menus(
		array(
			'menu-2' => esc_html__( 'Learning Center', 'procoders' ),
		)
	);
	register_nav_menus(
		array(
			'menu-3' => esc_html__( 'Blog', 'procoders' ),
		)
	);
	register_nav_menus(
		array(
			'menu-4' => esc_html__( 'Event', 'procoders' ),
		)
	);
	add_theme_support(
		'html5',
		array(
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	require_once get_template_directory() . '/walkers/EventWalkerMenu.php';
}
add_action( 'after_setup_theme', 'procoders_setup' );

function gerald_scripts()
{
    // Styles & JS files
    wp_register_style('gerald-style', get_stylesheet_directory_uri() . '/dist/app.css', [], 1, 'all');
    wp_enqueue_script('gerald-script', get_stylesheet_directory_uri() . '/dist/app.js', ['jquery'], 1, true);

    // Enque All
    wp_enqueue_style('gerald-style');
    wp_enqueue_script('gerald-script');
}
add_action('wp_enqueue_scripts', 'gerald_scripts');

function gerald_admin_scripts()
{
    // Styles & JS files
    wp_register_style('gerald-style-admin', get_stylesheet_directory_uri() . '/dist/admin.css', [], 1, 'all');
    // Enque All
    wp_enqueue_style('gerald-style-admin');
}
add_action('admin_enqueue_scripts', 'gerald_admin_scripts');

// Custom Post Types
require_once(get_theme_file_path() . '/post-types/Course.php');



