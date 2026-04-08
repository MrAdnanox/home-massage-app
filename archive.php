<?php
/**
 * The template for displaying archive pages
 */

get_header(); ?>

<div class="w-full max-w-7xl mx-auto px-4 md:px-10 py-12 md:py-20">
	<div class="mb-12 text-center">
		<?php
		the_archive_title( '<h1 class="text-3xl md:text-4xl font-bold text-accent mb-4">', '</h1>' );
		the_archive_description( '<div class="text-gray-600 max-w-2xl mx-auto">', '</div>' );
		?>
	</div>

	<?php if ( have_posts() ) : ?>
		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content', get_post_type() );
			endwhile;
			?>
		</div>
		<div class="mt-8">
			<?php the_posts_pagination(); ?>
		</div>
	<?php else : ?>
		<p><?php _e( 'Nothing found.', 'mpe2025' ); ?></p>
	<?php endif; ?>
</div>

<?php get_footer(); ?>
