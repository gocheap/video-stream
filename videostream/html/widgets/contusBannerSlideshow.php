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
	if ( !function_exists('wp_register_sidebar_widget') )
	return;
	function widget_ContusBannerSlideshow($args)
	{     
            $videoSearch = $bannertype = '';
            if(isset($_REQUEST['video_search'])){
		$videoSearch = $_REQUEST['video_search'];           
            }
            $show=5;
        if( (is_home() == 1 ||  is_front_page()== 1) && empty($videoSearch) ){        	
	    extract($args);
		global $wpdb;
		$options		= get_option('widget_ContusBannerSlideshow');
		$title 			= $options['title'];  // Title in sidebar for widget
		$show 			= $options['show'];  // # of Posts we are showing
		$excerpt 		= $options['excerpt'];  // Showing the excerpt or not
		$exclude 		= $options['exclude'];  // Categories to exclude
		$site_url 		= get_bloginfo('url');
                if(isset($_SESSION["stream_plugin"])){
                $pluginName     	=     $_SESSION["stream_plugin"];
                }

        if(empty($bannertype))
        $bannertype='featured';

        switch ($bannertype) {
            case 'popular' :
                $baseref = "type=1&numberofvideos=$show";
                 $bannervideos = "SELECT distinct w.*,p.playlist_name FROM " . $wpdb->prefix . "hdflvvideoshare w
              INNER JOIN " . $wpdb->prefix . "hdflvvideoshare_med2play m ON m.media_id = w.vid
              INNER JOIN " . $wpdb->prefix . "hdflvvideoshare_playlist p ON p.pid=m.playlist_id
              WHERE publish='1' AND p.is_publish='1' GROUP BY w.vid ORDER BY w.hitcount DESC LIMIT ". $show;
                break;
            case 'recent' :
                $baseref = "type=2&numberofvideos=$show";
                $bannervideos = "SELECT distinct w.*,p.playlist_name FROM " . $wpdb->prefix . "hdflvvideoshare w
              INNER JOIN " . $wpdb->prefix . "hdflvvideoshare_med2play m ON m.media_id = w.vid
              INNER JOIN " . $wpdb->prefix . "hdflvvideoshare_playlist p ON p.pid=m.playlist_id
              WHERE publish='1' AND p.is_publish='1' GROUP BY w.vid ORDER BY w.post_date DESC LIMIT ". $show;
                break;
            case 'featured' :
                $baseref = "type=3&numberofvideos=$show";
                 $bannervideos = "SELECT distinct w.*,p.playlist_name FROM " . $wpdb->prefix . "hdflvvideoshare w
              INNER JOIN " . $wpdb->prefix . "hdflvvideoshare_med2play m ON m.media_id = w.vid
              INNER JOIN " . $wpdb->prefix . "hdflvvideoshare_playlist p ON p.pid=m.playlist_id
              WHERE featured='1' and publish='1' AND p.is_publish='1' GROUP BY w.vid ORDER BY w.ordering ASC LIMIT ". $show;
                break;
            case 'category' :
                $playid = $content['catid'];
                $bannervideos = "SELECT distinct w.*,p.playlist_name FROM " . $wpdb->prefix . "hdflvvideoshare w
              INNER JOIN " . $wpdb->prefix . "hdflvvideoshare_med2play m ON m.media_id = w.vid
              INNER JOIN " . $wpdb->prefix . "hdflvvideoshare_playlist p ON p.pid=m.playlist_id
              WHERE (m.playlist_id = '".intval($playid)."') and publish='1' AND p.is_publish='1' GROUP BY w.vid ORDER BY w.ordering ASC LIMIT ". $show;
                 break;
            default;
        }
        $bannerSlideShow = $wpdb->get_results($bannervideos);
		?>
<script language="javascript" type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery-1.3.2.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery-ui-1.7.1.custom.min.js"></script>
<script type="text/javascript">
   var lt=false;
</script>
<!--[if lt IE 7]>
  <script type="text/javascript">
    var lt=true;
  </script>
<![endif]-->
<!--[if lt IE 8]>
  <script type="text/javascript">
    var lt=true;
  </script>
<![endif]-->
<!--[if lt IE 9]>
  <script type="text/javascript">
    var lt=true;
  </script>
<![endif]-->
<script type="text/javascript">
    var baseurl;
    baseurl = '<?php echo $site_url; ?>';
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
            embedCode  = sourceCode.replace('embecontus','embed');
            embedCode  = embedCode.replace('iframcontus','iframe');
            embedCode  = embedCode.replace('videcontus','video');
            if(lt==true){
            embedCode  = sourceCode.replace('EMBECONTUS','EMBED');
            embedCode  = embedCode.replace('IFRAMCONTUS','IFRAME');
            embedCode  = embedCode.replace('VIDECONTUS','IFRAME');
            }
            document.getElementById("nav-"+vid).className = 'ui-tabs-nav-item ui-tabs-selected';
            removeSelectItem = document.getElementById("activeCSS").value;
            document.getElementById("nav-"+removeSelectItem).className = 'ui-tabs-nav-item';
            document.getElementById('videoPlay').innerHTML = embedCode;
            document.getElementById("activeCSS").value = vid;

        }
        window.onload = function(){
            vid = "fragment-<?php echo $bannerSlideShow[0]->vid; ?>";
            sourceCode = document.getElementById(vid).innerHTML;
            embedCode  = sourceCode.replace('embecontus','embed');
            embedCode  = embedCode.replace('iframcontus','iframe');
            embedCode  = embedCode.replace('videcontus','video');
            if(lt==true){
            embedCode  = sourceCode.replace('EMBECONTUS','EMBED');
            embedCode  = embedCode.replace('IFRAMCONTUS','IFRAME');
            embedCode  = embedCode.replace('VIDECONTUS','IFRAME');
            }
            document.getElementById("nav-"+vid).className = 'ui-tabs-nav-item ui-tabs-selected';
            document.getElementById('videoPlay').innerHTML = embedCode;
        }
        </script>
		<?php
function videostream_detectmobile()
{
    $_SERVER['ALL_HTTP'] = isset($_SERVER['ALL_HTTP']) ? $_SERVER['ALL_HTTP'] : '';

    $mobile_browser = '0';

    $agent = strtolower($_SERVER['HTTP_USER_AGENT']);

    if(preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|iphone|ipad|ipod|android|xoom)/i', $agent))
        $mobile_browser++;

    if((isset($_SERVER['HTTP_ACCEPT'])) and (strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') !== false))
        $mobile_browser++;

    if(isset($_SERVER['HTTP_X_WAP_PROFILE']))
        $mobile_browser++;

    if(isset($_SERVER['HTTP_PROFILE']))
        $mobile_browser++;

    $mobile_ua = substr($agent,0,4);
    $mobile_agents = array(
                        'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
                        'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
                        'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
                        'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
                        'newt','noki','oper','palm','pana','pant','phil','play','port','prox',
                        'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
                        'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
                        'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
                        'wapr','webc','winw','xda','xda-'
                        );

    if(in_array($mobile_ua, $mobile_agents))
        $mobile_browser++;

    if(strpos(strtolower($_SERVER['ALL_HTTP']), 'operamini') !== false)
        $mobile_browser++;

    // Pre-final check to reset everything if the user is on Windows
    if(strpos($agent, 'windows') !== false)
        $mobile_browser=0;

    // But WP7 is also Windows, with a slightly different characteristic
    if(strpos($agent, 'windows phone') !== false)
        $mobile_browser++;

    if($mobile_browser>0)
        return true;
    else
        return false;
}
?>
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
            <div id="videoPlay" class="ui-tabs-panel" style="height:100%">
            </div>
        </div>
    <input type="hidden" id="activeCSS" value="fragment-<?php echo $bannerSlideShow[0]->vid; ?>" />
<?php for ($i = 0; $i < count($bannerSlideShow); $i++) {
    if($bannertype=='category')
    $baseref = "&pid=".$playid;
    ?>
                <div id="fragment-<?php echo $bannerSlideShow[$i]->vid; ?>" class="ui-tabs-panel" style="height:100%;float:right">
		    <?php $file_type           = $bannerSlideShow[$i]->file_type;
                    if ($file_type == 5){
                    $bannerembedcode = stripslashes($bannerSlideShow[$i]->embedcode);
                   $banneriframecode =  str_replace('<iframe', '<iframcontus', $bannerembedcode);
                   $banneriframewidth =  str_replace('width=', 'width="672"', $banneriframecode);
                   echo str_replace('height=', 'height="315"', $banneriframewidth);
                     // '<script> currentvideo("'.$bannerSlideShow->name.'",'.$bannerSlideShow->vid.'); </script>';
            }else{
                $mobile = videostream_detectmobile();
   if($mobile === true){
       $videourl            = $bannerSlideShow[$i]->file;
        $_imagePath             = APPTHA_VGALLERY_BASEURL . 'images' . DS;
        $image_path             = str_replace('plugins/contus-video-gallery/', 'uploads/videogallery/', APPTHA_VGALLERY_BASEURL);
                $imgurl              = $bannerSlideShow[$i]->image;
                $file_type           = $bannerSlideShow[$i]->file_type;
                if ($imgurl == '') {                ## If there is no thumb image for video
                $imgurl              = $_imagePath . 'nothumbimage.jpg';
                } else {
                    if ($file_type == 2) {          ## For uploaded image
                        $imgurl      = $image_path . $imgurl;
                    }
                }

                if (preg_match('/www\.youtube\.com\/watch\?v=[^&]+/', $videourl, $vresult))
                {
                   $urlArray = explode("=", $vresult[0]);
                   $videoid = trim($urlArray[1]);
?>
               <iframcontus  type="text/html" width="672" height="315" src="http://www.youtube.com/embed/<?php echo $videoid; ?>" frameborder="0">
               </iframcontus>
<?php
                } else { 
                    if ($file_type == 2) {                  ## For uploaded image
                    $videourl       = $image_path . $videourl;
                } else if ($file_type == 4) {           ## For RTMP videos
                    $streamer       = str_replace("rtmp://", "http://", $bannerSlideShow[$i]->streamer_path);
                    $videourl       = $streamer . '_definst_/mp4:' . $videourl . '/playlist.m3u8';
                }
                ?>
               <videcontus id='video' width="672" height="315" poster='<?php echo $imgurl; ?>' src='<?php echo $videourl; ?>' autobuffer controls onerror='failed(event)'>Html5 Not support This video Format.</video>
               <?php
                
}
   }else{	?>
				<embecontus
					src="<?php echo $site_url.'/wp-content/plugins/'.$pluginName.'/hdflvplayer/hdplayer.swf'; ?>"
					flashvars="baserefW=<?php echo $site_url; ?>&banner=true&mtype=playerModule&vid=<?php echo $bannerSlideShow[$i]->vid; ?>&<?php echo $baseref; ?>&Preview=<?php echo $bannerSlideShow[$i]->image; ?>"
					style="width:672px; height: 315px" allowFullScreen="true"
					allowScriptAccess="always" type="application/x-shockwave-flash"
					wmode="transparent"></embecontus>
            <?php } } ?>
		</div>
		<?php }?>
		</div>	
       <div class="page-bannershort" id="gallery_banner_list" >
            <ul class="page-lof-navigator">
<?php for ($i = 0; $i < count($bannerSlideShow); $i++) { ?>
                <li class="ui-tabs-nav-item " id="nav-fragment-<?php echo $bannerSlideShow[$i]->vid; ?>">
				<div class="nav_container">
                        <a href="javascript:void(0)" onclick=switchVideo("fragment-<?php echo $bannerSlideShow[$i]->vid; ?>")>
                            <div class="page-thumb-img">
                                 <?php
                                $image_path                     = str_replace('plugins/'.$pluginName.'/', 'uploads/videogallery/', APPTHA_VGALLERY_BASEURL);
                                $_imagePath                     = APPTHA_VGALLERY_BASEURL . 'images' . DS;
                                $thumb_image                    = $bannerSlideShow[$i]->image;                                  ## Get thumb image
                                $file_type                      = $bannerSlideShow[$i]->file_type;                              ## Get file type of a video

                                    if ($thumb_image == '') {       ## If there is no thumb image for video
                                        $thumb_image            = $_imagePath . 'nothumbimage.jpg';
                                    } else {
                                        if ($file_type == 2 || $file_type == 5) {      ## For uploaded image
                                            $thumb_image        = $image_path . $thumb_image;
                                        }
                                    }
                                ?>
                                <img src="<?php echo $thumb_image; ?>"  alt="thumb image" /></div>
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
		if ( isset($_POST['ContusBannerSlideshow-submit']) && $_POST['ContusBannerSlideshow-submit'] )
		{
			// Remember to sanitize and format use input appropriately.
			$options['title'] = strip_tags(stripslashes($_POST['ContusBannerSlideshow-title']));
			$options['show'] = strip_tags(stripslashes($_POST['ContusBannerSlideshow-show']));
                        if(isset($_POST['ContusFeatureVideos-excerpt'])){
			$options['excerpt'] = strip_tags(stripslashes($_POST['ContusFeatureVideos-excerpt']));
                        }
                        if(isset($_POST['ContusFeatureVideos-exclude'])){
			$options['exclude'] = strip_tags(stripslashes($_POST['ContusFeatureVideos-exclude']));
                        }
			update_option('widget_ContusBannerSlideshow', $options);
		}
		// Get options for form fields to show
		$title = htmlspecialchars($options['title'], ENT_QUOTES);
		$show = htmlspecialchars($options['show'], ENT_QUOTES);
		$excerpt = htmlspecialchars($options['excerpt'], ENT_QUOTES);
		$exclude = htmlspecialchars($options['exclude'], ENT_QUOTES);
		// The form fields
		echo '<p >
        <label for="ContusBannerSlideshow-title">' . __('Title:') . '
        <input id="ContusBannerSlideshow-title" name="ContusBannerSlideshow-title" type="text" value="'.$title.'" />
        </label></p>';
		echo '<p >
        <label for="ContusBannerSlideshow-show">' . __('Show:') . '
        <input id="ContusBannerSlideshow-show"  name="ContusBannerSlideshow-show" type="text" value="'.$show.'" />
        </label></p>';
		echo '<input type="hidden" id="ContusBannerSlideshow-submit" name="ContusBannerSlideshow-submit" value="1" />';
	}
        
	// Register widget for use
	wp_register_sidebar_widget( 'stream_banner',        // your unique widget id
    'Contus Banner Slideshow',          // widget name
        'widget_ContusBannerSlideshow' // Callback function
                );
	// Register settings for use, 300x100 pixel form
	wp_register_widget_control('stream_banner',        // your unique widget id
    'Contus Banner Slideshow',          // widget name
        'widget_ContusBannerSlideshow_control' // Callback function
        );
    

}
// Run code and init
add_action('widgets_init', 'widget_ContusBannerSlideshow_init');
?>