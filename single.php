<?php
/**
 * Single Post Template
 * 
 * @package Tahseen_Ashrafi_Theme
 */

get_header();
?>

<?php while (have_posts()) : the_post(); ?>
    <article class="single-post">
        <header class="post-header">
            <h1 class="post-title"><?php the_title(); ?></h1>
            
            <div class="post-meta-info">
                <span class="post-author">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="display: inline-block; vertical-align: middle;">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                    <?php the_author(); ?>
                </span>
                <time class="post-published" datetime="<?php echo get_the_date('c'); ?>">
                    Published: <?php echo get_the_date('F j, Y, g:i a'); ?>
                </time>
                <time class="post-updated" datetime="<?php echo get_the_modified_date('c'); ?>">
                    Updated: <?php echo get_the_modified_date('F j, Y, g:i a'); ?>
                </time>
            </div>
        </header>

        <?php if (has_post_thumbnail()) : ?>
            <div class="post-featured-image-wrapper">
                <?php the_post_thumbnail('large', array('class' => 'post-featured-image', 'alt' => get_the_title())); ?>
            </div>
        <?php endif; ?>

        <div class="post-content">
            <?php the_content(); ?>
        </div>

        <?php if (has_tag()) : ?>
            <div class="post-tags">
                <?php
                $tags = get_the_tags();
                foreach ($tags as $tag) {
                    echo '<a href="' . get_tag_link($tag->term_id) . '" class="tag">' . esc_html($tag->name) . '</a>';
                }
                ?>
            </div>
        <?php endif; ?>

        <!-- Read More Section -->
        <section class="read-more-section">
            <div class="section-heading">
                <h2>Read More</h2>
            </div>
            
            <?php
            $read_more_categories = array('World', 'National', 'Lifestyle');
            foreach ($read_more_categories as $category) :
                $cat_query = new WP_Query(array(
                    'category_name' => strtolower($category),
                    'posts_per_page' => 3,
                    'post__not_in' => array(get_the_ID())
                ));
                
                if ($cat_query->have_posts()) :
            ?>
                <div class="read-more-category">
                    <h3><?php echo esc_html($category); ?></h3>
                    <?php while ($cat_query->have_posts()) : $cat_query->the_post(); ?>
                        <article class="news-item">
                            <div class="news-meta">
                                <time datetime="<?php echo get_the_date('c'); ?>">
                                    <?php echo get_the_date('F j, Y, g:i a'); ?>
                                </time>
                            </div>
                            <h4 class="news-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h4>
                        </article>
                    <?php endwhile; ?>
                </div>
            <?php 
                endif;
                wp_reset_postdata();
            endforeach;
            ?>
        </section>

        <!-- Author Box -->
        <div class="author-box">
            <div class="author-avatar-wrapper">
                <?php echo get_avatar(get_the_author_meta('ID'), 100, '', get_the_author(), array('class' => 'author-avatar')); ?>
            </div>
            <div class="author-details">
                <h4><?php the_author(); ?></h4>
                <p><?php echo get_the_author_meta('description'); ?></p>
                <div class="author-actions">
                    <button onclick="alert('Follow functionality')">Follow</button>
                    <button onclick="window.location.href='mailto:<?php echo get_the_author_meta('user_email'); ?>'">Email</button>
                </div>
            </div>
        </div>

        <!-- Related Articles -->
        <section class="related-articles">
            <div class="section-heading">
                <h2>Related Articles</h2>
            </div>
            
            <div class="related-grid">
                <?php
                $categories = get_the_category();
                if ($categories) {
                    $category_ids = array();
                    foreach ($categories as $category) {
                        $category_ids[] = $category->term_id;
                    }
                    
                    $related_query = new WP_Query(array(
                        'category__in' => $category_ids,
                        'post__not_in' => array(get_the_ID()),
                        'posts_per_page' => 5,
                        'orderby' => 'rand'
                    ));
                    
                    if ($related_query->have_posts()) :
                        while ($related_query->have_posts()) : $related_query->the_post();
                ?>
                    <article class="related-item">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('medium', array('class' => 'related-image', 'alt' => get_the_title())); ?>
                            </a>
                        <?php endif; ?>
                        <div class="news-meta">
                            <time datetime="<?php echo get_the_date('c'); ?>">
                                <?php echo get_the_date('F j, Y'); ?>
                            </time>
                        </div>
                        <h4 class="news-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h4>
                    </article>
                <?php 
                        endwhile;
                    endif;
                    wp_reset_postdata();
                }
                ?>
            </div>
        </section>

        <?php
        if (comments_open() || get_comments_number()) :
            comments_template();
        endif;
        ?>
    </article>
<?php endwhile; ?>

<?php
get_footer();
?>
