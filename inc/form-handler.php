<?php
/**
 * AJAX Form Handler for Reservation Form
 * Sends HTML formatted emails without page reload
 */

/**
 * Enqueue AJAX script for reservation form
 */
function mpe2025_enqueue_reservation_scripts() {
    wp_localize_script( 'mpe-reservation-form', 'mpe_ajax', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce'    => wp_create_nonce( 'mpe_reservation_ajax_nonce' ),
    ) );
}
add_action( 'wp_enqueue_scripts', 'mpe2025_enqueue_reservation_scripts' );

/**
 * Handle AJAX reservation form submission
 */
function mpe2025_ajax_reservation_form() {
    // Verify Nonce
    if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'mpe_reservation_ajax_nonce' ) ) {
        wp_send_json_error( array( 'message' => 'Security check failed' ) );
    }

    // Sanitize Input
    $date     = sanitize_text_field( $_POST['res_date'] );
    $name     = sanitize_text_field( $_POST['res_name'] );
    $tel      = sanitize_text_field( $_POST['res_tel'] );
    $email    = sanitize_email( $_POST['res_email'] );
    $object   = sanitize_text_field( $_POST['res_object'] );
    $message  = sanitize_textarea_field( $_POST['res_message'] );
    $page_url = esc_url_raw( $_POST['page_url'] );

    // Validation
    if ( empty( $name ) || empty( $email ) || empty( $tel ) || empty( $message ) ) {
        wp_send_json_error( array( 'message' => 'Please fill in all required fields.' ) );
    }

    if ( ! is_email( $email ) ) {
        wp_send_json_error( array( 'message' => 'Please enter a valid email address.' ) );
    }

    // Format date for display
    $formatted_date = ! empty( $date ) ? date_i18n( 'F j, Y', strtotime( $date ) ) : 'Not specified';
    $submission_time = current_time( 'F j, Y - H:i' );

    // Get recipient emails from theme options
    $mpe_options = get_option( 'mpe_theme_options' );
    $reservation_emails = isset( $mpe_options['reservation_emails'] ) ? $mpe_options['reservation_emails'] : '';
    
    // Parse emails (one per line) and create comma-separated list
    if ( ! empty( $reservation_emails ) ) {
        $emails_array = array_filter( array_map( 'trim', preg_split( '/[\n,]+/', $reservation_emails ) ) );
        $to = implode( ', ', $emails_array );
    } else {
        // Fallback to admin email
        $to = get_option( 'admin_email' );
    }

    // Prepare HTML Email
    // Prepare HTML Email
    $subject = '🌸 New Booking Request: ' . $object;
    
    $body = mpe2025_get_email_template( array(
        'name'            => $name,
        'email'           => $email,
        'tel'             => $tel,
        'date'            => $formatted_date,
        'object'          => $object,
        'message'         => $message,
        'page_url'        => $page_url,
        'submission_time' => $submission_time,
    ) );

    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: Massage & Spa Marrakech <contact@massage-marrakech.com>',
        'Reply-To: ' . $name . ' <' . $email . '>',
    );

    // Send Email
    $sent = wp_mail( $to, $subject, $body, $headers );

    if ( $sent ) {
        // Create Reservation Post
        $post_title = sprintf( 'Devis - %s - %s', $name, $formatted_date );
        
        $reservation_data = array(
            'post_title'   => $post_title,
            'post_type'    => 'reservation',
            'post_status'  => 'publish', // Or 'private' if we want them hidden from frontend queries by default, but public=false CPT is already hidden.
        );

        $reservation_id = wp_insert_post( $reservation_data );

        if ( $reservation_id && ! is_wp_error( $reservation_id ) ) {
            // Save Meta Data
            update_post_meta( $reservation_id, '_mpe_reservation_date', $date ); // Raw date for sorting? or formatted? Formatted is better for display, raw for sorting. Storing raw input date.
            update_post_meta( $reservation_id, '_mpe_reservation_name', $name );
            update_post_meta( $reservation_id, '_mpe_reservation_phone', $tel );
            update_post_meta( $reservation_id, '_mpe_reservation_email', $email );
            update_post_meta( $reservation_id, '_mpe_reservation_object', $object );
            update_post_meta( $reservation_id, '_mpe_reservation_message', $message );
            update_post_meta( $reservation_id, '_mpe_reservation_page_url', $page_url );
            update_post_meta( $reservation_id, '_mpe_reservation_status', 'pending' );
        }

        wp_send_json_success( array( 'message' => 'Thank you! Your quote request has been sent successfully.' ) );
    } else {
        wp_send_json_error( array( 'message' => 'Failed to send email. Please try again later.' ) );
    }
}
add_action( 'wp_ajax_mpe_reservation_ajax', 'mpe2025_ajax_reservation_form' );
add_action( 'wp_ajax_nopriv_mpe_reservation_ajax', 'mpe2025_ajax_reservation_form' );

/**
 * Generate professional HTML email template
 * 
 * @param array $data Form data
 * @return string HTML email content
 */
