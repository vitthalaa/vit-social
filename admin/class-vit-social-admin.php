<?php

class Vit_Social_Admin
{

    private $plugin_name;
    private $version;
    private $helper;

    public function __construct($plugin_name, $version, $helper)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->helper = $helper;
    }

    public function enqueue_scripts()
    {
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts_styles'));
    }

    /**
     * Register the stylesheets for the admin area.
     */
    public function enqueue_scripts_styles()
    {
        wp_enqueue_style($this->plugin_name . '_jquery_ui', $this->helper->assets('vendor/jquery-ui/jquery-ui.css'), array(), $this->version, 'all');
        wp_enqueue_script($this->plugin_name . '_admin_js', $this->helper->assets('js/vit-social-admin.js'), array('jquery'), $this->version, false);
    }

    public function add_meta_box($postType = null)
    {
        $postType = (null == $postType) ? get_post_type() : $postType;
        if ($this->helper->doShow($postType)) {
            add_meta_box(
                    'social_button_settings', __('Social Button Settings'), array($this, 'renderMetaBox'), $postType, 'side', 'high'
            );
        }
    }

    public function saveMetaBox($post_id = null)
    {
        $post_id = (null == $post_id) ? get_the_ID() : $post_id;
        // Check if our nonce is set.
        if (!isset($_POST['vit_inner_custom_box_nonce'])) {
            return $post_id;
        }

        $nonce = $_POST['vit_inner_custom_box_nonce'];

        // Verify that the nonce is valid.
        if (!wp_verify_nonce($nonce, 'vit_inner_custom_box')) {
            return $post_id;
        }

        // If this is an autosave, our form has not been submitted,
        //     so we don't want to do anything.
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }

        // Check the user's permissions.
        if ('page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id)) {
                return $post_id;
            }
        } else {
            if (!current_user_can('edit_post', $post_id)) {
                return $post_id;
            }
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

    public function renderMetaBox($post)
    {
        $sortedButtons = $this->helper->getSortedButtons($post, true);
        ob_start();
        $this->helper->loadView('metaBox', 'admin', compact('sortedButtons'));
        $output = ob_get_clean();

        echo $output;
    }
}
