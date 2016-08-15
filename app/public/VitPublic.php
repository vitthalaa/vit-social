<?php

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class responsible for loading required scripts and adding icons to post/page
 *
 * @author vitthal
 */
class VitPublic
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
     * Add required css and js in front end
     * 
     * @return void
     */
    public function enqueueScripts()
    {
        if (!(is_page() || is_single(get_the_ID())) || !$this->helper->canShowButtons()) {
            return;
        }

        wp_register_style("vit_social_css", $this->helper->assets('css/vit-social.php'));
        wp_enqueue_style('vit_social_css');

        wp_enqueue_script($this->pluginName, $this->helper->assets('js/vit-social.js'), array('jquery'), $this->version, false);
        wp_enqueue_style($this->pluginName . '_font_awesome', $this->helper->assets('vendor/font-awesome/font-awesome.min.css'), array(), '4.4.0', 'all');
    }
    
    /**
     * Add icons to page/post content
     * 
     * @param   string $content May be null if theme is geting content using method get_the_content
     * @return  string Buttons appended content
     */
    public function addIcons($content = null)
    {
        if (null == $content) {
            $content = get_the_content();
        }
        
        if ((is_page() || is_single(get_the_ID())) && $this->helper->canShowButtons()) {
            return $content . $this->getHtml();
        }
        
        return $content;
    }

    /**
     * Return html for social buttons according to sorting
     * 
     * @global WP_Post $post
     * @return string
     */
    public function getHtml()
    {
        global $post;

        $sharePermalink = esc_url(get_permalink($post->ID)); //Post link
        $shareTitle = $this->helper->getShareTitle(); //Post title
        $emailSubject = $this->helper->getEmailSubject($shareTitle);
        $emailBody = $this->helper->getEmailBody($shareTitle, $sharePermalink);
        $whatsAppText = $this->helper->getWhatsAppText($shareTitle, $sharePermalink);
        $sortedButtons = $this->helper->getSortedButtons($post);
        $socialLinks = '';

        if (!empty($sortedButtons)) {
            //Create html of links
            $variables = compact('sortedButtons', 'sharePermalink', 'shareTitle', 'emailSubject', 'emailBody', 'whatsAppText');
            $socialLinks = $this->helper->loadView('buttons', 'public', $variables, true);
        }

        return $socialLinks;
    }
}
