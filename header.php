<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header" id="masthead">
    <!-- Top Bar with Breaking News -->
    <div class="header-top">
        <div class="header-top-inner">
            <div class="breaking-news">
                <span class="breaking-label">Breaking News</span>
                <div class="breaking-text">
                    <?php
                    $breaking_news = get_posts(array(
                        'posts_per_page' => 1,
                        'orderby' => 'date',
                        'order' => 'DESC'
                    ));
                    if ($breaking_news) {
                        foreach ($breaking_news as $post) {
                            setup_postdata($post);
                            echo '<a href="' . get_permalink() . '" style="color: white;">' . get_the_title() . '</a>';
                        }
                        wp_reset_postdata();
                    }
                    ?>
                </div>
            </div>
            <div class="header-date">
                <?php echo date_i18n('l, F j, Y'); ?>
            </div>
        </div>
    </div>

    <!-- Middle Header with Logo, Ad Space, and Search -->
    <div class="header-middle">
        <div class="header-middle-inner">
            <div class="site-branding">
                <?php if (has_custom_logo()) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
                        <?php bloginfo('name'); ?>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Header Ad Space (728x90) -->
            <div class="header-ad-space">
                <?php if (is_active_sidebar('header-ad')) : ?>
                    <?php dynamic_sidebar('header-ad'); ?>
                <?php else : ?>
                    <!-- AdSense code here (728x90 Leaderboard) -->
                    Advertisement Space 728x90
                <?php endif; ?>
            </div>

            <div class="header-search">
                <?php get_search_form(); ?>
            </div>
        </div>
    </div>

    <!-- Bottom Header with Navigation -->
    <div class="header-bottom">
        <nav class="main-navigation">
            <button class="menu-toggle" aria-label="Toggle Menu">☰</button>
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_class'     => 'primary-menu',
                'container'      => false,
                'fallback_cb'    => 'newweb_default_menu',
            ));
            ?>
        </nav>
    </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mobile Menu Toggle
    const menuToggle = document.querySelector('.menu-toggle');
    const primaryMenu = document.querySelector('.primary-menu');
    
    if (menuToggle && primaryMenu) {
        menuToggle.addEventListener('click', function() {
            primaryMenu.classList.toggle('active');
        });
    }

    // Header Show/Hide on Scroll
    let lastScrollTop = 0;
    const header = document.getElementById('masthead');
    const scrollThreshold = 200;
    
    window.addEventListener('scroll', function() {
        let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        if (scrollTop > scrollThreshold) {
            if (scrollTop > lastScrollTop) {
                // Scrolling down
                header.classList.add('header-hidden');
            } else {
                // Scrolling up
                header.classList.remove('header-hidden');
            }
        } else {
            header.classList.remove('header-hidden');
        }
        
        lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
    });

    // Back to Top Button
    const backToTop = document.createElement('button');
    backToTop.className = 'back-to-top';
    backToTop.innerHTML = '↑';
    backToTop.setAttribute('aria-label', 'Back to top');
    document.body.appendChild(backToTop);
    
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            backToTop.classList.add('show');
        } else {
            backToTop.classList.remove('show');
        }
    });
    
    backToTop.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
});
</script>
