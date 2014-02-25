<?php
$themeName = "Theme";
$shortName = "wpc";
$templateURL = get_template_directory_uri();
//Add the Theme Settings Field

$options = array(
    array("name" => "Logo",
        "type" => "title"),
    array("type" => "open"),
    array("name" => "Image Url:",
        "desc" => "Enter your logo image url  Ex: http://www.apptha.com/demo/template/videostream/wp-content/uploads/2012/01/logo.png",
        "id" => $shortName . "_logo_url",
        "std" => "",
        "type" => "text"),
    array("type" => "close"),

    array("name" => "Social Links",
        "type" => "title"),
    array("type" => "open"),  
    array("name" => "Facebook",
        "desc" => "Enter your facebook connect link  Ex: http://www.facebook.com/apptha",
        "id" => $shortName . "_facebook_url",
        "std" => "",
        "type" => "text"),
    array("name" => "Twitter",
        "desc" => "Enter your twitter link  Ex: http://www.twitter.com/contus",
        "id" => $shortName . "_twitter_url",
        "std" => "",
        "type" => "text"),
    array("name" => "Linkedin",
        "desc" => "Enter your linkedin link  Ex: http://www.linkedin.com/company/contus-support",
        "id" => $shortName . "_linkedin_url",
        "std" => "",
        "type" => "text"),
    array("type" => "close"),
    array("name" => "Comments",
        "type" => "title"),
    array("type" => "open"),
    array("name" => "Comment Option:",
        "desc" => "Choose the comment option",
        "id" => $shortName . "_comment_option",
        "std" => "",
        "type" => "radio"),
    array("type" => "close"),
    array("name" => "Facebook API Settings",
        "type" => "title"),
    array("type" => "open"),
    array("name" => "App ID:",
        "desc" => "<a href=\"https://developers.facebook.com/apps\" target=\"_blank\">Link to create App ID</a>",
        "id" => $shortName . "_fb_apikey",
        "std" => "",
        "type" => "text"),
    array("type" => "close"),   
    array("type" => "close"),
);

function mytheme_add_admin() {
    global $themeName, $shortName, $options;
    if ($_GET['page'] == basename(__FILE__)) {
        if ('save' == $_REQUEST['action']) {
            foreach ($options as $value) {
                update_option($value['id'], $_REQUEST[$value['id']]);
            }
            foreach ($options as $value) {
                if (isset($_REQUEST[$value['id']])) {
                    update_option($value['id'], $_REQUEST[$value['id']]);
                } else {
                    delete_option($value['id']);
                }
            }
            header("Location: themes.php?page=functions.php&saved=true");
            die;
        } else if ('reset' == $_REQUEST['action']) {
            foreach ($options as $value) {
                delete_option($value['id']);
            }
            header("Location: themes.php?page=functions.php&reset=true");
            die;
        }
    }
    add_theme_page($themeName . " Options", "" . $themeName . " Options", 'edit_themes', basename(__FILE__), 'mytheme_admin');
}

