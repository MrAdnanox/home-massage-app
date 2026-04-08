<?php
/**
 * The template for displaying search results pages
 */

get_header(); ?>

<div class="w-full max-w-7xl mx-auto px-4 md:px-10 py-12 md:py-20">
	<header class="mb-12 text-center">
		<h1 class="text-3xl md:text-4xl font-bold text-accent mb-4">
			<?php
			/* translators: %s: search query. */
			printf( esc_html__( 'Search Results for: %s', 'mpe2025' ), '<span>' . get_search_query() . '</span>' );
			?>
		</h1>
	</header>

	<?php
	// Custom Query to ensure we get results from our CPTs
	$search_term = get_search_query();
	$args = array(
		's'           => $search_term,
		'post_type'   => array( 'service', 'vehicle', 'excursion' ),
		'post_status' => 'publish',
	);

	$search_query = new WP_Query( $args );

	if ( $search_query->have_posts() ) : ?>
		<div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
			<?php
			while ( $search_query->have_posts() ) :
				$search_query->the_post();
				
				// Get data for the card
				$thumb_url = get_the_post_thumbnail_url( get_the_ID(), 'large' );
				// Fallback image if needed, or just leave empty as per original design
				if ( ! $thumb_url ) {
					$thumb_url = ''; // Or a placeholder URL
				}
				
				$seats = get_post_meta( get_the_ID(), '_mpe2025_vehicle_seats', true );
				$luggage = get_post_meta( get_the_ID(), '_mpe2025_vehicle_luggage', true );
				?>
				<div class="card group">
					<a href="<?php the_permalink(); ?>" class="block overflow-hidden">
						<div class="w-full bg-center bg-no-repeat aspect-video bg-cover transition-transform duration-300 group-hover:scale-105" style='background-image: url("<?php echo esc_url( $thumb_url ); ?>");'></div>
					</a>
					<div class="card-content">
						<a href="<?php the_permalink(); ?>">
							<p class="text-text-light text-xl font-medium leading-normal hover:text-primary transition-colors"><?php the_title(); ?></p>
						</a>
						<div class="flex items-center gap-4 mt-2 text-gray-600">
							<?php if ( $seats ) : ?>
								<div class="flex items-center gap-1.5"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 24 24" width="1em" fill="currentColor" class="text-lg"><path d="M0 0h24v24H0z" fill="none"/><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg><span><?php echo esc_html( $seats ); ?></span></div>
							<?php endif; ?>
							<?php if ( $luggage ) : ?>
								<div class="flex items-center gap-1.5"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 24 24" width="1em" fill="currentColor" class="text-lg"><path d="M0 0h24v24H0z" fill="none"/><path d="M20 6h-4V4c0-1.11-.89-2-2-2h-4c-1.11 0-2 .89-2 2v2H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-6 0h-4V4h4v2z"/></svg><span><?php echo esc_html( $luggage ); ?></span></div>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<?php
			endwhile;
			wp_reset_postdata();
			?>
		</div>
		<div class="mt-8">
			<?php 
			// Pagination for custom query
			$big = 999999999; // need an unlikely integer
			echo paginate_links( array(
				'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format' => '?paged=%#%',
				'current' => max( 1, get_query_var('paged') ),
				'total' => $search_query->max_num_pages
			) );
			?>
		</div>
	<?php else : ?>
		<div class="text-center">
			<p class="text-gray-600 mb-8"><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'mpe2025' ); ?></p>
			<div class="max-w-md mx-auto">
				<?php get_search_form(); ?>
			</div>
		</div>
	<?php endif; ?>
</div>

<?php get_footer(); ?>
