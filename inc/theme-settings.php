<?php
/**
 * Theme Settings Page
 *
 * @package MPE2025
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Register the menu page.
 */
function mpe_add_admin_menu() {
	add_menu_page(
		__( 'MPE Options', 'mpe2025' ),
		__( 'MPE Options', 'mpe2025' ),
		'manage_options',
		'mpe_theme_options',
		'mpe_theme_options_page_html',
		'dashicons-admin-generic',
		60
	);
}
add_action( 'admin_menu', 'mpe_add_admin_menu' );

/**
 * Register settings and fields.
 */
function mpe_settings_init() {
	register_setting( 'mpe_theme_options_group', 'mpe_theme_options', 'mpe_sanitize_options' );

	// Section: General Info
	add_settings_section(
		'mpe_general_section',
		__( 'General Information', 'mpe2025' ),
		'mpe_general_section_callback',
		'mpe_theme_options'
	);

	add_settings_field(
		'phone_number',
		__( 'Phone Number', 'mpe2025' ),
		'mpe_text_field_render',
		'mpe_theme_options',
		'mpe_general_section',
		array( 'field' => 'phone_number' )
	);

	add_settings_field(
		'email_address',
		__( 'Email Address', 'mpe2025' ),
		'mpe_text_field_render',
		'mpe_theme_options',
		'mpe_general_section',
		array( 'field' => 'email_address' )
	);

	add_settings_field(
		'address',
		__( 'Address', 'mpe2025' ),
		'mpe_textarea_field_render',
		'mpe_theme_options',
		'mpe_general_section',
		array( 'field' => 'address' )
	);

    add_settings_field(
		'ice_number',
		__( 'ICE Number', 'mpe2025' ),
		'mpe_text_field_render',
		'mpe_theme_options',
		'mpe_general_section',
		array( 'field' => 'ice_number' )
	);

    add_settings_field(
		'whatsapp_number',
		__( 'WhatsApp Number', 'mpe2025' ),
		'mpe_text_field_render',
		'mpe_theme_options',
		'mpe_general_section',
		array( 'field' => 'whatsapp_number' )
	);

	// Section: Reservation Emails
	add_settings_section(
		'mpe_reservation_emails_section',
		__( 'Reservation Emails', 'mpe2025' ),
		'mpe_reservation_emails_section_callback',
		'mpe_theme_options'
	);

	add_settings_field(
		'reservation_emails',
		__( 'Recipient Email Addresses', 'mpe2025' ),
		'mpe_reservation_emails_render',
		'mpe_theme_options',
		'mpe_reservation_emails_section'
	);

	// Section: Language Settings (Parent section for language-related options)
	add_settings_section(
		'mpe_language_settings_section',
		__( 'Language Settings', 'mpe2025' ),
		'mpe_language_settings_section_callback',
		'mpe_theme_options'
	);

	// Reservation Form Labels per Language
	add_settings_field(
		'reservation_form_languages',
		__( 'Reservation Form Labels', 'mpe2025' ),
		'mpe_reservation_form_languages_render',
		'mpe_theme_options',
		'mpe_language_settings_section'
	);

	// Hero Text per Language
	add_settings_field(
		'hero_text_languages',
		__( 'Hero Section Text', 'mpe2025' ),
		'mpe_hero_text_languages_render',
		'mpe_theme_options',
		'mpe_language_settings_section'
	);

	// Header CTA Button per Language
	add_settings_field(
		'header_cta_languages',
		__( 'Header CTA Button', 'mpe2025' ),
		'mpe_header_cta_languages_render',
		'mpe_theme_options',
		'mpe_language_settings_section'
	);

	// Section: Footer Settings
	add_settings_section(
		'mpe_footer_section',
		__( 'Footer Settings', 'mpe2025' ),
		'mpe_footer_section_callback',
		'mpe_theme_options'
	);

	add_settings_field(
		'footer_content',
		__( 'Footer Content', 'mpe2025' ),
		'mpe_footer_content_render',
		'mpe_theme_options',
		'mpe_footer_section'
	);

	// Section: Social Media
	add_settings_section(
		'mpe_social_section',
		__( 'Social Media', 'mpe2025' ),
		'mpe_social_section_callback',
		'mpe_theme_options'
	);

	add_settings_field(
		'facebook_url',
		__( 'Facebook URL', 'mpe2025' ),
		'mpe_text_field_render',
		'mpe_theme_options',
		'mpe_social_section',
		array( 'field' => 'facebook_url' )
	);

	add_settings_field(
		'instagram_url',
		__( 'Instagram URL', 'mpe2025' ),
		'mpe_text_field_render',
		'mpe_theme_options',
		'mpe_social_section',
		array( 'field' => 'instagram_url' )
	);

	add_settings_field(
		'youtube_url',
		__( 'YouTube URL', 'mpe2025' ),
		'mpe_text_field_render',
		'mpe_theme_options',
		'mpe_social_section',
		array( 'field' => 'youtube_url' )
	);

    add_settings_field(
		'tripadvisor_url',
		__( 'TripAdvisor URL', 'mpe2025' ),
		'mpe_text_field_render',
		'mpe_theme_options',
		'mpe_social_section',
		array( 'field' => 'tripadvisor_url' )
	);

	// Section: Google Reviews
	add_settings_section(
		'mpe_google_reviews_section',
		__( 'Google Reviews', 'mpe2025' ),
		'mpe_google_reviews_section_callback',
		'mpe_theme_options'
	);

	add_settings_field(
		'google_reviews_url',
		__( 'Google Reviews Link', 'mpe2025' ),
		'mpe_text_field_render',
		'mpe_theme_options',
		'mpe_google_reviews_section',
		array( 'field' => 'google_reviews_url' )
	);

	// Section: Visual Identity
	add_settings_section(
		'mpe_visual_section',
		__( 'Visual Identity', 'mpe2025' ),
		'mpe_visual_section_callback',
		'mpe_theme_options'
	);



	add_settings_field(
		'site_logo',
		__( 'Site Logo', 'mpe2025' ),
		'mpe_image_upload_render',
		'mpe_theme_options',
		'mpe_visual_section',
		array( 'field' => 'site_logo' )
	);

	add_settings_field(
		'site_icon',
		__( 'Site Icon (Favicon)', 'mpe2025' ),
		'mpe_site_icon_upload_render',
		'mpe_theme_options',
		'mpe_visual_section',
		array( 'field' => 'site_icon' )
	);

    add_settings_field(
		'hero_image',
		__( 'Hero Image', 'mpe2025' ),
		'mpe_image_upload_render',
		'mpe_theme_options',
		'mpe_visual_section',
		array( 'field' => 'hero_image' )
	);

    add_settings_field(
		'hero_style',
		__( 'Hero Section Style', 'mpe2025' ),
		'mpe_select_field_render',
		'mpe_theme_options',
		'mpe_visual_section',
		array( 
			'field'   => 'hero_style',
			'options' => array(
				'default'  => __( 'Default (Centered)', 'mpe2025' ),
				'modern'   => __( 'Modern Split (Left Text, Right Focus)', 'mpe2025' ),
				'creative' => __( 'Creative Parallax (Immersive)', 'mpe2025' ),
			),
			'default' => 'default'
		)
	);

    add_settings_field(
		'menu_style',
		__( 'Menu Style', 'mpe2025' ),
		'mpe_select_field_render',
		'mpe_theme_options',
		'mpe_visual_section',
		array( 
			'field'   => 'menu_style',
			'options' => array(
				'default'  => __( 'Default (Logo Left, Menu Right)', 'mpe2025' ),
				'centered' => __( 'Centered (Logo Top, Menu Bottom)', 'mpe2025' ),
				'classic'  => __( 'Classic (Logo Left, Menu Left)', 'mpe2025' ),
			),
			'default' => 'default'
		)
	);

    // Colors
    add_settings_field(
        'theme_colors',
        __( 'Theme Colors', 'mpe2025' ),
        'mpe_theme_colors_render',
        'mpe_theme_options',
        'mpe_visual_section'
    );


}
add_action( 'admin_init', 'mpe_settings_init' );

