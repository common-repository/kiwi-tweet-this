<?php
/*
Plugin Name: Kiwi Tweet this!
Plugin URI: http://getkiwi.org/plugins/tweet-this/
Description: Tweet a text with or without a specified url. Use the shortcode [tweetthis url="http://www.example.com"]The text to tweet[/tweetthis]
Version: 2.0
Author: Kiwi by Yourstyledesign
Author URI: http://www.getkiwi.org/
*/

if ( ! class_exists( 'kiwi_tweet_this' ) ) :

class kiwi_tweet_this {

	function __construct() {
		add_action('wp_head', array( &$this, 'javascript' ) );
		add_shortcode( 'tweetthis', array( &$this, 'shortcode' ) );
	}
	
	function javascript() {
		//Adds the script which gives access to the twitter api
		echo '<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
	}
	
	function shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'url' => ''
		), $atts ) );
		if (!empty($url)) {
			$ch = curl_init("http://tinyurl.com/api-create.php?url=$url");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
			$url = curl_exec($ch);
			curl_close($ch);
		}
		return '<div class="kiwi-tweetthis"><p class="text">'.$content.'</p><a href="https://twitter.com/share" class="twitter-share-button" data-url="'.$url.'" data-text="'.htmlspecialchars($content).'" data-count="none">Tweet</a></div>';
	}

}

new kiwi_tweet_this;

endif;