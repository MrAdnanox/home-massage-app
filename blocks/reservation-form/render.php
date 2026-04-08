<?php
/**
 * Render callback for the Reservation Form block.
 *
 * @param array $attributes Block attributes.
 */

// Get language from Polylang or fallback to block attribute
$language = 'en'; // Default
if ( function_exists( 'pll_current_language' ) ) {
    $language = pll_current_language( 'slug' );
} elseif ( isset( $attributes['language'] ) ) {
    $language = $attributes['language'];
}

// Get theme options for custom labels
$options = get_option( 'mpe_theme_options' );

// Default labels for each language (fallback)
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

// Build labels from theme options with fallback to defaults
$base_defaults = isset( $default_labels[ $language ] ) ? $default_labels[ $language ] : $default_labels['en'];
$label_keys = array( 'title', 'date_label', 'name_label', 'tel_label', 'email_label', 'object_label', 'message_label', 'submit_label', 'sending_label', 'success', 'error' );

$current_labels = array();
foreach ( $label_keys as $key ) {
    $option_key = 'reservation_form_' . $key . '_' . $language;
    $current_labels[ $key ] = ! empty( $options[ $option_key ] ) ? $options[ $option_key ] : $base_defaults[ $key ];
}

// Get current page title for the Object field
$page_title = get_the_title();
$page_url   = get_permalink();

// Generate unique form ID
$form_id = 'mpe-reservation-form-' . uniqid();
?>

<div class="mpe-reservation-form-container" id="<?php echo esc_attr( $form_id ); ?>-container">
    <div class="mpe-alert mpe-alert-success" style="display: none;" role="alert"></div>
    <div class="mpe-alert mpe-alert-error" style="display: none;" role="alert"></div>

    <div class="mpe-reservation-form-header">
        <h3><?php echo esc_html( $current_labels['title'] ); ?></h3>
    </div>

    <form id="<?php echo esc_attr( $form_id ); ?>" class="mpe-reservation-form" novalidate>
        <!-- Hidden Fields -->
        <input type="hidden" name="page_url" value="<?php echo esc_url( $page_url ); ?>">

        <!-- Visible Fields -->
        <div class="form-group">
            <label for="<?php echo esc_attr( $form_id ); ?>-date" class="sr-only"><?php echo esc_html( $current_labels['date_label'] ); ?></label>
            <input type="date" id="<?php echo esc_attr( $form_id ); ?>-date" name="res_date" required placeholder="<?php echo esc_attr( $current_labels['date_label'] ); ?>">
        </div>

        <div class="form-group">
            <label for="<?php echo esc_attr( $form_id ); ?>-name" class="sr-only"><?php echo esc_html( $current_labels['name_label'] ); ?></label>
            <input type="text" id="<?php echo esc_attr( $form_id ); ?>-name" name="res_name" required placeholder="<?php echo esc_attr( $current_labels['name_label'] ); ?>">
        </div>

        <div class="form-group">
            <label for="<?php echo esc_attr( $form_id ); ?>-tel" class="sr-only"><?php echo esc_html( $current_labels['tel_label'] ); ?></label>
            <input type="tel" id="<?php echo esc_attr( $form_id ); ?>-tel" name="res_tel" required placeholder="<?php echo esc_attr( $current_labels['tel_label'] ); ?>">
        </div>

        <div class="form-group">
            <label for="<?php echo esc_attr( $form_id ); ?>-email" class="sr-only"><?php echo esc_html( $current_labels['email_label'] ); ?></label>
            <input type="email" id="<?php echo esc_attr( $form_id ); ?>-email" name="res_email" required placeholder="<?php echo esc_attr( $current_labels['email_label'] ); ?>">
        </div>

        <div class="form-group">
            <label for="<?php echo esc_attr( $form_id ); ?>-object" class="sr-only"><?php echo esc_html( $current_labels['object_label'] ); ?></label>
            <input type="text" id="<?php echo esc_attr( $form_id ); ?>-object" name="res_object" value="<?php echo esc_attr( $page_title ); ?>" placeholder="<?php echo esc_attr( $current_labels['object_label'] ); ?>">
        </div>

        <div class="form-group">
            <label for="<?php echo esc_attr( $form_id ); ?>-message" class="sr-only"><?php echo esc_html( $current_labels['message_label'] ); ?></label>
            <textarea id="<?php echo esc_attr( $form_id ); ?>-message" name="res_message" rows="4" required placeholder="<?php echo esc_attr( $current_labels['message_label'] ); ?>"></textarea>
        </div>

        <div class="form-submit">
            <button type="submit" class="btn btn-primary w-full" data-original-text="<?php echo esc_attr( $current_labels['submit_label'] ); ?>">
                <?php echo esc_html( $current_labels['submit_label'] ); ?>
            </button>
        </div>
    </form>
