<?php

class Vit_Social_Admin_Options {

    private $plugin_name;
    private $helper;

    function __construct($plugin_name, $helper) {
        $this->plugin_name = $plugin_name;
        $this->helper = $helper;
    }
    
    private function addSectionSettings($page, $settingsSection) {
        $this->addSettingField('vit_button_shape', 'Button shapes', 'buttonShapeField', $page, $settingsSection);
        $this->addSettingField('vit_button_zoom', 'Button zoom', 'buttonZoomField', $page, $settingsSection);
        $this->addSettingField('vit_button_rotate', 'Button rotate', 'buttonRotateField', $page, $settingsSection);
    }
    
    private function addSettingField($fieldName, $label, $funtion, $page, $settingsSection) {
        //register setting field
        register_setting($page, $fieldName);
        
        // Add field
        add_settings_field(
            $fieldName, __($label, 'vit_social'), array($this, $funtion), $page, $settingsSection
        );
        
    }
    
    public function enqueue_scripts()
    {
        global $pageHook;
        add_action('admin_print_styles-' . $pageHook, array($this, 'enqueue_scripts_styles'));
    }
    
    /**
     * Register the stylesheets for the admin options area.
     */
    public function enqueue_scripts_styles($hook)
    {
        wp_enqueue_style($this->plugin_name . '_jquery_ui', plugin_dir_url(__FILE__) . '../public/assets/css/vit-social.css', array(), false, 'all');
        wp_enqueue_style($this->plugin_name . '_font_awesome', plugin_dir_url(__FILE__) . '../public/assets/font-awesome/font-awesome.min.css', array(), '4.4.0', 'all');
        wp_enqueue_style($this->plugin_name . '_admin_options_css', plugin_dir_url(__FILE__) . 'css/vit-admin-options.css', array(), false, 'all');
        wp_enqueue_script($this->plugin_name . '_admin_options_js', plugin_dir_url(__FILE__) . 'js/vit-admin-options.js', array('jquery'));
    }
    
    function addAdminMenu() {
        global $pageHook;
        $pageHook = add_options_page('VIT Social', 'VIT Social', 'manage_options', 'vit-social', array($this, 'initSettingPage'));
    }

    function initSettingPage() {
        $title = "VIT Social";
        $this->helper->loadView('optionsForm', 'admin', compact('title'));
    }

    function settingsApiInit() {
        $page = 'vit_social';
        $settingsSection = 'vit_skins';
        add_settings_section(
                $settingsSection, __('Skins', 'vit_social'), array($this, 'skinSectionDescription'), $page
        );
        $this->addSectionSettings($page, $settingsSection);
    }

    function skinSectionDescription() {
        _e('<p>Select your preferences</p>', 'vit_social');
    }

    function buttonShapeField() {
        $buttonShape = get_option('vit_button_shape', 'flat');
        echo '<label><input name="vit_button_shape" class="vit_button_shape" type="radio" value="flat" ' . checked('flat', $buttonShape, false) . ' /> ' . __('Flat', 'vit_social') . '</label>';
        echo '<label><input name="vit_button_shape" class="vit_button_shape" type="radio" value="rounded" ' . checked('rounded', $buttonShape, false) . ' /> ' . __('Rounded', 'vit_social') . '</label>';
        echo '<label><input name="vit_button_shape" class="vit_button_shape" type="radio" value="circle" ' . checked('circle', $buttonShape, false) . ' /> ' . __('Circle', 'vit_social') . '</label>';
    }
    
    function buttonZoomField() {
        $buttonZoom = get_option('vit_button_zoom', 'y');
        echo '<label><input name="vit_button_zoom" class="vit_button_zoom" type="radio" value="y" ' . checked('y', $buttonZoom, false) . ' /> ' . __('Yes', 'vit_social') . '</label>';
        echo '<label><input name="vit_button_zoom" class="vit_button_zoom" type="radio" value="n" ' . checked('n', $buttonZoom, false) . ' /> ' . __('No', 'vit_social') . '</label>';
    }
    
    function buttonRotateField() {
        $buttonRotate = get_option('vit_button_rotate', 'y');
        echo '<label><input name="vit_button_rotate" class="vit_button_rotate" type="radio" value="y" ' . checked('y', $buttonRotate, false) . ' /> ' . __('Yes', 'vit_social') . '</label>';
        echo '<label><input name="vit_button_rotate" class="vit_button_rotate" type="radio" value="n" ' . checked('n', $buttonRotate, false) . ' /> ' . __('No', 'vit_social') . '</label>';
    }

}
