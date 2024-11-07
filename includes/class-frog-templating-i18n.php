<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://https://github.com/elfedali/
 * @since      1.0.0
 *
 * @package    Frog_Templating
 * @subpackage Frog_Templating/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Frog_Templating
 * @subpackage Frog_Templating/includes
 * @author     Abdessamad EL FEDALI <a.elfedali@gmail.com>
 */
class Frog_Templating_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'frog-templating',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
