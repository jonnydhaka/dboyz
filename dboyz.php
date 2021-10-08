<?php
/*
Plugin Name: dboyz Library
Plugin URI: http://smartdatasoft.com/
Description: This is custom Library for dboyz.
Author: SmartDataSoft Team
Version: 1.0
Author URI: http://smartdatasoft.com/
 */


if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * The main plugin class
 */
final class Dboyz_PS
{

    /**
     * Plugin Version
     *
     * @since 1.2.0
     * @var string The plugin version.
     */
    const VERSION = '1.0';

    /**
     * Minimum PHP Version
     *
     * @since 1.2.0
     * @var string Minimum PHP version required to run the plugin.
     */
    const MINIMUM_PHP_VERSION = '7.0';

    /**
     * Constructor
     *
     * @since 1.0.0
     * @access public
     */

    /**
     * Class construcotr
     */
    private function __construct()
    {
        $this->define_constants();
        register_activation_hook(__FILE__, [$this, 'activate']);
        add_action('plugins_loaded', [$this, 'init_plugin']);
    }




    /**
     * Initializes a singleton instance
     *
     * @return \dboyz_PS
     */
    public static function init()
    {
        static $instance = false;

        if (!$instance) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Define the required plugin constants
     *
     * @return void
     */
    public function define_constants()
    {
        define('dboyz_PS_VERSION', self::VERSION);
        define('dboyz_PS_FILE', __FILE__);
        define('dboyz_PS_PATH', __DIR__);
        define('dboyz_PS_URL', plugins_url('', dboyz_PS_FILE));
        define('dboyz_PS_ASSETS', dboyz_PS_URL . '/assets');
        $theme = wp_get_theme();
        define('THEME_VERSION_CORE', $theme->Version);
    }

    /**
     * Initialize the plugin
     *
     * @return void
     */
    public function init_plugin()
    {

        // Check for required PHP version
        if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
            add_action('admin_notices', array($this, 'admin_notice_minimum_php_version'));
            return;
        }

        load_plugin_textdomain('dboyz-ps', false, basename(dirname(__FILE__)) . '/languages');
        new \Dboyz\PS\Templates();
        new \Dboyz\PS\Frontend();
        new \Dboyz\PS\Taxonomy();
        new \Dboyz\PS\Elementor\Elementor();

        if (is_admin()) {
            new \Dboyz\PS\Admin();
        }
    }




    /**
     * Admin notice
     *
     * Warning when the site doesn't have a minimum required PHP version.
     *
     * @since 1.0.0
     * @access public
     */
    public function admin_notice_minimum_php_version()
    {
        if (isset($_GET['activate'])) {
            unset($_GET['activate']);
        }

        $message = sprintf(
            /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'dboyz-ps'),
            '<strong>' . esc_html__('Dboyz Reveal', 'dboyz-ps') . '</strong>',
            '<strong>' . esc_html__('PHP', 'dboyz-ps') . '</strong>',
            self::MINIMUM_PHP_VERSION
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    /**
     * Do stuff upon plugin activation
     *
     * @return void
     */
    public function activate()
    {
    }
}

/**
 * Initializes the main plugin
 *
 * @return \Dboyz_PS
 */
function dboyz_PS_Function()
{
    return Dboyz_PS::init();
}
$role = add_role('dboyzuser', '2000 user', array(
    'read' => true,
));
// kick-off the plugin
dboyz_PS_Function();
