<?php
  // show error reporting
  error_reporting(E_ALL);
  // set your default time-zone
  date_default_timezone_set('Asia/Manila');
  // variables used for jwt
  $key = "app_tesis";
  $iss = "http://example.org";
  $aud = "http://example.com";
  $iat = time();
  $nbf = $iat + 10;
  $exp = $nbf + 60;
?>