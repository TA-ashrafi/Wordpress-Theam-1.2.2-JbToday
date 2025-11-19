<?php
/**
 * Page Template
 * 
 * @package Tahseen_Ashrafi_Theme
 */

get_header();
?>

<main class="main-content">
    <div class="content-area" style="width: 70%; margin: 40px auto;">
        <?php
        while (have_posts()) : the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="post-header">
                    <h1 class="post-title"><?php the_title(); ?></h1>
                </header>
                
                <?php if (has_post_thumbnail()) : ?>
                    <div class="post-featured-image">
                        <?php the_post_thumbnail('full'); ?>
                    </div>
                <?php endif; ?>
                
                <div class="post-content">
                    <?php the_content(); ?>
                </div>
                
                <?php
                // If comments are open or we have at least one comment
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
                ?>
            </article>
            <?php
        endwhile;
        ?>
    </div>
    
    <aside class="sidebar-area">
        <?php get_sidebar(); ?>
    </aside>
</main>

<?php get_footer(); ?>