/**
 * Sanitize options.
 *
 * @param array $input Input options.
 * @return array Sanitized options.
 */
function mpe_sanitize_options( $input ) {
	$sanitized_input = array();
    
    // Text Fields
    $text_fields = array( 'phone_number', 'whatsapp_number', 'ice_number', 'menu_style', 'hero_style' );
    foreach ( $text_fields as $field ) {
        if ( isset( $input[ $field ] ) ) {
            $sanitized_input[ $field ] = sanitize_text_field( $input[ $field ] );
        }
    }

    // Dynamic Header CTA fields (for all Polylang languages)
    foreach ( $input as $key => $value ) {
        if ( strpos( $key, 'header_cta_text_' ) === 0 ) {
            $sanitized_input[ $key ] = sanitize_text_field( $value );
        } elseif ( strpos( $key, 'header_cta_url_' ) === 0 ) {
            $sanitized_input[ $key ] = esc_url_raw( $value );
        } elseif ( strpos( $key, 'hero_title_' ) === 0 ) {
            $sanitized_input[ $key ] = sanitize_text_field( $value );
        } elseif ( strpos( $key, 'hero_subtitle_' ) === 0 ) {
            $sanitized_input[ $key ] = sanitize_text_field( $value );
        } elseif ( strpos( $key, 'hero_search_placeholder_' ) === 0 ) {
            $sanitized_input[ $key ] = sanitize_text_field( $value );
        }
    }

    // Dynamic Reservation Form Labels (for all Polylang languages)
    $label_fields = array( 'title', 'date_label', 'name_label', 'tel_label', 'email_label', 'object_label', 'message_label', 'submit_label', 'sending_label', 'success', 'error' );
    foreach ( $input as $key => $value ) {
        foreach ( $label_fields as $label_field ) {
            if ( strpos( $key, 'reservation_form_' . $label_field . '_' ) === 0 ) {
                $sanitized_input[ $key ] = sanitize_text_field( $value );
                break;
            }
        }
    }

    // Dynamic Footer Content (for all Polylang languages)
    $footer_fields = array( 'footer_title_1', 'footer_text', 'footer_title_2', 'footer_title_3', 'footer_title_4' );
    foreach ( $input as $key => $value ) {
        foreach ( $footer_fields as $field_base ) {
            if ( strpos( $key, $field_base . '_' ) === 0 ) {
                $sanitized_input[ $key ] = sanitize_textarea_field( $value ); // Using textarea/text sanitization
                break;
            }
        }
    }

    // Email
	if ( isset( $input['email_address'] ) ) {
		$sanitized_input['email_address'] = sanitize_email( $input['email_address'] );
	}

    // Textarea
	if ( isset( $input['address'] ) ) {
		$sanitized_input['address'] = sanitize_textarea_field( $input['address'] );
	}

	// Reservation Emails - sanitize each email
	if ( isset( $input['reservation_emails'] ) ) {
		$emails_raw = sanitize_textarea_field( $input['reservation_emails'] );
		$emails_array = array_filter( array_map( 'trim', preg_split( '/[\n,]+/', $emails_raw ) ) );
		$sanitized_emails = array();
		foreach ( $emails_array as $email ) {
			if ( is_email( $email ) ) {
				$sanitized_emails[] = sanitize_email( $email );
			}
		}
		$sanitized_input['reservation_emails'] = implode( "\n", $sanitized_emails );
	}

    // URLs
    $url_fields = array( 'facebook_url', 'instagram_url', 'youtube_url', 'tripadvisor_url', 'google_reviews_url', 'site_logo', 'site_icon', 'hero_image' );
    foreach ( $url_fields as $field ) {
        if ( isset( $input[ $field ] ) ) {
            $sanitized_input[ $field ] = esc_url_raw( $input[ $field ] );
        }
    }

    // Colors
    $color_fields = array( 'primary', 'primary_hover', 'background_light', 'background_dark', 'text_light', 'text_dark', 'accent', 'gold' );
    foreach ( $color_fields as $field ) {
        $key = $field . '_color';
        if ( isset( $input[ $key ] ) ) {
            $sanitized_input[ $key ] = sanitize_hex_color( $input[ $key ] );
        }
    }

	return $sanitized_input;
}

/**
 * Section callbacks.
 */
function mpe_general_section_callback() {
	echo '<p>' . __( 'Enter your general contact information here.', 'mpe2025' ) . '</p>';
}

