<?php
/**
 * 404 Error Page Template
 * 
 * @package Tahseen_Ashrafi_Theme
 */

get_header();
?>

<main class="error-404">
    <div class="container">
        <h1 class="error-code">404</h1>
        <h2><?php _e('Oops! Page Not Found', 'tahseen-ashrafi-theme'); ?></h2>
        <p><?php _e('The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'tahseen-ashrafi-theme'); ?></p>
        
        <div class="search-form-wrapper" style="max-width: 500px; margin: 40px auto;">
            <?php get_search_form(); ?>
        </div>
        
        <a href="<?php echo esc_url(home_url('/')); ?>" class="more-button" style="margin-top: 20px;">
            <?php _e('Go Back Home', 'tahseen-ashrafi-theme'); ?>
        </a>
        
        <!-- Popular Posts -->
        <div style="margin-top: 60px; max-width: 800px; margin-left: auto; margin-right: auto;">
            <h3 style="text-align: center; margin-bottom: 30px; color: var(--primary-red);">
                <?php _e('Popular Articles', 'tahseen-ashrafi-theme'); ?>
            </h3>
            <div class="three-column-grid" style="grid-template-columns: repeat(3, 1fr);">
                <?php
                $popular_posts = tahseen_ashrafi_get_latest_posts(3);
                if ($popular_posts->have_posts()) :
                    while ($popular_posts->have_posts()) : $popular_posts->the_post();
                        ?>
                        <article class="archive-post">
                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php the_permalink(); ?>">
                                    <img src="<?php the_post_thumbnail_url('featured-medium'); ?>" 
                                         alt="<?php the_title_attribute(); ?>" 
                                         style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px;">
                                </a>
                            <?php endif; ?>
                            <h4 style="margin-top: 15px;">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h4>
                        </article>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
