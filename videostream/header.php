<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>" />
        <meta id="viewport" name="viewport" content="width=320; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
        <title><?php
/*
 * Print the <title> tag based on what is being viewed.
 */
global $page, $paged;
wp_title('|', true, 'right');
// Add the blog name.
bloginfo('name');
// Add the blog description for the home/front page.
$site_description = get_bloginfo('description', 'display');
if ($site_description && ( is_home() || is_front_page() ))
    echo " | $site_description";
    // Add a page number if necessary:
if ($paged >= 2 || $page >= 2)
    echo ' | ' . sprintf(__('Page %s', 'videostream'), max($paged, $page));
?></title>
        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_url'); ?>" />
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/media-query.css" type="text/css" media="screen" />
<!--        <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_directory'); ?>/style.css.php" />-->
        <!--[if IE]>
          <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/i-style.css" type="text/css" media="screen" />
        <![endif]-->
        <!--[if IE 7]>
          <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/i7-style.css" type="text/css" media="screen" />
        <![endif]-->
        <link href='http://fonts.googleapis.com/css?family=Nobile' rel='stylesheet' type='text/css'>
        <link type="image/vnd.microsoft.icon" rel="shortcut icon" href="http://www.apptha.com/templates/apptha/favicon.ico"/>    
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
        <script language="javascript" type="text/javascript" src="<?php echo get_bloginfo('url'); ?>/wp-content/plugins/contus-video-gallery/js/jquery-1.3.2.min.js"></script>
        <script language="javascript" type="text/javascript" src="<?php echo get_bloginfo('url'); ?>/wp-content/plugins/contus-video-gallery/js/jquery-ui-1.7.1.custom.min.js"></script>

        <script language="javascript" type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/custommenu.js"></script>

        <?php
            if (is_singular() && get_option('thread_comments'))
                wp_enqueue_script('comment-reply');
            wp_head();

            //To display common functions
            require_once('commonfunc.php');
        ?>
        </head>
        <body <?php body_class(); ?>>
	<div class="texture">
            <div id="wrapper" class="hfeed">
             <div id="header">
                  <div id="masthead">
                        <h1 class="logo">
                         <?php
                        global $options;
                        foreach ($options as $value) {
                            if (get_settings($value['id']) === FALSE) {
                                $$value['id'] = $value['std'];
                            } else {
                                $$value['id'] = get_settings($value['id']);
                            }
                        }
                        if (empty($wpc_logo_url)) {
                            $wpc_logo_url = get_bloginfo('template_url') . '/images/logo.png';
                        }
                        ?>
                        <a href="<?php bloginfo('url'); ?>" title="Home"><img src="<?php echo $wpc_logo_url; ?>" alt="" /></a>
                    </h1>
                    <div class="header-right">
                        <!-- social network share-->
                        <ul class="socialwidgets">
                        <li>
                                <a href="<?php echo $wpc_twitter_url; ?>" target="_blank"><span class="clssocialicon">Twitter</span><img src="<?php bloginfo('template_url'); ?>/images/twitter-icon.png" alt="" /><!--  twitter--></a>
                        </li>
                            <li>
                                <a href="<?php echo $wpc_facebook_url; ?>" target="_blank"><span class="clssocialicon">Facebook</span><img src="<?php bloginfo('template_url'); ?>/images/fb-icon.png" alt="" /><!-- facebook--></a>
                            </li>
                            <li>
                                <a href="<?php echo $wpc_linkedin_url; ?>" target="_blank"><span class="clssocialicon">Linkedin</span><img src="<?php bloginfo('template_url'); ?>/images/linkedin-icon.png" alt="" /><!-- linkedin--></a>
                            </li></ul>
                        <div class="clear"></div>
                        <div id="search" class="widget-container widget_search">
                         <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Header Widget Area')) : ?>
                         <?php endif; ?>       
                        </div>
                    </div>


                    <div class="clear"></div>
                    <div id="branding" role="banner">
                        <!-- main menu -->
                        <div id="mainmenu">
                          <h3 id="menu_selector" class="  ">
                              <span class="text">Menu</span>
                              <span class="line">
                                  <span></span>
                                  <span></span>
                                  <span></span>
                              </span>
                          </h3>
                          <ul id="navigation" class=" ">
                                <li class=" <?php
                            if (is_home ()) {
                                echo ' current-cat ';
                            }
                            ?> home">
                            <?php 
                            $activeCls = '';
                            if(is_home() || is_front_page()){
                            	$activeCls = 'active';
                            }
                            ?>
                            <a class="<?php echo $activeCls?> " href="<?php bloginfo('url'); ?>">Home</a></li>
                            
                            <?php
                             if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Top Menu Widget Area')) : ?>
                             <?php wp_list_categories('depth=3&show_option_none=0&exclude=1&hide_empty=1&orderby=name&show_count=0&use_desc_for_title=1&title_li='); ?>
                             <?php endif;?> 
                            </ul>
                             
                            </div>
                    </div><!-- #masthead -->
                </div><!-- #header -->                 
            </div>
        </div>
                                <!-- #header -->
<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Banner Widget Area')) : ?>

            <?php endif; ?>
                                <div id="main">
            




