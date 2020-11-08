<?php
$_SERVER['SERVER_PORT'] = 443;
$host = $_SERVER['HTTP_HOST'];

require_once __DIR__.'/../../../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../../..');
$dotenv->load();
$db = [
    'port' => $_ENV['DB_PORT'],
    'host' => $_ENV['DB_HOST'],
    'database' => $_ENV['DB_DATABASE'],
    'username' => $_ENV['DB_USERNAME'],
    'password' => $_ENV['DB_PASSWORD'],
];

/*
 * @see vendor/simplesamlphp/simplesamlphp/config-templates/config.php
 */
$config = [
  'baseurlpath' => 'https://' . $host . '/simplesaml/',

  'certdir' => $_SERVER['DOCUMENT_ROOT'] . '/../private/simplesaml/cert',
  'logging.handler' => 'errorlog',
  'tempdir' => $_SERVER['DOCUMENT_ROOT'] . '/tmp/simplesaml',
  'metadatadir' => $_SERVER['DOCUMENT_ROOT'] . '/../private/simplesaml/metadata',

  'technicalcontact_name' => 'Administrator',
  'technicalcontact_email' => 'psw58@cornell.edu',

  'debug' => [
        'saml' => false,
        'backtraces' => true,
        'validatexml' => false,
  ],
  'showerrors' => true,
  'errorreporting' => true,
  'logging.level' => SimpleSAML\Logger::DEBUG,
  'logging.handler' => 'syslog',
  'logging.facility' => defined('LOG_LOCAL5') ? constant('LOG_LOCAL5') : LOG_USER,
  'logging.processname' => 'simplesamlphp',
  'logging.logfile' => 'simplesamlphp.log',


  'secretsalt' => '994kf8gmsowod882lfmnmos874la934uzz12899457',
  'auth.adminpassword' => 'C!Tlogging',

  'authproc.sp' => [
    ['class' => 'core:AttributeMap', 'oid2name'],
  ],

  'store.type' => 'sql',
  'store.sql.dsn' => "mysql:host={$db['host']};port={$db['port']};dbname={$db['database']}",
  'store.sql.username' => $db['username'],
  'store.sql.password' => $db['password'],
];

$local_settings = __DIR__ . "/config.local.php";
if (file_exists($local_settings)) {
  include $local_settings;
}
