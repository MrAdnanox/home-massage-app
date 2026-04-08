<?php
/**
 * The main template file
 */

get_header(); ?>

<div class="w-full max-w-7xl mx-auto px-4 md:px-10 py-12 md:py-20">
    <?php if ( have_posts() ) : ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php
            while ( have_posts() ) :
                the_post();
                get_template_part( 'template-parts/content' );
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
