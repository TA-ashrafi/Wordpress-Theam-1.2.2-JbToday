<footer class="site-footer">
    <div class="container">
        <div class="footer-content">
            <!-- Footer Column 1 - Quick Links -->
            <div class="footer-section">
                <h3><?php _e('Quick Links', 'tahseen-ashrafi-theme'); ?></h3>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer',
                    'menu_class'     => 'footer-menu',
                    'container'      => false,
                    'fallback_cb'    => function() {
                        echo '<ul>';
                        echo '<li><a href="#">Contact Us</a></li>';
                        echo '<li><a href="#">About Us</a></li>';
                        echo '<li><a href="#">Privacy Policy</a></li>';
                        echo '<li><a href="#">Terms & Conditions</a></li>';
                        echo '</ul>';
                    },
                ));
                ?>
            </div>
            
            <!-- Footer Column 2 - Editor's Picks -->
            <div class="footer-section">
                <h3><?php _e("Editor's Picks", 'tahseen-ashrafi-theme'); ?></h3>
                <ul>
                    <?php
                    $editors_picks = tahseen_ashrafi_get_latest_posts(5);
                    if ($editors_picks->have_posts()) :
                        while ($editors_picks->have_posts()) : $editors_picks->the_post();
                            ?>
                            <li>
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </li>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </ul>
            </div>
            
            <!-- Footer Column 3 - Widget Area -->
            <div class="footer-section">
                <?php if (is_active_sidebar('footer-3')) : ?>
                    <?php dynamic_sidebar('footer-3'); ?>
                <?php else : ?>
                    <h3><?php _e('About', 'tahseen-ashrafi-theme'); ?></h3>
                    <p><?php bloginfo('description'); ?></p>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="footer-logo">
                <?php
                if (has_custom_logo()) {
                    the_custom_logo();
                } else {
                    echo 'NEWSISLAND';
                }
                ?>
            </div>
            
            <div class="copyright">
                <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. 
                <?php _e('All rights reserved.', 'tahseen-ashrafi-theme'); ?>
                <?php _e('Designed by Tahseen Ashrafi', 'tahseen-ashrafi-theme'); ?></p>
            </div>
            
            <div class="social-icons">
                <a href="https://facebook.com" target="_blank" rel="noopener" aria-label="Facebook">
                    <span>f</span>
                </a>
                <a href="https://twitter.com" target="_blank" rel="noopener" aria-label="Twitter">
                    <span>𝕏</span>
                </a>
                <a href="https://instagram.com" target="_blank" rel="noopener" aria-label="Instagram">
                    <span>📷</span>
                </a>
                <a href="https://youtube.com" target="_blank" rel="noopener" aria-label="YouTube">
                    <span>▶</span>
                </a>
            </div>
        </div>
    </div>
</footer>


<?php wp_footer(); ?>

<script>
// Copyright Button Functionality
document.addEventListener('copy', function(e) {
    const copyrightEnabled = localStorage.getItem('copyrightEnabled');
    if (copyrightEnabled === 'true') {
        const selection = window.getSelection();
        const copiedText = selection.toString();
        if (copiedText.length > 0) {
            e.clipboardData.setData('text/plain', copiedText + '\n\nImage by Tahseen Ashrafi');
            e.preventDefault();
        }
    }
});

// Lazy Loading for Images
document.addEventListener('DOMContentLoaded', function() {
    const images = document.querySelectorAll('img[data-src]');
    
    const imageObserver = new IntersectionObserver(function(entries, observer) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
                imageObserver.unobserve(img);
            }
        });
    });
    
    images.forEach(function(img) {
        imageObserver.observe(img);
    });
});

// Form Validation
const forms = document.querySelectorAll('form');
forms.forEach(function(form) {
    form.addEventListener('submit', function(e) {
        const inputs = form.querySelectorAll('input[required], textarea[required]');
        let isValid = true;
        
        inputs.forEach(function(input) {
            if (!input.value.trim()) {
                isValid = false;
                input.style.borderColor = 'red';
            } else {
                input.style.borderColor = '';
            }
            
            // Email validation
            if (input.type === 'email' && input.value) {
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(input.value)) {
                    isValid = false;
                    input.style.borderColor = 'red';
                }
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Please fill in all required fields correctly.');
        }
    });
});
</script>

</body>
</html>