function mytheme_admin() {
    global $themeName, $shortName, $options;
    if ($_REQUEST['saved'])
        echo '<div id="message" class="updated fade"><p><strong>' . $themeName . ' settings saved.</strong></p></div>';
    if ($_REQUEST['reset'])
        echo '<div id="message" class="updated fade"><p><strong>' . $themeName . ' settings reset.</strong></p></div>';
?>
    <div class="wrap">
        <h2><?php echo $themeName; ?> settings</h2>
        <form method="post">
        <?php
        foreach ($options as $value) {
            switch ($value['type']) {
                case "open":
        ?>
                    <table width="100%" border="0" style="background-color:#f0f0f0; padding:10px;">
            <?php
                    break;
                case "close":
            ?>
                </table>
        <?php
                    break;
                case "title":
        ?>
                    <table width="100%" border="0" style="background-color:#ddd9cc; padding:0px 10px;"><tr>
                            <td colspan="2"><h3 style="font-size:13px;margin:5px 0px" ><?php echo $value['name']; ?></h3></td>
                        </tr><?php
                    break;
                case 'text':
        ?>
                    <tr>
                        <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
                        <td width="80%"><input style="width:400px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php
                    if (get_settings($value['id']) != "") {
                        echo stripslashes(get_settings($value['id']));
                    } else {
                        echo $value['std'];
                    }
        ?>" /></td>
            </tr>
            <tr>
                <td><small><?php echo $value['desc']; ?></small></td>
            </tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>
            <?php
                                       break;
                                   case 'textarea':
            ?>
                                       <tr>
                                           <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
                                           <td width="80%"><textarea name="<?php echo $value['id']; ?>" style="width:400px; height:200px;" type="<?php echo $value['type']; ?>" cols="" rows=""><?php
                                       if (get_settings($value['id']) != "") {
                                           echo stripslashes(get_settings($value['id']));
                                       } else {
                                           echo $value['std'];
                                       }
            ?></textarea></td>
                           </tr>
                           <tr>
                               <td><small><?php echo $value['desc']; ?></small></td>
                           </tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>
            <?php
                                       break;
                                   case 'radio':
            ?>
                                       <tr>
                                           <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
                                           <td width="80%">
                                               <input type="<?php echo $value['type']; ?>" name="<?php echo $value['id']; ?>"  <?php
                                       if (get_settings($value['id']) == '0') {
                                           echo "checked=checked";
                                       }
            ?> value="0" />
                                <label> Facebook</label>&nbsp;
                                <input type="<?php echo $value['type']; ?>" name="<?php echo $value['id']; ?>" <?php
                                       if (get_settings($value['id']) == '1') {
                                           echo "checked=checked";
                                       }
            ?> value="1" /><label> Default</label>
                            </td>
                        </tr>
            <?php
                                       break;
                                   case "title":
            ?>
                                       <tr>
                                           <td colspan="2"><h3 style="font-size:13px;margin:5px 0px" ><?php echo $value['name']; ?></h3></td>
                                       </tr>
            <?php
                                       break;
                                   case 'text':
            ?>
                                       <tr>
                                           <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
                                           <td width="80%"><input style="width:400px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php
                                       if (get_settings($value['id']) != "") {
                                           echo stripslashes(get_settings($value['id']));
                                       } else {
                                           echo $value['std'];
                                       }
            ?>" /></td>
            </tr>
            <?php
                                       break;
                               }
                           }
            ?>
                           <!--</table>-->
                           <p class="submit">
                               <input name="save" type="submit" value="Save changes" />
                               <input type="hidden" name="action" value="save" />
                           </p>
                   </form>
                   <form method="post">
                       <p class="submit">
                           <input name="reset" type="submit" value="Reset" />
                           <input type="hidden" name="action" value="reset" />
                       </p>
                   </form>
    <?php
                       }

                       add_action('admin_menu', 'mytheme_add_admin');



                       if (!isset($content_width))
                           $content_width = 640;

                       /** Tell WordPress to run videostream_setup() when the 'after_setup_theme' hook is run. */
                       add_action('after_setup_theme', 'videostream_setup');

                       if (!function_exists('videostream_setup')):

                           function videostream_setup() {

                               // This theme styles the visual editor with editor-style.css to match the theme style.
                               add_editor_style();

                               // Post Format support. You can also use the legacy "gallery" or "asides" (note the plural) categories.
                               add_theme_support('post-formats', array('aside', 'gallery'));

                               // This theme uses post thumbnails
                               add_theme_support('post-thumbnails');

                               // Add default posts and comments RSS feed links to head
                               add_theme_support('automatic-feed-links');

                               // Make theme available for translation
                               // Translations can be filed in the /languages/ directory
                               load_theme_textdomain('videostream', TEMPLATEPATH . '/languages');

                               $locale = get_locale();
                               $locale_file = TEMPLATEPATH . "/languages/$locale.php";
                               if (is_readable($locale_file))
                                   require_once( $locale_file );

                               // This theme uses wp_nav_menu() in one location.
                               register_nav_menus(array(
                                   'primary' => __('Primary Navigation', 'videostream'),
                               ));
							    
                               // This theme allows users to set a custom background
                            //   add_custom_background();

                               // Your changeable header business starts here
                               if (!defined('HEADER_TEXTCOLOR'))
                                   define('HEADER_TEXTCOLOR', '');

                               // No CSS, just IMG call. The %s is a placeholder for the theme template directory URI.
                               if (!defined('HEADER_IMAGE'))
                                   define('HEADER_IMAGE', '%s/images/headers/path.jpg');

                               // The height and width of your custom header. You can hook into the theme's own filters to change these values.
                               // Add a filter to videostream_header_image_width and videostream_header_image_height to change these values.
                               define('HEADER_IMAGE_WIDTH', apply_filters('videostream_header_image_width', 960));
                               define('HEADER_IMAGE_HEIGHT', apply_filters('videostream_header_image_height', 352));

                               // We'll be using post thumbnails for custom header images on posts and pages.
                               // We want them to be 940 pixels wide by 198 pixels tall.
                               // Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
                               set_post_thumbnail_size(HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true);

                               // Don't support text inside the header image.
                               if (!defined('NO_HEADER_TEXT'))
                                   define('NO_HEADER_TEXT', true);

                               // Add a way for the custom header to be styled in the admin panel that controls
                               // custom headers. See videostream_admin_header_style(), below.
                               

                               // ... and thus ends the changeable header business.
                               // Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
                               register_default_headers(array(
                                   'berries' => array(
                                       'url' => '%s/images/headers/berries.jpg',
                                       'thumbnail_url' => '%s/images/headers/berries-thumbnail.jpg',
                                       /* translators: header image description */
                                       'description' => __('Berries', 'videostream')
                                   ),
                                   
                               ));
                           }

                       endif;

                       if (!function_exists('videostream_admin_header_style')) :

                           function videostream_admin_header_style() {
    ?>
                               <style type="text/css">
                                   /* Shows the same border as on front end */
                                   #headimg {
                                       border-bottom: 1px solid #000;
                                       border-top: 4px solid #000;
                                   }
                                   /* If NO_HEADER_TEXT is false, you would style the text with these selectors:
                                                                                 	#headimg #name { }
                                                                                 	#headimg #desc { }
                                   */
                               </style>
    <?php
                           }

                       endif;

                      
                       function videostream_page_menu_args($args) {
                           $args['show_home'] = true;
                           return $args;
                       }

                       add_filter('wp_page_menu_args', 'videostream_page_menu_args');

                      
                       function videostream_excerpt_length($length) {
                           return 40;
                       }

                       add_filter('excerpt_length', 'videostream_excerpt_length');

                       function videostream_continue_reading_link() {
                           return ' <a href="' . get_permalink() . '">' . __('Continue reading <span class="meta-nav">&rarr;</span>', 'videostream') . '</a>';
                       }

                    
                       function videostream_auto_excerpt_more($more) {
                           return ' &hellip;' . videostream_continue_reading_link();
                       }

                       add_filter('excerpt_more', 'videostream_auto_excerpt_more');

                  
                       function videostream_custom_excerpt_more($output) {
                           if (has_excerpt() && !is_attachment()) {
                               $output .= videostream_continue_reading_link();
                           }
                           return $output;
                       }

                       add_filter('get_the_excerpt', 'videostream_custom_excerpt_more');

                    
                       add_filter('use_default_gallery_style', '__return_false');

                       
                       function videostream_remove_gallery_css($css) {
                           return preg_replace("#<style type='text/css'>(.*?)</style>#s", '', $css);
                       }

