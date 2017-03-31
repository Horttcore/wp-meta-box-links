<?php
if ( !class_exists( 'WP_Meta_Box_Link' ) ) :

/**
 *
 */
class WP_Meta_Box_Link
{



	function __construct()
	{

		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_post' ) );

	} // END __construct



	/**
	 * Register meta box
	 *
	 * @access public
	 * @return void
	 * @author Ralf Hortt <me@horttcore.de>
	 **/
	public function add_meta_boxes()
	{

		$post_types = get_post_types_by_support( 'link' );

		foreach ( $post_types as $post_type ) :

			add_meta_box( 'page-link', __( 'Links' ), array( $this, 'meta_box' ), $post_type );

		endforeach;

	} // END add_meta_boxes



	/**
	 * Meta box
	 *
	 * @param WP_Post $post Post object
	 * @return void
	 */
	public function meta_box( $post )
	{

		$link = get_post_meta( $post->ID, '_link', TRUE );

		?>
		<table class="form-table">
			<tr>
				<td><label for="wp-meta-box-link ?>"><?php _e( 'Link' ) ?></label></td>
				<td>
					<input class="regular-text" type="text" name="wp-meta-box-link" value="<?php if ( isset( $link ) ) echo esc_url_raw( $link ) ?>" id="wp-meta-box-link">
				</td>
			</tr>
		</table>
		<?php

		wp_nonce_field( 'save-wp-meta-box-link', 'wp-meta-box-link-nonce' );

	} // END meta_box



	/**
	 * Save post meta
	 *
	 * @access public
	 * @param int $post_id Post ID
	 * @author Ralf Hortt
	 **/
	public function save_post( $post_id )
	{

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return;

		if ( !isset( $_POST['wp-meta-box-link-nonce'] ) || !wp_verify_nonce( $_POST['wp-meta-box-link-nonce'], 'save-wp-meta-box-link' ) )
			return;

		if ( !empty( $_POST['wp-meta-box-link'] ) )
			update_post_meta( $post_id, '_link', esc_url_raw( $_POST['wp-meta-box-link'] ) );
		else
			delete_post_meta( $post_id, '_link' );

	} // END save_post



} // END class WP_Meta_Box_Link
new WP_Meta_Box_Link;

endif;
