# cd-simplesamlphp-auth-wp-plugin

tested with WordPress -v 5.5.3, simplesamlphp -v 1.19.0
>Logs a user into WordPress using simplesamlphp

This plugin uses add_filter to modify the authentication function and uses simplesamlphp, instead of login form credentials.

An alternative plugin with additional features can be found here [WP SAML Auth](https://github.com/pantheon-systems/wp-saml-auth)

resources: [Shibboleth at Cornell Page](https://confluence.cornell.edu/display/SHIBBOLETH/Shibboleth+at+Cornell+Page), [saml-20-adp-remote.php](https://confluence.cornell.edu/pages/viewpage.action?pageId=333373586&preview=%2F333373586%2F335416853%2Fsaml20-idp-remote.php)

## Get Started

### Install simplesamlphp using download method with symbolic link

[from the pantheon docs](https://pantheon.io/docs/shibboleth-sso)

- Download [SimpleSAMLphp](https://simplesamlphp.org/) and add it to your git repository as

```bash
wget https://simplesamlphp.org/download?latest -O simplesamlphp-latest.tar.gz
mkdir -p private/simplesamlphp
tar -zxf simplesamlphp-latest.tar.gz -C private/simplesamlphp --strip-components 1
git add private
git commit -am "Adding SimpleSAML"
```

- Add a symlink to your repository from /simplesaml to /private/simplesamlphp/www:

```bash
ln -s private/simplesamlphp/www simplesaml
git add simplesaml
git commit -am "Adding SimpleSAML symlink"
```

- [Generate or install certs](https://simplesamlphp.org/docs/stable/simplesamlphp-sp#section_1_1) as needed, and add them to the repository in `private/simplesamlphp/cert`.

```bash
cd private/simplesaml/cert
openssl req -newkey rsa:2048 -new -x509 -days 3652 -nodes -out saml.crt -keyout saml.pem
```

### Install the cd-simplesamlphp-auth-wp-plugin

- Get the code from github, here we will use direct download but you can use composer.

```bash
wget https://github.com/CU-CommunityApps/cd-simplesamlphp-auth-wp-plugin/archive/main.zip
unzip https://github.com/CU-CommunityApps/cd-simplesamlphp-auth-wp-plugin/archive/main.zip -d ./wp-content/plugins
```

- The plugin comes with some default configurations installed in docs folder. Copy them to private/simplesaml/

```bash
cp -r wp-content/plugins/cd-simplesamlphp-auth-wp-plugin/docs/config private/simplesaml
cp -r wp-content/plugins/cd-simplesamlphp-auth-wp-plugin/docs/metadata private/simplesaml
```

- Install the plugin requires wp-cli or log into the site and activate the plugin.

```bash
wp plugin cd-simplesamlphp-auth-wp-plugin activate
```

- Log into site and should be redirected to simplesamlphp auth.
