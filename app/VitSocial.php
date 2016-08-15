<?php

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Main plugin class for loading dependencies, define hooks and run plugin
 *
 * @author vitthal
 */
class VitSocial
{

    /**
     * The unique identifier of this plugin.
     * 
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $pluginName;

    /**
     * The current version of the plugin.
     *
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     * 
     * @access   protected
     * @var      Plugin_Name_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * Helper for basic operations
     * 
     * @access  protected
     * @var     Helper $helper
     */
    protected $helper;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     */
    public function __construct()
    {
        $this->pluginName = 'vit-social';
        $this->version = '1.0.0';
        $this->loadDependencies();
        
        if (is_admin()) {
            $this->defineAdminHooks();
        } else {
            $this->definePublicHooks();
        }
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @return    string    The name of the plugin.
     */
    public function getPluginName()
    {
        return $this->pluginName;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @return    Plugin_Name_Loader    Orchestrates the hooks of the plugin.
     */
    public function getLoader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @return    string    The version number of the plugin.
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Load the required dependencies for this plugin.
     * 
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     * 
     * @access   private
     */
    private function loadDependencies()
    {
        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(__FILE__) . 'includes/VitLoader.php';

        require_once plugin_dir_path(__FILE__) . 'includes/VitHelper.php';

        /**
         * The class responsible for defining all actions that occur in the admin posts/pages area.
         */
        require_once plugin_dir_path(__FILE__) . '/admin/VitAdmin.php';

        /**
         * The class responsible for defining all actions that occur in the admin option page.
         */
        require_once plugin_dir_path(__FILE__) . '/admin/VitOptions.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(__FILE__) . '/public/VitPublic.php';

        $this->loader = new VitLoader();
        $this->helper = new VitHelper();
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @access   private
     */
    private function defineAdminHooks()
    {
        $pluginAdmin = new VitAdmin($this->getPluginName(), $this->getVersion(), $this->helper);
        $pluginAdminOption = new VitOptions($this->getPluginName(), $this->getVersion(), $this->helper);

        //Add scripts only on post add/edit page
        $this->loader->addAction('load-post.php', $pluginAdmin, 'enqueueScripts');
        $this->loader->addAction('load-post-new.php', $pluginAdmin, 'enqueueScripts');

        //Add meta boxes and save its content on save post
        $this->loader->addAction('add_meta_boxes', $pluginAdmin, 'addMetaBox');
        $this->loader->addAction('save_post', $pluginAdmin, 'saveMetaBox');

        //Add setting page
        $this->loader->addAction('admin_menu', $pluginAdminOption, 'addAdminMenu');
        $this->loader->addAction('admin_init', $pluginAdminOption, 'settingsApiInit');
        $this->loader->addAction('admin_enqueue_scripts', $pluginAdminOption, 'enqueueScripts');
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @access   private
     */
    private function definePublicHooks()
    {
        $pluginPublic = new VitPublic($this->getPluginName(), $this->getVersion(), $this->helper);
        $this->loader->addAction('wp_enqueue_scripts', $pluginPublic, 'enqueueScripts');
        $this->loader->addFilter('the_content', $pluginPublic, 'addIcons');
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     */
    public function run()
    {
        $this->loader->run();
    }

}
