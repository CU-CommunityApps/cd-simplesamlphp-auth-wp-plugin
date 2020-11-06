<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/philwilliammee
 * @since      1.0.0
 *
 * @package    Cd_Simplesamlphp_Auth_Wp_Plugin
 * @subpackage Cd_Simplesamlphp_Auth_Wp_Plugin/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Cd_Simplesamlphp_Auth_Wp_Plugin
 * @subpackage Cd_Simplesamlphp_Auth_Wp_Plugin/includes
 * @author     Philwilliammee <psw58@cornell.edu>
 */
class Cd_Simplesamlphp_Auth_Wp_Plugin {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Cd_Simplesamlphp_Auth_Wp_Plugin_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'CD_SIMPLESAMLPHP_AUTH_WP_PLUGIN_VERSION' ) ) {
			$this->version = CD_SIMPLESAMLPHP_AUTH_WP_PLUGIN_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'cd-simplesamlphp-auth-wp-plugin';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Cd_Simplesamlphp_Auth_Wp_Plugin_Loader. Orchestrates the hooks of the plugin.
	 * - Cd_Simplesamlphp_Auth_Wp_Plugin_i18n. Defines internationalization functionality.
	 * - Cd_Simplesamlphp_Auth_Wp_Plugin_Admin. Defines all hooks for the admin area.
	 * - Cd_Simplesamlphp_Auth_Wp_Plugin_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-cd-simplesamlphp-auth-wp-plugin-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-cd-simplesamlphp-auth-wp-plugin-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-cd-simplesamlphp-auth-wp-plugin-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-cd-simplesamlphp-auth-wp-plugin-public.php';

		$this->loader = new Cd_Simplesamlphp_Auth_Wp_Plugin_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Cd_Simplesamlphp_Auth_Wp_Plugin_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Cd_Simplesamlphp_Auth_Wp_Plugin_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Cd_Simplesamlphp_Auth_Wp_Plugin_Admin( $this->get_plugin_name(), $this->get_version() );

		// $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		// $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		// Displays settings in admin menu.
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_plugin_options_page', 9 );
		// Database settings used by plugin.
		// $this->loader->add_action( 'admin_init', $plugin_admin, 'register_and_build_fields' );

		$this->loader->add_filter( 'authenticate', $plugin_admin, 'authenticate', 10, 2 );
		$this->loader->add_action( 'wp_logout', $plugin_admin, 'logout' );
		$this->loader->add_action( 'lost_password', $plugin_admin, 'disable_function' );
		$this->loader->add_action( 'retrieve_password', $plugin_admin, 'disable_function' );
		$this->loader->add_action( 'password_reset', $plugin_admin, 'disable_function' );
		$this->loader->add_filter( 'show_password_fields', $plugin_admin, 'show_password_fields' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Cd_Simplesamlphp_Auth_Wp_Plugin_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Cd_Simplesamlphp_Auth_Wp_Plugin_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
