<?php
/**
 * Custom Meta Boxes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}



/**
 * Custom Meta Boxes for Masseuses
 */
function mpe2025_add_masseuse_meta_boxes() {
    add_meta_box(
        'mpe2025_masseuse_details',
        __( 'Détails de la masseuse', 'mpe2025' ),
        'mpe2025_masseuse_meta_box_callback',
        'masseuse',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'mpe2025_add_masseuse_meta_boxes' );

function mpe2025_masseuse_meta_box_callback( $post ) {
    wp_nonce_field( 'mpe2025_save_masseuse_details', 'mpe2025_masseuse_details_nonce' );
    
    $phone = get_post_meta( $post->ID, 'masseuse_phone', true );
    $gender = get_post_meta( $post->ID, 'masseuse_gender', true );
    ?>
    <p>
        <label for="masseuse_phone"><?php _e( 'Téléphone:', 'mpe2025' ); ?></label>
        <input type="text" id="masseuse_phone" name="masseuse_phone" value="<?php echo esc_attr( $phone ); ?>" class="widefat" />
    </p>
    <p>
        <label for="masseuse_gender"><?php _e( 'Genre:', 'mpe2025' ); ?></label>
        <select id="masseuse_gender" name="masseuse_gender" class="widefat">
            <option value=""><?php _e( '-- Sélectionner --', 'mpe2025' ); ?></option>
            <option value="female" <?php selected( $gender, 'female' ); ?>><?php _e( 'Femme', 'mpe2025' ); ?></option>
            <option value="male" <?php selected( $gender, 'male' ); ?>><?php _e( 'Homme', 'mpe2025' ); ?></option>
        </select>
    </p>
    <?php
}

function mpe2025_save_masseuse_details( $post_id ) {
    if ( ! isset( $_POST['mpe2025_masseuse_details_nonce'] ) ) {
        return;
    }
    if ( ! wp_verify_nonce( $_POST['mpe2025_masseuse_details_nonce'], 'mpe2025_save_masseuse_details' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['masseuse_phone'] ) ) {
        update_post_meta( $post_id, 'masseuse_phone', sanitize_text_field( $_POST['masseuse_phone'] ) );
    }

    if ( isset( $_POST['masseuse_gender'] ) ) {
        update_post_meta( $post_id, 'masseuse_gender', sanitize_text_field( $_POST['masseuse_gender'] ) );
    }
}
add_action( 'save_post', 'mpe2025_save_masseuse_details' );

/**
 * Custom Admin Columns for Masseuses
 */
function mpe2025_set_masseuse_columns( $columns ) {
    $new_columns = array();
    foreach($columns as $key => $label) {
        $new_columns[$key] = $label;
        if($key == 'title') {
            $new_columns['genre'] = __( 'Genre', 'mpe2025' );
            $new_columns['phone'] = __( 'Téléphone', 'mpe2025' );
        }
    }
    return $new_columns;
}
add_filter( 'manage_masseuse_posts_columns', 'mpe2025_set_masseuse_columns' );

function mpe2025_masseuse_custom_column( $column, $post_id ) {
    if ( $column === 'genre' ) {
        $gender = get_post_meta( $post_id, 'masseuse_gender', true );
        if ( $gender === 'female' ) echo '🌸 ' . __( 'Femme', 'mpe2025' );
        elseif ( $gender === 'male' ) echo '👔 ' . __( 'Homme', 'mpe2025' );
        else echo '-';
    }
    if ( $column === 'phone' ) {
        echo get_post_meta( $post_id, 'masseuse_phone', true );
    }
}
add_action( 'manage_masseuse_posts_custom_column', 'mpe2025_masseuse_custom_column', 10, 2 );

/**
 * Custom Meta Box for Sticky Option on Services and Service APPs
 */
function mpe2025_add_services_sticky_meta_box() {
    $post_types = array( 'service', 'service_app' );
    foreach ( $post_types as $post_type ) {
        add_meta_box(
            'mpe2025_sticky_meta',
            __( 'Mise en avant (Sticky)', 'mpe2025' ),
            'mpe2025_sticky_meta_callback',
            $post_type,
            'side',
            'high'
        );
    }
}
add_action( 'add_meta_boxes', 'mpe2025_add_services_sticky_meta_box' );

/**
 * Custom Meta Box for Price & Duration on Services and Service APPs
 */
function mpe2025_add_services_price_meta_box() {
    $post_types = array( 'service', 'service_app' );
    foreach ( $post_types as $post_type ) {
        add_meta_box(
            'mpe2025_price_meta',
            __( 'Prix & Durée du Service', 'mpe2025' ),
            'mpe2025_price_meta_callback',
            $post_type,
            'side',
            'high'
        );
    }
}
add_action( 'add_meta_boxes', 'mpe2025_add_services_price_meta_box' );

function mpe2025_price_meta_callback( $post ) {
    wp_nonce_field( 'mpe2025_save_price', 'mpe2025_price_nonce' );
    $price = get_post_meta( $post->ID, '_mpe2025_service_price', true );
    $duration = get_post_meta( $post->ID, '_mpe2025_service_duration', true );
    ?>
    <p>
        <label>
            <?php _e( 'Prix :', 'mpe2025' ); ?><br />
            <input type="text" name="mpe2025_service_price" value="<?php echo esc_attr( $price ); ?>" class="widefat" placeholder="ex: 350, 500 MAD" />
        </label>
    </p>
    <p>
        <label>
            <?php _e( 'Durée :', 'mpe2025' ); ?><br />
            <input type="text" name="mpe2025_service_duration" value="<?php echo esc_attr( $duration ); ?>" class="widefat" placeholder="ex: 60 min, 1h30" />
        </label>
    </p>
    <?php
}

function mpe2025_sticky_meta_callback( $post ) {
    wp_nonce_field( 'mpe2025_save_sticky', 'mpe2025_sticky_nonce' );
    $is_sticky = get_post_meta( $post->ID, '_mpe2025_is_sticky', true ) === '1';
    ?>
    <p>
        <label>
            <input type="checkbox" name="mpe2025_sticky_checkbox" value="1" <?php checked( $is_sticky, true ); ?> />
            <?php _e( 'Cocher pour mettre en avant (Sticky)', 'mpe2025' ); ?>
        </label>
    </p>
    <?php
}

function mpe2025_save_sticky_meta( $post_id, $post, $update ) {
    // Ne rien faire sur les autosaves
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Vérifier les permissions
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    
    // Identifier s'il s'agit d'une sauvegarde via Quick Edit
    $is_quick_edit = isset( $_POST['_inline_edit'] ) && wp_verify_nonce( $_POST['_inline_edit'], 'inlineeditnonce' );
    
    // Identifier s'il s'agit d'une sauvegarde de Meta Box classique (Gutenberg Legacy ou Classic Editor)
    $is_meta_box = isset( $_POST['mpe2025_sticky_nonce'] ) && wp_verify_nonce( $_POST['mpe2025_sticky_nonce'], 'mpe2025_save_sticky' );

    // Si aucune des deux méthodes n'est reconnue, on abandonne.
    if ( ! $is_quick_edit && ! $is_meta_box ) {
        return;
    }

    // Gestion de l'option de mise en avant avec un Post Meta dédié (plus fiable pour les CPT que stick_post natif)
    if ( isset( $_POST['mpe2025_sticky_checkbox'] ) ) {
        update_post_meta( $post_id, '_mpe2025_is_sticky', '1' );
    } else {
        delete_post_meta( $post_id, '_mpe2025_is_sticky' );
    }
}
add_action( 'save_post_service', 'mpe2025_save_sticky_meta', 10, 3 );
add_action( 'save_post_service_app', 'mpe2025_save_sticky_meta', 10, 3 );

function mpe2025_save_price_meta( $post_id, $post, $update ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    
    // Identifier s'il s'agit d'une sauvegarde via Quick Edit
    $is_quick_edit = isset( $_POST['_inline_edit'] ) && wp_verify_nonce( $_POST['_inline_edit'], 'inlineeditnonce' );
    
    // Identifier s'il s'agit d'une sauvegarde de Meta Box classique
    $is_meta_box = isset( $_POST['mpe2025_price_nonce'] ) && wp_verify_nonce( $_POST['mpe2025_price_nonce'], 'mpe2025_save_price' );

    if ( ! $is_quick_edit && ! $is_meta_box ) {
        return;
    }

    if ( isset( $_POST['mpe2025_service_price'] ) ) {
        update_post_meta( $post_id, '_mpe2025_service_price', sanitize_text_field( $_POST['mpe2025_service_price'] ) );
    }
    
    if ( isset( $_POST['mpe2025_service_duration'] ) ) {
        update_post_meta( $post_id, '_mpe2025_service_duration', sanitize_text_field( $_POST['mpe2025_service_duration'] ) );
    }
}
add_action( 'save_post_service', 'mpe2025_save_price_meta', 10, 3 );
add_action( 'save_post_service_app', 'mpe2025_save_price_meta', 10, 3 );

/**
 * Custom Admin Columns & Quick Edit for Services & Service APPs Sticky
 */
function mpe2025_service_sticky_column( $columns ) {
    $new_columns = array();
    foreach ( $columns as $key => $title ) {
        $new_columns[ $key ] = $title;
        if ( $key === 'title' ) {
            $new_columns['is_sticky_col'] = __( 'Mise en avant', 'mpe2025' );
            $new_columns['price_col'] = __( 'Prix & Durée', 'mpe2025' );
        }
    }
    return $new_columns;
}
add_filter( 'manage_service_posts_columns', 'mpe2025_service_sticky_column' );
add_filter( 'manage_service_app_posts_columns', 'mpe2025_service_sticky_column' );

function mpe2025_service_sticky_column_content( $column, $post_id ) {
    if ( $column === 'is_sticky_col' ) {
        $is_sticky = get_post_meta( $post_id, '_mpe2025_is_sticky', true ) === '1';
        echo '<div class="mpe-sticky-indicator" data-sticky="' . ( $is_sticky ? '1' : '0' ) . '">';
        if ( $is_sticky ) {
            echo '<span class="dashicons dashicons-star-filled" style="color:#f56e28;" title="' . esc_attr__( 'Mis en avant', 'mpe2025' ) . '"></span>';
        } else {
            echo '<span class="dashicons dashicons-star-empty" style="color:#ccc;"></span>';
        }
        echo '</div>';
    }
    if ( $column === 'price_col' ) {
        $price = get_post_meta( $post_id, '_mpe2025_service_price', true );
        $duration = get_post_meta( $post_id, '_mpe2025_service_duration', true );
        
        echo '<div class="mpe-price-indicator" data-price="' . esc_attr( $price ) . '" data-duration="' . esc_attr( $duration ) . '">';
        if ( $price ) echo '<strong>' . esc_html( $price ) . '</strong>';
        if ( $price && $duration ) echo ' - ';
        if ( $duration ) echo esc_html( $duration );
        if ( ! $price && ! $duration ) echo '-';
        echo '</div>';
    }
}
add_action( 'manage_service_posts_custom_column', 'mpe2025_service_sticky_column_content', 10, 2 );
add_action( 'manage_service_app_posts_custom_column', 'mpe2025_service_sticky_column_content', 10, 2 );

// Quick Edit Box
function mpe2025_service_quick_edit_custom_box( $column_name, $post_type ) {
    if ( $column_name === 'is_sticky_col' && in_array( $post_type, array( 'service', 'service_app' ) ) ) {
        wp_nonce_field( 'mpe2025_save_sticky', 'mpe2025_sticky_nonce' );
        wp_nonce_field( 'mpe2025_save_price', 'mpe2025_price_nonce' );
        ?>
        <fieldset class="inline-edit-col-center inline-edit-categories">
            <div class="inline-edit-col">
                <label class="alignleft">
                    <input type="checkbox" name="mpe2025_sticky_checkbox" value="1" class="mpe2025-sticky-quick-edit-cb" />
                    <span class="checkbox-title"><?php _e( 'Mettre en avant (Sticky)', 'mpe2025' ); ?></span>
                </label>
            </div>
            
            <div class="inline-edit-col">
                <label class="alignleft">
                    <span class="title"><?php _e( 'Prix', 'mpe2025' ); ?></span>
                    <span class="input-text-wrap"><input type="text" name="mpe2025_service_price" value="" class="mpe2025-price-quick-edit-input" /></span>
                </label>
                <label class="alignleft mt-2">
                    <span class="title"><?php _e( 'Durée', 'mpe2025' ); ?></span>
                    <span class="input-text-wrap"><input type="text" name="mpe2025_service_duration" value="" class="mpe2025-duration-quick-edit-input" /></span>
                </label>
            </div>
        </fieldset>
        <?php
    }
}
add_action( 'quick_edit_custom_box', 'mpe2025_service_quick_edit_custom_box', 10, 2 );

// JS for Quick Edit Population
function mpe2025_service_quick_edit_js() {
    $current_screen = get_current_screen();
    if ( ! $current_screen || ! in_array( $current_screen->post_type, array( 'service', 'service_app' ) ) ) {
        return;
    }
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            if (typeof inlineEditPost !== 'undefined') {
                var wp_inline_edit = inlineEditPost.edit;
                inlineEditPost.edit = function(id) {
                    var post_id = 0;
                    if (typeof(id) == 'object') {
                        post_id = parseInt(this.getId(id));
                    } else {
                        post_id = id;
                    }
                    
                    wp_inline_edit.apply(this, arguments);
                    
                    if (post_id > 0) {
                        var isSticky = $('#post-' + post_id).find('.mpe-sticky-indicator').data('sticky');
                        $('#edit-' + post_id).find('.mpe2025-sticky-quick-edit-cb').prop('checked', isSticky == '1');
                        
                        var price = $('#post-' + post_id).find('.mpe-price-indicator').data('price');
                        $('#edit-' + post_id).find('.mpe2025-price-quick-edit-input').val(price);
                        
                        var duration = $('#post-' + post_id).find('.mpe-price-indicator').data('duration');
                        $('#edit-' + post_id).find('.mpe2025-duration-quick-edit-input').val(duration);
                    }
                };
            }
        });
    </script>
    <?php
}
add_action( 'admin_footer', 'mpe2025_service_quick_edit_js' );