function mpe_reservation_emails_section_callback() {
	echo '<p>' . __( 'Configure the email addresses that will receive reservation form submissions.', 'mpe2025' ) . '</p>';
}

function mpe_language_settings_section_callback() {
	echo '<p>' . __( 'Configure language-specific settings for your website. Labels and buttons will automatically adapt based on the active language in Polylang.', 'mpe2025' ) . '</p>';
}

function mpe_social_section_callback() {
	echo '<p>' . __( 'Enter your social media profile URLs.', 'mpe2025' ) . '</p>';
}

function mpe_footer_section_callback() {
	echo '<p>' . __( 'Customize the content of the footer for each language.', 'mpe2025' ) . '</p>';
}

function mpe_visual_section_callback() {
	echo '<p>' . __( 'Customize the visual appearance of your theme.', 'mpe2025' ) . '</p>';
}

function mpe_google_reviews_section_callback() {
    echo '<p>' . __( 'Configure settings for Google Reviews integration.', 'mpe2025' ) . '</p>';
}

function mpe_tripadvisor_section_callback() {
	echo '<div style="background: #fff3cd; border: 1px solid #ffc107; padding: 12px; border-radius: 4px; margin-bottom: 15px;">';
	echo '<p style="margin: 0;"><strong>📌 Instructions:</strong></p>';
	echo '<ol style="margin: 10px 0 0 20px; padding: 0;">';
	echo '<li>' . __( 'Enter your TripAdvisor profile URL below', 'mpe2025' ) . '</li>';
	echo '<li><strong>' . __( 'Click "Save Settings" at the bottom of the page', 'mpe2025' ) . '</strong></li>';
	echo '<li>' . __( 'Then click "Fetch Reviews Now" to import reviews', 'mpe2025' ) . '</li>';
	echo '</ol>';
	echo '</div>';
	echo '<p>' . __( 'Configure TripAdvisor reviews integration settings.', 'mpe2025' ) . '</p>';
}

/**
 * Field callbacks.
 */
function mpe_text_field_render( $args ) {
	$options = get_option( 'mpe_theme_options' );
	$field   = $args['field'];
	$value   = isset( $options[ $field ] ) ? $options[ $field ] : '';
	?>
	<input type="text" name="mpe_theme_options[<?php echo esc_attr( $field ); ?>]" value="<?php echo esc_attr( $value ); ?>" class="regular-text">
	<?php
}

/**
 * Render Header CTA fields dynamically for all Polylang languages.
 */
function mpe_header_cta_languages_render() {
	$options = get_option( 'mpe_theme_options' );
	
	// Get all Polylang languages using helper function
	$languages = mpe_get_available_languages();
	?>
	<div class="mpe-cta-languages-grid">
		<?php foreach ( $languages as $lang ) : 
			$text_field = 'header_cta_text_' . $lang['slug'];
			$url_field  = 'header_cta_url_' . $lang['slug'];
			$text_value = isset( $options[ $text_field ] ) ? $options[ $text_field ] : '';
			$url_value  = isset( $options[ $url_field ] ) ? $options[ $url_field ] : '';
		?>
			<div class="mpe-cta-lang-card">
				<div class="mpe-cta-lang-header">
					<?php if ( ! empty( $lang['flag'] ) ) : ?>
						<img src="<?php echo esc_url( $lang['flag'] ); ?>" alt="<?php echo esc_attr( $lang['name'] ); ?>" class="mpe-lang-flag">
					<?php endif; ?>
					<strong><?php echo esc_html( $lang['name'] ); ?></strong>
					<code><?php echo esc_html( $lang['slug'] ); ?></code>
				</div>
				<div class="mpe-cta-lang-fields">
					<label>
						<?php _e( 'Button Text', 'mpe2025' ); ?>
						<input type="text" name="mpe_theme_options[<?php echo esc_attr( $text_field ); ?>]" value="<?php echo esc_attr( $text_value ); ?>" class="regular-text" placeholder="<?php esc_attr_e( 'e.g. Book Now', 'mpe2025' ); ?>">
					</label>
					<label>
						<?php _e( 'Button URL', 'mpe2025' ); ?>
						<input type="text" name="mpe_theme_options[<?php echo esc_attr( $url_field ); ?>]" value="<?php echo esc_attr( $url_value ); ?>" class="regular-text" placeholder="<?php esc_attr_e( 'e.g. /contact', 'mpe2025' ); ?>">
					</label>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<p class="description"><?php _e( 'Configure the header button for each active language in Polylang.', 'mpe2025' ); ?></p>
	<?php
}

/**
 * Render Hero Text fields dynamically for all Polylang languages.
 */
