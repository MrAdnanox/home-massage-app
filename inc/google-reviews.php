<?php
/**
 * Google Reviews - Manual Entry Only
 *
 * @package MPE2025
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register custom post type for reviews (redundant if already in cpt.php but kept for structure if moved back, 
 * however current architecture has CPTs in cpt.php. ensure consistency. 
 * Wait, existing tripadvisor-reviews.php registered the CPT inside itself too? 
 * Let's check step 16. Yes, it did `register_post_type` inside `mpe_register_tripadvisor_review_cpt`.
 * But step 6 `inc/cpt.php` ALSO had it?
 * Let's check `inc/cpt.php` in step 6.
 * Line 85: definition of tripadvisor_review.
 * Line 15: definition of tripadvisor_review.
 * It seems duplicated or I misinterpreted.
 * Step 6 shows `inc/cpt.php` has `tripadvisor_review`.
 * Step 16 `inc/tripadvisor-reviews.php` ALSO has `register_post_type`.
 * 
 * If I renamed it in `inc/cpt.php` (Step 29), I should NOT register it again here to avoid "already registered" notices or conflict, 
 * OR I should remove it from one place.
 * 
 * The `inc/cpt.php` seems to be the main place. 
 * The `tripadvisor-reviews.php` file had `add_action( 'init', 'mpe_register_tripadvisor_review_cpt' );`.
 * 
 * I should probably REMOVE the registration from this new file and rely on `inc/cpt.php`, 
 * OR keep it here and remove from `inc/cpt.php`. 
 * 
 * Given `inc/cpt.php` seems to be the "central" place, I will comment out or remove the registration here 
 * and only keep the Meta Boxes and Shortcode.
 * 
 * HOWEVER, looking at `inc/tripadvisor-reviews.php` in Step 16, it DOES register it.
 * And `inc/cpt.php` in Step 6 DOES register it.
 * This effectively registers it twice if both run on init. Redundant but harmless usually as second overwrites or is ignored.
 * 
 * I will REMOVE the CPT registration from this new file to clean up, relying on `inc/cpt.php`.
 */

/**
 * Add meta boxes for review details
 */
function mpe_add_google_review_meta_boxes() {
	add_meta_box(
		'mpe_google_review_details',
		__( 'Google Review Details', 'mpe2025' ),
		'mpe_google_review_details_meta_box',
		'google_reviews',
		'side',
		'high'
	);
}
add_action( 'add_meta_boxes', 'mpe_add_google_review_meta_boxes' );

/**
 * Render meta box content
 */
function mpe_google_review_details_meta_box( $post ) {
	wp_nonce_field( 'mpe_google_review_details', 'mpe_google_review_nonce' );
	
	$rating = get_post_meta( $post->ID, 'rating', true );
	$review_date = get_post_meta( $post->ID, 'review_date', true );
	$reviewer_location = get_post_meta( $post->ID, 'reviewer_location', true );
	?>
	<p>
		<label for="mpe_rating"><strong><?php _e( 'Rating (1-5)', 'mpe2025' ); ?></strong></label><br>
		<input type="number" id="mpe_rating" name="mpe_rating" value="<?php echo esc_attr( $rating ); ?>" min="1" max="5" style="width:100%">
	</p>
	<p>
		<label for="mpe_review_date"><strong><?php _e( 'Review Date', 'mpe2025' ); ?></strong></label><br>
		<input type="date" id="mpe_review_date" name="mpe_review_date" value="<?php echo esc_attr( $review_date ); ?>" style="width:100%">
	</p>
	<p>
		<label for="mpe_reviewer_location"><strong><?php _e( 'Reviewer Location', 'mpe2025' ); ?></strong></label><br>
		<input type="text" id="mpe_reviewer_location" name="mpe_reviewer_location" value="<?php echo esc_attr( $reviewer_location ); ?>" style="width:100%">
	</p>
	<?php
}

/**
 * Save meta box data
 */
function mpe_save_google_review_meta( $post_id ) {
	if ( ! isset( $_POST['mpe_google_review_nonce'] ) || ! wp_verify_nonce( $_POST['mpe_google_review_nonce'], 'mpe_google_review_details' ) ) {
		return;
	}
	
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	
	if ( isset( $_POST['mpe_rating'] ) ) {
		update_post_meta( $post_id, 'rating', intval( $_POST['mpe_rating'] ) );
	}
	if ( isset( $_POST['mpe_review_date'] ) ) {
		update_post_meta( $post_id, 'review_date', sanitize_text_field( $_POST['mpe_review_date'] ) );
	}
	if ( isset( $_POST['mpe_reviewer_location'] ) ) {
		update_post_meta( $post_id, 'reviewer_location', sanitize_text_field( $_POST['mpe_reviewer_location'] ) );
	}
}
add_action( 'save_post_google_reviews', 'mpe_save_google_review_meta' );

