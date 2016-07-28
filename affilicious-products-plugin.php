<?php
/**
 * Plugin Name: Affilicious Produkte
 * Description: Erstelle und verwalte Affilicious Produkte mit den dazugehörigen Feldern und Details in Wordpress
 * Version: 0.1
 * Author: Alexander Barton
 * Author URI: https://affilicioustheme.de/author/alexander-barton
 * Plugin URI: http://affilicioustheme.de/plugins/products
 * License: MIT
 * Requires at least: 4.0
 * Tested up to: 4.6
 * Text Domain: affiliciousproducts
 * Domain Path: /languages
 */
use Affilicious\ProductsPlugin\Loader;

final class AffiliciousProductsPlugin
{
    const PLUGIN_NAME = 'affilicious-products';
    const PLUGIN_VERSION = '0.1';
    const PLUGIN_NAMESPACE = 'Affilicious\\ProductsPlugin\\';
    const PLUGIN_SOURCE_DIR = 'src/';
    const PLUGIN_LANGUAGE_DIR = 'language/';

    /**
     * Register all actions and filters for the plugin.
     * @var Loader
     */
    private $loader;

    /**
     * Prepare the plugin with for usage with Wordpress and namespaces
     */
    public function __construct()
    {
        spl_autoload_register(array($this, 'autoload'));

        $this->loader = new Loader();
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     */
    public function run()
    {
        register_activation_hook( __FILE__, array($this, 'activate'));
        register_deactivation_hook( __FILE__, array($this, 'deactivate'));
        $this->loader->add_action('plugins_loaded', $this, 'loaded');

        $this->loader->run();
        $this->registerPublicHooks();
        $this->registerAdminHooks();
    }

    /**
     * Make namespaces compatible with the source code of this plugin
     * @param string $class
     */
    public function autoload($class)
    {
        $prefix = 'Affilicious';
        if (stripos($class, $prefix) === false) {
            return;
        }
        $file_path = __DIR__ . '/' . self::PLUGIN_SOURCE_DIR . str_ireplace(self::PLUGIN_NAMESPACE, '', $class) . '.php';
        $file_path = str_replace('\\', DIRECTORY_SEPARATOR, $file_path);
        include_once($file_path);
    }

    /**
     * The code that runs during plugin activation.
     */
    public function activate()
    {
        // Nothing to do here
    }

    /**
     * The code that runs during plugin deactivation.
     */
    public function deactivate()
    {
        // Nothing to do here
    }

    /**
     * The code that runs after the plugin is loaded
     */
    public function loaded()
    {
        $this->registerTextdomain();
    }

    /**
     * Register the plugin textdomain for internationalization.
     */
    public function registerTextdomain()
    {
        load_plugin_textdomain(
            self::PLUGIN_NAME,
            false,
            dirname(dirname(plugin_basename( __FILE__ ))) . '/' . self::PLUGIN_LANGUAGE_DIR
        );
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     */
    public function registerPublicHooks()
    {
    }

    /**
     * Register all of the hooks related to the admin area functionality
     */
    public function registerAdminHooks()
    {
    }
}

$affiliciousProductsPlugin = new AffiliciousProductsPlugin();
$affiliciousProductsPlugin->run();