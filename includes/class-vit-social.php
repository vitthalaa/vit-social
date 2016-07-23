<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Vit_Social
{

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     * 
     * @access   protected
     * @var      Plugin_Name_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;
    
    protected $helper;

    /**
     * The unique identifier of this plugin.
     * 
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     */
    public function __construct() {
        $this->plugin_name = 'vit-social';
        $this->version = '1.0.0';
        $this->load_dependencies();
        
        if (is_admin()) {
            $this->define_admin_hooks();
        }
        
        if (!is_admin()) {
            $this->define_public_hooks();
        }
        //$this->define_public_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     * 
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     * 
     * @access   private
     */
    private function load_dependencies() {
        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-vit-social-loader.php';
        
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-vit-social-helper.php';

        /**
         * The class responsible for defining all actions that occur in the admin posts/pages area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-vit-social-admin.php';
        
        /**
         * The class responsible for defining all actions that occur in the admin option page.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-vit-social-admin-options.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-vit-social-public.php';

        $this->loader = new Vit_Social_Loader();
        $this->helper = new Vit_Social_Helper();
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @access   private
     */
    private function define_admin_hooks() {
        $pluginAdmin = new Vit_Social_Admin($this->get_plugin_name(), $this->get_version(), $this->helper);
        $pluginAdminOption = new Vit_Social_Admin_Options($this->get_plugin_name(), $this->helper);
        
        //Add scripts only on post add/edit page
        $this->loader->add_action('load-post.php', $pluginAdmin, 'enqueue_scripts');
        $this->loader->add_action('load-post-new.php', $pluginAdmin, 'enqueue_scripts');
        
        //Add meta boxes and save its content on save post
        $this->loader->add_action('add_meta_boxes', $pluginAdmin, 'add_meta_box');
        $this->loader->add_action('save_post', $pluginAdmin, 'saveMetaBox');
        
        //Add setting page
        $this->loader->add_action('admin_menu', $pluginAdminOption, 'addAdminMenu');
        $this->loader->add_action('admin_init', $pluginAdminOption, 'settingsApiInit');
        $this->loader->add_action('admin_enqueue_scripts', $pluginAdminOption, 'enqueue_scripts');
        
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @access   private
     */
    private function define_public_hooks() {
        $pluginPublic = new Vit_Social_Public($this->get_plugin_name(), $this->get_version(), $this->helper);
        $this->loader->add_action('wp_enqueue_scripts', $pluginPublic, 'enqueueScripts');
        $this->loader->add_filter('the_content', $pluginPublic, 'addIcons');
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     */
    public function run() {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name() {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @return    Plugin_Name_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader() {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @return    string    The version number of the plugin.
     */
    public function get_version() {
        return $this->version;
    }

}
