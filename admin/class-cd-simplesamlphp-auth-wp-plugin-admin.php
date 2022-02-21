<?php
/**
 * The admin-specific functionality of the plugin.
 * User authentication via simplesamlphp. Some of this code could be refactored.
 *
 * @link       https://github.com/philwilliammee
 * @since      1.0.0
 *
 * @package    Cd_Simplesamlphp_Auth_Wp_Plugin
 * @subpackage Cd_Simplesamlphp_Auth_Wp_Plugin/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Cd_Simplesamlphp_Auth_Wp_Plugin
 * @subpackage Cd_Simplesamlphp_Auth_Wp_Plugin/admin
 * @author     Philwilliammee <psw58@cornell.edu>
 */
class Cd_Simplesamlphp_Auth_Wp_Plugin_Admin {

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
	 * The data options.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $options    The current version of this plugin.
	 */
	private $options;

	/**
	 * Helper class for simple authentication applications.
	 *
	 * @var \SimpleSAML\Auth\Simple
	 */
	private $auth;

	/**
	 * Check if setting options are set.
	 *
	 * @var boolean
	 */
	private $simplesaml_configured;


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param    string $plugin_name       The name of this plugin.
	 * @param    string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->options = get_option( 'simplesaml_authentication_options' );
		$this->simplesaml_configured = true;
		$this->init_simple_saml();
	}

	/**
	 * Adds the plugin to the admin menu.
	 */
	public function add_plugin_options_page() {
		add_options_page(
			$this->plugin_name,
			'Simplesamlphp Auth',
			'manage_options',
			$this->plugin_name,
			[ $this, 'display_plugin_options_page' ],
			26
		);
	}

	/**
	 * Loads the template.
	 */
	public function display_plugin_options_page() {
		require_once 'partials/' . $this->plugin_name . '-admin-display.php';
	}

	/**
	 * Initializes simple saml.
	 */
	private function init_simple_saml() {
		// Try to configure the simpleSAMLphp client.
		if ( '' == $this->options['include_path'] ) {
			$this->simplesaml_configured = false;
		} else {
			$include_file = ABSPATH . $this->options['include_path'] . '/lib/_autoload.php';
			if ( file_exists( $include_file ) && is_readable( $include_file ) ) {
				require_once $include_file;
			} else {
				$this->simplesaml_configured = false;
			}
		}

		if ( $this->simplesaml_configured ) {
			global $auth;
			$sp_auth = ( '' === $this->options['sp_auth'] ) ? 'default-sp' : $this->options['sp_auth'];
			if ( ! isset( $auth ) ) {
				$this->auth = new SimpleSAML\Auth\Simple( $sp_auth );
				$auth = $this->auth;
			} else {
				$this->auth = $auth;
			}
		}
	}

	/**
	 * Filters whether a set of user login credentials are valid.
	 *
	 * @param null|WP_User|WP_Error $user The user email.
	 * @param string                $username The users name.
	 * @return mixed
	 */
	function authenticate( $user, $username ) {

		if ( is_a( $user, 'WP_User' ) ) {
			return $user;
		}

		if ( ! $this->simplesaml_configured ) {
			echo 'simplesaml-authentication plugin not configured' ;
			return;
		}

		// Reset value from input ($_POST and $_COOKIE).
		$user_email = '';

		$site_url = get_site_url();

		// Don't redirect to wp-login.php. adds relay state to login.
		$this->auth->requireAuth(
			[
				'ReturnTo' => "$site_url/login/",
				'KeepPost' => false,
			]
		);

		$attributes = $this->auth->getAttributes();
		$username = $this->get_username( $this->options, $attributes );
		$user_email = $this->get_email( $this->options, $attributes, $username );
		$this->validate_email( $user_email );
		$user = get_user_by( 'email', $user_email );

		if ( $user ) {
			// user already exists.
			return $user;
		} else {
			// First time logging in.
			// Auto-registration is enabled
			// User is not in the WordPress database
			// They passed SimpleSAML and so are authorized
			// Add them to the database.
			// User must have an e-mail address to register.
			if ( 1 == $this->options['new_user'] ) {
				$user_info = [
					'user_login' => $username,
					'user_pass' => rand_string( 8 ),
					'user_email' => $user_email,
					'first_name' => $this->get_first_name( $this->options, $attributes ),
					'last_name' => $this->get_last_name( $this->options, $attributes ),
				];

				// @todo we could use ldap to set this. $user_info['role'] = 'administrator';
				$wp_uid = wp_insert_user( $user_info );

				// @todo handle  wp_insert_user errors.
				if ( is_numeric( $wp_uid ) ) {
					$user = get_user_by( 'email', $user_email );
					$user->set_role( $this->options['default_role'] );
					return $user;
				}
			} else {
				$this->display_invalid_user_message( $user_email );
			}
		}
	}

	/**
	 * Logout user.
	 *
	 * @return void
	 */
	function logout() {
		if ( ! $this->simplesaml_configured || ! isset( $this->auth ) ) {
			echo 'simplesaml-authentication not configured';
			return;
		}
		$this->auth->logout( get_option( 'siteurl' ) );
	}

	/**
	 * Don't show password fields on user profile page.
	 *
	 * @param bool $show_password_fields Unused.
	 * @return bool
	 */
	function show_password_fields( $show_password_fields ) {
		return false;
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	function disable_function() {
		die( 'Disabled' );
	}

	/**
	 * Validates email is a string.
	 *
	 * @param string $user_email The user email returned from simplesaml.
	 * @return void
	 */
	private function validate_email( $user_email ) {
		$sanitized_email = sanitize_email( $user_email, true );
		if ( substr( $sanitized_email, 0, 60 ) !== $user_email ) {
			$admin_email = get_option( 'admin_email' );
			$error = <<<EOD
<p><strong>ERROR</strong><br /><br />
We got back the following identifier from the login process:<pre>$user_email</pre>
Unfortunately that is not suitable as a user email.<br />
Please contact the <a href="mailto:$admin_email">blog administrator</a> and ask to reconfigure the
simpleSAMLphp plugin!</p>
EOD;
			$errors['registerfail'] = $error;
			echo wp_kses( $error, allowed_html() );
			exit();
		}
	}

	/**
	 * Shows a invalid user message.
	 *
	 * @param string $user_email The auth user email.
	 * @return void
	 */
	private function display_invalid_user_message( $user_email ) {
		$admin_email = get_option( 'admin_email' );
		$error = <<<EOD
<p style="max-width:320px; margin:auto; padding-top:50px;"><strong>Invalid</strong>: $user_email is not a registered user.
Please contact the <a href='mailto:$admin_email'>site administrator</a> to create a new
account!</p>
EOD;
		$errors['registerfail'] = $error;
		echo wp_kses( $error, allowed_html() );
		echo wp_kses( "<p style='max-width:320px; margin:auto'><a href='/wp-login.php?action=logout'>Log out</a> of Cornell's authentication.</p>", allowed_html() );
		// If we exit here we can hide the default login page; exit().
	}

	/**
	 * Gets the username from attributes
	 *
	 * @param array $sa_opt the $this->options.
	 * @param array $attributes The simple saml attributes.
	 * @return string
	 */
	private function get_username( &$sa_opt, &$attributes ) {
		$username = '';
		if ( empty( $sa_opt['username_attribute'] ) ) {
			$username = $attributes['uid'][0];
		} else {
			$username = $attributes[ $sa_opt['username_attribute'] ][0];
		}
		return $username;
	}

	/**
	 * Gets users email from params
	 *
	 * @param array  $sa_opt The $this->options.
	 * @param array  $attributes The user name to fallback for email.
	 * @param string $username The user name to fallback for email.
	 * @return string
	 */
	private function get_email( &$sa_opt, &$attributes, $username = '' ) {
		$email_attribute = empty( $sa_opt['email_attribute'] ) ? 'mail' : $sa_opt['email_attribute'];

		if ( $attributes[ $email_attribute ][0] ) {
			// Try to get email address from attribute.
			return $attributes[ $email_attribute ][0];
		}
		// Otherwise use default email suffix.
		return $username . '@cornell.edu';
	}

	/**
	 * Gets the first name from attributes.
	 *
	 * @param array $sa_opt The $this->options.
	 * @param array $attributes The user name to fallback for email.
	 * @return string
	 */
	private function get_first_name( &$sa_opt, &$attributes ) {
		if ( empty( $sa_opt['firstname_attribute'] ) ) {
			return $attributes['givenName'][0];
		}
		return  $attributes[ $sa_opt['firstname_attribute'] ][0];
	}

	/**
	 * Gets the last name from attributes.
	 *
	 * @param array $sa_opt The $this->options.
	 * @param array $attributes The user name to fallback for email.
	 * @return string
	 */
	private function get_last_name( &$sa_opt, &$attributes ) {
		if ( empty( $sa_opt['firstname_attribute'] ) ) {
			return $attributes['sn'][0];
		}
		return  $attributes[ $sa_opt['lastname_attribute'] ][0];
	}
}

