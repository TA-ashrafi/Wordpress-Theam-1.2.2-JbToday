<?php
/**
 * Sidebar Template
 * 
 * @package Tahseen_Ashrafi_Theme
 */

if (!is_active_sidebar('sidebar-1')) {
    return;
}
?>

<aside class="sidebar">
    <!-- Latest News Widget -->
    <div class="widget">
        <h3 class="widget-title"><?php _e('Latest', 'tahseen-ashrafi-theme'); ?></h3>
        <ul class="latest-news-list">
            <?php
            $latest_posts = tahseen_ashrafi_get_latest_posts(8);
            if ($latest_posts->have_posts()) :
                while ($latest_posts->have_posts()) : $latest_posts->the_post();
                    ?>
                    <li class="latest-news-item">
                        <div class="news-meta">
                            <time><?php echo get_the_date('M j, Y'); ?></time>
                        </div>
                        <h4 class="news-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h4>
                    </li>
                    <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </ul>
    </div>
    
    <?php dynamic_sidebar('sidebar-1'); ?>
</aside>
