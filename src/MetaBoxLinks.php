<?php

namespace RalfHortt\MetaBoxLinks;

use RalfHortt\MetaBoxes\MetaBox;
use RalfHortt\TranslatorService\Translator;

class MetaBoxLinks extends MetaBox
{
    protected array $links;

    public function __construct(array $screen = [], array $links = ['links' => 'Link'], string $context = 'advanced', string $priority = 'default')
    {
        $this->identifier = apply_filters('wp-meta-box-links/identifier', 'links-data');
        $this->name = apply_filters('wp-meta-box-links/label', __('Links', 'wp-meta-box-links'));
        $this->screen = $screen;
        $this->context = $context;
        $this->priority = $priority;
        $this->links = $links;
    }

    protected function render(\WP_Post $post, array $callbackArgs): void
    {
        $links = get_post_meta($post->ID, '_links', true);
        $fields = apply_filters('wp-meta-box-links/fields', $this->links, $post);
        ?>
        <table class="form-table">
            <?php do_action('wp-meta-box-links/before'); ?>
            <?php foreach ($fields as $field => $label) { ?>
                <tr>
                    <th><label for="wp-meta-box-links-<?= esc_attr($field) ?>"><?= $label ?></label></th>
                    <td>
                        <input
                            type="url"
                            class="large-text"
                            name="wp-meta-box-links[<?= esc_attr($field) ?>]"
                            id="wp-meta-box-links-<?= esc_attr($field) ?>"
                            value="<?php if (isset($links[$field])) { echo esc_attr($links[$field]);} ?>"
                        />
                    </td>
                </tr>
            <?php } ?>
            <?php do_action('wp-meta-box-links/after'); ?>
        </table>
        <?php
        wp_nonce_field('save-wp-meta-box-links', 'wp-meta-box-link-nonce');
    }

    protected function save(int $postId, \WP_Post $post, bool $update): void
    {
        $links = array_map('esc_url_raw', $_POST['wp-meta-box-links']);
        $links = array_filter($links);

        if (empty($_POST['wp-meta-box-links'])) {
            delete_post_meta($postId, '_links');
            return;
        }
        update_post_meta($postId, '_links', $links);
        do_action('wp-meta-box-links/save', $postId, $post);
    }
}
