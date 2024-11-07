<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://https://github.com/elfedali/
 * @since      1.0.0
 *
 * @package    Frog_Templating
 * @subpackage Frog_Templating/admin
 */

use Frog\Templating\Core\BuildHTML;

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Frog_Templating
 * @subpackage Frog_Templating/admin
 * @author     Abdessamad EL FEDALI <a.elfedali@gmail.com>
 */
class Frog_Templating_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Frog_Templating_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Frog_Templating_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/frog-templating-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Frog_Templating_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Frog_Templating_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/frog-templating-admin.js', array('jquery'), $this->version, false);
	}

	public function  add_frog_metabox()
	{
		add_meta_box(
			'frog_metabox', // Unique ID
			__('Frog Yaml templating'),         // Box title
			array($this, 'display_frog_metabox'),  // Content callback, must be of type callable
			'page'          // Post type where the box appears
		);
	}

	/**
	 * Display the metabox
	 */
	public  function display_frog_metabox($post)
	{
		// Add nonce for security and authentication
		wp_nonce_field('frog_nonce_action', 'frog_nonce');

		$frog_description = get_post_meta($post->ID, '_frog_description', true);


		// echo '<p><label for="frog_description">Frog templating</label></p>';
		echo '<textarea id="frog_description" name="frog_description">' . esc_textarea($frog_description) . '</textarea>';
	}

	/**
	 * Save the metabox data
	 */
	public function save_frog_metabox($post_id)
	{

		// Verify nonce for security
		if (!isset($_POST['frog_nonce']) || !wp_verify_nonce($_POST['frog_nonce'], 'frog_nonce_action')) {
			return;
		}

		// Check autosave and user permission
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
		if (!current_user_can('edit_page', $post_id)) return;



		// Save Frog Description
		if (isset($_POST['frog_description'])) {
			update_post_meta($post_id, '_frog_description', sanitize_textarea_field($_POST['frog_description']));
		}
	}


	public function enqueue_codemirror_assets($hook)
	{
		// Only load on the page editor screen
		if ($hook !== 'post.php' && $hook !== 'post-new.php') return;

		// Enqueue CodeMirror scripts and styles
		wp_enqueue_script('codemirror-js', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/codemirror.min.js', array(), null, true);
		wp_enqueue_script('codemirror-mode-js', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/yaml/yaml.min.js', array('codemirror-js'), null, true);
		wp_enqueue_style('codemirror-css', 'https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/codemirror.min.css');

		// Enqueue custom script to initialize CodeMirror
		wp_enqueue_script('init-codemirror', plugin_dir_url(__FILE__) . 'js/init-codemirror.js', array('codemirror-js'), null, true);
	}


	public function append_frog_description_to_content($content)
	{
		if (is_singular('page')) {
			global $post;
			if (get_post_meta($post->ID, '_frog_description', true)) {
				// Get the Frog Description meta data
				$frog_description = get_post_meta($post->ID, '_frog_description', true);
				$builder = new BuildHTML();
				$html = $builder->buildFromString($frog_description);

				// Append Frog Description to the page content
				if (!empty($frog_description)) {
					$content .= $html;
				}
			}
		}

		return $content;
	}
}
