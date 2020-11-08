<?php

// Pantheon specific.
$idp = (isset($_SERVER['PANTHEON_ENVIRONMENT']) && $_SERVER['PANTHEON_ENVIRONMENT'] == 'live')
  ? 'https://shibidp.cit.cornell.edu/idp/shibboleth'
  : 'https://shibidp-test.cit.cornell.edu/idp/shibboleth';

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

];
