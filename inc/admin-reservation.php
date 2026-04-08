<?php
/**
 * Reservation Management - Meta Boxes & Admin Columns
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Add Meta Boxes
 */
function mpe2025_add_reservation_meta_boxes() {
    add_meta_box(
        'mpe_reservation_details',
        __( 'Détails de la réservation', 'mpe2025' ),
        'mpe2025_render_reservation_details_box',
        'reservation',
        'normal',
        'high'
    );

    add_meta_box(
        'mpe_reservation_management',
        __( 'Gestion de la réservation', 'mpe2025' ),
        'mpe2025_render_reservation_management_box',
        'reservation',
        'side',
        'high'
    );
}
add_action( 'add_meta_boxes', 'mpe2025_add_reservation_meta_boxes' );

/**
 * Render Details Meta Box (Read Only)
 */
function mpe2025_render_reservation_details_box( $post ) {
    $date    = get_post_meta( $post->ID, '_mpe_reservation_date', true );
    $time    = get_post_meta( $post->ID, '_mpe_reservation_time', true );
    $name    = get_post_meta( $post->ID, '_mpe_reservation_name', true ); // Added name meta
    $city    = get_post_meta( $post->ID, '_mpe_reservation_city', true );
    $email   = get_post_meta( $post->ID, '_mpe_reservation_email', true );
    $phone   = get_post_meta( $post->ID, '_mpe_reservation_phone', true ); // Changed from tel to phone to match standard english but kept consistancy with form handler mapping needed later
    $object  = get_post_meta( $post->ID, '_mpe_reservation_object', true );
    $message = get_post_meta( $post->ID, '_mpe_reservation_message', true );
    $url     = get_post_meta( $post->ID, '_mpe_reservation_page_url', true );
    ?>
    <table class="form-table">
        <tr>
            <th><label for="mpe_reservation_date"><?php _e( 'Date souhaitée', 'mpe2025' ); ?></label></th>
            <td>
                <input type="date" name="mpe_reservation_date" id="mpe_reservation_date" value="<?php echo esc_attr( $date ); ?>" class="regular-text">
            </td>
        </tr>
        <tr>
            <th><label for="mpe_reservation_time"><?php _e( 'Heure souhaitée', 'mpe2025' ); ?></label></th>
            <td>
                <input type="time" name="mpe_reservation_time" id="mpe_reservation_time" value="<?php echo esc_attr( $time ); ?>" class="regular-text">
            </td>
        </tr>
        <tr>
            <th><label for="mpe_reservation_name"><?php _e( 'Nom du client', 'mpe2025' ); ?></label></th>
            <td>
                <input type="text" name="mpe_reservation_name" id="mpe_reservation_name" value="<?php echo esc_attr( $name ); ?>" class="regular-text">
            </td>
        </tr>
        <tr>
            <th><label for="mpe_reservation_city"><?php _e( 'Ville', 'mpe2025' ); ?></label></th>
            <td>
                <input type="text" name="mpe_reservation_city" id="mpe_reservation_city" value="<?php echo esc_attr( $city ); ?>" class="regular-text">
            </td>
        </tr>
        <tr>
            <th><label for="mpe_reservation_email"><?php _e( 'Email', 'mpe2025' ); ?></label></th>
            <td>
                <input type="email" name="mpe_reservation_email" id="mpe_reservation_email" value="<?php echo esc_attr( $email ); ?>" class="regular-text">
            </td>
        </tr>
        <tr>
            <th><label for="mpe_reservation_phone"><?php _e( 'Téléphone', 'mpe2025' ); ?></label></th>
            <td>
                <input type="text" name="mpe_reservation_phone" id="mpe_reservation_phone" value="<?php echo esc_attr( $phone ); ?>" class="regular-text">
            </td>
        </tr>
        <tr>
            <th><label for="mpe_reservation_object"><?php _e( 'Objet / Excursion', 'mpe2025' ); ?></label></th>
            <td>
                <input type="text" name="mpe_reservation_object" id="mpe_reservation_object" value="<?php echo esc_attr( $object ); ?>" class="regular-text" style="width: 100%;">
                <?php if ( $url ) : ?>
                    <br><small><a href="<?php echo esc_url( $url ); ?>" target="_blank"><?php _e( 'Voir la page source', 'mpe2025' ); ?></a></small>
                    <input type="hidden" name="mpe_reservation_page_url" value="<?php echo esc_attr( $url ); ?>">
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th><label for="mpe_reservation_message"><?php _e( 'Message', 'mpe2025' ); ?></label></th>
            <td>
                <textarea name="mpe_reservation_message" id="mpe_reservation_message" rows="5" class="large-text"><?php echo esc_textarea( $message ); ?></textarea>
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Render Management Meta Box (Status & Driver)
 */
function mpe2025_render_reservation_management_box( $post ) {
    wp_nonce_field( 'mpe_save_reservation_meta', 'mpe_reservation_meta_nonce' );

    $status    = get_post_meta( $post->ID, '_mpe_reservation_status', true );
    $masseuse_id = get_post_meta( $post->ID, '_mpe_reservation_masseuse_id', true );

    // Default status
    if ( ! $status ) {
        $status = 'pending';
    }

    $statuses = array(
        'pending'   => __( 'Demande (En attente)', 'mpe2025' ),
        'confirmed' => __( 'Confirmée', 'mpe2025' ),
        'completed' => __( 'Terminée', 'mpe2025' ),
        'cancelled' => __( 'Annulée', 'mpe2025' ),
    );

    // Get masseuses
    $masseuses = get_posts( array(
        'post_type'      => 'masseuse',
        'posts_per_page' => -1,
        'orderby'        => 'title',
        'order'          => 'ASC',
    ) );
    ?>
    <p>
        <label for="mpe_reservation_status"><strong><?php _e( 'Statut', 'mpe2025' ); ?></strong></label>
        <br>
        <select name="mpe_reservation_status" id="mpe_reservation_status" class="widefat">
            <?php foreach ( $statuses as $value => $label ) : ?>
                <option value="<?php echo esc_attr( $value ); ?>" <?php selected( $status, $value ); ?>>
                    <?php echo esc_html( $label ); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </p>
    
    <p>
        <label for="mpe_reservation_masseuse_id"><strong><?php _e( 'Assigner une masseuse', 'mpe2025' ); ?></strong></label>
        <br>
        <select name="mpe_reservation_masseuse_id" id="mpe_reservation_masseuse_id" class="widefat">
            <option value=""><?php _e( '-- Sélectionner une masseuse --', 'mpe2025' ); ?></option>
            <?php foreach ( $masseuses as $masseuse ) : ?>
                <option value="<?php echo esc_attr( $masseuse->ID ); ?>" <?php selected( $masseuse_id, $masseuse->ID ); ?>>
                    <?php echo esc_html( $masseuse->post_title ); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </p>

    <div style="margin-top: 15px; border-top: 1px solid #eee; padding-top: 10px;">
        <?php if ( $masseuse_id ) : ?>
            <?php $masseuse_phone = get_post_meta( $masseuse_id, 'masseuse_phone', true ); // Assuming masseuse has phone meta ?>
            <p><strong><?php _e( 'Info Masseuse:', 'mpe2025' ); ?></strong></p>
            <p><a href="<?php echo get_edit_post_link( $masseuse_id ); ?>"><?php _e( 'Voir la fiche masseuse', 'mpe2025' ); ?></a></p>
        <?php endif; ?>
    </div>
    <?php
}

/**
 * Save Meta Data
 */
function mpe2025_save_reservation_meta( $post_id ) {
    // Check nonce
    if ( ! isset( $_POST['mpe_reservation_meta_nonce'] ) || ! wp_verify_nonce( $_POST['mpe_reservation_meta_nonce'], 'mpe_save_reservation_meta' ) ) {
        return;
    }

    // Check autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check permissions
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    // Save Status
    if ( isset( $_POST['mpe_reservation_status'] ) ) {
        update_post_meta( $post_id, '_mpe_reservation_status', sanitize_text_field( $_POST['mpe_reservation_status'] ) );
    }

    // Save Masseuse
    if ( isset( $_POST['mpe_reservation_masseuse_id'] ) ) {
        update_post_meta( $post_id, '_mpe_reservation_masseuse_id', sanitize_text_field( $_POST['mpe_reservation_masseuse_id'] ) );
    }

    // Save Reservation Details
    $fields = array(
        'mpe_reservation_date'     => '_mpe_reservation_date',
        'mpe_reservation_time'     => '_mpe_reservation_time',
        'mpe_reservation_name'     => '_mpe_reservation_name',
        'mpe_reservation_city'     => '_mpe_reservation_city',
        'mpe_reservation_email'    => '_mpe_reservation_email',
        'mpe_reservation_phone'    => '_mpe_reservation_phone',
        'mpe_reservation_object'   => '_mpe_reservation_object',
        'mpe_reservation_message'  => '_mpe_reservation_message',
        'mpe_reservation_page_url' => '_mpe_reservation_page_url',
    );

    foreach ( $fields as $input_name => $meta_key ) {
        if ( isset( $_POST[ $input_name ] ) ) {
            $value = ( $input_name === 'mpe_reservation_message' ) ? sanitize_textarea_field( $_POST[ $input_name ] ) : sanitize_text_field( $_POST[ $input_name ] );
            update_post_meta( $post_id, $meta_key, $value );
        }
    }
}
add_action( 'save_post_reservation', 'mpe2025_save_reservation_meta' );

/**
 * Custom Admin Columns
 */
function mpe2025_set_reservation_columns( $columns ) {
    $new_columns = array(
        'cb' => $columns['cb'],
        'title' => __( 'Référence / Client', 'mpe2025' ),
        'res_date' => __( 'Date du voyage', 'mpe2025' ),
        'res_status' => __( 'Statut', 'mpe2025' ),
        'res_masseuse' => __( 'Masseuse', 'mpe2025' ),
        'date' => $columns['date'], // Submitted Date
    );
    return $new_columns;
}
add_filter( 'manage_reservation_posts_columns', 'mpe2025_set_reservation_columns' );

function mpe2025_reservation_custom_column( $column, $post_id ) {
    switch ( $column ) {
        case 'res_date':
            $date = get_post_meta( $post_id, '_mpe_reservation_date', true );
            $time = get_post_meta( $post_id, '_mpe_reservation_time', true );
            echo esc_html( $date );
            if ( $time ) {
                echo ' ' . esc_html( $time );
            }
            break;

        case 'res_status':
            $status = get_post_meta( $post_id, '_mpe_reservation_status', true );
            $labels = array(
                'pending'   => '<span style="color: #d63638; font-weight: bold;">' . __( 'En attente', 'mpe2025' ) . '</span>',
                'confirmed' => '<span style="color: #008a20; font-weight: bold;">' . __( 'Confirmée', 'mpe2025' ) . '</span>',
                'completed' => '<span style="color: #797979; font-weight: bold;">' . __( 'Terminée', 'mpe2025' ) . '</span>',
                'cancelled' => '<span style="color: #d63638;">' . __( 'Annulée', 'mpe2025' ) . '</span>',
            );
            echo isset( $labels[$status] ) ? $labels[$status] : $status;
            break;

        case 'res_masseuse':
            $masseuse_id = get_post_meta( $post_id, '_mpe_reservation_masseuse_id', true );
            if ( $masseuse_id ) {
                echo '<a href="' . get_edit_post_link( $masseuse_id ) . '">' . get_the_title( $masseuse_id ) . '</a>';
            } else {
                echo '<span style="color: #999;">' . __( 'Non assigné', 'mpe2025' ) . '</span>';
            }
            break;
    }
}
add_action( 'manage_reservation_posts_custom_column', 'mpe2025_reservation_custom_column', 10, 2 );

/**
 * Filter Reservations by Status (Optional but good UX)
 */
// TODO: Add filter logic if needed in future
