<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://github.com/philwilliammee
 * @since      1.0.0
 *
 * @package    Cd_Simplesamlphp_Auth_Wp_Plugin
 * @subpackage Cd_Simplesamlphp_Auth_Wp_Plugin/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Cd_Simplesamlphp_Auth_Wp_Plugin
 * @subpackage Cd_Simplesamlphp_Auth_Wp_Plugin/includes
 * @author     Philwilliammee <psw58@cornell.edu>
 */
class Cd_Simplesamlphp_Auth_Wp_Plugin_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'cd-simplesamlphp-auth-wp-plugin',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
