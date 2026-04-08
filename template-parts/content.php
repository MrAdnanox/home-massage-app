<?php
/**
 * Template part for displaying posts
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'card' ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="w-full bg-center bg-no-repeat aspect-video bg-cover" style='background-image: url("<?php echo get_the_post_thumbnail_url( get_the_ID(), 'large' ); ?>");'></div>
	<?php endif; ?>
	<div class="card-content">
		<h2 class="text-xl font-medium leading-normal mb-2">
			<a href="<?php the_permalink(); ?>" class="hover:text-primary"><?php the_title(); ?></a>
		</h2>
		<div class="text-gray-600 text-sm mb-4">
			<?php echo get_the_excerpt(); ?>
		</div>
		<a href="<?php the_permalink(); ?>" class="btn btn-primary text-sm">Read More</a>
	</div>
</article>
