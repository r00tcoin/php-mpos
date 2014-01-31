<?php
$defflip = (!cfip()) ? exit(header('HTTP/1.1 401 Unauthorized')) : 1;

// Check user to ensure they are admin
if (!$user->isAuthenticated() || !$user->isAdmin($_SESSION['USERDATA']['id'])) {
  header("HTTP/1.1 404 Page not found");
  die("404 Page not found");
}

if (@$_REQUEST['do'] == 'save' && !empty($_REQUEST['data'])) {
  if ($this->config['logging']['enabled'] && $this->config['logging']['level'] > 0) {
    $user->log->LogWarn($_SESSION['USERDATA']['username']." changed admin settings from [".$_SERVER['REMOTE_ADDR']."]");
  }
  foreach($_REQUEST['data'] as $var => $value) {
    $setting->setValue($var, $value);
  }
  $_SESSION['POPUP'][] = array('CONTENT' => 'Settings updated', 'TYPE' => 'success');
}

// Load our available settings from configuration
require_once(INCLUDE_DIR . '/config/admin_settings.inc.php');

// Load onto the template
$smarty->assign("SETTINGS", $aSettings);

// Tempalte specifics
$smarty->assign("CONTENT", "default.tpl");
?>
