<?php
/**
 * Comments Template
 * 
 * @package Tahseen_Ashrafi_Theme
 */

if (post_password_required()) {
    return;
}
?>

<div class="comments-area">
    <?php if (have_comments()) : ?>
        <h3 class="comments-title">
            <?php
            $comment_count = get_comments_number();
            if ('1' === $comment_count) {
                printf(
                    __('One comment on &ldquo;%s&rdquo;', 'tahseen-ashrafi-theme'),
                    get_the_title()
                );
            } else {
                printf(
                    __('%1$s comments on &ldquo;%2$s&rdquo;', 'tahseen-ashrafi-theme'),
                    number_format_i18n($comment_count),
                    get_the_title()
                );
            }
            ?>
        </h3>
        
        <ol class="comment-list">
            <?php
            wp_list_comments(array(
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 50,
                'callback'    => 'tahseen_ashrafi_comment_callback',
            ));
            ?>
        </ol>
        
        <?php
        if (get_comment_pages_count() > 1 && get_option('page_comments')) :
            ?>
            <nav class="comment-navigation">
                <div class="nav-previous">
                    <?php previous_comments_link(__('&larr; Older Comments', 'tahseen-ashrafi-theme')); ?>
                </div>
                <div class="nav-next">
                    <?php next_comments_link(__('Newer Comments &rarr;', 'tahseen-ashrafi-theme')); ?>
                </div>
            </nav>
            <?php
        endif;
        ?>
        
    <?php endif; ?>
    
    <?php if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
        <p class="no-comments"><?php _e('Comments are closed.', 'tahseen-ashrafi-theme'); ?></p>
    <?php endif; ?>
    
    <?php
    comment_form(array(
        'title_reply'          => __('Leave a Comment', 'tahseen-ashrafi-theme'),
        'title_reply_to'       => __('Leave a Reply to %s', 'tahseen-ashrafi-theme'),
        'cancel_reply_link'    => __('Cancel Reply', 'tahseen-ashrafi-theme'),
        'label_submit'         => __('Post Comment', 'tahseen-ashrafi-theme'),
        'comment_field'        => '<p class="comment-form-comment"><label for="comment">' 
                                  . __('Comment', 'tahseen-ashrafi-theme') 
                                  . ' <span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" required></textarea></p>',
        'fields'               => array(
            'author' => '<p class="comment-form-author"><label for="author">' 
                        . __('Name', 'tahseen-ashrafi-theme') 
                        . ' <span class="required">*</span></label><input id="author" name="author" type="text" value="' 
                        . esc_attr($commenter['comment_author']) 
                        . '" size="30" maxlength="245" required /></p>',
            'email'  => '<p class="comment-form-email"><label for="email">' 
                        . __('Email', 'tahseen-ashrafi-theme') 
                        . ' <span class="required">*</span></label><input id="email" name="email" type="email" value="' 
                        . esc_attr($commenter['comment_author_email']) 
                        . '" size="30" maxlength="100" aria-describedby="email-notes" required /></p>',
            'url'    => '<p class="comment-form-url"><label for="url">' 
                        . __('Website', 'tahseen-ashrafi-theme') 
                        . '</label><input id="url" name="url" type="url" value="' 
                        . esc_attr($commenter['comment_author_url']) 
                        . '" size="30" maxlength="200" /></p>',
        ),
        'class_submit'         => 'more-button',
    ));
    ?>
</div>

<?php
/**
 * Custom Comment Callback
 */
function tahseen_ashrafi_comment_callback($comment, $args, $depth) {
    $tag = ('div' === $args['style']) ? 'div' : 'li';
    ?>
    <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class(empty($args['has_children']) ? '' : 'parent'); ?>>
        <article id="div-comment-<?php comment_ID(); ?>" class="comment">
            <div class="comment-meta">
                <div class="comment-author vcard">
                    <?php echo get_avatar($comment, 50, '', '', array('class' => 'comment-author-avatar')); ?>
                    <div>
                        <b class="fn"><?php echo get_comment_author_link($comment); ?></b>
                        <time datetime="<?php comment_time('c'); ?>">
                            <?php printf(__('%1$s at %2$s', 'tahseen-ashrafi-theme'), get_comment_date('', $comment), get_comment_time()); ?>
                        </time>
                    </div>
                </div>
            </div>
            
            <div class="comment-content">
                <?php comment_text(); ?>
            </div>
            
            <div class="reply">
                <?php
                comment_reply_link(array_merge($args, array(
                    'add_below' => 'div-comment',
                    'depth'     => $depth,
                    'max_depth' => $args['max_depth'],
                    'before'    => '<span class="reply-link">',
                    'after'     => '</span>',
                )));
                ?>
            </div>
        </article>
    <?php
}
?>
