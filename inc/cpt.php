<?php
/**
 * Custom Post Types Registration
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function mpe2025_register_cpts() {
	
	// Services CPT
	register_post_type( 'service', array(
		'labels' => array(
			'name'               => __( 'Services', 'mpe2025' ),
			'singular_name'      => __( 'Service', 'mpe2025' ),
			'add_new'            => __( 'Add New Service', 'mpe2025' ),
			'add_new_item'       => __( 'Add New Service', 'mpe2025' ),
			'edit_item'          => __( 'Edit Service', 'mpe2025' ),
			'new_item'           => __( 'New Service', 'mpe2025' ),
			'view_item'          => __( 'View Service', 'mpe2025' ),
			'search_items'       => __( 'Search Services', 'mpe2025' ),
			'not_found'          => __( 'No services found', 'mpe2025' ),
			'not_found_in_trash' => __( 'No services found in Trash', 'mpe2025' ),
		),
		'public'      => true,
		'show_in_nav_menus' => true,
		'exclude_from_search' => false,
		'show_in_rest' => true,
		'has_archive' => true,
		'menu_icon'   => 'dashicons-businessman',
		'supports'    => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'rewrite'     => array( 'slug' => 'services' ),
	) );

	// Service APP CPT
	register_post_type( 'service_app', array(
		'labels' => array(
			'name'               => __( 'Services APP', 'mpe2025' ),
			'singular_name'      => __( 'Service APP', 'mpe2025' ),
			'add_new'            => __( 'Add New Service APP', 'mpe2025' ),
			'add_new_item'       => __( 'Add New Service APP', 'mpe2025' ),
			'edit_item'          => __( 'Edit Service APP', 'mpe2025' ),
			'new_item'           => __( 'New Service APP', 'mpe2025' ),
			'view_item'          => __( 'View Service APP', 'mpe2025' ),
			'search_items'       => __( 'Search Services APP', 'mpe2025' ),
			'not_found'          => __( 'No services APP found', 'mpe2025' ),
			'not_found_in_trash' => __( 'No services APP found in Trash', 'mpe2025' ),
		),
		'public'      => true,
		'show_in_nav_menus' => true,
		'exclude_from_search' => false,
		'show_in_rest' => true,
		'has_archive' => true,
		'menu_icon'   => 'dashicons-smartphone', // Icone modifiée pour refléter une APP
		'supports'    => array( 'title', 'editor', 'thumbnail', 'excerpt', 'sticky' ), // Ajout du support 'sticky' comme demandé
		'rewrite'     => array( 'slug' => 'services-app' ),
	) );



	// Google Reviews CPT
	register_post_type( 'google_reviews', array(
		'labels' => array(
			'name'               => __( 'Google Reviews', 'mpe2025' ),
			'singular_name'      => __( 'Review', 'mpe2025' ),
			'add_new'            => __( 'Add New Review', 'mpe2025' ),
			'add_new_item'       => __( 'Add New Review', 'mpe2025' ),
			'edit_item'          => __( 'Edit Review', 'mpe2025' ),
			'new_item'           => __( 'New Review', 'mpe2025' ),
			'view_item'          => __( 'View Review', 'mpe2025' ),
			'search_items'       => __( 'Search Reviews', 'mpe2025' ),
			'not_found'          => __( 'No reviews found', 'mpe2025' ),
			'not_found_in_trash' => __( 'No reviews found in Trash', 'mpe2025' ),
		),
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => false,
		'exclude_from_search' => true,
		'show_in_rest'        => false,
		'has_archive'         => false,
		'menu_icon'           => 'dashicons-star-filled',
		'supports'            => array( 'title', 'editor', 'thumbnail' ), // Added thumbnail support
		'capability_type'     => 'post',
		'map_meta_cap'        => true,
	) );

    // Reservation CPT
    register_post_type( 'reservation', array(
        'labels' => array(
            'name'               => __( 'Réservations', 'mpe2025' ),
            'singular_name'      => __( 'Réservation', 'mpe2025' ),
            'add_new'            => __( 'Ajouter une réservation', 'mpe2025' ), // Should normally be auto-generated
            'add_new_item'       => __( 'Ajouter une réservation', 'mpe2025' ),
            'edit_item'          => __( 'Modifier la réservation', 'mpe2025' ),
            'new_item'           => __( 'Nouvelle réservation', 'mpe2025' ),
            'view_item'          => __( 'Voir la réservation', 'mpe2025' ),
            'search_items'       => __( 'Rechercher des réservations', 'mpe2025' ),
            'not_found'          => __( 'Aucune réservation trouvée', 'mpe2025' ),
            'not_found_in_trash' => __( 'Aucune réservation trouvée dans la corbeille', 'mpe2025' ),
			'menu_name'          => __( 'Réservations', 'mpe2025' ),
        ),
        'public'              => false, // Internal use only
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => false,
        'exclude_from_search' => true,
		'show_in_rest'        => true, // Enabled for External App
        'menu_icon'           => 'dashicons-calendar-alt',
        'supports'            => array( 'title', 'custom-fields' ), // custom-fields required for REST API meta support
        'capability_type'     => 'post',
        'map_meta_cap'        => true,
    ) );

    // Masseuse CPT
    register_post_type( 'masseuse', array(
        'labels' => array(
            'name'               => __( 'Masseuses', 'mpe2025' ),
            'singular_name'      => __( 'Masseuse', 'mpe2025' ),
            'add_new'            => __( 'Ajouter une masseuse', 'mpe2025' ),
            'add_new_item'       => __( 'Ajouter une nouvelle masseuse', 'mpe2025' ),
            'edit_item'          => __( 'Modifier la masseuse', 'mpe2025' ),
            'new_item'           => __( 'Nouvelle masseuse', 'mpe2025' ),
            'view_item'          => __( 'Voir la masseuse', 'mpe2025' ),
            'search_items'       => __( 'Rechercher des masseuses', 'mpe2025' ),
            'not_found'          => __( 'Aucune masseuse trouvée', 'mpe2025' ),
            'not_found_in_trash' => __( 'Aucune masseuse trouvée dans la corbeille', 'mpe2025' ),
			'menu_name'          => __( 'Masseuses', 'mpe2025' ),
        ),
        'public'              => false, // Internal management
        'show_ui'             => true,
        'show_in_menu'        => true,
		'show_in_rest'        => true, // Use block editor
        'menu_icon'           => 'dashicons-heart',
        'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
        'rewrite'             => array( 'slug' => 'masseuses' ),
    ) );
}
add_action( 'init', 'mpe2025_register_cpts' );
