<?php

/**
 * Description of VitPublic
 *
 * @author vitthal
 */
class VitPublic
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
        if (!$this->helper->doShow()) {
            return;
        }

        wp_register_style("vit_social_css", $this->helper->assets('css/vit-social.php'));
        wp_enqueue_style('vit_social_css');

        wp_enqueue_script($this->pluginName, $this->helper->assets('js/vit-social.js'), array('jquery'), $this->version, false);
        wp_enqueue_style($this->pluginName . '_font_awesome', $this->helper->assets('vendor/font-awesome/font-awesome.min.css'), array(), '4.4.0', 'all');
    }

    public function addIcons($content = null)
    {
        if (null == $content) {
            $content = get_the_content();
        }
        
        if ($this->helper->doShow()) {
            return $content . $this->getHtml();
        }
        
        return $content;
    }

    /**
     * Return html for social buttons according to sorting
     * @global WP_Post $post
     * @return string
     */
    public function getHtml()
    {
        global $post;

        $sharePermalink = get_permalink($post->ID);
        $shareTitle = $this->helper->getShareTitle();
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