function mpe_hero_text_languages_render() {
	$options = get_option( 'mpe_theme_options' );
	
	// Get all Polylang languages
	$languages = mpe_get_available_languages();
	
	// Default labels for each language
	$default_labels = array(
		'en' => array(
			'title'              => 'Experience Luxury Massage at Home',
			'subtitle'           => 'Professional certified therapists delivering premium spa treatments to your doorstep in Marrakech.',
			'search_placeholder' => 'Enter your neighborhood',
		),
		'fr' => array(
			'title'              => 'Votre Moment de Détente à Domicile',
			'subtitle'           => 'Thérapeutes certifiées pour des soins spa premium directement chez vous à Marrakech.',
			'search_placeholder' => 'Entrez votre quartier',
		),
	);
	?>
	<div class="mpe-cta-languages-grid">
		<?php foreach ( $languages as $lang ) : 
			$title_field       = 'hero_title_' . $lang['slug'];
			$subtitle_field    = 'hero_subtitle_' . $lang['slug'];
			$search_field      = 'hero_search_placeholder_' . $lang['slug'];
			$title_value       = isset( $options[ $title_field ] ) ? $options[ $title_field ] : '';
			$subtitle_value    = isset( $options[ $subtitle_field ] ) ? $options[ $subtitle_field ] : '';
			$search_value      = isset( $options[ $search_field ] ) ? $options[ $search_field ] : '';
			$lang_defaults     = isset( $default_labels[ $lang['slug'] ] ) ? $default_labels[ $lang['slug'] ] : $default_labels['en'];
		?>
			<div class="mpe-cta-lang-card">
				<div class="mpe-cta-lang-header" style="background: linear-gradient(135deg, #16a085, #1abc9c);">
					<?php if ( ! empty( $lang['flag'] ) ) : ?>
						<img src="<?php echo esc_url( $lang['flag'] ); ?>" alt="<?php echo esc_attr( $lang['name'] ); ?>" class="mpe-lang-flag">
					<?php endif; ?>
					<strong><?php echo esc_html( $lang['name'] ); ?></strong>
					<code><?php echo esc_html( $lang['slug'] ); ?></code>
				</div>
				<div class="mpe-cta-lang-fields">
					<label>
						<?php _e( 'Hero Title', 'mpe2025' ); ?>
						<input type="text" name="mpe_theme_options[<?php echo esc_attr( $title_field ); ?>]" value="<?php echo esc_attr( $title_value ); ?>" class="regular-text" placeholder="<?php echo esc_attr( $lang_defaults['title'] ); ?>">
					</label>
					<label>
						<?php _e( 'Hero Subtitle', 'mpe2025' ); ?>
						<input type="text" name="mpe_theme_options[<?php echo esc_attr( $subtitle_field ); ?>]" value="<?php echo esc_attr( $subtitle_value ); ?>" class="regular-text" placeholder="<?php echo esc_attr( $lang_defaults['subtitle'] ); ?>">
					</label>
					<label>
						<?php _e( 'Search Placeholder', 'mpe2025' ); ?>
						<input type="text" name="mpe_theme_options[<?php echo esc_attr( $search_field ); ?>]" value="<?php echo esc_attr( $search_value ); ?>" class="regular-text" placeholder="<?php echo esc_attr( $lang_defaults['search_placeholder'] ); ?>">
					</label>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<p class="description"><?php _e( 'Configure the hero section text for each active language in Polylang.', 'mpe2025' ); ?></p>
	<?php
}

/**
 * Render Reservation Form Labels for all Polylang languages.
 */
function mpe_reservation_form_languages_render() {
	$options = get_option( 'mpe_theme_options' );
	
	// Get all Polylang languages
	$languages = mpe_get_available_languages();
	
	// Default labels for each language (used as placeholders/defaults)
	$default_labels = array(
		'en' => array(
			'title'         => 'BOOK YOUR SESSION',
			'date_label'    => 'Preferred Date',
			'name_label'    => 'Full Name',
			'tel_label'     => 'Phone Number',
			'email_label'   => 'Email Address',
			'object_label'  => 'Treatment',
			'message_label' => 'Tell us about any specific needs or conditions...',
			'submit_label'  => 'Book Appointment',
			'sending_label' => 'Booking...',
			'success'       => 'Thank you! Your booking request has been received. We will confirm shortly.',
			'error'         => 'An error occurred. Please try again.',
		),
		'fr' => array(
			'title'         => 'RÉSERVEZ VOTRE SÉANCE',
			'date_label'    => 'Date souhaitée',
			'name_label'    => 'Nom complet',
			'tel_label'     => 'Numéro de téléphone',
			'email_label'   => 'Adresse email',
			'object_label'  => 'Soin souhaité',
			'message_label' => 'Précisez vos besoins spécifiques ou contre-indications...',
			'submit_label'  => 'Réserver maintenant',
			'sending_label' => 'Réservation en cours...',
			'success'       => 'Merci ! Votre demande de réservation a été bien reçue. Nous vous confirmerons rapidement.',
			'error'         => 'Une erreur est survenue. Veuillez réessayer.',
		),
	);
	
	// Label display names
	$label_names = array(
		'title'         => __( 'Form Title', 'mpe2025' ),
		'date_label'    => __( 'Date Label', 'mpe2025' ),
		'name_label'    => __( 'Name Label', 'mpe2025' ),
		'tel_label'     => __( 'Tel Label', 'mpe2025' ),
		'email_label'   => __( 'Email Label', 'mpe2025' ),
		'object_label'  => __( 'Object Label', 'mpe2025' ),
		'message_label' => __( 'Message Placeholder', 'mpe2025' ),
		'submit_label'  => __( 'Submit Button', 'mpe2025' ),
		'sending_label' => __( 'Sending Text', 'mpe2025' ),
		'success'       => __( 'Success Message', 'mpe2025' ),
		'error'         => __( 'Error Message', 'mpe2025' ),
	);
	?>
	<div class="mpe-form-languages-wrapper">
		<?php foreach ( $languages as $lang ) : 
			$lang_defaults = isset( $default_labels[ $lang['slug'] ] ) ? $default_labels[ $lang['slug'] ] : $default_labels['en'];
		?>
			<div class="mpe-form-lang-card">
				<div class="mpe-form-lang-header">
					<?php if ( ! empty( $lang['flag'] ) ) : ?>
						<img src="<?php echo esc_url( $lang['flag'] ); ?>" alt="<?php echo esc_attr( $lang['name'] ); ?>" class="mpe-lang-flag">
					<?php endif; ?>
					<strong><?php echo esc_html( $lang['name'] ); ?></strong>
					<code><?php echo esc_html( $lang['slug'] ); ?></code>
				</div>
				<div class="mpe-form-lang-fields">
					<?php foreach ( $label_names as $label_key => $label_display ) : 
						$field_name = 'reservation_form_' . $label_key . '_' . $lang['slug'];
						$field_value = isset( $options[ $field_name ] ) ? $options[ $field_name ] : '';
						$placeholder = isset( $lang_defaults[ $label_key ] ) ? $lang_defaults[ $label_key ] : '';
					?>
						<div class="mpe-form-field-row">
							<label><?php echo esc_html( $label_display ); ?></label>
							<?php if ( in_array( $label_key, array( 'success', 'error', 'message_label' ), true ) ) : ?>
								<textarea name="mpe_theme_options[<?php echo esc_attr( $field_name ); ?>]" rows="2" placeholder="<?php echo esc_attr( $placeholder ); ?>"><?php echo esc_textarea( $field_value ); ?></textarea>
							<?php else : ?>
								<input type="text" name="mpe_theme_options[<?php echo esc_attr( $field_name ); ?>]" value="<?php echo esc_attr( $field_value ); ?>" placeholder="<?php echo esc_attr( $placeholder ); ?>">
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<p class="description"><?php _e( 'Configure reservation form labels for each language. Leave empty to use default values shown as placeholders.', 'mpe2025' ); ?></p>
	<?php
}

