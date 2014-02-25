<?php
class wpCommonFunc {
    function twitterFeed($username) {
        $format = 'json';
        // get tweets and decode them into a variable;        
        
        $tweets = json_decode(file_get_contents("http://www.twitter.com/statuses/user_timeline/" . $username . ".json?count=3"));           
        foreach ($tweets as $tweet) {
            echo '<li>';
            echo '<p class="floatleft"><img src="' . $tweet->user->profile_image_url . '" width="28" height="28" /></p>';
            echo '<p>' . $tweet->text . '</p>';
            echo '</li>';
        }       
    }
}
?>