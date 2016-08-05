<?php

/*
 * Plugin name: VIT Social
 * Description: Post wise social share buttons
 * Version: 1.0.0
 * Author: Vitthal Awate 
 * License: GPL2
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

$GLOBALS['vitPluginDirectoryPath'] = plugin_dir_path(__FILE__);
$GLOBALS['pluginDirectoryUrl'] = plugin_dir_url(__FILE__);

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'app/VitSocial.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 */
function runVitSocial()
{
    $plugin = new VitSocial();
    $plugin->run();
}

runVitSocial();