/**
 * Render Footer Content fields dynamically for all Polylang languages.
 */
function mpe_footer_content_render() {
	$options = get_option( 'mpe_theme_options' );
	
	// Get all Polylang languages
	$languages = mpe_get_available_languages();
    
    // Default values for placeholders
    $defaults = array(
        'en' => array(
            'title_1' => get_bloginfo( 'name' ),
            'text'    => 'Your wellness partner at home in Marrakech. Professional massages and spa treatments at your place.',
            'title_2' => 'Quick Links',
            'title_3' => 'Contact Us',
            'title_4' => 'Follow Us',
        ),
        'fr' => array(
            'title_1' => get_bloginfo( 'name' ),
            'text'    => 'Votre partenaire bien-être à domicile à Marrakech. Massages professionnels et soins spa chez vous.',
            'title_2' => 'Liens Rapides',
            'title_3' => 'Contactez-nous',
            'title_4' => 'Suivez-nous',
        ),
    );

	?>
	<div class="mpe-footer-languages-wrapper">
		<?php foreach ( $languages as $lang ) : 
            $lang_defaults = isset( $defaults[ $lang['slug'] ] ) ? $defaults[ $lang['slug'] ] : $defaults['en'];
        ?>
			<div class="mpe-language-section" style="background: #fff; border: 1px solid #ccd0d4; padding: 20px; margin-bottom: 20px; border-radius: 4px;">
				<div class="mpe-lang-header" style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px;">
					<?php if ( ! empty( $lang['flag'] ) ) : ?>
						<img src="<?php echo esc_url( $lang['flag'] ); ?>" alt="<?php echo esc_attr( $lang['name'] ); ?>" style="height: 20px;">
					<?php endif; ?>
					<h3 style="margin: 0;"><?php echo esc_html( $lang['name'] ); ?> (<?php echo esc_html( $lang['slug'] ); ?>)</h3>
				</div>
                
                <!-- Column 1 -->
                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 5px;"><?php _e( 'Column 1 Title (Company Name)', 'mpe2025' ); ?></label>
                    <?php 
                        $key = 'footer_title_1_' . $lang['slug'];
                        $val = isset( $options[ $key ] ) ? $options[ $key ] : '';
                    ?>
                    <input type="text" name="mpe_theme_options[<?php echo esc_attr( $key ); ?>]" value="<?php echo esc_attr( $val ); ?>" class="regular-text" placeholder="<?php echo esc_attr( $lang_defaults['title_1'] ); ?>">
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 5px;"><?php _e( 'Column 1 Description', 'mpe2025' ); ?></label>
                    <?php 
                        $key = 'footer_text_' . $lang['slug'];
                        $val = isset( $options[ $key ] ) ? $options[ $key ] : '';
                    ?>
                    <textarea name="mpe_theme_options[<?php echo esc_attr( $key ); ?>]" rows="3" class="large-text" placeholder="<?php echo esc_attr( $lang_defaults['text'] ); ?>"><?php echo esc_textarea( $val ); ?></textarea>
                </div>

                <!-- Column 2 -->
                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 5px;"><?php _e( 'Column 2 Title (Menu)', 'mpe2025' ); ?></label>
                    <?php 
                        $key = 'footer_title_2_' . $lang['slug'];
                        $val = isset( $options[ $key ] ) ? $options[ $key ] : '';
                    ?>
                    <input type="text" name="mpe_theme_options[<?php echo esc_attr( $key ); ?>]" value="<?php echo esc_attr( $val ); ?>" class="regular-text" placeholder="<?php echo esc_attr( $lang_defaults['title_2'] ); ?>">
                </div>

                <!-- Column 3 -->
                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 5px;"><?php _e( 'Column 3 Title (Contact)', 'mpe2025' ); ?></label>
                    <?php 
                        $key = 'footer_title_3_' . $lang['slug'];
                        $val = isset( $options[ $key ] ) ? $options[ $key ] : '';
                    ?>
                    <input type="text" name="mpe_theme_options[<?php echo esc_attr( $key ); ?>]" value="<?php echo esc_attr( $val ); ?>" class="regular-text" placeholder="<?php echo esc_attr( $lang_defaults['title_3'] ); ?>">
                </div>

                <!-- Column 4 -->
                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 5px;"><?php _e( 'Column 4 Title (Social)', 'mpe2025' ); ?></label>
                    <?php 
                        $key = 'footer_title_4_' . $lang['slug'];
                        $val = isset( $options[ $key ] ) ? $options[ $key ] : '';
                    ?>
                    <input type="text" name="mpe_theme_options[<?php echo esc_attr( $key ); ?>]" value="<?php echo esc_attr( $val ); ?>" class="regular-text" placeholder="<?php echo esc_attr( $lang_defaults['title_4'] ); ?>">
                </div>

			</div>
		<?php endforeach; ?>
	</div>
	<?php
}
function mpe_get_available_languages() {
	$languages = array();
	if ( function_exists( 'pll_languages_list' ) ) {
		$pll_languages = pll_languages_list( array( 'fields' => '' ) );
		foreach ( $pll_languages as $lang ) {
			$languages[] = array(
				'slug'  => $lang->slug,
				'name'  => $lang->name,
				'flag'  => $lang->flag_url,
			);
		}
	}
	
	// Fallback if Polylang is not active or no languages configured
	if ( empty( $languages ) ) {
		$languages = array(
			array( 'slug' => 'en', 'name' => 'English', 'flag' => '' ),
		);
	}
	
	return $languages;
}

function mpe_textarea_field_render( $args ) {
	$options = get_option( 'mpe_theme_options' );
	$field   = $args['field'];
	$value   = isset( $options[ $field ] ) ? $options[ $field ] : '';
	?>
	<textarea name="mpe_theme_options[<?php echo esc_attr( $field ); ?>]" rows="5" cols="50" class="large-text"><?php echo esc_textarea( $value ); ?></textarea>
	<?php
}

/**
 * Render reservation emails textarea field.
 */