// Backwards compatibility with WordPress 3.0.
                       if (version_compare($GLOBALS['wp_version'], '3.1', '<'))
                           add_filter('gallery_style', 'videostream_remove_gallery_css');

                       if (!function_exists('videostream_comment')) :

                          
                           function videostream_comment($comment, $args, $depth) {
                               $GLOBALS['comment'] = $comment;
                               switch ($comment->comment_type) :
                                   case '' :
    ?>
                                       <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
                                           <div id="comment-<?php comment_ID(); ?>">
                                               <div class="comment-author vcard">
                <?php echo get_avatar($comment, 40); ?>
                <?php printf(__('%s <span class="says">says:</span>', 'videostream'), sprintf('<cite class="fn">%s</cite>', get_comment_author_link())); ?>
                                   </div><!-- .comment-author .vcard -->
            <?php if ($comment->comment_approved == '0') : ?>
                                           <em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', 'videostream'); ?></em>
                                           <br />
            <?php endif; ?>

                                           <div class="comment-meta commentmetadata"><a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
                    <?php
                                           /* translators: 1: date, 2: time */
                                           printf(__('%1$s at %2$s', 'videostream'), get_comment_date(), get_comment_time());
                    ?></a><?php edit_comment_link(__('(Edit)', 'videostream'), ' '); ?>
                                   </div><!-- .comment-meta .commentmetadata -->

                                   <div class="comment-body"><?php comment_text(); ?></div>

                                   <div class="reply">
                <?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
                                       </div><!-- .reply -->
                                   </div><!-- #comment-##  -->

        <?php
                                           break;
                                       case 'pingback' :
                                       case 'trackback' :
        ?>
                                       <li class="post pingback">
                                           <p><?php _e('Pingback:', 'videostream'); ?> <?php comment_author_link(); ?><?php edit_comment_link(__('(Edit)', 'videostream'), ' '); ?></p>
        <?php
                                           break;
                                   endswitch;
                               }
                           endif;
                      
                           function videostream_widgets_init() {
                               // Area 1, located at the top of the sidebar.
                               register_sidebar(array(
                                   'name' => __('Header Widget Area', 'videostream'),
                                   'id' => 'header-widget-area',
                                   'description' => __('The primary widget area', 'videostream'),
                                   'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
                                   'after_widget' => '</div>',
                                   'before_title' => '<h3 class="widget-title">',
                                   'after_title' => '</h3>',
                               ));
                               register_sidebar(array(
                                   'name' => __('Top Menu Widget Area', 'videostream'),
                                   'id' => 'top-menu-widget-area',
                                   'description' => __('The top menu widget area', 'videostream'),
                                   'before_widget' => '<li id="%1$s" class="headermenu %2$s">',
                                   'after_widget' => '</li>',
                                   'before_title' => '<h3 class="widget-title displaytitle">',
                                   'after_title' => '</h3>',
                               ));
                               register_sidebar(array(
                                   'name' => __('Banner Widget Area', 'videostream'),
                                   'id' => 'banner-widget-area',
                                   'description' => __('The primary widget area', 'videostream'),
                                   'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
                                   'after_widget' => '</div>',
                                   'before_title' => '<h3 class="widget-title">',
                                   'after_title' => '</h3>',
                               ));
                               // Area 4, located in the footer. Empty by default.
                               register_sidebar(array(
                                   'name' => __('Sidebar Widget Area', 'videostream'),
                                   'id' => 'sidebar-widget-area',
                                   'description' => __('The sidebar widget area', 'videostream'),
                                   'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
                                   'after_widget' => '</li>',
                                   'before_title' => '<h3 class="widget-title">',
                                   'after_title' => '</h3>',
                               ));
                               
                               
                                // Area 3, located in the footer. Empty by default.
                               register_sidebar(array(
                                   'name' => __('Footer Left Widget Area', 'videostream'),
                                   'id' => 'footer-left-widget-area',
                                   'description' => __('The footer left widget area', 'videostream'),
                                   'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
                                   'after_widget' => '</li>',
                                   'before_title' => '<h3 class="widget-title">',
                                   'after_title' => '</h3>',
                               ));
                               // Area 3, located in the footer. Empty by default.
                               register_sidebar(array(
                                   'name' => __('Footer Middle Widget Area', 'videostream'),
                                   'id' => 'footer-middle-widget-area',
                                   'description' => __('The footer middle widget area', 'videostream'),
                                   'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
                                   'after_widget' => '</li>',
                                   'before_title' => '<h3 class="widget-title">',
                                   'after_title' => '</h3>',
                               ));
                               // Area 4, located in the footer. Empty by default.
                               register_sidebar(array(
                                   'name' => __('Footer Right Widget Area', 'videostream'),
                                   'id' => 'footer-right-widget-area',
                                   'description' => __('The footer right widget area', 'videostream'),
                                   'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
                                   'after_widget' => '</li>',
                                   'before_title' => '<h3 class="widget-title">',
                                   'after_title' => '</h3>',
                               ));
                           }
                           /** Register sidebars by running videostream_widgets_init() on the widgets_init hook. */
                           add_action('widgets_init', 'videostream_widgets_init');
                       
                           function videostream_remove_recent_comments_style() {
                               add_filter('show_recent_comments_widget_style', '__return_false');
                           }

                           add_action('widgets_init', 'videostream_remove_recent_comments_style');

                           if (!function_exists('videostream_posted_on')) :

                            
                               function videostream_posted_on() {
                                   printf(__('<span class="%1$s">Posted on</span> %2$s <span class="meta-sep">by</span> %3$s', 'videostream'),
                                           'meta-prep meta-prep-author',
                                           sprintf('<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
                                                   get_permalink(),
                                                   esc_attr(get_the_time()),
                                                   get_the_date()
                                           ),
                                           sprintf('<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
                                                   get_author_posts_url(get_the_author_meta('ID')),
                                                   sprintf(esc_attr__('View all posts by %s', 'videostream'), get_the_author()),
                                                   get_the_author()
                                           )
                                   );
                               }

                           endif;

                           if (!function_exists('videostream_posted_in')) :

                               function videostream_posted_in() {
                                   // Retrieves tag list of current post, separated by commas.
                                   $tag_list = get_the_tag_list('', ', ');
                                   if ($tag_list) {
                                       $posted_in = __('This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'videostream');
                                   } elseif (is_object_in_taxonomy(get_post_type(), 'category')) {
                                       $posted_in = __('This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'videostream');
                                   } else {
                                       $posted_in = __('Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'videostream');
                                   }
                                   // Prints the string, replacing the placeholders.
                                   printf(
                                           $posted_in,
                                           get_the_category_list(', '),
                                           $tag_list,
                                           get_permalink(),
                                           the_title_attribute('echo=0')
                                   );
                               }

                           endif;




