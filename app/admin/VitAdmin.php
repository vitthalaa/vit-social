<?php
// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class responsible for configure share button on edit/create post page.
 * Add metabox and save metabox values
 * 
 * @author vitthal
 */
class VitAdmin
{

    private $pluginName;
    private $version;
    private $helper;
    
    /**
     * Set the plugin name and the plugin version and helper object of plugin
     * 
     * @param string    $pluginName
     * @param string    $version
     * @param VitHelper $helper
     */
    public function __construct($pluginName, $version, $helper)
    {
        $this->pluginName = $pluginName;
        $this->version = $version;
        $this->helper = $helper;
    }
    
    /**
     * Define action for adding scripts and styles
     */
    public function enqueueScripts()
    {
        add_action('admin_enqueue_scripts', array($this, 'enqueueScriptsStyles'));
    }

    /**
     * Register the stylesheets and javascripts for the admin area.
     */
    public function enqueueScriptsStyles()
    {
        wp_enqueue_script($this->pluginName . '_admin_js', $this->helper->assets('js/vit-social-admin.js'), array('jquery'), $this->version, false);
    }
    
    /**
     * Check for valid nonce and user permissions for editing content
     * Also check for autosave is done or not.
     * 
     * @param   int     $postId
     * @return  boolean false in valid and have permissions
     */
    private function isInvalidNoncePermissions($postId)
    {
        // Check if our nonce is set and nonce is valid.
        if (!isset($_POST['vit_inner_custom_box_nonce']) ||
                !wp_verify_nonce(sanitize_text_field($_POST['vit_inner_custom_box_nonce']), 'vit_inner_custom_box')) {
            return true;
        }

        // If this is an autosave, our form has not been submitted,
        //     so we don't want to do anything.
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $postId;
        }
        
        $postType = sanitize_text_field($_POST['post_type']);
        // Check the user's permissions.
        if ('page' == $postType && !current_user_can('edit_page', $postId)) {
            return true;
        }

        if ('page' != $postType && !current_user_can('edit_post', $postId)) {
            return true;
        }

        return false;
    }
    
    /**
     * Add metabox to edit/add post page.
     * Check whether need to add metabox for page/post or not
     * 
     * @param string $postType post|page
     */
    public function addMetaBox($postType = null)
    {
        $postType = (null == $postType) ? get_post_type() : $postType;
        if ($this->helper->canShowButtons($postType)) {
            add_meta_box(
                    'social_button_settings', __('Social Button Settings'), array($this, 'renderMetaBox'), $postType, 'side', 'high'
            );
        }
    }
    
    /**
     * Save buttons order and visibility
     * 
     * @param   int     $postId
     * @return  mixed   void|$postId void on success, post id if not valid nonce
     */
    public function saveMetaBox($postId = null)
    {
        $postId = (null == $postId) ? get_the_ID() : $postId;

        if (!$this->helper->canShowButtons() || $this->isInvalidNoncePermissions($postId)) {
            return $postId;
        }

        $buttons = $this->helper->getShareButtons();

        foreach ($buttons as $buttonId => $button) {
            $showField = "vit_show_" . $buttonId;
            $orderField = "vit_order_" . $buttonId;

            $showValue = (isset($_POST[$showField])) ? 1 : 0; //Either 1 or 0 only
            $orderValue = intval(sanitize_text_field($_POST[$orderField]));

            // Update the meta field.
            update_post_meta($postId, $showField, $showValue);
            update_post_meta($postId, $orderField, $orderValue);
        }
        
        return;
    }
    
    /**
     * Show metabox view on post edit page
     * 
     * @param WP_Post $post Wordpress post object
     */
    public function renderMetaBox($post)
    {
        $sortedButtons = $this->helper->getSortedButtons($post, true);
        ob_start();
        $this->helper->loadView('metaBox', 'admin', compact('sortedButtons'));
        $output = ob_get_clean();

        echo $output;
    }

}
