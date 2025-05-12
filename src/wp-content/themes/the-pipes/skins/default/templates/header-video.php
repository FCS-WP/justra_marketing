<?php
/**
 * The template to display the background video in the header
 *
 * @package THE PIPES
 * @since THE PIPES 1.0.14
 */
$the_pipes_header_video = the_pipes_get_header_video();
$the_pipes_embed_video  = '';
if ( ! empty( $the_pipes_header_video ) && ! the_pipes_is_from_uploads( $the_pipes_header_video ) ) {
	if ( the_pipes_is_youtube_url( $the_pipes_header_video ) && preg_match( '/[=\/]([^=\/]*)$/', $the_pipes_header_video, $matches ) && ! empty( $matches[1] ) ) {
		?><div id="background_video" data-youtube-code="<?php echo esc_attr( $matches[1] ); ?>"></div>
		<?php
	} else {
		?>
		<div id="background_video"><?php the_pipes_show_layout( the_pipes_get_embed_video( $the_pipes_header_video ) ); ?></div>
		<?php
	}
}
