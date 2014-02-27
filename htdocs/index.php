<?php

// Connect to mariaDB
print_r('<h1>mariaDB - Connect</h1>');
$connectionCredentials = getCredentials('maria-dave');
$mysqli = new mysqli($connectionCredentials->host, $connectionCredentials->username, $connectionCredentials->password, $connectionCredentials->database, $connectionCredentials->port);
if ($mysqli->connect_errno) {
  print_r('Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}
print_r('Successfully connected to mariaDB' . '<br><br>');

// Connect to mongo
print_r('<h1>mongoDB - Connect</h1>');
$connectionCredentials = getCredentials('mongo-dave');
try {
  $m = new MongoClient($connectionCredentials->url);
  print_r('Successfully connected to mongoDB' . '<br><br>');
} catch (Exception $e) {
  print_r('Exception: ',  $e->getMessage() . '<br><br>');
}

// Connect to postgreSQL
print_r('<h1>postgreSQL - Connect</h1>');
$connectionCredentials = getCredentials('post-dave');
// Verbindungsaufbau und Auswahl der Datenbank
$dbconn = pg_connect('host=' . $connectionCredentials->host . ' port=' . $connectionCredentials->port . ' dbname=' . $connectionCredentials->name . ' user=' . $connectionCredentials->username . ' password=' . $connectionCredentials->password);
print_r($dbconn);
if (empty($dbconn)) {
  print_r('Connection fail: ' . pg_last_error());
} else {
  print_r('Successfully connected to postgreSQL' . '<br><br>');
}

// Connect to mssql
print_r('<h1>mssql - Connect</h1>');
$connectionCredentials = getCredentials('ms sql db');

/**
 * Get the credentail stdClass object form vcap_services
 *
 * @param $name
 * @return stdClass|bool
 */
function getCredentials($name) {
  $arr_vcap_services = json_decode((string)$_ENV['VCAP_SERVICES']);

  foreach ($arr_vcap_services as $type) {
    foreach ($type as $value) {
      if ($value->name == $name) {
        return $value->credentials;
      }
    }
  }

  return false;
}

?>