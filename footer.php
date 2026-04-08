<?php
/**
 * Footer Template
 *
 * @package MPE2025
 */

$options = get_option( 'mpe_theme_options' );
$phone = isset( $options['phone_number'] ) ? $options['phone_number'] : '';
$whatsapp = isset( $options['whatsapp_number'] ) ? $options['whatsapp_number'] : '';
$email = isset( $options['email_address'] ) ? $options['email_address'] : '';
$address = isset( $options['address'] ) ? $options['address'] : '';
$facebook = isset( $options['facebook_url'] ) ? $options['facebook_url'] : '';
$instagram = isset( $options['instagram_url'] ) ? $options['instagram_url'] : '';
$youtube = isset( $options['youtube_url'] ) ? $options['youtube_url'] : '';
$tripadvisor = isset( $options['tripadvisor_url'] ) ? $options['tripadvisor_url'] : '';
?>
<?php
// Get current language
$current_lang = function_exists('pll_current_language') ? pll_current_language() : 'en';

// Helper to get option with fallback
$get_footer_option = function($key_base, $default) use ($options, $current_lang) {
    $key = $key_base . '_' . $current_lang;
    return !empty($options[$key]) ? $options[$key] : $default;
};

// Defaults (Fallback if empty in options)
$default_texts = array(
    'title_1' => get_bloginfo( 'name' ),
    'text'    => 'Votre partenaire bien-être à domicile à Marrakech. Massages professionnels et soins spa chez vous.', // Defaulting to French as per request context
    'title_2' => 'Quick Links',
    'title_3' => 'Contact Us',
    'title_4' => 'Follow Us',
);

if ($current_lang === 'fr') {
    $default_texts['title_2'] = 'Liens Rapides';
    $default_texts['title_3'] = 'Contactez-nous';
    $default_texts['title_4'] = 'Suivez-nous';
}

