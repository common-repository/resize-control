<?php

/**
 * Plugin Name:       Resize Control
 * Plugin URI:        https://tuningwp.com
 * Description:       Automate all your media resolutions and sizes for you and your wp accounts to save time, site speed and disk space and bandwith.
 * Version:           1.0.9
 * Requires at least: 6.4
 * Requires PHP:      8.0
 * Author:            TuningWP
 * Author URI:        https://tuningwp.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

define('RECO_VERSION', '1.0.9');
define('RECO_PLUGINROOT', __DIR__);
define('RECO_PLUGINFILE', __FILE__);

function recoActivate()
{
    require_once plugin_dir_path(__FILE__) . 'includes/RecoActivator.php';
    Reco\RecoActivator::activate();
}

function recoDeactivate()
{
    require_once plugin_dir_path(__FILE__) . 'includes/RecoDeactivator.php';
    Reco\RecoDeactivator::deactivate();
}

register_activation_hook(__FILE__, 'recoActivate');
register_deactivation_hook(__FILE__, 'recoDeactivate');

require plugin_dir_path(__FILE__) . 'includes/Reco.php';


function recoRun()
{
    $plugin = new Reco\Reco();
    $plugin->run();
}

recoRun();