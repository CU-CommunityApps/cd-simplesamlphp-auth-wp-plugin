<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/philwilliammee
 * @since      1.0.0
 *
 * @package    Cd_Simplesamlphp_Auth_Wp_Plugin
 * @subpackage Cd_Simplesamlphp_Auth_Wp_Plugin/admin/partials
 */

?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<!-- @todo move options into admin page -->
<?php


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
<h2>CD Simplesamlphp Authentication Options</h2>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>?page=cd-simplesamlphp-auth-wp-plugin&updated=true">
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
