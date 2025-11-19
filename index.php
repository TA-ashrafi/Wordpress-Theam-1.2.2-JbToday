<?php
/**
 * Main Index Template
 * 
 * @package Tahseen_Ashrafi_Theme
 */

get_header();
?>

<main class="main-content">
    <div class="content-area">
        <!-- Other Top Stories Section -->
        <div class="section-heading">
            <h2>Other Top Stories</h2>
        </div>
        
        <div class="news-grid">
            <!-- Center Column: World & Sports Featured -->
            <div class="news-column-center">
                <?php
                $world_query = new WP_Query(array(
                    'category_name' => 'world',
                    'posts_per_page' => 1
                ));
                
                if ($world_query->have_posts()) : $world_query->the_post();
                ?>
                    <article class="featured-news">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('large', array('class' => 'featured-image', 'alt' => get_the_title())); ?>
                        <?php endif; ?>
                        <div class="news-meta">
                            <span class="category-name">World</span>
                            <time datetime="<?php echo get_the_date('c'); ?>">
                                <?php echo get_the_date('F j, Y, g:i a'); ?>
                            </time>
                        </div>
                        <h3 class="featured-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                    </article>
                <?php 
                endif;
                wp_reset_postdata();
                ?>

                <div class="news-separator"></div>

                <?php
                $sports_query = new WP_Query(array(
                    'category_name' => 'sports',
                    'posts_per_page' => 2
                ));
                
                if ($sports_query->have_posts()) :
                ?>
                    <div class="news-row">
                        <?php while ($sports_query->have_posts()) : $sports_query->the_post(); ?>
                            <article class="medium-news">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('medium', array('class' => 'medium-image', 'alt' => get_the_title())); ?>
                                <?php endif; ?>
                                <div class="news-meta">
                                    <span class="category-name">Sports</span>
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
                ?>

                <div class="news-separator"></div>

                <?php
                $lifestyle_education_query = new WP_Query(array(
                    'category_name' => 'lifestyle,education',
                    'posts_per_page' => 2
                ));
                
                if ($lifestyle_education_query->have_posts()) :
                ?>
                    <div class="news-row">
                        <?php while ($lifestyle_education_query->have_posts()) : $lifestyle_education_query->the_post(); ?>
                            <article class="medium-news">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('medium', array('class' => 'medium-image', 'alt' => get_the_title())); ?>
                                <?php endif; ?>
                                <div class="news-meta">
                                    <?php
                                    $categories = get_the_category();
                                    if (!empty($categories)) {
                                        echo '<span class="category-name">' . esc_html($categories[0]->name) . '</span>';
                                    }
                                    ?>
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
                ?>
            </div>
        </div>
    </div>

    <?php get_sidebar(); ?>
</main>

<!-- Three Column Section: Technology, Health, Politics -->
<section class="secondary-section">
    <div class="three-column-grid">
        <?php 
        $featured_categories = array('Technology', 'Health', 'Politics');
        foreach ($featured_categories as $category) :
            $cat_query = new WP_Query(array(
                'category_name' => strtolower($category),
                'posts_per_page' => 4
            ));
            
            if ($cat_query->have_posts()) :
        ?>
            <div class="category-column">
                <h3 class="category-title"><?php echo esc_html($category); ?></h3>
                <?php 
                $item_count = 0;
                while ($cat_query->have_posts()) : $cat_query->the_post(); 
                    $item_count++;
                ?>
                    <article class="news-item">
                        <div class="news-item-content">
                            <div class="news-meta">
                                <time datetime="<?php echo get_the_date('c'); ?>">
                                    <?php echo get_the_date('F j, Y, g:i a'); ?>
                                </time>
                            </div>
                            <h4 class="news-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h4>
                        </div>
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('thumbnail', array('class' => 'small-image', 'alt' => get_the_title())); ?>
                            </a>
                        <?php endif; ?>
                    </article>
                    <?php if ($item_count < 4) : ?>
                        <div class="news-item-separator"></div>
                    <?php endif; ?>
                <?php endwhile; ?>
            </div>
        <?php 
            endif;
            wp_reset_postdata();
        endforeach;
        ?>
    </div>
