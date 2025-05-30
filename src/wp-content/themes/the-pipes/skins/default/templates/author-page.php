<?php
/**
 * The template to display the user's avatar, bio and socials on the Author page
 *
 * @package THE PIPES
 * @since THE PIPES 1.71.0
 */
?>

<div class="author_page author vcard" itemprop="author" itemscope="itemscope" itemtype="<?php echo esc_attr( the_pipes_get_protocol( true ) ); ?>//schema.org/Person">

	<div class="author_avatar" itemprop="image">
		<?php
		$the_pipes_mult = the_pipes_get_retina_multiplier();
		echo get_avatar( get_the_author_meta( 'user_email' ), 120 * $the_pipes_mult );
		?>
	</div><!-- .author_avatar -->

	<h4 class="author_title" itemprop="name"><span class="fn"><?php the_author(); ?></span></h4>

	<?php
	$the_pipes_author_description = get_the_author_meta( 'description' );
	if ( ! empty( $the_pipes_author_description ) ) {
		?>
		<div class="author_bio" itemprop="description"><?php echo wp_kses( wpautop( $the_pipes_author_description ), 'the_pipes_kses_content' ); ?></div>
		<?php
	}
	?>

	<div class="author_details">
		<span class="author_posts_total">
			<?php
			$the_pipes_posts_total = count_user_posts( get_the_author_meta('ID'), 'post' );
			if ( $the_pipes_posts_total > 0 ) {
				// Translators: Add the author's posts number to the message
				echo wp_kses( sprintf( _n( '%s article published', '%s articles published', $the_pipes_posts_total, 'the-pipes' ),
										'<span class="author_posts_total_value">' . number_format_i18n( $the_pipes_posts_total ) . '</span>'
								 		),
							'the_pipes_kses_content'
							);
			} else {
				esc_html_e( 'No posts published.', 'the-pipes' );
			}
			?>
		</span><?php
			ob_start();
			do_action( 'the_pipes_action_user_meta', 'author-page' );
			$the_pipes_socials = ob_get_contents();
			ob_end_clean();
			the_pipes_show_layout( $the_pipes_socials,
				'<span class="author_socials"><span class="author_socials_caption">' . esc_html__( 'Follow:', 'the-pipes' ) . '</span>',
				'</span>'
			);
		?>
	</div><!-- .author_details -->

</div><!-- .author_page -->