function mpe_reservation_emails_render() {
	$options = get_option( 'mpe_theme_options' );
	$value   = isset( $options['reservation_emails'] ) ? $options['reservation_emails'] : '';
	
	// Default to admin email if empty
	if ( empty( $value ) ) {
		$value = get_option( 'admin_email' );
	}
	?>
	<textarea name="mpe_theme_options[reservation_emails]" rows="4" cols="50" class="large-text" placeholder="email1@example.com&#10;email2@example.com"><?php echo esc_textarea( $value ); ?></textarea>
	<p class="description">
		<?php _e( 'Enter one email address per line. All addresses will receive reservation form submissions.', 'mpe2025' ); ?>
		<br>
		<code><?php _e( 'Example:', 'mpe2025' ); ?> contact@massage-marrakech.com</code>
	</p>
	<?php
}


function mpe_number_field_render( $args ) {
	$options = get_option( 'mpe_theme_options' );
	$field   = $args['field'];
	$default = isset( $args['default'] ) ? $args['default'] : '';
	$value   = isset( $options[ $field ] ) ? $options[ $field ] : $default;
	?>
	<input type="number" name="mpe_theme_options[<?php echo esc_attr( $field ); ?>]" value="<?php echo esc_attr( $value ); ?>" class="regular-text" min="1" max="100">
	<?php
}

function mpe_select_field_render( $args ) {
	$options = get_option( 'mpe_theme_options' );
	$field   = $args['field'];
	$default = isset( $args['default'] ) ? $args['default'] : '';
	$value   = isset( $options[ $field ] ) ? $options[ $field ] : $default;
	$select_options = isset( $args['options'] ) ? $args['options'] : array();
	?>
	<select name="mpe_theme_options[<?php echo esc_attr( $field ); ?>]">
		<?php foreach ( $select_options as $opt_value => $opt_label ) : ?>
			<option value="<?php echo esc_attr( $opt_value ); ?>" <?php selected( $value, $opt_value ); ?>>
				<?php echo esc_html( $opt_label ); ?>
			</option>
		<?php endforeach; ?>
	</select>
	<?php
}

function mpe_readonly_field_render( $args ) {
	$options = get_option( 'mpe_theme_options' );
	$field   = $args['field'];
	$value   = isset( $options[ $field ] ) ? $options[ $field ] : __( 'Never', 'mpe2025' );
	?>
	<input type="text" value="<?php echo esc_attr( $value ); ?>" class="regular-text" readonly style="background: #f0f0f0;">
	<?php
}

function mpe_fetch_button_render() {
	$options = get_option( 'mpe_theme_options' );
	$has_url = ! empty( $options['tripadvisor_profile_url'] );
	?>
	<button type="button" id="mpe-fetch-ta-reviews" class="button button-primary" <?php echo ! $has_url ? 'disabled' : ''; ?>>
		<?php _e( 'Fetch Reviews Now', 'mpe2025' ); ?>
	</button>
	<span id="mpe-fetch-status" style="margin-left: 10px;"></span>
	<p class="description">
		<?php if ( ! $has_url ) : ?>
			<span style="color: #dc3232;">⚠️ <?php _e( 'Please enter a TripAdvisor URL above and click "Save Settings" first.', 'mpe2025' ); ?></span>
		<?php else : ?>
			<?php _e( 'Manually fetch and store reviews from TripAdvisor.', 'mpe2025' ); ?>
		<?php endif; ?>
	</p>
	<?php
}

function mpe_theme_colors_render() {
    $options = get_option( 'mpe_theme_options' );
    $colors = array(
        'primary' => __( 'Primary', 'mpe2025' ),
        'primary_hover' => __( 'Primary Hover', 'mpe2025' ),
        'background_light' => __( 'Background Light', 'mpe2025' ),
        'background_dark' => __( 'Background Dark', 'mpe2025' ),
        'text_light' => __( 'Text Light', 'mpe2025' ),
        'text_dark' => __( 'Text Dark', 'mpe2025' ),
        'accent' => __( 'Accent', 'mpe2025' ),
        'gold' => __( 'Gold', 'mpe2025' ),
    );
    ?>
    <div class="mpe-color-grid">
        <?php foreach ( $colors as $key => $label ) : 
            $field = $key . '_color';
            $value = isset( $options[ $field ] ) ? $options[ $field ] : '';
        ?>
            <div class="mpe-color-item">
                <label><?php echo esc_html( $label ); ?></label>
                <input type="text" name="mpe_theme_options[<?php echo esc_attr( $field ); ?>]" value="<?php echo esc_attr( $value ); ?>" class="mpe-color-picker" data-default-color="#ffffff">
            </div>
        <?php endforeach; ?>
    </div>
    <?php
}

function mpe_image_upload_render( $args ) {
	$options = get_option( 'mpe_theme_options' );
	$field   = $args['field'];
	$value   = isset( $options[ $field ] ) ? $options[ $field ] : '';
	?>
	<div class="image-preview-wrapper">
		<img id="image-preview-<?php echo esc_attr( $field ); ?>" src="<?php echo esc_attr( $value ); ?>" style="max-width: 150px; display: <?php echo $value ? 'block' : 'none'; ?>;" />
	</div>
	<input type="hidden" name="mpe_theme_options[<?php echo esc_attr( $field ); ?>]" id="image-url-<?php echo esc_attr( $field ); ?>" value="<?php echo esc_attr( $value ); ?>">
	<input type="button" class="button button-secondary mpe-upload-button" value="<?php esc_attr_e( 'Upload Image', 'mpe2025' ); ?>" data-target="#image-url-<?php echo esc_attr( $field ); ?>" data-preview="#image-preview-<?php echo esc_attr( $field ); ?>">
	<input type="button" class="button button-secondary mpe-remove-button" value="<?php esc_attr_e( 'Remove', 'mpe2025' ); ?>" data-target="#image-url-<?php echo esc_attr( $field ); ?>" data-preview="#image-preview-<?php echo esc_attr( $field ); ?>" style="display: <?php echo $value ? 'inline-block' : 'none'; ?>;">
	<?php
}

/**
 * Render site icon (favicon) upload field with description.
 */
