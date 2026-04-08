<?php
/**
 * The template for displaying all single posts
 */

get_header(); ?>

<?php
while ( have_posts() ) :
    the_post();
    $thumbnail_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
    ?>
    
    <!-- Hero Section -->
    <div class="single-hero relative h-[60vh] min-h-[400px] flex items-center justify-center overflow-hidden">
        <?php if ( $thumbnail_url ) : ?>
            <div class="single-hero-bg absolute inset-0 bg-cover bg-center" style="background-image: url('<?php echo esc_url( $thumbnail_url ); ?>');"></div>
        <?php else : ?>
            <div class="single-hero-bg absolute inset-0 bg-accent"></div>
        <?php endif; ?>
        
        <div class="single-hero-overlay absolute inset-0 bg-black/50"></div>
        
        <div class="single-hero-content relative z-10 container text-center text-white px-4">

            <?php the_title( '<h1 class="text-4xl md:text-6xl font-bold mb-4 text-white drop-shadow-lg">', '</h1>' ); ?>
        </div>
    </div>

    <div class="container relative z-20 mt-8 mb-20 px-4">
        <article id="post-<?php the_ID(); ?>" <?php post_class( 'bg-background-light rounded-xl shadow-xl p-8 md:p-12 max-w-4xl mx-auto' ); ?>>

            <div class="prose max-w-none text-text-light">
                <?php the_content(); ?>
            </div>

            <?php
            // If it's a vehicle, show the meta details
            if ( 'vehicle' === get_post_type() ) :
                $seats = get_post_meta( get_the_ID(), '_mpe2025_vehicle_seats', true );
                $luggage = get_post_meta( get_the_ID(), '_mpe2025_vehicle_luggage', true );
                $wifi = get_post_meta( get_the_ID(), '_mpe2025_vehicle_wifi', true );
                ?>
                <div class="mt-8 p-6 bg-background-light rounded-xl border border-gray-200">
                    <h3 class="text-xl font-bold text-accent mb-4">Vehicle Details</h3>
                    <ul class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                        <?php if ( $seats ) : ?>
                            <li class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24" fill="currentColor" class="text-primary"><path d="M0 0h24v24H0z" fill="none"/><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                                <span><strong>Seats:</strong> <?php echo esc_html( $seats ); ?></span>
                            </li>
                        <?php endif; ?>
                        <?php if ( $luggage ) : ?>
                            <li class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24" fill="currentColor" class="text-primary"><path d="M0 0h24v24H0z" fill="none"/><path d="M20 6h-4V4c0-1.11-.89-2-2-2h-4c-1.11 0-2 .89-2 2v2H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-6 0h-4V4h4v2z"/></svg>
                                <span><strong>Luggage:</strong> <?php echo esc_html( $luggage ); ?></span>
                            </li>
                        <?php endif; ?>
                        <?php if ( $wifi ) : ?>
                            <li class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24" fill="currentColor" class="text-primary"><path d="M0 0h24v24H0z" fill="none"/><path d="M1 9l2 2c4.97-4.97 13.03-4.97 18 0l2-2C16.93 2.93 7.08 2.93 1 9zm8 8l3 3 3-3c-1.65-1.66-4.34-1.66-6 0zm-4-4l2 2c2.76-2.76 7.24-2.76 10 0l2-2C15.14 9.14 8.87 9.14 5 13z"/></svg>
                                <span><strong>Wifi:</strong> <?php echo 'yes' === $wifi ? 'Available' : 'Not Available'; ?></span>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            <?php endif; ?>

        </article>
    </div>
    <?php
endwhile; // End of the loop.
?>

<?php get_footer(); ?>