$options = get_option( 'simplesaml_authentication_options' );
if ( $options['slo'] && ! function_exists( 'is_user_logged_in' ) ) {
	/**
	 * Log the user out from WordPress if the simpleSAMLphp SP session is gone.
	 * This function overrides the is_logged_in function from wp core.
	 * (Another solution could be to extend the wp_validate_auth_cookie func instead).
	 *
	 * @return boolean
	 */
	function is_user_logged_in() {
		global $auth;
		$user = wp_get_current_user();
		if ( $user->ID > 0 ) {
			// User is local authenticated but SP session was closed.
			if ( ! isset( $auth ) ) {
				$sp_auth = ( '' === $options['sp_auth']) ? 'default-sp' : $options['sp_auth'];
				$auth = new SimpleSAML\Auth\Simple( $sp_auth );
			}

			if ( ! $auth->isAuthenticated() ) {
				wp_logout();
				return false;
			} else {
				return true;
			}
		}
		return false;
	}
}


if ( ! function_exists( 'allowed_html' ) ) {
	/**
	 * Allowed html elements.
	 *
	 * @return array
	 */
	function allowed_html() {
		$allowed_html = [
			'div' => [],
			'p' => [
				'class' => true,
				'style' => [
					'max-width' => true,
					'margin' => true,
					'padding' => true,
				],
			],
			'a' => [
				'href' => true,
				'title' => true,
				'class' => true,
			],
			'span' => [
				'class' => true,
			],
			'b' => [],
			'em' => [],
			'i' => [],
			'strong' => [],

		];
		return $allowed_html;
	}
}

/**
 * Generates a random string
 *
 * @param [type] $length The length of the password.
 * @return string
 */
function rand_string( $length ) {
	$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	return substr( str_shuffle( $chars ), 0, $length );
}



if ( ! function_exists( 'write_log' ) ) {
	/**
	 * Helper function for debugging.
	 *
	 * @param mixed $log The content to log.
	 */
	function write_log( $log ) {
		if ( is_array( $log ) || is_object( $log ) ) {
			$log = wp_json_encode( $log );
		}
		if ( true === WP_DEBUG ) {
			error_log( $log );
		}
	}
}
