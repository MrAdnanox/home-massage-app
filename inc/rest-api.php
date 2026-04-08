<?php
/**
 * REST API Enhancements
 * Expose custom fields for Reservations and Drivers
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register post meta for REST API
 */
function mpe2025_register_post_meta() {
    // Reservation Meta
    $reservation_meta = array(
        '_mpe_reservation_date',
        '_mpe_reservation_time',
        '_mpe_reservation_name',
        '_mpe_reservation_email',
        '_mpe_reservation_phone',
        '_mpe_reservation_object',
        '_mpe_reservation_message',
        '_mpe_reservation_page_url',
        '_mpe_reservation_status',
        '_mpe_reservation_city',
        '_mpe_reservation_masseuse_id'
    );

    foreach ( $reservation_meta as $meta_key ) {
        register_post_meta( 'reservation', $meta_key, array(
            'show_in_rest'  => true,
            'single'        => true,
            'type'          => 'string',
            'auth_callback' => function() {
                return current_user_can( 'edit_posts' );
            },
        ) );
    }

    // Masseuse Meta
    $masseuse_meta = array(
        'masseuse_phone',
        'masseuse_gender'
    );

    foreach ( $masseuse_meta as $meta_key ) {
        register_post_meta( 'masseuse', $meta_key, array(
            'show_in_rest'  => true,
            'single'        => true,
            'type'          => 'string',
            'auth_callback' => function() {
                return current_user_can( 'edit_posts' );
            },
        ) );
    }
}
add_action( 'init', 'mpe2025_register_post_meta' );

/**
 * Register REST Fields
 */
function mpe2025_register_rest_fields() {
    
    // Reservation Fields
    $reservation_fields = array(
        'client_name'   => '_mpe_reservation_name',
        'client_email'  => '_mpe_reservation_email',
        'client_phone'  => '_mpe_reservation_phone', // mapped to phone
        'city'          => '_mpe_reservation_city',
        'trip_date'     => '_mpe_reservation_date',
        'trip_time'     => '_mpe_reservation_time',
        'trip_object'   => '_mpe_reservation_object',
        'message'       => '_mpe_reservation_message',
        'page_url'      => '_mpe_reservation_page_url',
        'status'        => '_mpe_reservation_status',
        'masseuse_id'   => '_mpe_reservation_masseuse_id',
    );

    foreach ( $reservation_fields as $field_name => $meta_key ) {
        register_rest_field( 'reservation', $field_name, array(
            'get_callback'    => function( $object ) use ( $meta_key ) {
                return get_post_meta( $object['id'], $meta_key, true );
            },
            'update_callback' => function( $value, $object ) use ( $meta_key ) {
                return update_post_meta( $object->ID, $meta_key, sanitize_text_field( $value ) );
            },
            'schema'          => array(
                'type' => 'string',
                'arg_options' => array(
                    'sanitize_callback' => 'sanitize_text_field',
                ),
            ),
        ) );
    }

    // Masseuse Fields
    register_rest_field( 'masseuse', 'phone', array(
        'get_callback'    => function( $object ) {
            return get_post_meta( $object['id'], 'masseuse_phone', true );
        },
        'update_callback' => function( $value, $object ) {
            return update_post_meta( $object->ID, 'masseuse_phone', sanitize_text_field( $value ) );
        },
        'schema'          => array(
            'type' => 'string',
        ),
    ) );

    register_rest_field( 'masseuse', 'gender', array(
        'get_callback'    => function( $object ) {
            return get_post_meta( $object['id'], 'masseuse_gender', true );
        },
        'update_callback' => function( $value, $object ) {
            return update_post_meta( $object->ID, 'masseuse_gender', sanitize_text_field( $value ) );
        },
        'schema'          => array(
            'type' => 'string',
        ),
    ) );

    // Sticky Field for Services
    $service_types = array( 'service', 'service_app' );
    foreach ( $service_types as $type ) {
        register_rest_field( $type, 'is_sticky', array(
            'get_callback'    => function( $object ) {
                return get_post_meta( $object['id'], '_mpe2025_is_sticky', true ) === '1';
            },
            'update_callback' => function( $value, $object ) {
                if ( $value ) {
                    return update_post_meta( $object->ID, '_mpe2025_is_sticky', '1' );
                } else {
                    return delete_post_meta( $object->ID, '_mpe2025_is_sticky' );
                }
            },
            'schema'          => array(
                'type' => 'boolean',
            ),
        ) );

        register_rest_field( $type, 'price', array(
            'get_callback'    => function( $object ) {
                return get_post_meta( $object['id'], '_mpe2025_service_price', true );
            },
            'update_callback' => function( $value, $object ) {
                return update_post_meta( $object->ID, '_mpe2025_service_price', sanitize_text_field( $value ) );
            },
            'schema'          => array(
                'type' => 'string',
            ),
        ) );

        register_rest_field( $type, 'duration', array(
            'get_callback'    => function( $object ) {
                return get_post_meta( $object['id'], '_mpe2025_service_duration', true );
            },
            'update_callback' => function( $value, $object ) {
                return update_post_meta( $object->ID, '_mpe2025_service_duration', sanitize_text_field( $value ) );
            },
            'schema'          => array(
                'type' => 'string',
            ),
        ) );
    }
}
add_action( 'rest_api_init', 'mpe2025_register_rest_fields' );

/**
 * Filter Reservations by Custom Status via API
 * Usage: GET /wp-json/wp/v2/reservation?status_filter=pending
 */
function mpe2025_filter_reservations_by_data( $args, $request ) {
    $status_filter = $request->get_param( 'status_filter' );
    
    if ( ! empty( $status_filter ) ) {
        $args['meta_query'] = array(
            array(
                'key'     => '_mpe_reservation_status',
                'value'   => $status_filter,
                'compare' => '=',
            ),
        );
    }
    
    return $args;
}
add_filter( 'rest_reservation_query', 'mpe2025_filter_reservations_by_data', 10, 2 );

/**
 * Filter Masseuses by Gender via API
 * Usage: GET /wp-json/wp/v2/masseuse?gender_filter=female
 */
function mpe2025_filter_masseuses_by_data( $args, $request ) {
    $gender_filter = $request->get_param( 'gender_filter' );
    
    if ( ! empty( $gender_filter ) ) {
        $args['meta_query'] = array(
            array(
                'key'     => 'masseuse_gender',
                'value'   => $gender_filter,
                'compare' => '=',
            ),
        );
    }
    
    return $args;
}
add_filter( 'rest_masseuse_query', 'mpe2025_filter_masseuses_by_data', 10, 2 );

/**
 * Register custom endpoint for Theme Settings
 */
add_action( 'rest_api_init', function () {
    register_rest_route( 'mpe/v1', '/settings', array(
        'methods' => 'GET',
        'callback' => 'mpe2025_get_theme_settings',
        'permission_callback' => '__return_true',
    ) );
} );

function mpe2025_get_theme_settings() {
    $options = get_option( 'mpe_theme_options' );
    $whatsapp_number = isset( $options['whatsapp_number'] ) ? $options['whatsapp_number'] : '';
    // Format to only keep numbers and plus
    $whatsapp_number = preg_replace('/[^0-9+]/', '', $whatsapp_number);
    return rest_ensure_response( array(
        'whatsapp_number' => $whatsapp_number,
    ) );
}