function mpe_site_icon_upload_render( $args ) {
	$options = get_option( 'mpe_theme_options' );
	$field   = $args['field'];
	$value   = isset( $options[ $field ] ) ? $options[ $field ] : '';
	?>
	<div class="image-preview-wrapper">
		<img id="image-preview-<?php echo esc_attr( $field ); ?>" src="<?php echo esc_attr( $value ); ?>" style="max-width: 64px; display: <?php echo $value ? 'block' : 'none'; ?>;" />
	</div>
	<input type="hidden" name="mpe_theme_options[<?php echo esc_attr( $field ); ?>]" id="image-url-<?php echo esc_attr( $field ); ?>" value="<?php echo esc_attr( $value ); ?>">
	<input type="button" class="button button-secondary mpe-upload-button" value="<?php esc_attr_e( 'Upload Icon', 'mpe2025' ); ?>" data-target="#image-url-<?php echo esc_attr( $field ); ?>" data-preview="#image-preview-<?php echo esc_attr( $field ); ?>">
	<input type="button" class="button button-secondary mpe-remove-button" value="<?php esc_attr_e( 'Remove', 'mpe2025' ); ?>" data-target="#image-url-<?php echo esc_attr( $field ); ?>" data-preview="#image-preview-<?php echo esc_attr( $field ); ?>" style="display: <?php echo $value ? 'inline-block' : 'none'; ?>;">
	<p class="description">
		<?php _e( 'Upload a square image (PNG or ICO format recommended). Ideal size: 512x512 pixels. This will be used as the browser favicon and mobile app icon.', 'mpe2025' ); ?>
	</p>
	<?php
}

/**
 * Render the settings page.
 */
function mpe_theme_options_page_html() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form action="options.php" method="post">
			<?php
			settings_fields( 'mpe_theme_options_group' );
			do_settings_sections( 'mpe_theme_options' );
			submit_button( __( 'Save Settings', 'mpe2025' ) );
			?>
		</form>
	</div>
	<?php
}

/**
 * Enqueue scripts and styles.
 */
