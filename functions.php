<?php
/**
 * Tahseen Ashrafi Theme Functions
 * 
 * @package Tahseen_Ashrafi_Theme
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme Setup
 */
function tahseen_ashrafi_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    add_theme_support('custom-logo');
    add_theme_support('responsive-embeds');
    add_theme_support('editor-styles');
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'tahseen-ashrafi-theme'),
        'footer' => __('Footer Menu', 'tahseen-ashrafi-theme'),
    ));
    
    // Set image sizes
    add_image_size('featured-large', 800, 500, true);
    add_image_size('featured-medium', 400, 300, true);
    add_image_size('featured-small', 120, 80, true);
    add_image_size('gallery-image', 300, 200, true);
}
add_action('after_setup_theme', 'tahseen_ashrafi_setup');

/**
 * Enqueue Scripts and Styles
 */
function tahseen_ashrafi_scripts() {
    // Enqueue main stylesheet
    wp_enqueue_style('tahseen-ashrafi-style', get_stylesheet_uri(), array(), '1.0');
    
    // Enqueue custom JavaScript
    wp_enqueue_script('tahseen-ashrafi-script', get_template_directory_uri() . '/js/main.js', array('jquery'), '1.0', true);
    
    // Enqueue comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'tahseen_ashrafi_scripts');

/**
 * Register Widget Areas
 */
function tahseen_ashrafi_widgets_init() {
    register_sidebar(array(
        'name'          => __('Sidebar', 'tahseen-ashrafi-theme'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here for the main sidebar.', 'tahseen-ashrafi-theme'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name'          => __('Footer Column 1', 'tahseen-ashrafi-theme'),
        'id'            => 'footer-1',
        'description'   => __('Add widgets for footer column 1.', 'tahseen-ashrafi-theme'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name'          => __('Footer Column 2', 'tahseen-ashrafi-theme'),
        'id'            => 'footer-2',
        'description'   => __('Add widgets for footer column 2.', 'tahseen-ashrafi-theme'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name'          => __('Footer Column 3', 'tahseen-ashrafi-theme'),
        'id'            => 'footer-3',
        'description'   => __('Add widgets for footer column 3.', 'tahseen-ashrafi-theme'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'tahseen_ashrafi_widgets_init');

/**
 * Custom Excerpt Length
 */
function tahseen_ashrafi_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'tahseen_ashrafi_excerpt_length');

/**
 * Custom Excerpt More
 */
function tahseen_ashrafi_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'tahseen_ashrafi_excerpt_more');

/**
 * Get Top News for Marquee
 */
function tahseen_ashrafi_get_top_news($limit = 10) {
    $args = array(
        'posts_per_page' => $limit,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    );
    
    return new WP_Query($args);
}

/**
 * Get Posts by Category
 */
function tahseen_ashrafi_get_category_posts($category_slug, $limit = 6) {
    $args = array(
        'posts_per_page' => $limit,
        'post_status'    => 'publish',
        'category_name'  => $category_slug,
        'orderby'        => 'date',
        'order'          => 'DESC',
    );
    
    return new WP_Query($args);
}

/**
 * Get Latest Posts
 */
function tahseen_ashrafi_get_latest_posts($limit = 5) {
    $args = array(
        'posts_per_page' => $limit,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    );
    
    return new WP_Query($args);
}

/**
 * Get Related Posts
 */
function tahseen_ashrafi_get_related_posts($post_id, $limit = 4) {
    $categories = wp_get_post_categories($post_id);
    
    if (empty($categories)) {
        return null;
    }
    
    $args = array(
        'posts_per_page' => $limit,
        'post_status'    => 'publish',
        'post__not_in'   => array($post_id),
        'category__in'   => $categories,
        'orderby'        => 'date',
        'order'          => 'DESC',
    );
    
    return new WP_Query($args);
}

/**
 * Custom Pagination
 */
function tahseen_ashrafi_pagination() {
    global $wp_query;
    
    $big = 999999999;
    
    echo '<div class="pagination">';
    echo paginate_links(array(
        'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format'    => '?paged=%#%',
        'current'   => max(1, get_query_var('paged')),
        'total'     => $wp_query->max_num_pages,
        'prev_text' => '&laquo; Previous',
        'next_text' => 'Next &raquo;',
    ));
    echo '</div>';
}

/**
 * Add async and defer attributes to scripts
 */
function tahseen_ashrafi_add_async_defer($tag, $handle) {
    if ('tahseen-ashrafi-script' !== $handle) {
        return $tag;
    }
    return str_replace(' src', ' defer src', $tag);
}
add_filter('script_loader_tag', 'tahseen_ashrafi_add_async_defer', 10, 2);

/**
 * Add SEO Meta Tags
 */
function tahseen_ashrafi_add_meta_tags() {
    if (is_single()) {
        global $post;
        $description = wp_trim_words(strip_tags($post->post_content), 30, '...');
        $keywords = '';
        $tags = get_the_tags();
        if ($tags) {
            foreach($tags as $tag) {
                $keywords .= $tag->name . ', ';
            }
            $keywords = rtrim($keywords, ', ');
        }
        
        echo '<meta name="description" content="' . esc_attr($description) . '">' . "\n";
        if ($keywords) {
            echo '<meta name="keywords" content="' . esc_attr($keywords) . '">' . "\n";
        }
        echo '<meta property="og:title" content="' . esc_attr(get_the_title()) . '">' . "\n";
        echo '<meta property="og:description" content="' . esc_attr($description) . '">' . "\n";
        echo '<meta property="og:type" content="article">' . "\n";
        echo '<meta property="og:url" content="' . esc_url(get_permalink()) . '">' . "\n";
        if (has_post_thumbnail()) {
            $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
            echo '<meta property="og:image" content="' . esc_url($thumbnail[0]) . '">' . "\n";
        }
    }
}
add_action('wp_head', 'tahseen_ashrafi_add_meta_tags');

/**
 * Add Structured Data for Articles
 */
function tahseen_ashrafi_add_structured_data() {
    if (is_single()) {
        global $post;
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'NewsArticle',
            'headline' => get_the_title(),
            'description' => wp_trim_words(strip_tags($post->post_content), 30, '...'),
            'datePublished' => get_the_date('c'),
            'dateModified' => get_the_modified_date('c'),
            'author' => array(
                '@type' => 'Person',
                'name' => get_the_author()
            ),
            'publisher' => array(
                '@type' => 'Organization',
                'name' => get_bloginfo('name'),
                'logo' => array(
                    '@type' => 'ImageObject',
                    'url' => get_template_directory_uri() . '/images/logo.png'
                )
            )
        );
        
        if (has_post_thumbnail()) {
            $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
            $schema['image'] = $thumbnail[0];
        }
        
        echo '<script type="application/ld+json">' . json_encode($schema) . '</script>';
    }
}
add_action('wp_head', 'tahseen_ashrafi_add_structured_data');

/**
 * Format Post Date
 */
function tahseen_ashrafi_format_date($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    return get_the_date('F j, Y, g:i a', $post_id);
}

/**
 * Get Post Author with Avatar
 */
function tahseen_ashrafi_author_info() {
    $author_id = get_the_author_meta('ID');
    $author_name = get_the_author();
    $author_avatar = get_avatar_url($author_id, array('size' => 100));
    $author_bio = get_the_author_meta('description');
    
    return array(
        'id' => $author_id,
        'name' => $author_name,
        'avatar' => $author_avatar,
        'bio' => $author_bio,
    );
}

/**
 * Sanitize form inputs
 */
function tahseen_ashrafi_sanitize_input($input) {
    return sanitize_text_field(trim($input));
}

/**
 * View count for posts
 */
function tahseen_ashrafi_set_post_views($post_id) {
    $count_key = 'post_views_count';
    $count = get_post_meta($post_id, $count_key, true);
    if ($count == '') {
        $count = 0;
        delete_post_meta($post_id, $count_key);
        add_post_meta($post_id, $count_key, '0');
    } else {
        $count++;
        update_post_meta($post_id, $count_key, $count);
    }
}

function tahseen_ashrafi_get_post_views($post_id) {
    $count_key = 'post_views_count';
    $count = get_post_meta($post_id, $count_key, true);
    if ($count == '') {
        delete_post_meta($post_id, $count_key);
        add_post_meta($post_id, $count_key, '0');
        return "0 View";
    }
    return $count . ' Views';
}

/**
 * Optimize images
 */
function tahseen_ashrafi_optimize_images() {
    add_filter('jpeg_quality', function() { return 85; });
    add_filter('wp_editor_set_quality', function() { return 85; });
}
add_action('init', 'tahseen_ashrafi_optimize_images');

/**
 * Remove version strings from scripts and styles
 */
function tahseen_ashrafi_remove_version_strings($src) {
    if (strpos($src, 'ver=')) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('style_loader_src', 'tahseen_ashrafi_remove_version_strings', 10, 1);
add_filter('script_loader_src', 'tahseen_ashrafi_remove_version_strings', 10, 1);

/**
 * Disable emoji scripts
 */
function tahseen_ashrafi_disable_emojis() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
}
add_action('init', 'tahseen_ashrafi_disable_emojis');
