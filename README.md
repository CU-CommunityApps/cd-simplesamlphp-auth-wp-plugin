# cd-simplesamlphp-auth-wp-plugin

tested with WordPress -v 5.5.3, simplesamlphp -v 1.19.0
>Logs a user into WordPress using simplesamlphp

This plugin uses add_filter to modify the authentication function and uses simplesamlphp, instead of login form credentials.

An alternative plugin with additional features can be found here [WP SAML Auth](https://github.com/pantheon-systems/wp-saml-auth)

resources: [Shibboleth at Cornell Page](https://confluence.cornell.edu/display/SHIBBOLETH/Shibboleth+at+Cornell+Page), [saml-20-adp-remote.php](https://confluence.cornell.edu/pages/viewpage.action?pageId=333373586&preview=%2F333373586%2F335416853%2Fsaml20-idp-remote.php)

## Get Started

### Install [SimpleSAMLphp](https://simplesamlphp.org/)  using download method with symbolic link for [Pantheon](https://pantheon.io/docs/shibboleth-sso)

```bash
wget https://simplesamlphp.org/download?latest -O simplesamlphp-latest.tar.gz
mkdir -p private/simplesamlphp
tar -zxf simplesamlphp-latest.tar.gz -C private/simplesamlphp --strip-components 1
ln -s private/simplesamlphp/www simplesaml
```
### Download cd-simplesamlphp-auth-wp-plugin and copy default config

```bash
wget https://github.com/CU-CommunityApps/cd-simplesamlphp-auth-wp-plugin/archive/main.zip
unzip main.zip -d ./wp-content/plugins
mv wp-content/plugins/cd-simplesamlphp-auth-wp-plugin-main wp-content/plugins/cd-simplesamlphp-auth-wp-plugin
mkdir -p private/simplesaml
cp -r wp-content/plugins/cd-simplesamlphp-auth-wp-plugin/docs/config private/simplesaml
cp -r wp-content/plugins/cd-simplesamlphp-auth-wp-plugin/docs/metadata private/simplesaml
```

### [Generate certs](https://simplesamlphp.org/docs/stable/simplesamlphp-sp#section_1_1) as needed, and add them to the repository in `private/simplesamlphp/cert`.

```bash
mkdir private/simplesaml/cert
cd private/simplesaml/cert
# openssl req -newkey rsa:2048 -new -x509 -days 3652 -nodes -out saml.crt -keyout saml.pem
cd ../../../
rm -r private/simplesamlphp/cert
cp -r private/simplesaml/cert private/simplesamlphp/cert
```

### Copy the backed up config to the simpleaml directory

```bash
rm -r private/simplesamlphp/config
rm -r private/simplesamlphp/metadata
cp -r ./private/simplesaml/config ./private/simplesamlphp/config
cp -r ./private/simplesaml/metadata ./private/simplesamlphp/metadata
```

- Login into the website and activate the plugin.
![image](https://user-images.githubusercontent.com/4685094/98468714-c4ceaa00-21a9-11eb-9d46-ddc9e057b275.png)

- settings can be configured under settings -> (Simplesamlphp auth)[/wp-admin/options-general.php?page=cd-simplesamlphp-auth-wp-plugin]

- Log into site and should be redirected to simplesamlphp auth.
