<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://https://github.com/elfedali/
 * @since             1.0.0
 * @package           Frog_Templating
 *
 * @wordpress-plugin
 * Plugin Name:       Frog Templating
 * Plugin URI:        https://wordpress.org/plugins/frog-templating/
 * Description:       Build you website pages using YAML, It supports adding CDN links, inline and external scripts, and content sections with nested elements.

 * Version:           1.0.0
 * Author:            Abdessamad EL FEDALI
 * Author URI:        https://https://github.com/elfedali//
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       frog-templating
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (! defined('WPINC')) {
	die;
}
if (! defined('FROG_TEMPLATING_PLUGIN_DIR')) {
	define('FROG_TEMPLATING_PLUGIN_DIR', plugin_dir_path(__FILE__));
}

use Whoops\Run;
use Whoops\Handler\PrettyPageHandler;

require_once FROG_TEMPLATING_PLUGIN_DIR . 'vendor/autoload.php';


// whoops error handler
// Initialize Whoops
function initialize_whoops()
{
	// Only activate Whoops for admin users or in a development environment
	if (defined('WP_DEBUG') && WP_DEBUG && current_user_can('manage_options')) {
		$whoops = new Run();
		$whoops->pushHandler(new PrettyPageHandler());
		$whoops->register();
	}
}
add_action('plugins_loaded', 'initialize_whoops');

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('FROG_TEMPLATING_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-frog-templating-activator.php
 */
function activate_frog_templating()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-frog-templating-activator.php';
	Frog_Templating_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-frog-templating-deactivator.php
 */
function deactivate_frog_templating()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-frog-templating-deactivator.php';
	Frog_Templating_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_frog_templating');
register_deactivation_hook(__FILE__, 'deactivate_frog_templating');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-frog-templating.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_frog_templating()
{

	$plugin = new Frog_Templating();
	$plugin->run();
}
run_frog_templating();
