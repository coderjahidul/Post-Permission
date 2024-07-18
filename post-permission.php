<?php
/**
 * Post Permission
 *
 * @package       POSTPERMIS
 * @author        Jahidul islam Sabuz
 * @version       1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:   Post Permission
 * Plugin URI:    https://github.com/coderjahidul/Post-Permission.git
 * Description:   This is some demo short description...
 * Version:       1.0.0
 * Author:        Jahidul islam Sabuz
 * Author URI:    https://grocoder.com
 * Text Domain:   post-permission
 * Domain Path:   /languages
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

// Add custom column to post list
function nq_add_noindex_column($columns) {
    $columns['noindex'] = 'Noindex';
    return $columns;
}
add_filter('manage_posts_columns', 'nq_add_noindex_column');

// Show custom column value
function nq_show_noindex_column($column, $post_id) {
    if ($column === 'noindex') {
        $noindex = get_post_meta($post_id, '_noindex', true);
        echo $noindex ? 'Yes' : 'No';
    }
}
add_action('manage_posts_custom_column', 'nq_show_noindex_column', 10, 2);

// Add Quick Edit field
function nq_add_noindex_quick_edit($column_name, $post_type) {
    if ($column_name !== 'noindex') {
        return;
    }
    ?>
    <fieldset class="inline-edit-col-right inline-edit-noindex">
        <div class="inline-edit-col">
            <label class="alignleft">
                <span class="title">Noindex</span>
                <span class="input-text-wrap">
                    <input type="checkbox" name="noindex" value="1">
                </span>
            </label>
        </div>
    </fieldset>
    <?php
}
add_action('quick_edit_custom_box', 'nq_add_noindex_quick_edit', 10, 2);

// Enqueue JavaScript for Quick Edit
function nq_enqueue_quick_edit_noindex_script($hook) {
    if ($hook !== 'edit.php') {
        return;
    }
    wp_enqueue_script('quick-edit-noindex', plugin_dir_url(__FILE__) . 'js/quick-edit-noindex.js', array('jquery', 'inline-edit-post'), '', true);
}
add_action('admin_enqueue_scripts', 'nq_enqueue_quick_edit_noindex_script');

// Save custom field value
function nq_save_noindex_quick_edit($post_id) {
    if (isset($_POST['noindex'])) {
        update_post_meta($post_id, '_noindex', '1');
    } else {
        delete_post_meta($post_id, '_noindex');
    }
}
add_action('save_post', 'nq_save_noindex_quick_edit');