</section>

<!-- Photo Gallery Section -->
<section class="gallery-section">
    <div class="section-heading">
        <h2>Photo Gallery</h2>
    </div>
    
    <div class="gallery-grid">
        <?php
        $gallery_query = new WP_Query(array(
            'posts_per_page' => 5,
            'meta_query' => array(
                array(
                    'key' => '_thumbnail_id',
                    'compare' => 'EXISTS'
                )
            )
        ));
        
        if ($gallery_query->have_posts()) :
            while ($gallery_query->have_posts()) : $gallery_query->the_post();
        ?>
            <div class="gallery-item">
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail('medium', array('class' => 'gallery-image', 'alt' => get_the_title())); ?>
                    <p class="gallery-caption"><?php the_title(); ?></p>
                </a>
            </div>
        <?php 
            endwhile;
        endif;
        wp_reset_postdata();
        ?>
    </div>
    <div class="text-center">
        <a href="<?php echo esc_url(home_url('/gallery')); ?>" class="more-button">More</a>
    </div>
</section>

<!-- Second Three Column Section: Business, National, Sports -->
<section class="secondary-section">
    <div class="section-heading">
        <h2>More News</h2>
    </div>
    
    <div class="three-column-grid">
        <?php 
        $more_categories = array('Business', 'National', 'Sports');
        foreach ($more_categories as $category) :
            $cat_query = new WP_Query(array(
                'category_name' => strtolower($category),
                'posts_per_page' => 5
            ));
            
            if ($cat_query->have_posts()) :
        ?>
            <div class="category-column">
                <h3 class="category-title"><?php echo esc_html($category); ?></h3>
                <?php 
                $item_count = 0;
                while ($cat_query->have_posts()) : $cat_query->the_post(); 
                    $item_count++;
                ?>
                    <article class="news-item">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('thumbnail', array('class' => 'small-image', 'alt' => get_the_title())); ?>
                            </a>
                        <?php endif; ?>
                        <div class="news-item-content">
                            <div class="news-meta">
                                <time datetime="<?php echo get_the_date('c'); ?>">
                                    <?php echo get_the_date('F j, Y, g:i a'); ?>
                                </time>
                            </div>
                            <h4 class="news-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h4>
                        </div>
                    </article>
                    <?php if ($item_count < 5) : ?>
                        <div class="news-item-separator"></div>
                    <?php endif; ?>
                <?php endwhile; ?>
                <a href="<?php echo esc_url(get_category_link(get_cat_ID($category))); ?>" class="more-button">More</a>
            </div>
        <?php 
            endif;
            wp_reset_postdata();
        endforeach;
        ?>
    </div>
</section>

<!-- World Section -->
<section class="world-section">
    <div class="section-heading">
        <h2>World News</h2>
    </div>
    
    <div class="world-grid">
        <?php
        $world_section_query = new WP_Query(array(
            'category_name' => 'world',
            'posts_per_page' => 3
        ));
        
        if ($world_section_query->have_posts()) :
            while ($world_section_query->have_posts()) : $world_section_query->the_post();
        ?>
            <article class="world-news-item">
                <?php if (has_post_thumbnail()) : ?>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('large', array('class' => 'world-image', 'alt' => get_the_title())); ?>
                    </a>
                <?php endif; ?>
                <div class="news-meta">
                    <time datetime="<?php echo get_the_date('c'); ?>">
                        <?php echo get_the_date('F j, Y, g:i a'); ?>
                    </time>
                </div>
                <h3 class="news-title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h3>
                <div class="news-excerpt">
                    <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                </div>
                <a href="<?php the_permalink(); ?>" class="read-button">Read</a>
            </article>
        <?php 
            endwhile;
        endif;
        wp_reset_postdata();
        ?>
    </div>
</section>

<?php
get_footer();
?>
