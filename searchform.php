<?php
/**
 * Search Form Template
 * 
 * @package Tahseen_Ashrafi_Theme
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <label>
        <span class="screen-reader-text"><?php _e('Search for:', 'tahseen-ashrafi-theme'); ?></span>
        <input type="search" 
               class="search-field" 
               placeholder="<?php esc_attr_e('Search news...', 'tahseen-ashrafi-theme'); ?>" 
               value="<?php echo get_search_query(); ?>" 
               name="s" 
               required 
               maxlength="200" />
    </label>
    <button type="submit" class="search-submit">
        <?php _e('Search', 'tahseen-ashrafi-theme'); ?>
    </button>
</form>
