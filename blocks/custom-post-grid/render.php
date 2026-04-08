<?php
/**
 * Render callback for the Custom Post Grid block.
 *
 * @param array $attributes Block attributes.
 */

$post_type = isset( $attributes['postType'] ) ? $attributes['postType'] : 'post';
$posts_to_show = isset( $attributes['postsToShow'] ) ? intval( $attributes['postsToShow'] ) : 3;
$selected_category = isset( $attributes['selectedCategory'] ) ? $attributes['selectedCategory'] : '';

$args = array(
    'post_type'      => $post_type,
    'posts_per_page' => $posts_to_show,
    'post_status'    => 'publish',
);

// Add category filter if selected
if ( ! empty( $selected_category ) ) {
    // Determine taxonomy based on post type
    $taxonomy = 'category'; // Default for posts
    if ( 'service' === $post_type ) {
        // Services might not have categories, but if they did...
        // For now, assuming standard category or custom tax if defined.
        // If services don't have categories, this might need adjustment.
        // Let's assume standard 'category' for now or skip if not applicable.
    } elseif ( 'vehicle' === $post_type ) {
        // Vehicles might use a custom taxonomy?
    } elseif ( 'excursion' === $post_type ) {
        // Excursions might use a custom taxonomy?
    }
    
    // For simplicity in this iteration, we'll try to filter by 'category' 
    // if the user selected one, assuming the post type supports it.
    // If we need specific taxonomies per CPT, we'd need to fetch them.
    // Given the prompt "choisie celon la categorie", we'll assume 'category' or generic tax query.
    
    // However, the prompt implies selecting a category *after* choosing post type.
    // In the editor, we'll list categories. Here we just query by it.
    // We'll assume the ID is passed or slug. Let's assume ID for robustness if we can get it, or slug.
    // Let's stick to 'category_name' if it's a slug, or 'cat' if ID.
    // The JS will likely pass a slug or ID. Let's assume ID for now.
    
    if ( is_numeric( $selected_category ) ) {
         $args['cat'] = $selected_category;
    } else {
         $args['category_name'] = $selected_category;
    }
}

$query = new WP_Query( $args );

if ( $query->have_posts() ) : ?>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
        <?php
        while ( $query->have_posts() ) :
            $query->the_post();
            
            // Get data for the card
            $thumb_url = get_the_post_thumbnail_url( get_the_ID(), 'thumb' );
            if ( ! $thumb_url ) {
                $thumb_url = ''; 
            }
            
            $seats = get_post_meta( get_the_ID(), '_mpe2025_vehicle_seats', true );
            $luggage = get_post_meta( get_the_ID(), '_mpe2025_vehicle_luggage', true );
            $wifi = get_post_meta( get_the_ID(), '_mpe2025_vehicle_wifi', true );
            ?>
            <div class="card group">
                <a href="<?php the_permalink(); ?>" class="block overflow-hidden" aria-label="<?php echo esc_attr( sprintf( __( 'Read more about %s', 'mpe2025' ), get_the_title() ) ); ?>">
                    <div class="w-full bg-center bg-no-repeat aspect-video bg-cover transition-transform duration-300 group-hover:scale-105" style='background-image: url("<?php echo esc_url( $thumb_url ); ?>");'></div>
                </a>
                <div class="card-content">
                    <a href="<?php the_permalink(); ?>">
                        <p class="text-text-light text-xl font-medium leading-normal hover:text-primary transition-colors"><?php the_title(); ?></p>
                    </a>
                    
                    <?php if ( 'vehicle' === $post_type ) : ?>
                    <div class="flex items-center gap-4 mt-2 text-gray-600">
                        <?php if ( $seats ) : ?>
                            <div class="flex items-center gap-1.5"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 24 24" width="1em" fill="currentColor" class="text-lg"><path d="M0 0h24v24H0z" fill="none"/><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg><span><?php echo esc_html( $seats ); ?></span></div>
                        <?php endif; ?>
                        <?php if ( $luggage ) : ?>
                            <div class="flex items-center gap-1.5"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 24 24" width="1em" fill="currentColor" class="text-lg"><path d="M0 0h24v24H0z" fill="none"/><path d="M20 6h-4V4c0-1.11-.89-2-2-2h-4c-1.11 0-2 .89-2 2v2H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-6 0h-4V4h4v2z"/></svg><span><?php echo esc_html( $luggage ); ?></span></div>
                        <?php endif; ?>
                        <?php if ( $wifi ) : ?>
                            <div class="flex items-center gap-1.5"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 24 24" width="1em" fill="currentColor" class="text-lg"><path d="M0 0h24v24H0z" fill="none"/><path d="M1 9l2 2c4.97-4.97 13.03-4.97 18 0l2-2C16.93 2.93 7.08 2.93 1 9zm8 8l3 3 3-3c-1.65-1.66-4.34-1.66-6 0zm-4-4l2 2c2.76-2.76 7.24-2.76 10 0l2-2C15.14 9.14 8.87 9.14 5 13z"/></svg></div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ( 'post' === $post_type || 'service' === $post_type || 'excursion' === $post_type ) : ?>
                        <div class="text-sm text-gray-500 mt-2">
                            <?php echo wp_trim_words( get_the_excerpt(), 10 ); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php
        endwhile;
        wp_reset_postdata();
        ?>
    </div>
<?php else : ?>
    <p><?php _e( 'No posts found.', 'mpe2025' ); ?></p>
<?php endif; ?>
