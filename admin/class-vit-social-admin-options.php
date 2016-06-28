<?php

class Vit_Social_Admin_Options {

    private $plugin_name;
    private $helper;

    function __construct($plugin_name, $helper) {
        $this->plugin_name = $plugin_name;
        $this->helper = $helper;
    }

    function addAdminMenu() {
        add_options_page('VIT Social', 'VIT Social', 'manage_options', 'vit-social', array($this, 'initSettingPage'));
    }

    function initSettingPage() {
        //var_dump(get_option( 'vit_button_shape')); exit;
        echo "<h1>Hello World!</h1>";
        echo '<form action="options.php" method="post">';
        settings_fields('vit_social');
        do_settings_sections('vit_social');

        echo '<input name="Submit" type="submit" value="' . __('Save Changes') . '" class="button button-primary" />';
        echo '</form>';
    }

    function settingsApiInit() {
        // Create Setting
        $sectionGroup = 'vit_social';
        $sectionName = 'vit_button_shape';
        register_setting($sectionGroup, $sectionName);

        // Create section of Page
        $settingsSection = 'vit_skins';
        $page = $sectionGroup;
        add_settings_section(
                $settingsSection, __('Skins', 'vit_social'), array($this, 'skinSectionDescription'), $page
        );

        // Add fields to that section
        add_settings_field(
                $sectionName, __('Button shapes', 'vit_social'), array($this, 'buttonShapeField'), $page, $settingsSection
        );
    }

    function skinSectionDescription() {
        _e('<p>Select your preferences</p>', 'vit_social');
    }

    function buttonShapeField() {
        $buttonShape = get_option('vit_button_shape', 'flat');
        echo '<input name="vit_button_shape" id="vit_button_shape" type="radio" value="flat" class="code" ' . checked('flat', $buttonShape, false) . ' /> ' . __('Flat', 'vit_social');
        echo '<input name="vit_button_shape" id="vit_button_shape" type="radio" value="rounded" class="code" ' . checked('rounded', $buttonShape, false) . ' /> ' . __('Rounded', 'vit_social');
        echo '<input name="vit_button_shape" id="vit_button_shape" type="radio" value="circle" class="code" ' . checked('circle', $buttonShape, false) . ' /> ' . __('Circle', 'vit_social');
    }

}
