<?php
// 'https://idselect.idm.cit.cornell.edu/idselect/select.html'

$idp = ($_ENV['APP_ENV'] == 'production')
    ? 'https://shibidp.cit.cornell.edu/idp/shibboleth'
    : 'https://shibidp-test.cit.cornell.edu/idp/shibboleth';


$weill_idp = ($_ENV['APP_ENV'] == 'production')
    ? 'https://login.weill.cornell.edu/idp'
    : 'https://login-test.weill.cornell.edu/idp';

$config = [

  'admin' => [
    'core:AdminPassword',
  ],

  'default-sp' => [
    'saml:SP',
    'idp' => $idp,
    'privatekey' => 'saml.pem',
    'certificate' => 'saml.crt',
  ],

  'cornell' => [
    'saml:SP',
    'idp' => $idp,
    'privatekey' => 'saml.pem',
    'certificate' => 'saml.crt',
  ],

  'weill' => [
    'saml:SP',
    'idp' => $weill_idp,
    'privatekey' => 'saml.pem',
    'certificate' => 'saml.crt',
  ],

];
