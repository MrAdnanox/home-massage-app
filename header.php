<!DOCTYPE html>
<html <?php language_attributes(); ?> class="light">
<head>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-KKYNLD3HC5"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-KKYNLD3HC5');
</script>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php 
wp_body_open(); 
$options = get_option( 'mpe_theme_options' );
?>


    <header class="<?php echo esc_attr( isset( $options['menu_style'] ) && ! empty( $options['menu_style'] ) ? 'menu-style-' . $options['menu_style'] : 'menu-style-default' ); ?>">

        <div class="container">
            <div class="logo">
                <?php
                $logo_url = isset( $options['site_logo'] ) ? $options['site_logo'] : '';
                
                if ( $logo_url ) :
                ?>
                    <a href="/">
                        <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php bloginfo( 'name' ); ?>" style="max-height: 50px;">
                    </a>
                <?php else : ?>
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 24 24" width="1em" fill="currentColor" class="text-3xl text-primary"><path d="M0 0h24v24H0z" fill="none"/><path d="M12 10.9c-.61 0-1.1.49-1.1 1.1s.49 1.1 1.1 1.1c.61 0 1.1-.49 1.1-1.1s-.49-1.1-1.1-1.1zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm2.19 12.19L6 18l3.81-8.19L18 6l-3.81 8.19z"/></svg>
                    <a href="<?php echo home_url(); ?>">
                        <?php bloginfo( 'name' ); ?>
                    </a>
                <?php endif; ?>
            </div>
            
            <div class="mobile-menu-toggle lg:hidden">
                <button id="menu-toggle" class="hamburger-btn" aria-label="Toggle menu" aria-expanded="false" aria-controls="site-navigation">
                    <svg class="hamburger-icon" viewBox="0 0 100 100" width="30" height="30" aria-hidden="true">
                        <rect class="line top" width="80" height="10" x="10" y="25" rx="5"></rect>
                        <rect class="line middle" width="80" height="10" x="10" y="45" rx="5"></rect>
                        <rect class="line bottom" width="80" height="10" x="10" y="65" rx="5"></rect>
                    </svg>
                </button>
            </div>

            <nav id="site-navigation" class="nav-menu" aria-label="Main Navigation">
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'menu-list',
                    'fallback_cb'    => false,
                ) );
                ?>
                <?php
                // Get current language (default to 'en' if Polylang not active)
                $current_lang = function_exists( 'pll_current_language' ) ? pll_current_language() : 'en';
                
                // Get the appropriate button text based on language (fallback chain: current lang -> 'en' -> default)
                $cta_text = '';
                if ( isset( $options['header_cta_text_' . $current_lang] ) && ! empty( $options['header_cta_text_' . $current_lang] ) ) {
                    $cta_text = $options['header_cta_text_' . $current_lang];
                } elseif ( isset( $options['header_cta_text_en'] ) && ! empty( $options['header_cta_text_en'] ) ) {
                    $cta_text = $options['header_cta_text_en'];
                } else {
                    $cta_text = __( 'Book Now', 'mpe2025' );
                }
                
                // Get the appropriate button URL based on language (fallback chain: current lang -> 'en' -> contact)
                $cta_url = '';
                if ( isset( $options['header_cta_url_' . $current_lang] ) && ! empty( $options['header_cta_url_' . $current_lang] ) ) {
                    $cta_url = $options['header_cta_url_' . $current_lang];
                } elseif ( isset( $options['header_cta_url_en'] ) && ! empty( $options['header_cta_url_en'] ) ) {
                    $cta_url = $options['header_cta_url_en'];
                } else {
                    $cta_url = home_url( '/contact' );
                }
                ?>
                <?php
                if ( isset( $options['menu_style'] ) && $options['menu_style'] === 'centered' ) :
                ?>
                    <a target="_blank" aria-label="WhatsApp" class="btn-whatsapp-minimal mobile-menu-btn" href="<?php echo esc_url( $cta_url ); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"></path></svg>
                        <span><?php echo esc_html( $cta_text ); ?></span>
                    </a>
                <?php else : ?>
                    <a target="_blank" aria-label="WhatsApp" class="btn btn-primary mobile-menu-btn" href="<?php echo esc_url( $cta_url ); ?>"><?php echo esc_html( $cta_text ); ?></a>
                <?php endif; ?>

            </nav>

                <?php 
                /*
            <div class="header-actions">
                if ( function_exists( 'pll_the_languages' ) ) :
                    $languages = pll_the_languages( array( 'raw' => 1 ) );
                    if ( ! empty( $languages ) ) : ?>
                        <div class="language-switcher relative">
                            <a class="btn btn-lang" onclick="const menu = this.nextElementSibling; menu.classList.toggle('active');">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"/><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zm6.93 6h-2.95c-.32-1.25-.78-2.45-1.38-3.56 1.84.63 3.37 1.91 4.33 3.56zM12 4.04c.83 1.2 1.48 2.53 1.91 3.96h-3.82c.43-1.43 1.08-2.76 1.91-3.96zM4.26 14C4.1 13.36 4 12.69 4 12s.1-1.36.26-2h3.38c-.08.66-.14 1.32-.14 2 0 .68.06 1.34.14 2H4.26zm.82 2h2.95c.32 1.25.78 2.45 1.38 3.56-1.84-.63-3.37-1.9-4.33-3.56zm2.95-8H5.08c.96-1.66 2.49-2.93 4.33-3.56C8.81 5.55 8.35 6.75 8.03 8zM12 19.96c-.83-1.2-1.48-2.53-1.91-3.96h3.82c-.43 1.43-1.08 2.76-1.91 3.96zM14.34 14H9.66c-.09-.66-.16-1.32-.16-2 0-.68.07-1.35.16-2h4.68c.09.65.16 1.32.16 2 0 .68-.07 1.34-.16 2zm.25 5.56c.6-1.11 1.06-2.31 1.38-3.56h2.95c-.96 1.65-2.49 2.93-4.33 3.56zM16.36 14c.08-.66.14-1.32.14-2 0-.68-.06-1.34-.14-2h3.38c.16.64.26 1.31.26 2s-.1 1.36-.26 2h-3.38z"/></svg>
                            </a>
                            <ul class="lang-dropdown">
                                <?php foreach ( $languages as $lang ) : ?>
                                    <li>
                                        <a href="<?php echo esc_url( $lang['url'] ); ?>">
                                            <?php if ( ! empty( $lang['flag'] ) ) : ?>
                                                <img src="<?php echo esc_url( $lang['flag'] ); ?>" alt="<?php echo esc_attr( $lang['name'] ); ?>">
                                            <?php endif; ?>
                                            <span class="<?php echo $lang['current_lang'] ? 'current' : ''; ?>"><?php echo esc_html( $lang['name'] ); ?></span>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php else : ?>
                        <!-- Fallback if no languages are configured -->
                        <a class="btn btn-lang" title="No languages configured" aria-label="No languages configured">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"/><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zm6.93 6h-2.95c-.32-1.25-.78-2.45-1.38-3.56 1.84.63 3.37 1.91 4.33 3.56zM12 4.04c.83 1.2 1.48 2.53 1.91 3.96h-3.82c.43-1.43 1.08-2.76 1.91-3.96zM4.26 14C4.1 13.36 4 12.69 4 12s.1-1.36.26-2h3.38c-.08.66-.14 1.32-.14 2 0 .68.06 1.34.14 2H4.26zm.82 2h2.95c.32 1.25.78 2.45 1.38 3.56-1.84-.63-3.37-1.9-4.33-3.56zm2.95-8H5.08c.96-1.66 2.49-2.93 4.33-3.56C8.81 5.55 8.35 6.75 8.03 8zM12 19.96c-.83-1.2-1.48-2.53-1.91-3.96h3.82c-.43 1.43-1.08 2.76-1.91 3.96zM14.34 14H9.66c-.09-.66-.16-1.32-.16-2 0-.68.07-1.35.16-2h4.68c.09.65.16 1.32.16 2 0 .68-.07 1.34-.16 2zm.25 5.56c.6-1.11 1.06-2.31 1.38-3.56h2.95c-.96 1.65-2.49 2.93-4.33 3.56zM16.36 14c.08-.66.14-1.32.14-2 0-.68-.06-1.34-.14-2h3.38c.16.64.26 1.31.26 2s-.1 1.36-.26 2h-3.38z"/></svg>
                        </a>
                    <?php endif;
                else : ?>
                    <!-- Fallback if Polylang is not active -->
                    <a class="btn btn-lang" title="Polylang not active" aria-label="Polylang not active">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"/><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zm6.93 6h-2.95c-.32-1.25-.78-2.45-1.38-3.56 1.84.63 3.37 1.91 4.33 3.56zM12 4.04c.83 1.2 1.48 2.53 1.91 3.96h-3.82c.43-1.43 1.08-2.76 1.91-3.96zM4.26 14C4.1 13.36 4 12.69 4 12s.1-1.36.26-2h3.38c-.08.66-.14 1.32-.14 2 0 .68.06 1.34.14 2H4.26zm.82 2h2.95c.32 1.25.78 2.45 1.38 3.56-1.84-.63-3.37-1.9-4.33-3.56zm2.95-8H5.08c.96-1.66 2.49-2.93 4.33-3.56C8.81 5.55 8.35 6.75 8.03 8zM12 19.96c-.83-1.2-1.48-2.53-1.91-3.96h3.82c-.43 1.43-1.08 2.76-1.91 3.96zM14.34 14H9.66c-.09-.66-.16-1.32-.16-2 0-.68.07-1.35.16-2h4.68c.09.65.16 1.32.16 2 0 .68-.07 1.34-.16 2zm.25 5.56c.6-1.11 1.06-2.31 1.38-3.56h2.95c-.96 1.65-2.49 2.93-4.33 3.56zM16.36 14c.08-.66.14-1.32.14-2 0-.68-.06-1.34-.14-2h3.38c.16.64.26 1.31.26 2s-.1 1.36-.26 2h-3.38z"/></svg>
                    </a>
                <?php endif; ?>
            </div>
                */
                ?>

        </div>
    </header>
<div class="relative flex w-full flex-col">
    <main>