</div>

<script>
(function() {
    'use strict';
    
    // Get form elements
    var container = document.getElementById('<?php echo esc_js( $form_id ); ?>-container');
    var form = document.getElementById('<?php echo esc_js( $form_id ); ?>');
    
    if (!form || !container) return;
    
    var submitBtn = form.querySelector('button[type="submit"]');
    var successAlert = container.querySelector('.mpe-alert-success');
    var errorAlert = container.querySelector('.mpe-alert-error');
    
    // Labels
    var labels = {
        sending: '<?php echo esc_js( $current_labels['sending_label'] ); ?>',
        success: '<?php echo esc_js( $current_labels['success'] ); ?>',
        error: '<?php echo esc_js( $current_labels['error'] ); ?>'
    };
    
    // AJAX configuration
    var ajaxUrl = '<?php echo esc_js( admin_url( 'admin-ajax.php' ) ); ?>';
    var nonce = '<?php echo esc_js( wp_create_nonce( 'mpe_reservation_ajax_nonce' ) ); ?>';
    
    // Hide alerts
    function hideAlerts() {
        successAlert.style.display = 'none';
        errorAlert.style.display = 'none';
    }
    
    // Show alert
    function showAlert(type, message) {
        hideAlerts();
        var alert = type === 'success' ? successAlert : errorAlert;
        alert.textContent = message;
        alert.style.display = 'block';
        
        // Scroll to alert
        container.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
    
    // Set button loading state
    function setLoading(loading) {
        if (loading) {
            submitBtn.disabled = true;
            submitBtn.textContent = labels.sending;
            submitBtn.classList.add('is-loading');
        } else {
            submitBtn.disabled = false;
            submitBtn.textContent = submitBtn.getAttribute('data-original-text');
            submitBtn.classList.remove('is-loading');
        }
    }
    
    // Handle form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        hideAlerts();
        setLoading(true);
        
        // Collect form data
        var formData = new FormData(form);
        formData.append('action', 'mpe_reservation_ajax');
        formData.append('nonce', nonce);
        
        // Create XMLHttpRequest (native, no dependencies)
        var xhr = new XMLHttpRequest();
        xhr.open('POST', ajaxUrl, true);
        
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                setLoading(false);
                
                try {
                    var response = JSON.parse(xhr.responseText);
                    
                    if (xhr.status === 200 && response.success) {
                        showAlert('success', response.data.message || labels.success);
                        form.reset();
                        
                        // Restore object field value
                        var objectField = form.querySelector('[name="res_object"]');
                        if (objectField) {
                            objectField.value = '<?php echo esc_js( $page_title ); ?>';
                        }
                    } else {
                        showAlert('error', response.data && response.data.message ? response.data.message : labels.error);
                    }
                } catch (e) {
                    showAlert('error', labels.error);
                }
            }
        };
        
        xhr.onerror = function() {
            setLoading(false);
            showAlert('error', labels.error);
        };
        
        xhr.send(formData);
    });
})();
</script>
