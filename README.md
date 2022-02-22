# cd-simplesamlphp-auth-wp-plugin

tested with WordPress -v 5.5.3, simplesamlphp -v 1.19.0, configured for use on <b>Pantheon</b> servers only
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

### [Generate certs](https://simplesamlphp.org/docs/stable/simplesamlphp-sp#section_1_1) as needed, and add them to `private/simplesamlphp/cert`.

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

### Clean up and remove the downloaded files

```bash
rm main.zip
rm simplesamlphp-latest.tar.gz
```

- Login into the website and activate the plugin.<br/>
    ![image](https://user-images.githubusercontent.com/4685094/98468714-c4ceaa00-21a9-11eb-9d46-ddc9e057b275.png)

- settings can be configured under settings -> [Simplesamlphp auth](/wp-admin/options-general.php?page=cd-simplesamlphp-auth-wp-plugin)

  - example configuration: ![image](https://user-images.githubusercontent.com/4685094/114222538-ba713180-993c-11eb-9291-243f16fc83cb.png)

- Logout and then Log into site and should be redirected to simplesamlphp auth.

## To apply updates to simplesamlphp

```bash
rm - r private/simplesamlphp
rm - r simplesaml

wget https://simplesamlphp.org/download?latest -O simplesamlphp-latest.tar.gz
mkdir -p private/simplesamlphp
tar -zxf simplesamlphp-latest.tar.gz -C private/simplesamlphp --strip-components 1
ln -s private/simplesamlphp/www simplesaml

rm -r private/simplesamlphp/cert
cp -r private/simplesaml/cert private/simplesamlphp/cert

rm -r private/simplesamlphp/config
rm -r private/simplesamlphp/metadata
cp -r ./private/simplesaml/config ./private/simplesamlphp/config
cp -r ./private/simplesaml/metadata ./private/simplesamlphp/metadata

#clean up
rm simplesamlphp-la
```

## Go Live

register your meta data with Cornell IDM [https://confluence.cornell.edu/display/SHIBBOLETH/Shibboleth+at+Cornell+Page](https://confluence.cornell.edu/display/SHIBBOLETH/Shibboleth+at+Cornell+Page)

Then enable the module on production.

## Sites using this plugin.

- [Engaged Cornell](https://oei.cornell.edu/)
- [The Intergroup Dialogue Project (IDP)](https://idp.cornell.edu/)
- [Cornell University Graduate School](https://gradschool.cornell.edu/)
- [Cornell Grad School]( https://gradschool.cornell.edu/)
