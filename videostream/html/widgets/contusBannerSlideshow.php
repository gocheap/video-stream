<?php
/*Plugin Name: Video Gallery Banner
Plugin URI: http://www.hdflvplayer.net/wordpress-video-gallery/
Description: BannerSlideshow widget with the standard system of wordpress.
Version: 1.0
Author: Apptha Team
wp-content\plugins\contus-hd-flv-player\ContusBannerSlideshow.php
Date : 21/2/2011
 */
function widget_ContusBannerSlideshow_init() {
	if ( !function_exists('register_sidebar_widget') )
	return;
	function widget_ContusBannerSlideshow($args)
	{     
		$videoSearch = $_REQUEST['video_search'];           
        if( (is_home() == 1 ||  is_front_page()== 1) && empty($videoSearch) ){        	
	    extract($args);
		global $wpdb, $wp_version, $popular_posts_current_ID;
		$options		= get_option('widget_ContusBannerSlideshow');
		$title 			= $options['title'];  // Title in sidebar for widget
		$show 			= $options['show'];  // # of Posts we are showing
		$excerpt 		= $options['excerpt'];  // Showing the excerpt or not
		$exclude 		= $options['exclude'];  // Categories to exclude
		$site_url 		= get_bloginfo('url');
		$pluginName     	= 'contus-video-gallery';
		$dir 			= dirname(plugin_basename(__FILE__));
		$dirExp 		= explode('/', $dir);
		$dirPage 		= $dirExp[0];
		$pluginPath     = plugins_url().'/'.$pluginName;
                $bannertype = $content['type'];
        $show = '';
        if(empty($bannertype))
        $bannertype='featured';

        switch ($bannertype) {
            case 'popular' :
                $show = $content['numberofvideos'];
                $bannerwidth = $content['width'];
                $playerwidth = $content['playerwidth'];
                $show=5;
                $baseref = "type=1&numberofvideos=$show";
                 $bannervideos = "SELECT distinct w.*,p.playlist_name FROM " . $wpdb->prefix . "hdflvvideoshare w
              INNER JOIN " . $wpdb->prefix . "hdflvvideoshare_med2play m ON m.media_id = w.vid
              INNER JOIN " . $wpdb->prefix . "hdflvvideoshare_playlist p ON p.pid=m.playlist_id
              WHERE publish='1' AND p.is_publish='1' GROUP BY w.vid ORDER BY w.hitcount DESC LIMIT ". $show;
                break;
            case 'recent' :
                $show = $content['numberofvideos'];
                $bannerwidth = $content['width'];
                $playerwidth = $content['playerwidth'];
                $show=5;
                $baseref = "type=2&numberofvideos=$show";
                $bannervideos = "SELECT distinct w.*,p.playlist_name FROM " . $wpdb->prefix . "hdflvvideoshare w
              INNER JOIN " . $wpdb->prefix . "hdflvvideoshare_med2play m ON m.media_id = w.vid
              INNER JOIN " . $wpdb->prefix . "hdflvvideoshare_playlist p ON p.pid=m.playlist_id
              WHERE publish='1' AND p.is_publish='1' GROUP BY w.vid ORDER BY w.post_date DESC LIMIT ". $show;
                break;
            case 'featured' :
                $show = $content['numberofvideos'];
                $bannerwidth = $content['width'];
                $playerwidth = $content['playerwidth'];
                $show=5;
                $baseref = "type=3&numberofvideos=$show";
                 $bannervideos = "SELECT distinct w.*,p.playlist_name FROM " . $wpdb->prefix . "hdflvvideoshare w
              INNER JOIN " . $wpdb->prefix . "hdflvvideoshare_med2play m ON m.media_id = w.vid
              INNER JOIN " . $wpdb->prefix . "hdflvvideoshare_playlist p ON p.pid=m.playlist_id
              WHERE featured='1' and publish='1' AND p.is_publish='1' GROUP BY w.vid ORDER BY w.ordering ASC LIMIT ". $show;
                break;
            case 'category' :
                $playid = $content['catid'];
                $bannerwidth = $content['width'];
                $playerwidth = $content['playerwidth'];
                $show=5;
                $show = $content['numberofvideos'];
                $bannervideos = "SELECT distinct w.*,p.playlist_name FROM " . $wpdb->prefix . "hdflvvideoshare w
              INNER JOIN " . $wpdb->prefix . "hdflvvideoshare_med2play m ON m.media_id = w.vid
              INNER JOIN " . $wpdb->prefix . "hdflvvideoshare_playlist p ON p.pid=m.playlist_id
              WHERE (m.playlist_id = '".intval($playid)."') and publish='1' AND p.is_publish='1' GROUP BY w.vid ORDER BY w.ordering ASC LIMIT ". $show;
                 break;
            default;
        }
        $bannerSlideShow = $wpdb->get_results($bannervideos);
		?>
<script type="text/javascript">
    var baseurl;
    baseurl = '<?php echo $site_url; ?>';
    folder  = '<?php echo $dirPage;?>'
</script>
<script type="text/javascript">
	$(document).ready(function(){
                $("#featured").tabs({fx:{opacity: "toggle"}}).tabs("rotate", 5000, true);
	});
</script>
<script type="text/javascript">
        $(document).ready(function(){
        var get_width = 'auto';
            // Getting the width of the theme to fix the banner fix
            if(get_width == 'auto')
            {
                var theme_width  =  '960';               
            }           
           // var border_width = parseInt('10');
            var actual_width = parseInt(theme_width);
            $("#featured").css('width',actual_width);
            $("#slider_banner > ul").tabs({fx:{opacity: "toggle"}}).tabs("rotate",  '3000', true);
        });
    </script>
<script type="text/javascript">
    function currentVideo(vid,videoids){
for(var i = 0; i < videoids.length; i++){
    if(videoids[i]!=vid){
        var prev_fragment = document.getElementById('nav-fragment-'+videoids[i])
        prev_fragment.className = "ui-tabs-nav-item" ;
}
}
        var fragment = document.getElementById('nav-fragment-'+vid)
         fragment.className += " ui-tabs-selected" ;
    }
                  function switchVideo(vid){
            sourceCode = document.getElementById(vid).innerHTML;
            objectCode = sourceCode.replace('OBJEC','object');
            embedCode  = objectCode.replace('embe','embed');
            document.getElementById("nav-"+vid).className = 'ui-tabs-nav-item ui-tabs-selected';
            removeSelectItem = document.getElementById("activeCSS").value;
            document.getElementById("nav-"+removeSelectItem).className = 'ui-tabs-nav-item';
            document.getElementById('videoPlay').innerHTML = embedCode;
            document.getElementById("activeCSS").value = vid;

        }
        window.onload = function(){
            vid = "fragment-<?php echo $bannerSlideShow[0]->vid; ?>";
            sourceCode = document.getElementById(vid).innerHTML;
            objectCode = sourceCode.replace('OBJEC','object');
            embedCode  = objectCode.replace('embe','embed');
            document.getElementById("nav-"+vid).className = 'ui-tabs-nav-item ui-tabs-selected';
            document.getElementById('videoPlay').innerHTML = embedCode;
        }
        </script>
		<?php
        $moreName = $wpdb->get_var("select ID from " . $wpdb->prefix . "posts WHERE post_content='[videomore]'");
		echo $before_widget;
		$div = '<div id="contusfeatured"  class="sidebar-wrap clearfix">
         <div><a href="'.$site_url.'/?page_id='.$moreName.'&more=fea"><h2 class="widget-title">Feature Videos</h2></a></div>';
		$show   = $options['show'];
		$moreF = $wpdb->get_results("select count(*) as contus from " . $wpdb->prefix . "hdflvvideoshare WHERE featured='1'");
		$countF = $moreF[0]->contus;
		
		$div .='<ul class="ulwidget">';		
		if (!empty($bannerSlideShow))
		{?>
<div id="featured">	
<div id="lofslidecontent45"	class="lof-slidecontent lof-snleft">
<div class="right_side">
   <?php $file_type = $bannerSlideShow->file_type;
if($bannerSlideShow->file_type == 5 && !empty($bannerSlideShow->embedcode)){
$div                 .= stripslashes($bannerSlideShow->embedcode);
            $div                 .= '<script> currentvideo("'.$bannerSlideShow->name.'",'.$bannerSlideShow->vid.'); </script>';
            }else{?>
            <div id="videoPlay" class="ui-tabs-panel" style="height:100%">    
            </div>
   <?php }?>
        </div>
    <input type="hidden" id="activeCSS" value="fragment-<?php echo $bannerSlideShow[0]->vid; ?>" />
<?php for ($i = 0; $i < count($bannerSlideShow); $i++) {
    if($bannertype=='category')
    $baseref = "&pid=".$playid;
    ?>
                <div id="fragment-<?php echo $bannerSlideShow[$i]->vid; ?>" class="ui-tabs-panel" style="height:100%;float:right">
                    <objec classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
				codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0"
				width="672" height="315">
				<param name="movie"
					value="<?php echo $site_url.'/wp-content/plugins/'.$pluginName.'/hdflvplayer/hdplayer.swf'; ?>" />
				<param name="flashvars"
					value="baserefW=<?php echo $site_url; ?>&vid=<?php echo $bannerSlideShow[$i]->vid; ?>&Preview=<?php echo $bannerSlideShow[$i]->image; ?>" />
				<param name="allowFullScreen" value="true" />
				<param name="wmode" value="transparent" />
				<param name="allowscriptaccess" value="always" />
				<embe
					src="<?php echo $site_url.'/wp-content/plugins/'.$pluginName.'/hdflvplayer/hdplayer.swf'; ?>"
					flashvars="baserefW=<?php echo $site_url; ?>&banner=true&mtype=playerModule&vid=<?php echo $bannerSlideShow[$i]->vid; ?>&<?php echo $baseref; ?>&Preview=<?php echo $bannerSlideShow[$i]->image; ?>"
					style="width:672px; height: 315px" allowFullScreen="true"
					allowScriptAccess="always" type="application/x-shockwave-flash"
					wmode="transparent"></embed>
			</objec>
		</div>
		<?php }?>
		</div>	
	    <!-- NAVIGATOR -->
        <div class="page-bannershort" id="gallery_banner_list" >
            <ul class="page-lof-navigator">
<?php for ($i = 0; $i < count($bannerSlideShow); $i++) { ?>
                <li class="ui-tabs-nav-item " id="nav-fragment-<?php echo $bannerSlideShow[$i]->vid; ?>">
				<div class="nav_container">
                        <a href="javascript:void(0)" onclick=switchVideo("fragment-<?php echo $bannerSlideShow[$i]->vid; ?>")>
                            <div class="page-thumb-img"><img src="<?php echo $bannerSlideShow[$i]->image; ?>"  alt="thumb image" /></div>
					<div class="slide_video_info" >
                                <?php echo substr($bannerSlideShow[$i]->name, 0, 25); ?>
                                <div class="category">
                                <?php echo $bannerSlideShow[$i]->playlist_name ?>
						</div>
					</div>
					</a>
				</div>
			</li>
			<?php } ?>
		</ul>
		</div>
	<!-- NAVIGATOR -->	
</div>	

		<?php  }//if end
		else $div .="No Banner videos";
		// end list
		if (($show < $countF) || ($show==$countF))
		{
			$div .='<div align="right"><a href="'.$site_url.'/?page_id='.$moreName.'&more=fea">More</a></div>';
		}
		else
		{
			$div .='<div align="right"> </div>';
		}
		$div .='</ul></div>';
		//echo $div;
		// echo widget closing tag
		echo $after_widget;
        }
	}
	// Settings form
	function widget_ContusBannerSlideshow_control()
	{
		// Get options
		$options = get_option('widget_ContusBannerSlideshow');
		// options exist? if not set defaults
		if ( !is_array($options) )
		{
			$options = array('title'=>'Banner Slide Show', 'show'=>'5', 'excerpt'=>'1','exclude'=>'');
		}
		// form posted?
		if ( $_POST['ContusBannerSlideshow-submit'] )
		{
			// Remember to sanitize and format use input appropriately.
			$options['title'] = strip_tags(stripslashes($_POST['ContusBannerSlideshow-title']));
			$options['show'] = strip_tags(stripslashes($_POST['ContusBannerSlideshow-show']));
			$options['excerpt'] = strip_tags(stripslashes($_POST['ContusFeatureVideos-excerpt']));
			$options['exclude'] = strip_tags(stripslashes($_POST['ContusFeatureVideos-exclude']));
			update_option('widget_ContusBannerSlideshow', $options);
		}
		// Get options for form fields to show
		$title = htmlspecialchars($options['title'], ENT_QUOTES);
		$show = htmlspecialchars($options['show'], ENT_QUOTES);
		$excerpt = htmlspecialchars($options['excerpt'], ENT_QUOTES);
		$exclude = htmlspecialchars($options['exclude'], ENT_QUOTES);
		// The form fields
		echo '<p style="text-align:right;">
        <label for="ContusBannerSlideshow-title">' . __('Title:') . '
        <input style="width: 200px;" id="ContusBannerSlideshow-title" name="ContusBannerSlideshow-title" type="text" value="'.$title.'" />
        </label></p>';
		echo '<p style="text-align:right;">
        <label for="ContusBannerSlideshow-show">' . __('Show:') . '
        <input style="width: 200px;" id="ContusBannerSlideshow-show"  name="ContusBannerSlideshow-show" type="text" value="'.$show.'" />
        </label></p>';
		echo '<input type="hidden" id="ContusBannerSlideshow-submit" name="ContusBannerSlideshow-submit" value="1" />';
	}
	// Register widget for use
	register_sidebar_widget(array('Contus Banner Slideshow', 'widgets'), 'widget_ContusBannerSlideshow');
	// Register settings for use, 300x100 pixel form
	register_widget_control(array('Contus Banner Slideshow', 'widgets'), 'widget_ContusBannerSlideshow_control', 300, 200);
}
// Run code and init
add_action('widgets_init', 'widget_ContusBannerSlideshow_init');
?>