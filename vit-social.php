<?php

/*
 * Plugin name: VIT Social
 * Description: VIT Social share plugin provides you customization, post wise share buttons with sort order for post or page sharing option.
 * Version: 1.0.0
 * Author: Vitthal Awate 
 * Author URI: https://www.linkedin.com/in/phpvitthal
 * License: GPL2
 */

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}

$GLOBALS['vitPluginDirectoryPath'] = plugin_dir_path(__FILE__);
$GLOBALS['vitPluginDirectoryUrl'] = plugin_dir_url(__FILE__);

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
