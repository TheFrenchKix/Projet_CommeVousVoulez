<?php

/*
Plugin Name: Module de Projet
Author: Leo
Version: 1.0.0
*/

if (!defined('ABSPATH')){
    exit;
}

define('PL_VERSION', '1.0.0');
define('PL_FILE', __FILE__);
define('PL_DIR', dirname(PL_FILE));
define('PL_BASENAME', pathinfo((PL_FILE))['filename']);
define('PL_PLUGIN_NAME', PL_BASENAME);
define('PL_URL', 'page-test');

foreach (glob(PL_DIR .'/classes/*/*.php') as $filename){
    if (!preg_match('/export|cron/i', $filename)){
        if (!@require_once $filename){
            throw new Exception(sprintf(__('Failed to include %s'), $filename));
        }
    }
}

register_activation_hook(PL_FILE, function() {
    $PL_Install = new PL_Install();
    $PL_Install->setup();
});

if (is_admin()){
    new PL_Admin();
}
else{
    new PL_Front();
}
?>