<?php
/*
Plugin Name: Argo Audio Player
Description: The Argo Audio Player Plugin.
Version: 0.1
*/
define( 'HALF_WIDTH', 300 );
/* The Argo Audio Player Plugin class - so we don't have function naming conflicts */
class ArgoAudioPlayer {
  
  /* Install function, runs when the plugin is installed - not implemented */
  function install() {
	
  }
  
  /* Deactivate function, runs when the plugin is deactivated - not implemented */
  function deactivate() {
	
  }
  
  /* Initialize the plugin */
  function init() {
	
	/**
	 * Add the "audio" shortcode for use in posts
	 * We call all other functions from within the argo_audio_shortcode function
	 * so that we only load the plugin assets if they are needed
	 * ie the shortcode is used on a page
	*/
	add_shortcode( 'audio', array(__CLASS__,'argo_audio_shortcode'));
	
	/* Override the default add audio link to post action*/
	add_filter( 'audio_send_to_editor_url', array(__CLASS__,'argo_audio_editor_shortcode'), 10, 3 );
	add_filter( 'media_send_to_editor', array(__CLASS__,'argo_audio_editor_media_gallery_shortcode'), 10, 3 );
	/* Add action to enqueue the jquery file for loading (this is called before the header loads)*/
	add_action('get_header',array(__CLASS__,'ArgoGetWPHeader'));
	add_action('wp_head',array(__CLASS__,'ArgoWPHead'));
  }
  
  /* Make sure the jQuery is queued up to be loaded, because we need it! */
  function ArgoGetWPHEader() {
	wp_enqueue_script("jquery");
  }
  /* Always load the css into the wp header, the only way it works right*/
  function ArgoWPHEad() {
	$style = plugins_url( 'css/argo-audio-player.css', __FILE__ );
	echo "<link rel='stylesheet' href='$style'/>\n";
  }
  /*  	echo "<img src="' .plugins_url( 'images/wordpress.png' , dirname(__FILE__) ). '" > ';
  
  <link rel='stylesheet' href='/wp-content/plugins/argo-audio-player/css/argo-audio-player.css'/>\n
  
  */

  /* Inserts the needed code into the themes footer */
  function ArgoWPFooter() {

	/* Load up the SoundManager 2 javascript files into the footer */
	echo "<script src='".plugins_url(null,__FILE__)."/js/sm.min.js'></script>";
	echo "<script src='".plugins_url(null, __FILE__)."/js/sm.playlist.js'></script>";
	
	
	/* Setup the SoundManager 2 swf directories*/
	echo "<script>
	soundManager.url = '".plugins_url(null,__FILE__)."/swf/';
	
	function setTheme(sTheme) {
	  var o = document.getElementsByTagName('ul')[0];
	  o.className = 'playlist'+(sTheme?' '+sTheme:'');
	  return false;
	}
	
	</script>";
	
	/* Load/Echo the audio controls*/
	echo '<div id="control-template">
			<!-- control markup inserted dynamically after each link -->
			<div class="controls">
				<div class="statusbar">
					<div class="loading"></div>
					<div class="position"></div>
				</div>
			</div>
			<div class="timing">
				<div id="sm2_timing" class="timing-data">
					<span class="sm2_position">%s1</span> / <span class="sm2_total">%s2</span></div>
			</div>
			<div class="peak">
				<div class="peak-box"><span class="l"></span><span class="r"></span>
				</div>
			</div>
		</div>
		<div id="spectrum-container" class="spectrum-container">
			<div class="spectrum-box">
				<div class="spectrum"></div>
			</div>
		</div>';
  }  

  /*
   * DISABLE DEFAULT FUNCTIONALITY
   */
  
  function disable_builtin_caption( $shcode, $html ) {
	  return $html;
  }
  //add_filter( 'image_add_caption_shortcode', 'disable_builtin_caption', 15, 2 );
  /*
   * END DISABLE DEFAULT FUNCTIONALITY
   */
  
  /*
   * AUDIO EDITOR MARKUP CUSTOMIZATIONS
   */
  function argo_audio_editor_markup( $href, $title, $caption ) {
	  $out = sprintf( '<ul class="%s"><li>', 'playlist' );
	  $out .= sprintf( '<a href="%s" class="%s" title="%s">%s', $href, 'inline', $title, $title );
	  if ( $caption ) {
		  $out .= sprintf( '<span class="%s">%s</span></a>', 'caption', $caption );
	  }
	  $out .= sprintf( '<a href="%s" class="%s">%s</a>', $href, 'exclude', 'Download' );
	  $out .= "</li></ul>";
  
	  return $out;
  }
  
  /*
   * SHORTCODES
   */
  function argo_audio_shortcode( $atts, $content ) {
	  extract( $atts );
	  /* Insert needed code into the footer */
	add_action('wp_footer',array(__CLASS__,'ArgoWPFooter'));
	  $html = ArgoAudioPlayer::argo_audio_editor_markup( $href, $title, $content );
	  return $html;
  }
  
  // construct shortcode for audio embeds
  function argo_audio_editor_shortcode( $html, $href, $title  ) {
	  return sprintf( '[audio href="%s" title="%s"]Insert caption here[/audio]', $href, $title );
  }
  // construct shortcode for audio embeds
  function argo_audio_editor_media_gallery_shortcode( $html, $send_id, $attachment  ) {
	$title = '';
	$href = '';
	if (preg_match("/\.mp3|\.ogg|\.mp4|\.wav|\.m4a/",$html)) {
	  /* Get the title from the html */
	  preg_match("/\>.+\</",$html,$title);
	  $title = $title[0];
	  $title = preg_replace("/\>|\</","",$title);
	  $title = preg_replace("/_/"," ",$title);
	  /* Get the url of the file from the html */
	  preg_match("/\'.+\'/",$html,$href);
	  $href = $href[0];
	  $href = preg_replace("/\'/","",$href);
	  return sprintf( '[audio href="%s" title="%s"]Insert caption here[/audio]', $href, $title );
	} else {
	  return;
	  
	}
	
  }
  /*
   * ADMIN PRESENTATION CUSTOMIZATIONS
   */
  function argo_tweak_upload_tabs( $defaults ) {
	  if ( array_key_exists( 'gallery', $defaults ) ) {
		  unset( $defaults[ 'gallery' ] );
	  }
	  return $defaults;
  }
  // XXX: it does more harm than good to comment this out.
  //add_filter( 'media_upload_tabs', 'argo_tweak_upload_tabs', 12, 1 );
  
  
  /*
   * END ADMIN PRESENTATION CUSTOMIZATIONS
   */
}

/* Initialize the plugin using it's init() function */
ArgoAudioPlayer::init();
?>
