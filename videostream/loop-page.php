<?php
global $wpdb;
$pageID = $wpdb->get_var("select ID from " . $wpdb->prefix . "posts WHERE post_content='[video]' and post_status='publish' and post_type='page' limit 1");
$morePageID = $wpdb->get_var("select ID from " . $wpdb->prefix . "posts WHERE post_content='[videomore]' and post_status='publish' and post_type='page' limit 1");
$homePageID = $wpdb->get_var("select ID from " . $wpdb->prefix . "posts WHERE post_content='[videohome]' and post_status='publish' and post_type='page' limit 1");
?>
<?php if (have_posts ())
    while (have_posts ()) : the_post(); ?>
        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php
        $content = get_the_content();
        $classPlayer = (preg_match('/\[videohome\]/', $content) || preg_match('/\[videomore\]/', $content) || preg_match('/\[video\]/', $content)) ? '' : 'video-cat-thumb';
    ?>
        <div class="entry-content">       
        <div class="<?php echo $classPlayer; ?>">
            <?php
            if (!empty($classPlayer))
                echo '<h3 class="entry-title">' . get_the_title() . '</h3>';
            ?>
            <?php the_content(); ?></div>
        <?php wp_link_pages(array('before' => '<div class="page-link">' . __('Pages:', 'videostream'), 'after' => '</div>')); ?>
        
        </div><!-- .entry-content -->
    </div><!-- #post-## -->
<?php endwhile; // end of the loop. ?>