function mpe_admin_scripts( $hook ) {
	if ( 'toplevel_page_mpe_theme_options' !== $hook ) {
		return;
	}

	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_media();

	wp_enqueue_script( 'mpe-admin-script', get_template_directory_uri() . '/assets/js/admin.js', array( 'jquery', 'wp-color-picker' ), '1.0.0', true );
    
    // Inline script for media uploader and color picker initialization
    wp_add_inline_script( 'mpe-admin-script', '
        jQuery(document).ready(function($){
            // Color Picker
            $(".mpe-color-picker").wpColorPicker();

            // Media Uploader
            $(".mpe-upload-button").click(function(e) {
                e.preventDefault();
                var button = $(this);
                var target = $(button.data("target"));
                var preview = $(button.data("preview"));
                var removeBtn = button.next(".mpe-remove-button");

                var custom_uploader = wp.media({
                    title: "Select Image",
                    button: {
                        text: "Use this image"
                    },
                    multiple: false
                }).on("select", function() {
                    var attachment = custom_uploader.state().get("selection").first().toJSON();
                    target.val(attachment.url);
                    preview.attr("src", attachment.url).show();
                    removeBtn.show();
                }).open();
            });

            $(".mpe-remove-button").click(function(e) {
                e.preventDefault();
                var button = $(this);
                var target = $(button.data("target"));
                var preview = $(button.data("preview"));
                
                target.val("");
                preview.hide();
                button.hide();
            });

            // TripAdvisor Fetch Button
            $("#mpe-fetch-ta-reviews").click(function(e) {
                e.preventDefault();
                var button = $(this);
                var status = $("#mpe-fetch-status");
                
                button.prop("disabled", true).text("Fetching...");
                status.html("<span style=\"color: #999;\">Please wait...</span>");
                
                $.ajax({
                    url: ajaxurl,
                    type: "POST",
                    data: {
                        action: "mpe_fetch_ta_reviews",
                        nonce: "' . wp_create_nonce( 'mpe_fetch_ta_reviews' ) . '"
                    },
                    success: function(response) {
                        button.prop("disabled", false).text("Fetch Reviews Now");
                        if (response.success) {
                            status.html("<span style=\"color: #46b450;\">✓ " + response.data.message + "</span>");
                            setTimeout(function() { location.reload(); }, 2000);
                        } else {
                            status.html("<span style=\"color: #dc3232;\">✗ " + response.data.message + "</span>");
                        }
                    },
                    error: function() {
                        button.prop("disabled", false).text("Fetch Reviews Now");
                        status.html("<span style=\"color: #dc3232;\">✗ Error occurred. Please try again.</span>");
                    }
                });
            });
        });
    ');

    // Inline CSS for Color Grid
    wp_add_inline_style( 'wp-color-picker', '
        .mpe-color-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }
        .mpe-color-item {
            background: #fff;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .mpe-color-item label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
        }
        
        /* Header CTA Languages Grid */
        .mpe-cta-languages-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 16px;
            margin-bottom: 12px;
        }
        .mpe-cta-lang-card {
            background: #fff;
            border: 1px solid #c3c4c7;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
        }
        .mpe-cta-lang-header {
            background: linear-gradient(135deg, #2271b1, #135e96);
            color: #fff;
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .mpe-cta-lang-header strong {
            flex: 1;
        }
        .mpe-cta-lang-header code {
            background: rgba(255,255,255,0.2);
            color: #fff;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 11px;
        }
        .mpe-lang-flag {
            width: 24px;
            height: 16px;
            object-fit: cover;
            border-radius: 2px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.2);
        }
        .mpe-cta-lang-fields {
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .mpe-cta-lang-fields label {
            display: flex;
            flex-direction: column;
            gap: 4px;
            font-weight: 500;
            color: #1d2327;
            font-size: 13px;
        }
        .mpe-cta-lang-fields input {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #c3c4c7;
            border-radius: 4px;
            font-size: 14px;
        }
        .mpe-cta-lang-fields input:focus {
            border-color: #2271b1;
            box-shadow: 0 0 0 1px #2271b1;
            outline: none;
        }
        
        /* Reservation Form Languages Grid */
        .mpe-form-languages-wrapper {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin-bottom: 12px;
        }
        .mpe-form-lang-card {
            background: #fff;
            border: 1px solid #c3c4c7;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
        }
        .mpe-form-lang-header {
            background: linear-gradient(135deg, #8e44ad, #6c3483);
            color: #fff;
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }
        .mpe-form-lang-header:hover {
            background: linear-gradient(135deg, #9b59b6, #7d3c98);
        }
        .mpe-form-lang-header strong {
            flex: 1;
        }
        .mpe-form-lang-header code {
            background: rgba(255,255,255,0.2);
            color: #fff;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 11px;
        }
        .mpe-form-lang-fields {
            padding: 16px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 12px;
            background: #f9f9f9;
        }
        .mpe-form-field-row {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .mpe-form-field-row label {
            font-weight: 500;
            color: #1d2327;
            font-size: 12px;
        }
        .mpe-form-field-row input,
        .mpe-form-field-row textarea {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #c3c4c7;
            border-radius: 4px;
            font-size: 13px;
        }
        .mpe-form-field-row input:focus,
        .mpe-form-field-row textarea:focus {
            border-color: #8e44ad;
            box-shadow: 0 0 0 1px #8e44ad;
            outline: none;
        }
        .mpe-form-field-row textarea {
            resize: vertical;
            min-height: 60px;
        }
    ');
}
add_action( 'admin_enqueue_scripts', 'mpe_admin_scripts' );

/**
 * Output Custom CSS Variables
 */
function mpe_custom_css_output() {
    $options = get_option( 'mpe_theme_options' );
    
    $css_vars = array(
        '--primary' => 'primary_color',
        '--primary-hover' => 'primary_hover_color',
        '--background-light' => 'background_light_color',
        '--background-dark' => 'background_dark_color',
        '--text-light' => 'text_light_color',
        '--text-dark' => 'text_dark_color',
        '--accent' => 'accent_color',
        '--gold' => 'gold_color',
    );

    $css_output = ":root {\n";
    foreach ( $css_vars as $css_var => $option_key ) {
        if ( ! empty( $options[ $option_key ] ) ) {
            $css_output .= "    {$css_var}: " . sanitize_hex_color( $options[ $option_key ] ) . ";\n";
        }
    }
    $css_output .= "}\n";

    if ( ! empty( $css_output ) ) {
        echo '<style type="text/css" id="mpe-custom-css">' . $css_output . '</style>';
    }
}
add_action( 'wp_head', 'mpe_custom_css_output' );

/**
 * Output Site Icon (Favicon) with SEO and Accessibility Best Practices.
 * Outputs multiple formats and sizes for maximum browser and device compatibility.
 */
function mpe_output_site_icon() {
    $options = get_option( 'mpe_theme_options' );
    $icon_url = isset( $options['site_icon'] ) ? $options['site_icon'] : '';
    
    if ( empty( $icon_url ) ) {
        return;
    }
    
    // Get the attachment ID from URL for generating different sizes
    $icon_id = attachment_url_to_postid( $icon_url );
    
    // Determine the file extension
    $extension = strtolower( pathinfo( $icon_url, PATHINFO_EXTENSION ) );
    $mime_type = 'image/png';
    if ( $extension === 'ico' ) {
        $mime_type = 'image/x-icon';
    } elseif ( $extension === 'svg' ) {
        $mime_type = 'image/svg+xml';
    }
    
    echo "\n<!-- Site Icon / Favicon - MPE Theme -->\n";
    
    // Standard favicon (legacy support)
    echo '<link rel="icon" href="' . esc_url( $icon_url ) . '" type="' . esc_attr( $mime_type ) . '">' . "\n";
    echo '<link rel="shortcut icon" href="' . esc_url( $icon_url ) . '" type="' . esc_attr( $mime_type ) . '">' . "\n";
    
    // If we have an attachment ID, generate different sizes for better SEO
    if ( $icon_id ) {
        // Small size for browsers (32x32)
        $icon_32 = wp_get_attachment_image_src( $icon_id, array( 32, 32 ) );
        if ( $icon_32 ) {
            echo '<link rel="icon" type="' . esc_attr( $mime_type ) . '" sizes="32x32" href="' . esc_url( $icon_32[0] ) . '">' . "\n";
        }
        
        // Medium size for high-DPI displays (192x192)
        $icon_192 = wp_get_attachment_image_src( $icon_id, array( 192, 192 ) );
        if ( $icon_192 ) {
            echo '<link rel="icon" type="' . esc_attr( $mime_type ) . '" sizes="192x192" href="' . esc_url( $icon_192[0] ) . '">' . "\n";
        }
        
        // Apple Touch Icon (180x180 for iOS)
        $icon_180 = wp_get_attachment_image_src( $icon_id, array( 180, 180 ) );
        if ( $icon_180 ) {
            echo '<link rel="apple-touch-icon" sizes="180x180" href="' . esc_url( $icon_180[0] ) . '">' . "\n";
        }
        
        // Large size for Android/Chrome (512x512)
        $icon_512 = wp_get_attachment_image_src( $icon_id, array( 512, 512 ) );
        if ( $icon_512 ) {
            echo '<link rel="icon" type="' . esc_attr( $mime_type ) . '" sizes="512x512" href="' . esc_url( $icon_512[0] ) . '">' . "\n";
        }
    } else {
        // Fallback: use original image for all sizes
        echo '<link rel="icon" type="' . esc_attr( $mime_type ) . '" sizes="32x32" href="' . esc_url( $icon_url ) . '">' . "\n";
        echo '<link rel="icon" type="' . esc_attr( $mime_type ) . '" sizes="192x192" href="' . esc_url( $icon_url ) . '">' . "\n";
        echo '<link rel="apple-touch-icon" sizes="180x180" href="' . esc_url( $icon_url ) . '">' . "\n";
    }
    
    // Microsoft Tile (for Windows and Edge)
    echo '<meta name="msapplication-TileImage" content="' . esc_url( $icon_url ) . '">' . "\n";
    
    // Theme color for mobile browsers (matches primary color if set)
    $primary_color = isset( $options['primary_color'] ) && ! empty( $options['primary_color'] ) ? $options['primary_color'] : '#007bff';
    echo '<meta name="theme-color" content="' . esc_attr( sanitize_hex_color( $primary_color ) ) . '">' . "\n";
    echo '<meta name="msapplication-TileColor" content="' . esc_attr( sanitize_hex_color( $primary_color ) ) . '">' . "\n";
}
add_action( 'wp_head', 'mpe_output_site_icon', 1 ); // Priority 1 to output early in head
