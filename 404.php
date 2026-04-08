<?php
/**
 * The template for displaying 404 pages (not found)
 */

get_header(); ?>

<div class="w-full max-w-7xl mx-auto px-4 md:px-10 py-12 md:py-20 text-center">
	<div class="max-w-2xl mx-auto">
		<h1 class="text-6xl font-bold text-primary mb-4">404</h1>
		<h2 class="text-3xl font-bold text-accent mb-6"><?php _e( 'Oops! That page can&rsquo;t be found.', 'mpe2025' ); ?></h2>
		<p class="text-gray-600 mb-8"><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'mpe2025' ); ?></p>
		
		<div class="max-w-md mx-auto">
			<?php get_search_form(); ?>
		</div>
		
		<div class="mt-12">
			<a href="<?php echo home_url(); ?>" class="btn btn-primary"><?php _e( 'Back to Homepage', 'mpe2025' ); ?></a>
		</div>
	</div>
</div>

<?php get_footer(); ?>
