<?php
if (!class_exists('WP_Meta_Box_Link')) {
    class WP_Meta_Box_Link
    {
        public function __construct()
        {
            add_action('add_meta_boxes', [$this, 'add_meta_boxes']);
            add_action('save_post', [$this, 'save_post']);
        }

        // END __construct

        /**
         * Register meta box.
         *
         * @return void
         *
         * @author Ralf Hortt <me@horttcore.de>
         **/
        public function add_meta_boxes()
        {
            $post_types = get_post_types_by_support('links');

            foreach ($post_types as $post_type) {
                add_meta_box('post-links', __('Links'), [$this, 'meta_box'], $post_type);
            }
        }

        // END add_meta_boxes

        /**
         * Meta box.
         *
         * @param WP_Post $post Post object
         *
         * @return void
         */
        public function meta_box($post)
        {
            $links = get_post_meta($post->ID, '_links', true);

            $fields = apply_filters('wp-meta-box-links--fields', [
                'links' => __('Link'),
            ], $post); ?>
		<table class="form-table">
			<?php foreach ($fields as $field => $label) { ?>
				<tr>
					<td><label for="wp-meta-box-links-<?php echo esc_attr($field) ?>"><?php echo $label ?></label></td>
					<td>
						<input type="url" class="large-text" name="wp-meta-box-links[<?php echo esc_attr($field) ?>]" value="<?php if (isset($links[$field])) {
            echo esc_attr($links[$field]);
        } ?>" id="wp-meta-box-links-<?php echo esc_attr($field) ?>">
					</td>
				</tr>
			<?php } ?>
		</table>
		<?php

        wp_nonce_field('save-wp-meta-box-links', 'wp-meta-box-link-nonce');
        }

        // END meta_box

        /**
         * Save post meta.
         *
         * @param int $post_id Post ID
         *
         * @author Ralf Hortt
         **/
        public function save_post($post_id)
        {
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return;
            }

            if (!isset($_POST['wp-meta-box-link-nonce']) || !wp_verify_nonce($_POST['wp-meta-box-link-nonce'], 'save-wp-meta-box-links')) {
                return;
            }

            $links = array_map('esc_url_raw', $_POST['wp-meta-box-links']);
            $links = array_filter($links);

            if (empty($_POST['wp-meta-box-links'])) {
                delete_post_meta($post_id, '_links');

                return;
            }

            update_post_meta($post_id, '_links', $links);
        }

        // END save_post
    } // END class WP_Meta_Box_Link
    new WP_Meta_Box_Link();
}
