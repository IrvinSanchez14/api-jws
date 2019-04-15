<?php
  error_reporting(E_ALL);
  date_default_timezone_set('Asia/Manila');
  $key = "app_tesis";
  $iss = "http://example.org";
  $aud = "http://example.com";
  $iat = time();
  $nbf = $iat + 10;
  $exp = $nbf + 60;
