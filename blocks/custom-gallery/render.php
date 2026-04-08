<?php
/**
 * Render callback for the Custom Gallery block.
 *
 * @param array $attributes Block attributes.
 */

$images = isset($attributes['images']) ? $attributes['images'] : [];
$columns = isset($attributes['columns']) ? $attributes['columns'] : 3;

if (empty($images)) {
    return;
}

// Unique ID for this block instance to handle multiple galleries on one page safely
$block_id = 'gallery-' . uniqid();
$grid_style = "grid-template-columns: repeat({$columns}, 1fr);";
?>

<div class="custom-gallery-block" id="<?php echo esc_attr($block_id); ?>">
    <div class="custom-gallery-grid" style="<?php echo esc_attr($grid_style); ?>">
        <?php foreach ($images as $index => $image) : 
            $thumb_url = isset($image['sizes']['thumbnail']['url']) ? $image['sizes']['thumbnail']['url'] : $image['url'];
            // Attempt to get a larger size (large/medium_large) instead of full original functionality if possible, 
            // but fallback to URL is safe.
            $full_url = isset($image['sizes']['large']['url']) ? $image['sizes']['large']['url'] : $image['url'];
            $alt_text = isset($image['alt']) ? $image['alt'] : '';
            $caption = isset($image['caption']) ? $image['caption'] : '';
        ?>
            <div class="gallery-item">
                <a href="<?php echo esc_url($full_url); ?>" 
                   class="gallery-link" 
                   data-no-swup 
                   data-index="<?php echo esc_attr($index); ?>"
                   aria-label="<?php echo esc_attr( $alt_text ?: 'View image' ); ?>">
                    <figure>
                        <img 
                            src="<?php echo esc_url($thumb_url); ?>" 
                            alt="<?php echo esc_attr($alt_text); ?>" 
                            loading="lazy"
                            width="300" 
                            height="300"
                            class="gallery-image"
                        >
                        <div class="gallery-overlay">
                            <span class="icon-zoom">+</span>
                        </div>
                    </figure>
                </a>
                <!-- Hidden data for JS to read -->
                <script type="application/json" class="img-data">
                    <?php echo json_encode([
                        'src' => $full_url,
                        'alt' => $alt_text,
                        'caption' => $caption
                    ]); ?>
                </script>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Lightbox Modal -->
    <div class="custom-gallery-lightbox" aria-hidden="true">
        <div class="lightbox-overlay"></div>
        
        <div class="lightbox-container">
            <button class="lightbox-close" aria-label="Close">
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
            
            <button class="lightbox-nav prev" aria-label="Previous">
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none"><polyline points="15 18 9 12 15 6"></polyline></svg>
            </button>
            
            <div class="lightbox-content">
                <img src="" alt="" class="lightbox-image">
                <div class="lightbox-caption"></div>
            </div>
            
            <button class="lightbox-nav next" aria-label="Next">
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </button>
        </div>
        
        <div class="lightbox-loader">
            <div class="spinner"></div>
        </div>
    </div>
</div>
