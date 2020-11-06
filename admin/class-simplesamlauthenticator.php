<?php
/**
 * Plugin Name: CD SimpleSAMLphp Authentication
 * Version: 1.0.0
 *
 * Plugin URI: 'https://github.com/CU-CommunityApps/'
 * Description: Authenticate users using <a href="http://simplesamlphp.org">simpleSAMLphp</a>.
 * Author: Phil Williammee
 * Author URI: https://github.com/CU-CommunityApps/
 * Credits: David O'Callaghan
 *
 * @package cd-simpleamlphp-authentication
 * @todo move this into a proper plugin.
 */

// Version logic.
$version = '1.0.0';
$previous_version = get_option( 'simplesaml_authentication_version' );
if ( ! $previous_version ) {
	update_option( 'simplesaml_authentication_version', $version );
}

add_action( 'admin_menu', 'simplesaml_authentication_add_options_page' );

$simplesaml_authentication_opt = get_option( 'simplesaml_authentication_options' );

$simplesaml_configured = true;


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

if ( ! class_exists( 'SimpleSAMLAuthenticator' ) ) {

	/**
	 * Undocumented class
	 */
	class SimpleSAMLAuthenticator {

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

			global $simplesaml_authentication_opt, $simplesaml_configured, $auth;

			if ( ! $simplesaml_configured ) {
				echo 'simplesaml-authentication plugin not configured' ;
				return;
			}

			// Reset value from input ($_POST and $_COOKIE).
			$user_email = '';

			$site_url = get_site_url();
			// Don't redirect to wp-login.php. adds relay state to login.
			$auth->requireAuth(
				[
					'ReturnTo' => "$site_url/login/",
					'KeepPost' => false,
				]
			);

			$attributes = $auth->getAttributes();
			$username = $this->get_username( $simplesaml_authentication_opt, $attributes );
			$user_email = $this->get_email( $simplesaml_authentication_opt, $attributes, $username );
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
				if ( 1 == $simplesaml_authentication_opt['new_user'] ) {
					// Load Password Hasher.
					require_once( ABSPATH . 'wp-includes/class-phpass.php' );
					$user_info = [
						'user_login' => $username,
						'user_pass' => new PasswordHash( 8, true ),
						'user_email' => $user_email,
						'first_name' => $this->get_first_name( $simplesaml_authentication_opt, $attributes ),
						'last_name' => $this->get_last_name( $simplesaml_authentication_opt, $attributes ),
					];

					// @todo we could use ldap to set this. $user_info['role'] = 'administrator';
					$wp_uid = wp_insert_user( $user_info );

					// @todo handle  wp_insert_user errors.
					if ( is_numeric( $wp_uid ) ) {
						$user = get_user_by( 'email', $user_email );
					}
				} else {
					$this->display_invalid_user_message( $user_email );
				}
			}
		}

		/**
		 * Undocumented function
		 *
		 * @return void
		 */
		function logout() {
			global $simplesaml_authentication_opt, $simplesaml_configured, $auth;
			if ( ! $simplesaml_configured ) {
				echo 'simplesaml-authentication not configured';
				return;
			}
			$auth->logout( get_option( 'siteurl' ) );
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
			// If we exit here we can hide the default login page.
			// exit();
		}

		/**
		 * Gets the username from attributes
		 *
		 * @param array $sa_opt the $simplesaml_authentication_opt.
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
		 * @param array  $sa_opt The $simplesaml_authentication_opt.
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
		 * @param array $sa_opt The $simplesaml_authentication_opt.
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
		 * @param array $sa_opt The $simplesaml_authentication_opt.
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
}

/**
 * Writes to the error logger
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

// Try to configure the simpleSAMLphp client.
if ( '' == $simplesaml_authentication_opt['include_path'] ) {
	$simplesaml_configured = false;
} else {
	$include_file = ABSPATH . $simplesaml_authentication_opt['include_path'] . '/lib/_autoload.php';
	// $include_file = dirname(__FILE__) . '/../../../private/simplesamlphp/lib/_autoload.php';
	// write_log($include_file);
	if ( file_exists( $include_file ) && is_readable( $include_file ) ) {
		require_once $include_file;
	} else {
		$simplesaml_configured = false;
	}
}

if ( $simplesaml_configured ) {
	$sp_auth = ( '' === $simplesaml_authentication_opt['sp_auth'] ) ? 'default-sp' : $simplesaml_authentication_opt['sp_auth'];
	$auth = new SimpleSAML\Auth\Simple( $sp_auth );
}

/*
	Plugin hooks into authentication system
*/
$saml_authenticator = new SimpleSAMLAuthenticator();
add_filter( 'authenticate', [ $saml_authenticator, 'authenticate' ], 10, 2 );
add_action( 'wp_logout', [ $saml_authenticator, 'logout' ] );
add_action( 'lost_password', [ $saml_authenticator, 'disable_function' ] );
add_action( 'retrieve_password', [ $saml_authenticator, 'disable_function' ] );
add_action( 'password_reset', [ $saml_authenticator, 'disable_function' ] );
add_filter( 'show_password_fields', [ $saml_authenticator, 'show_password_fields' ] );


