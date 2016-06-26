    <?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Vit_Social_Admin 
{
    private $plugin_name;
    
    private $version;
    
    private $helper;


    public function __construct($plugin_name, $version, $helper) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->helper = $helper;
    }
    
    public function enqueue_scripts() {
        add_action( 'admin_enqueue_scripts', array($this, 'enqueue_scripts_styles'));
    }

    /**
     * Register the stylesheets for the admin area.
     */
    public function enqueue_scripts_styles() {
        wp_enqueue_style($this->plugin_name . '_jquery_ui', plugin_dir_url(__FILE__) . 'css/jquery-ui.css', array(), $this->version, 'all');
        wp_enqueue_script($this->plugin_name . '_admin_js', plugin_dir_url(__FILE__) . 'js/vit-social-admin.js', array('jquery'), $this->version, false);
    }
    
    public function add_meta_box($post_type) {
        $post_types = array('post', 'page');     //limit meta box to posts and pages
        if (in_array($post_type, $post_types)) {
            add_meta_box(
                    'social_button_settings',
                    __('Social Button Settings'),
                    array($this, 'renderMetaBox'),
                    $post_type,
                    'side',
                    'high'
            );
        }
    }
    
    public function saveMetaBox($post_id) {
        // Check if our nonce is set.
        if (!isset($_POST['vit_inner_custom_box_nonce']))
            return $post_id;

        $nonce = $_POST['vit_inner_custom_box_nonce'];

        // Verify that the nonce is valid.
        if (!wp_verify_nonce($nonce, 'vit_inner_custom_box'))
            return $post_id;

        // If this is an autosave, our form has not been submitted,
        //     so we don't want to do anything.
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return $post_id;

        // Check the user's permissions.
        if ('page' == $_POST['post_type']) {

            if (!current_user_can('edit_page', $post_id))
                return $post_id;
        } else {

            if (!current_user_can('edit_post', $post_id))
                return $post_id;
        }
        
        $buttons = $this->helper->getShareButtons();
        
        foreach ($buttons as $buttonId => $button) {
            $showField = "vit_show_" . $buttonId;
            $orderField = "vit_order_" . $buttonId;

            $showValue = (isset($_POST[$showField])) ? 1 : 0;
            $orderValue = sanitize_text_field($_POST[$orderField]);

            // Update the meta field.
            update_post_meta($post_id, $showField, $showValue);
            update_post_meta($post_id, $orderField, $orderValue);
        }
    }


    public function renderMetaBox($post) {
        
        $sortedButtons = $this->helper->getSortedButtons($post, true);
        ob_start();
        $this->helper->loadView('metaBox', 'admin', compact('sortedButtons'));
        $op = ob_get_clean();
        
        echo $op;
    }
    
    function addAdminMenu(){
        add_submenu_page('options-general.php', 'VIT Social', 'VIT Social', 'manage_options', 'vit-social', array($this, 'initSettingPage'));
    }

    function initSettingPage(){
            echo "<h1>Hello World!</h1>";
            //settings_fields( 'rfi' );
            do_settings_sections( 'vit_social' );
    }
    
     function settingsApiInit() {
        // Create Setting
        $sectionGroup = 'vit_social';
        $sectionName = 'vit_settings';
        register_setting($sectionGroup, $sectionName);

        // Create section of Page
        $settingsSection = 'vit_skins';
        $page = $sectionGroup;
        add_settings_section( 
            $settingsSection,
            __( 'Skins', 'vit_social' ),
            array($this, 'skinSectionDescription'),
            $page
        );

        // Add fields to that section
        add_settings_field(
            $sectionName,
            __('Button shapes', 'vit_social'),
            array($this, 'buttonShapeField'),
            $page,
            $settingsSection
        ); 
    }
    
    function skinSectionDescription() {
 	_e('<p>Select your preferences</p>', 'vit_social');
    }

    // ------------------------------------------------------------------
    // Callback function for our example setting
    // ------------------------------------------------------------------
    //
    // creates a checkbox true/false option. Other types are surely possible
    //

    function buttonShapeField() {
        $buttonShape = get_option( 'vit_button_shape', 'flat');
        echo '<input name="vit_button_shape" id="vit_button_shape" type="checkbox" value="flat" class="code" ' . checked('flat', $buttonShape, false) . ' /> ' . __('Flat', 'vit_social');
        echo '<input name="vit_button_shape" id="vit_button_shape" type="checkbox" value="rounded" class="code" ' . checked('rounded', $buttonShape, false) . ' /> ' . __('Rounded', 'vit_social');
        echo '<input name="vit_button_shape" id="vit_button_shape" type="checkbox" value="circle" class="code" ' . checked('circle', $buttonShape, false) . ' /> ' . __('Circle', 'vit_social');
    }
}