function mpe2025_get_email_template( $data ) {
    $html = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Quote Request</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, Helvetica, sans-serif; background-color: #f4f4f4;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #f4f4f4; padding: 30px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #d4a373 0%, #faedcd 100%); padding: 30px; text-align: center;">
                            <h1 style="margin: 0; color: #5c4033; font-size: 24px; font-weight: 600;">
                                🌸 Massage & Spa Marrakech
                            </h1>
                            <p style="margin: 10px 0 0 0; color: #8d6e63; font-size: 14px;">
                                New Booking Request Received
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Quote Request Badge -->
                    <tr>
                        <td style="padding: 25px 30px 15px 30px; text-align: center;">
                            <span style="display: inline-block; background-color: #006233; color: #ffffff; padding: 8px 20px; border-radius: 20px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">
                                New Quote Request
                            </span>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 10px 30px 30px 30px;">
                            
                            <!-- Client Information -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="margin-bottom: 25px;">
                                <tr>
                                    <td style="padding-bottom: 15px;">
                                        <h2 style="margin: 0; color: #333333; font-size: 18px; font-weight: 600; border-bottom: 2px solid #C8102E; padding-bottom: 10px;">
                                            📋 Client Information
                                        </h2>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #f9f9f9; border-radius: 6px; border-left: 4px solid #C8102E;">
                                            <tr>
                                                <td style="padding: 15px;">
                                                    <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td style="padding: 8px 0; border-bottom: 1px solid #eeeeee;">
                                                                <strong style="color: #666666; font-size: 13px;">👤 Name:</strong>
                                                                <span style="color: #333333; font-size: 14px; margin-left: 10px;">' . esc_html( $data['name'] ) . '</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding: 8px 0; border-bottom: 1px solid #eeeeee;">
                                                                <strong style="color: #666666; font-size: 13px;">📧 Email:</strong>
                                                                <a href="mailto:' . esc_attr( $data['email'] ) . '" style="color: #C8102E; font-size: 14px; margin-left: 10px; text-decoration: none;">' . esc_html( $data['email'] ) . '</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding: 8px 0; border-bottom: 1px solid #eeeeee;">
                                                                <strong style="color: #666666; font-size: 13px;">📱 Phone:</strong>
                                                                <a href="tel:' . esc_attr( $data['tel'] ) . '" style="color: #C8102E; font-size: 14px; margin-left: 10px; text-decoration: none;">' . esc_html( $data['tel'] ) . '</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding: 8px 0;">
                                                                <strong style="color: #666666; font-size: 13px;">📅 Trip Date:</strong>
                                                                <span style="color: #333333; font-size: 14px; margin-left: 10px;">' . esc_html( $data['date'] ) . '</span>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- Tour Interest -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="margin-bottom: 25px;">
                                <tr>
                                    <td style="padding-bottom: 15px;">
                                        <h2 style="margin: 0; color: #333333; font-size: 18px; font-weight: 600; border-bottom: 2px solid #006233; padding-bottom: 10px;">
                                            💆 Requested Treatment
                                        </h2>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #f0f7f0; border-radius: 6px; border-left: 4px solid #006233;">
                                            <tr>
                                                <td style="padding: 15px;">
                                                    <p style="margin: 0 0 10px 0; font-size: 16px; color: #333333; font-weight: 600;">
                                                        ' . esc_html( $data['object'] ) . '
                                                    </p>
                                                    <a href="' . esc_url( $data['page_url'] ) . '" style="color: #006233; font-size: 13px; text-decoration: none;">
                                                        🔗 View Service Page
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- Message -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="margin-bottom: 25px;">
                                <tr>
                                    <td style="padding-bottom: 15px;">
                                        <h2 style="margin: 0; color: #333333; font-size: 18px; font-weight: 600; border-bottom: 2px solid #FFD700; padding-bottom: 10px;">
                                            💬 Client Message
                                        </h2>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div style="background-color: #fffef0; border-radius: 6px; border-left: 4px solid #FFD700; padding: 20px;">
                                            <p style="margin: 0; color: #333333; font-size: 14px; line-height: 1.7; white-space: pre-wrap;">' . esc_html( $data['message'] ) . '</p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- Submission Info -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="text-align: center; padding-top: 10px;">
                                        <p style="margin: 0; color: #999999; font-size: 12px;">
                                            ⏰ Submitted on: ' . esc_html( $data['submission_time'] ) . '
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #333333; padding: 30px; text-align: center;">
                            <h3 style="margin: 0 0 15px 0; color: #ffffff; font-size: 16px; font-weight: 600;">
                                INFORMATIONS GÉNÉRALES
                            </h3>
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="text-align: center; padding-bottom: 10px;">
                                        <a href="https://massage-marrakech.com" style="color: #FFD700; font-size: 14px; text-decoration: none; font-weight: 600;">
                                            🌐 massage-marrakech.com
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center; padding-bottom: 10px;">
                                        <a href="tel:+212667153738" style="color: #ffffff; font-size: 14px; text-decoration: none;">
                                            📞 +212 667 153 738
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center; padding-bottom: 10px;">
                                        <span style="color: #cccccc; font-size: 13px;">
                                            📍 Marrakech, Maroc
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;">
                                        <a href="mailto:contact@massage-marrakech.com" style="color: #ffffff; font-size: 14px; text-decoration: none;">
                                            ✉️ contact@massage-marrakech.com
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            <hr style="border: none; border-top: 1px solid #555555; margin: 20px 0;">
                            <p style="margin: 0; color: #888888; font-size: 11px;">
                                © ' . date('Y') . ' Morocco Private Excursions. All rights reserved.
                            </p>
                        </td>
                    </tr>
                    
                </table>
            </td>
        </tr>
    </table>
</body>
</html>';

    return $html;
}
