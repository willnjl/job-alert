<?php

/**
 * Plugin Name: 15_10 Job Alert Management System
 * Plugin URI: 
 * description:  Initialises 1510's Custom Job Alert system
 * Author: Will @ Fifteenten
 * Author URI: fifteenten.co.uk
 * License: GPL2
 */

use App\JobAlert;

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}

require __DIR__ . '/vendor/autoload.php';


/**
 * The code that runs during plugin activation.
 */
function activate_fifteenten_job_alert()
{
}


function deactivate_fifteenten_job_alert()
{
}

register_activation_hook(__FILE__, 'activate_fifteenten_job_alert');
register_deactivation_hook(__FILE__, 'deactivate_fifteenten_job_alert');

class FifteentenJobAlert_Plugin
{

    public $version = "0.0.0";

    public function __construct()
    {
        $this->define('_FIFTEENTEN_JOB_ALERT_VERSION_', $this->version);
        $this->define('_FIFTEENTEN_JOB_ALERT_PLUGIN_PATH_', plugin_dir_url(__FILE__));

        $this->jobAlert = new JobAlert('lol');
    }


    /**
     * define
     */
    function define($name, $value = true)
    {
        if (!defined($name)) {
            define($name, $value);
        }
    }
}


$plugin = new FifteentenJobAlert_Plugin();
