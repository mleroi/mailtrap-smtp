<?php
/*
  Plugin Name: Mleroi Mailtrap SMTP
  Description: Send all WordPress emails using Mailtrap. When activated and Mailtrap credentials set, no real email is sent to users.
  Version: 1.0
  Author: mleroi
 */

/**
 * Plugin bootstrap so that git repo can be cloned and used directly in a plugins folder's subdirectory
 */

require_once(dirname(__FILE__) .'/mleroi-mailtrap-smtp/mailtrap-smtp.php');
