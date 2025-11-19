<?php
/**
 * Archive Template (Category, Tag, Date, Author archives)
 * 
 * @package Tahseen_Ashrafi_Theme
 */

get_header();
?>

<main class="archive-page">
    <header class="archive-header">
        <h1 class="archive-title">
            <?php
            if (is_category()) {
                single_cat_title();
            } elseif (is_tag()) {
                single_tag_title();
            } elseif (is_author()) {
                the_author();
            } elseif (is_date()) {
                echo get_the_date('F Y');
            } else {
                _e('Archives', 'tahseen-ashrafi-theme');
            }
            ?>
        </h1>
        <?php
        if (is_category() && category_description()) {
            echo '<div class="archive-description">' . category_description() . '</div>';
        }
        ?>
    </header>
    
    <div class="main-content">
        <div class="archive-grid">
            <?php
            if (have_posts()) :
                while (have_posts()) : the_post();
                    ?>
                    <article class="archive-post">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>">
                                <img src="<?php the_post_thumbnail_url('featured-medium'); ?>" 
                                     alt="<?php the_title_attribute(); ?>" 
                                     class="archive-image">
                            </a>
                        <?php endif; ?>
                        
                        <div class="archive-post-content">
                            <div class="news-meta">
                                <?php
                                $categories = get_the_category();
                                if ($categories) {
                                    echo '<span class="category-tag" style="color: var(--primary-red);">' 
                                         . esc_html($categories[0]->name) . '</span>';
                                    echo '<span> | </span>';
                                }
                                ?>
                                <time><?php echo tahseen_ashrafi_format_date(); ?></time>
                                <span> | </span>
                                <span><?php _e('By', 'tahseen-ashrafi-theme'); ?> <?php the_author(); ?></span>
                            </div>
                            
                            <h2 class="news-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            
                            <div class="post-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                        </div>
                    </article>
                    <?php
                endwhile;
                
                // Pagination
                echo '<div class="view-more-btn">';
                tahseen_ashrafi_pagination();
                echo '</div>';
                
            else :
                ?>
                <div class="no-posts">
                    <h2><?php _e('Nothing Found', 'tahseen-ashrafi-theme'); ?></h2>
                    <p><?php _e('Sorry, no posts matched your criteria.', 'tahseen-ashrafi-theme'); ?></p>
                </div>
                <?php
            endif;
            ?>
        </div>
        
        <aside class="sidebar-area">
            <?php get_sidebar(); ?>
        </aside>
    </div>
</main>

<?php get_footer(); ?>
