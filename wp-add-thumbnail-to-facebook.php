<?php
/*
Plugin Name:  WP Add Thumbnail to Facebook
Plugin URI:   http://www.freakify.com
Description:  It will add ogg meta tags and perfect thumbnail to your share on Facebook.
Version:      1.3
Author:       WPCouple(Ahmad Awais & Maedah Batool)
Author URI:   https://AhmadAwais.com/
License:      GPL 3
Plugin URI:   https://WPCouple.com/
*/

// Add image size.
if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'fbshare-thumb', 90, 90, true );
}

// Hook.
add_action( 'wp_head', 'wpc_fb_thumb_share' );

/**
 * Generate Thumb Share
 *
 * @since 1.0.0
 */
function wpc_fb_thumb_share() {
	// Global obj.
	global $post;

	// Only for single and page.
	if ( is_single() || is_page() ) {
		if ( function_exists( 'has_post_thumbnail' ) && has_post_thumbnail( $post->ID ) ) {
			$thumb_id = get_post_thumbnail_id( $post->ID );
			$image = wp_get_attachment_image_src( $thumb_id, 'fbshare-thumb' );
			$image = $image[0];
		}
	}

	// If there is an image.
	if ( $image ) {
		if ( strpos( $image, '../' ) === 0 ) $image = substr( $image,3 );
		if ( strpos( $image, '/' ) === 0 )   $image = substr( $image,1 );
		if ( strpos( $image,'http://' ) !== 0 && strpos( $image, get_bloginfo( 'url' ) ) !== 0 )
			$image = ( get_bloginfo( 'url' ) ) . '/' . $image;
		echo '<link rel="image_src" href="' . esc_attr( $image ) . '" />';
		echo "\n";
		echo '<meta property="og:image" content="' . esc_attr( $image ) . '" />';
		echo "\n";
	}
}