/**
 * Shortcode: [google_reviews]
 */
function mpe_google_reviews_shortcode( $atts ) {
	$atts = shortcode_atts( array(
		'count'     => 5,
		'min_stars' => 4,
		'order'     => 'desc',
	), $atts, 'google_reviews' );
	
	$args = array(
		'post_type'      => 'google_reviews',
		'posts_per_page' => intval( $atts['count'] ),
		'order'          => strtoupper( $atts['order'] ) === 'ASC' ? 'ASC' : 'DESC',
		'orderby'        => 'date',
		'meta_query'     => array(
			array(
				'key'     => 'rating',
				'value'   => intval( $atts['min_stars'] ),
				'compare' => '>=',
				'type'    => 'NUMERIC',
			),
		),
	);
	
	$query = new WP_Query( $args );
	
	if ( ! $query->have_posts() ) {
		return '<p>' . __( 'No reviews found.', 'mpe2025' ) . '</p>';
	}
	
	ob_start();
	?>
	<div class="ta-reviews-container google-reviews-container">
		<?php while ( $query->have_posts() ) : $query->the_post(); ?>
			<?php
			$post_id = get_the_ID();
			$rating = get_post_meta( $post_id, 'rating', true );
			$review_date = get_post_meta( $post_id, 'review_date', true );
			$reviewer_name = get_the_title();
			$reviewer_location = get_post_meta( $post_id, 'reviewer_location', true );
			$review_text = get_the_content();
			?>
			<div class="ta-review-card google-review-card">
				<div class="ta-review-header">
					<?php if ( has_post_thumbnail() ) : ?>
						<img src="<?php echo esc_url( get_the_post_thumbnail_url( $post_id, 'thumbnail' ) ); ?>" alt="<?php echo esc_attr( $reviewer_name ); ?>" class="ta-review-avatar">
					<?php else : ?>
						<div class="ta-review-avatar-placeholder">
							<?php echo esc_html( strtoupper( substr( $reviewer_name, 0, 1 ) ) ); ?>
						</div>
					<?php endif; ?>
					<div class="ta-review-meta">
						<span class="ta-reviewer-name"><?php echo esc_html( $reviewer_name ); ?></span>
						<?php if ( $reviewer_location ) : ?>
							<span class="ta-reviewer-location"><?php echo esc_html( $reviewer_location ); ?></span>
						<?php endif; ?>
					</div>
				</div>
				
				<div class="ta-review-rating">
					<?php echo mpe_render_star_rating( intval( $rating ) ); ?>
				</div>
				
				<?php if ( $review_text ) : ?>
					<p class="ta-review-text"><?php echo wp_kses_post( $review_text ); ?></p>
				<?php endif; ?>
				
				<div class="ta-review-footer">
					<?php if ( $review_date ) : ?>
						<span class="ta-review-date"><?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $review_date ) ) ); ?></span>
					<?php else : ?>
						<span></span>
					<?php endif; ?>
					<!-- Google Logo could go here instead of TripAdvisor -->
                    <?php 
                    $mpe_options = get_option( 'mpe_theme_options' );
                    $google_link = isset( $mpe_options['google_reviews_url'] ) ? $mpe_options['google_reviews_url'] : '';
                    
                    if ( ! empty( $google_link ) ) : ?>
                        <a href="<?php echo esc_url( $google_link ); ?>" target="_blank" rel="noopener noreferrer" class="google-logo-text">Google Reviews</a>
                    <?php else : ?>
                        <span class="google-logo-text">Google Reviews</span> 
                    <?php endif; ?>
				</div>
			</div>
		<?php endwhile; ?>
	</div>
	<?php
	wp_reset_postdata();
	
	return ob_get_clean();
}
add_shortcode( 'google_reviews', 'mpe_google_reviews_shortcode' );

/**
 * Render star rating
 */
function mpe_render_star_rating( $rating ) {
	$rating = max( 1, min( 5, intval( $rating ) ) );
	
	$star_svg = '<svg class="ta-star" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
	$star_empty_svg = '<svg class="ta-star ta-star-empty" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
	
	$html = '<div class="ta-stars">';
	for ( $i = 1; $i <= 5; $i++ ) {
		$html .= ( $i <= $rating ) ? $star_svg : $star_empty_svg;
	}
	$html .= '</div>';
	
	return $html;
}
