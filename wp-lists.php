<?php
/**
 * @package WP Lists
 */
/*
Plugin Name: Top Ten Lists
Plugin URI: https://wordpress.org/plugins/retro-game-emulator/
Description: Top Ten Lists makes it easy to create popular "Top 10" (or more) style posts.
Version: 1.0.0
Author: grimmdude
Author URI: http://grimmdude.com
Text Domain: top-ten-lists
License: GPLv2 or later
*/

// Make sure we don't expose any info if called directly
if ( ! function_exists('add_action')) {
	exit;
}

if ( ! class_exists('WPLists')) {
	class WPLists
	{
		public function __construct()
		{
			add_action('admin_enqueue_scripts', array($this, 'adminScripts'));
			add_action('add_meta_boxes_post', array($this, 'metaBox'));
			add_action('save_post', array($this, 'savePost'));

			add_filter('the_content', array($this, 'display'));
		}


		public function adminScripts(string $hook)
		{
			wp_enqueue_media();
			wp_register_script('top_ten_lists_admin_js', plugin_dir_url(__FILE__) . 'assets/js/admin.js', array('angular'));
			wp_register_script('angular', plugin_dir_url(__FILE__) . 'assets/js/angular.min.js', array(), '1.6.4');
			wp_enqueue_script('top_ten_lists_admin_js');
			wp_enqueue_script('angular');
		}


		public function listFields(WP_Post $post)
		{
			$list_items = get_post_meta($post->ID, 'top_ten_list', TRUE);
			$upload_link = esc_url( get_upload_iframe_src( 'image', $post->ID ) );
			include plugin_dir_path(__FILE__) . 'views/meta-box.php';
		}


		public function metaBox($post)
		{
			 add_meta_box('wp-post-lists-plugin', __('<span class="dashicons dashicons-editor-ol"></span> Top Ten Lists'), array($this, 'listFields'), 'post', 'normal', 'high');
		}


		public function savePost(int $post_id)
		{
			if (isset($_POST['top_ten_list'])) {
				update_post_meta($post_id, 'top_ten_list', $_POST['top_ten_list']);
			}

			return $post_id;
		}


		public function display(string $content)
		{
			global $post;

			if ($list = get_post_meta($post->ID, 'top_ten_list', TRUE)) {
				if (is_array($list)) {
					ob_start();
					echo '<div class="top-ten-lists-container">';

					foreach ($list as $item) {
						include plugin_dir_path(__FILE__) . 'views/list-item.php';
					}

					echo '</div>';

					$list = ob_get_contents();
					ob_end_clean();

					return $content . $list;
				}
			}

			return $content;
		}

	}

	new WPLists;
}