// Single Logout.
$slo = $simplesaml_authentication_opt['slo'];
if ( $slo && ! function_exists( 'is_user_logged_in' ) && $simplesaml_configured ) {
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
				global $simplesaml_authentication_opt;
				$sp_auth = ( '' === $simplesaml_authentication_opt['sp_auth']) ? 'default-sp' : $simplesaml_authentication_opt['sp_auth'];
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

/**
 * ----------------------------------------------------------------------------
 *                        ADMIN OPTION PAGE FUNCTIONS
 * ----------------------------------------------------------------------------
 */

/**
 * Undocumented function
 *
 * @return void
 */
function simplesaml_authentication_add_options_page() {
	if ( function_exists( 'add_options_page' ) ) {
		add_options_page(
			'simpleSAMLphp Authentication',
			'simpleSAMLphp Authentication',
			'manage_options',
			basename( __FILE__ ), 'simplesaml_authentication_options_page'
		);
	}
}

/**
 * The settings form.
 *
 * @return void
 */
function simplesaml_authentication_options_page() {
	global $wpdb;

	// Default options.
	$options = [
		'new_user' => false,
		'slo' => false,
		'redirect_url' => '',
		'email_suffix' => 'example.com',
		'sp_auth' => 'default-sp',
		'username_attribute' => 'uid',
		'firstname_attribute' => 'givenName',
		'lastname_attribute' => 'sn',
		'email_attribute' => 'mail',
		'include_path' => 'private/simplesamlphp',
		'admin_entitlement' => '',
		'default_role' => 'author',
	];

	if ( isset( $_POST['submit'] ) ) {
		// Create updated options, loop through original one to get keys.
		$options_updated = [];
		foreach(array_keys($options) as $key) {
			$options_updated[$key] = isset($_POST[$key]) ? $_POST[$key] : $options[$key];
		}

		update_option('simplesaml_authentication_options', $options_updated);
	}

	// Get Options
	$options = get_option('simplesaml_authentication_options');

	?>

<div class="wrap">
<h2>SimpleSAMLphp Authentication Options</h2>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'] . '?page=' . basename(__FILE__); ?>&updated=true">
<fieldset class="options">
<h3>User registration options</h3>
<table class="form-table">
	<tr valign="top">
		<th scope="row">User registration</th>
		<td>
		<label for="new_user"><input name="new_user" type="checkbox" id="new_user_inp" value="1" <?php checked('1', $options['new_user']); ?> />Automatically register new users</label>
		<span class="setting-description">(Users will be registered with the default role.)</span>
		</td>
	</tr>
	<tr>
		<th><label for="default_role">Default Role</label></th>
		<td><input type="text" name="default_role" id="default_role_inp" value="<?php echo $options['default_role']; ?>" size="40" />
		<span class="setting-description">The default WordPress role for new users (e.g. author or subscriber).</span>
		</td>
	</tr>
	<!--
	<tr>
	<th><label for="email_suffix"> Default email domain</label></th>
	<td>
	<input type="text" name="email_suffix" id="email_suffix_inp" value="<?php echo $options['email_suffix']; ?>" size="35" />
	<span class="setting-description">If an email address is not available from the <acronym title="Identity Provider">IdP</acronym> <strong>username@domain</strong> will be used.</td>
	</tr>
	-->
	<!-- <tr>
		<th><label for="admin_entitlement">Administrator Entitlement URI</label></th>
		<td><input type="text" name="admin_entitlement" id="admin_entitlement_inp" value="<?php echo $options['admin_entitlement']; ?>" size="40" />
		<span class="setting-description">An eduPersonEntitlement URI to be mapped to the Administrator role.</span>
		</td>
	</tr> -->
</table>

<h3>SimpleSAMLphp options</h3>
<p><em>Note:</em> Once you fill in these options, WordPress authentication will happen through <a href="http://simplesamlphp.org">simpleSAMLphp</a>, even if you misconfigure it. To avoid being locked out of WordPress, use a second browser to check your settings before you end this session as Administrator. If you get an error in the other browser, correct your settings here. If you can not resolve the issue, disable this plug-in.</p>

<table class="form-table">
	<tr valign="top">
		<th scope="row"><label for="include_path">Path to simpleSAMLphp</label></th>
		<td><input type="text" name="include_path" id="include_path_inp" value="<?php echo $options['include_path']; ?>" size="35" />
		<span class="setting-description">SimpleSAMLphp suggested location is <tt>private/simplesamlphp</tt>.</span>
		</td>
	</tr>

	<tr valign="top">
		<th scope="row"><label for="sp_auth">Authentication source</label></th>
		<td><input type="text" name="sp_auth" id="sp_auth_inp" value="<?php echo $options['sp_auth']; ?>" size="35" />
		<span class="setting-description">SimpleSAMLphp default is "default-sp".</span>
		</td>
	</tr>

	<tr valign="top">
		<th scope="row"><label for="username_attribute">Attribute to be used as username</label></th>
		<td><input type="text" name="username_attribute" id="username_attribute_inp" value="<?php echo $options['username_attribute']; ?>" size="35" />
		<span class="setting-description">Default is "uid".</span>
		</td>
	</tr>

		<tr valign="top">
		<th scope="row"><label for="firstname_attribute">Attribute to be used as First Name</label></th>
		<td><input type="text" name="firstname_attribute" id="firstname_attribute_inp" value="<?php echo $options['firstname_attribute']; ?>" size="35" />
		<span class="setting-description">Default is "givenName".</span>
		</td>
	</tr>

		<tr valign="top">
		<th scope="row"><label for="lastname_attribute">Attribute to be used as Last Name</label></th>
		<td><input type="text" name="lastname_attribute" id="lastname_attribute_inp" value="<?php echo $options['lastname_attribute']; ?>" size="35" />
		<span class="setting-description">Default is "sn".</span>
		</td>
	</tr>

		<tr valign="top">
		<th scope="row"><label for="email_attribute">Attribute to be used as E-mail</label></th>
		<td><input type="text" name="email_attribute" id="email_attribute_inp" value="<?php echo $options['email_attribute']; ?>" size="35" />
		<span class="setting-description">Default is "mail".</span>
		</td>
	</tr>

	<tr valign="top">
		<th scope="row"><label for="slo">Single Log Out</label></th>
		<td><input type="checkbox" name="slo" id="slo" value="1" <?php checked('1', $options['slo']); ?> />
		<span class="setting-description">Enable Single Log Out</span>
		</td>
	</tr>
</table>
</fieldset>
<div class="submit">
	<input type="submit" name="submit" value="<?php _e('Update Options') ?> &raquo;" />
</div>
</form>

	<?php
}