$footer_title_1 = $get_footer_option('footer_title_1', $default_texts['title_1']);
$footer_text    = $get_footer_option('footer_text', $default_texts['text']);
$footer_title_2 = $get_footer_option('footer_title_2', $default_texts['title_2']);
$footer_title_3 = $get_footer_option('footer_title_3', $default_texts['title_3']);
$footer_title_4 = $get_footer_option('footer_title_4', $default_texts['title_4']);
?>
        </main>
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div>
                    <h4><?php echo esc_html( $footer_title_1 ); ?></h4>
                    <p class="text-sm"><?php echo nl2br( esc_html( $footer_text ) ); ?></p>
                </div>
                <div>
                    <h4><?php echo esc_html( $footer_title_2 ); ?></h4>
                    <?php
                    wp_nav_menu( array(
                        'theme_location' => 'footer_links',
                        'container'      => false,
                        'menu_class'     => 'footer-menu',
                        'fallback_cb'    => false,
                        'depth'          => 1,
                    ) );
                    ?>
                </div>
                <div>
                    <h4><?php echo esc_html( $footer_title_3 ); ?></h4>
                    <ul class="space-y-2 text-sm">
                        <?php if ( $phone ) : ?>
                            <li class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"/><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg><span><?php echo esc_html( $phone ); ?></span></li>
                        <?php endif; ?>
                        <?php if ( $email ) : ?>
                            <li class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"/><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg><span><?php echo esc_html( $email ); ?></span></li>
                        <?php endif; ?>
                        <?php if ( $address ) : ?>
                            <li class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"/><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg><span><?php echo esc_html( $address ); ?></span></li>
                        <?php endif; ?>
                        <?php 
                        $ice_number = isset( $options['ice_number'] ) ? $options['ice_number'] : '';
                        if ( $ice_number ) : 
                        ?>
                            <li class="flex items-center gap-2" style="padding-left: 32px;"><span>ICE: <?php echo esc_html( $ice_number ); ?></span></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div>
                    <h4><?php echo esc_html( $footer_title_4 ); ?></h4>
                    <div class="flex gap-4 footer-social">
                        <?php if ( $facebook ) : ?>
                            <a href="<?php echo esc_url( $facebook ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Visit our Facebook page">
                                <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path clip-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" fill-rule="evenodd"></path></svg>
                            </a>
                        <?php endif; ?>
                        <?php if ( $instagram ) : ?>
                            <a href="<?php echo esc_url( $instagram ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Visit our Instagram page">
                                <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.85s-.012 3.584-.07 4.85c-.148 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07s-3.584-.012-4.85-.07c-3.252-.148-4.771-1.691-4.919-4.919-.058-1.265-.07-1.645-.07-4.85s.012-3.584.07-4.85C2.28 3.854 3.726 2.31 6.981 2.163 8.246 2.105 8.623 2.093 12 2.093h.001zm0-2.093c-3.264 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.058 1.281-.072 1.685-.072 4.947s.014 3.666.072 4.947c.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.685.072 4.947.072s3.666-.014 4.947-.072c4.358-.2 6.78-2.618 6.98-6.98.058-1.281.072-1.685.072-4.947s-.014-3.666-.072-4.947c-.2-4.358-2.618-6.78-6.98-6.98C15.667.014 15.264 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.88 1.44 1.44 0 000-2.88z"></path></svg>
                            </a>
                        <?php endif; ?>
                        <?php if ( $tripadvisor ) : ?>
                            <a href="<?php echo esc_url( $tripadvisor ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Visit our TripAdvisor page">
                                <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2"><path d="M175.335 281.334c0 24.483-19.853 44.336-44.336 44.336-24.484 0-44.337-19.853-44.337-44.336 0-24.484 19.853-44.337 44.337-44.337 24.483 0 44.336 19.853 44.336 44.337zm205.554-44.337c-24.48 0-44.336 19.853-44.336 44.337 0 24.483 19.855 44.336 44.336 44.336 24.481 0 44.334-19.853 44.334-44.336-.006-24.47-19.839-44.31-44.309-44.323l-.025-.01v-.004zm125.002 44.337c0 68.997-55.985 124.933-124.999 124.933a124.466 124.466 0 01-84.883-33.252l-40.006 43.527-40.025-43.576a124.45 124.45 0 01-84.908 33.3c-68.968 0-124.933-55.937-124.933-124.932A124.586 124.586 0 0146.889 189L6 144.517h90.839c96.116-65.411 222.447-65.411 318.557 0H506l-40.878 44.484a124.574 124.574 0 0140.769 92.333zm-290.31 0c0-46.695-37.858-84.55-84.55-84.55-46.691 0-84.55 37.858-84.55 84.55 0 46.691 37.859 84.55 84.55 84.55 46.692 0 84.545-37.845 84.55-84.54v-.013.003zM349.818 155.1a244.01 244.01 0 00-187.666 0C215.532 175.533 256 223.254 256 278.893c0-55.634 40.463-103.362 93.826-123.786l-.005-.006h-.003zm115.64 126.224c0-46.694-37.858-84.55-84.55-84.55-46.691 0-84.552 37.859-84.552 84.55 0 46.692 37.855 84.55 84.553 84.55 46.697 0 84.55-37.858 84.55-84.55z" fill-rule="nonzero"/></svg>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?>. All Rights Reserved.</p>
            </div>
        </div>
    </footer>
    
    <!-- Floating Action Buttons -->
    <div class="floating-buttons">
        <?php 
            if ( $whatsapp ) : 
                $clean_phone = ltrim( $whatsapp, '+' );
        ?>
        <a href="<?php echo esc_html( $whatsapp ); ?>" target="_blank" rel="noopener noreferrer" class="floating-btn whatsapp-btn" aria-label="Contact us on WhatsApp">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
        </a>
        <?php endif; ?>
        <button id="scroll-to-top" class="floating-btn scroll-top-btn" aria-label="Scroll to top">
            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"/><path d="M4 12l1.41 1.41L11 7.83V20h2V7.83l5.58 5.59L20 12l-8-8-8 8z"/></svg>
        </button>
    </div>
</div>
<?php wp_footer(); ?>
</body>
</html>
