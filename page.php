<?php
/**
 * The template for displaying all pages
 */

get_header(); ?>

<div class="w-full max-w-7xl mx-auto px-4 md:px-10 py-12 md:py-20">
    <?php
    while ( have_posts() ) :
        the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="mb-8">
                <?php the_title( '<h1 class="text-3xl md:text-4xl font-bold text-accent mb-4">', '</h1>' ); ?>
            </div>

            <?php if ( has_post_thumbnail() ) : ?>
                <div class="mb-8 rounded-xl overflow-hidden shadow-lg">
                    <?php the_post_thumbnail( 'large', array( 'class' => 'w-full h-auto' ) ); ?>
                </div>
            <?php endif; ?>

            <div class="prose max-w-none text-text-light">
                <?php the_content(); ?>
            </div>
        </article>
        <?php
    endwhile; // End of the loop.
    ?>
</div>

<?php get_footer(); ?>
