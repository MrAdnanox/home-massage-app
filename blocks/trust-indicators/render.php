<?php
/**
 * Render callback for the Trust Indicators block.
 *
 * @param array $attributes Block attributes.
 */

// Define the 4 guarantees with updated content and icons
$guarantees = array(
    array(
        'title' => 'Expertise Certifiée',
        'text'  => 'Nos masseuses et kinésithérapeutes sont tous diplômés d\'État.',
        'svg'   => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.499 5.516 50.552 50.552 0 00-2.658.813m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" /></svg>',
    ),
    array(
        'title' => 'Satisfaction Client',
        'text'  => 'Plus de 1200 clients satisfaits par nos soins d’exception.',
        'svg'   => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"> <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 15.182a4.5 4.5 0 0 1-6.364 0M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75Zm6 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75Z" /></svg>',
    ),
    array(
        'title' => 'Expérience Confirmée',
        'text'  => 'Minimum 7 ans d\'expérience pratique pour chaque thérapeute.',
        'svg'   => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" /></svg>',
    ),
    array(
        'title' => 'Confiance & Sécurité',
        'text'  => 'Matériel professionnel stérilisé et respect strict de l’intimité.',
        'svg'   => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" /></svg>',
    )
);
?>

<style>
.mpe-trust-block {
    padding: 2rem 0;
}

.mpe-trust-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
    margin: 0 auto;
    max-width: 1280px;
    padding: 0 1.5rem;
}

@media (min-width: 768px) {
    .mpe-trust-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (min-width: 1200px) {
    .mpe-trust-grid { grid-template-columns: repeat(4, 1fr); }
}

.mpe-trust-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 2rem 1.5rem;
    text-align: center;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    border: 1px solid rgba(0, 0, 0, 0.03);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
    height: 100%;
}

.mpe-trust-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.01);
    border-color: rgba(212, 163, 115, 0.3);
}

.mpe-trust-icon-wrapper {
    width: 64px;
    height: 64px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: var(--bg-light, #f9fafb);
    color: var(--primary, #5c4033);
    margin-bottom: 0.5rem;
    transition: all 0.3s ease;
    border: 1px solid rgba(0,0,0,0.05);
}

.mpe-trust-card:hover .mpe-trust-icon-wrapper {
    background: var(--primary-hover, #5c4033);
    color: #ffffff;
    transform: scale(1.1) rotate(3deg);
    border-color: var(--primary-hover, #5c4033);
}

.mpe-trust-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--text-dark, #1f2937);
    font-family: var(--font-heading, "Playfair Display", serif);
    margin: 0;
    line-height: 1.3;
}

.mpe-trust-text {
    font-size: 0.95rem;
    color: var(--text-color, #6b7280);
    line-height: 1.6;
    margin: 0;
    flex-grow: 1; /* Ensures cards are same height visually if descriptions vary slightly */
}
</style>

<div class="mpe-trust-block">
    <div class="mpe-trust-grid">
        <?php foreach ( $guarantees as $item ) : ?>
            <div class="mpe-trust-card">
                <div class="mpe-trust-icon-wrapper">
                    <?php echo $item['svg']; ?>
                </div>
                <h3 class="mpe-trust-title"><?php echo esc_html( $item['title'] ); ?></h3>
                <p class="mpe-trust-text"><?php echo esc_html( $item['text'] ); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</div>
