<?php
/**
 * Template Name: Front Page
 */

get_header(); ?>

<div class="w-full">
    <!-- Hero Section -->
    <?php
    $options = get_option( 'mpe_theme_options' );
    $hero_image = ! empty( $options['hero_image'] ) ? $options['hero_image'] : 'https://lh3.googleusercontent.com/aida-public/AB6AXuDiz6btUyMkFOcrDMO3R-TBVwk6BY4Ba4CtO1dPsWs0Qta686lNVGoJBPvZamNQykUcbjSjEtFs_qoUHXELAElYfwqmYUfTPYT5JM_uUkDm527Z2WjROjEKGNMzx99fxuVziJPpsszqg6DFa64lW4vhTachxSmNQ6jL8teY3LdW14p_aFrJW7apBqAd3--B_eBvYFihDrN5pFGD5cgWc_RLzoQwuek_4h29D9nmkjoW1n-zQTyWOIAKORgzcG8iUVrHY1p0L35THEA';
    $hero_image = ! empty( $options['hero_image'] ) ? $options['hero_image'] : 'https://lh3.googleusercontent.com/aida-public/AB6AXuDiz6btUyMkFOcrDMO3R-TBVwk6BY4Ba4CtO1dPsWs0Qta686lNVGoJBPvZamNQykUcbjSjEtFs_qoUHXELAElYfwqmYUfTPYT5JM_uUkDm527Z2WjROjEKGNMzx99fxuVziJPpsszqg6DFa64lW4vhTachxSmNQ6jL8teY3LdW14p_aFrJW7apBqAd3--B_eBvYFihDrN5pFGD5cgWc_RLzoQwuek_4h29D9nmkjoW1n-zQTyWOIAKORgzcG8iUVrHY1p0L35THEA';
    $whatsapp = isset( $options['whatsapp_number'] ) ? $options['whatsapp_number'] : '';
    
    // Get current language for hero text
    $current_lang = function_exists( 'pll_current_language' ) ? pll_current_language() : 'en';
    
    // Get hero title and subtitle from options
    $hero_title_key    = 'hero_title_' . $current_lang;
    $hero_subtitle_key = 'hero_subtitle_' . $current_lang;
    
    // Default texts
    $default_titles = array(
        'en' => 'Your Private Journey Through Morocco Starts Here',
        'fr' => 'Votre Voyage Privé à Travers le Maroc Commence Ici',
    );
    $default_subtitles = array(
        'en' => 'Premium Private Drivers, Airport Transfers, and Custom Excursions in Marrakech.',
        'fr' => 'Chauffeurs privés premium, transferts aéroport et excursions sur mesure à Marrakech.',
    );
    
    $hero_title    = ! empty( $options[ $hero_title_key ] ) ? $options[ $hero_title_key ] : ( isset( $default_titles[ $current_lang ] ) ? $default_titles[ $current_lang ] : $default_titles['en'] );
    $hero_subtitle = ! empty( $options[ $hero_subtitle_key ] ) ? $options[ $hero_subtitle_key ] : ( isset( $default_subtitles[ $current_lang ] ) ? $default_subtitles[ $current_lang ] : $default_subtitles['en'] );
    
    // Search placeholder
    $hero_search_key = 'hero_search_placeholder_' . $current_lang;
    $default_search = array(
        'en' => 'Enter your destination',
        'fr' => 'Entrez votre destination',
    );
    $hero_search_placeholder = ! empty( $options[ $hero_search_key ] ) ? $options[ $hero_search_key ] : ( isset( $default_search[ $current_lang ] ) ? $default_search[ $current_lang ] : $default_search['en'] );
    ?>
    <?php
    $hero_style = isset( $options['hero_style'] ) ? $options['hero_style'] : 'default';
    $hero_class = 'hero-style-' . $hero_style;
    ?>
    <div class="hero <?php echo esc_attr( $hero_class ); ?>" style='background-image: url("<?php echo esc_url( $hero_image ); ?>");'>
        <div class="hero-content">
            <span class="hero-title"><?php echo esc_html( $hero_title ); ?></span>
            <p><?php echo esc_html( $hero_subtitle ); ?></p>
            <!--
            <form role="search" method="get" class="hero-search" action="/">
                <input type="search" class="search-field" placeholder="<?php echo esc_attr( $hero_search_placeholder ); ?>" value="<?php echo get_search_query(); ?>" name="s">
                <a type="submit" class="btn btn-primary">
                    <div class="hero-search-icon">
                         <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"/><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg> 
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                </a>
            </form>
            -->
            <?php 
            if ( $whatsapp ) : 
                $clean_phone = ltrim( $whatsapp, '+' );
            ?>
            <a target="_blank" aria-label="WhatsApp" class="btn btn-primary" href="<?php echo esc_url( $whatsapp ); ?>">Réservez</a>
            <?php endif; ?>
        </div>
    </div>
    <div class="w-full bg-background-light py-12 md:py-20" id="reviews">
        <div class="w-full max-w-7xl mx-auto px-4 md:px-10">
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) :
            the_post();
            the_content();
        endwhile;
    endif;
    ?>
        </div>
    </div>

<?php get_footer(); ?>
