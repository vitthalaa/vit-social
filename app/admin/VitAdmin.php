<?php

/**
 * Description of Admin
 *
 * @author vitthal
 */
class VitAdmin
{

    private $pluginName;
    private $version;
    private $helper;

    public function __construct($pluginName, $version, $helper)
    {
        $this->pluginName = $pluginName;
        $this->version = $version;
        $this->helper = $helper;
    }

    public function enqueueScripts()
    {
        add_action('admin_enqueue_scripts', array($this, 'enqueueScriptsStyles'));
    }

    private function isInvalidNoncePermissions($postId)
    {
        // Check if our nonce is set and nonce is valid.
        if (!isset($_POST['vit_inner_custom_box_nonce']) ||
                !wp_verify_nonce($_POST['vit_inner_custom_box_nonce'], 'vit_inner_custom_box')) {
            return true;
        }

        // If this is an autosave, our form has not been submitted,
        //     so we don't want to do anything.
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $postId;
        }

        // Check the user's permissions.
        if ('page' == $_POST['post_type'] && !current_user_can('edit_page', $postId)) {
            return true;
        }

        if ('page' != $_POST['post_type'] && !current_user_can('edit_post', $postId)) {
            return true;
        }

        return false;
    }

    /**
     * Register the stylesheets for the admin area.
     */
    public function enqueueScriptsStyles()
    {
        wp_enqueue_style($this->pluginName . '_jquery_ui', $this->helper->assets('vendor/jquery-ui/jquery-ui.css'), array(), $this->version, 'all');
        wp_enqueue_script($this->pluginName . '_admin_js', $this->helper->assets('js/vit-social-admin.js'), array('jquery'), $this->version, false);
    }

    public function addMetaBox($postType = null)
    {
        $postType = (null == $postType) ? get_post_type() : $postType;
        if ($this->helper->doShow($postType)) {
            add_meta_box(
                    'social_button_settings', __('Social Button Settings'), array($this, 'renderMetaBox'), $postType, 'side', 'high'
            );
        }
    }

    public function saveMetaBox($postId = null)
    {
        $postId = (null == $postId) ? get_the_ID() : $postId;

        if ($this->isInvalidNoncePermissions($postId)) {
            return $postId;
        }

        $buttons = $this->helper->getShareButtons();

        foreach ($buttons as $buttonId => $button) {
            $showField = "vit_show_" . $buttonId;
            $orderField = "vit_order_" . $buttonId;

            $showValue = (isset($_POST[$showField])) ? 1 : 0;
            $orderValue = sanitize_text_field($_POST[$orderField]);

            // Update the meta field.
            update_post_meta($postId, $showField, $showValue);
            update_post_meta($postId, $orderField, $orderValue);
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
