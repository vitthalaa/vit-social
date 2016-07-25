<?php

class Vit_Social_Public
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

    public function enqueueScripts()
    {
        if (!$this->helper->doShow()) {
            return;
        }

        wp_register_style("vit_social_css", $this->helper->assets('css/vit-social.php'));
        wp_enqueue_style('vit_social_css');

        wp_enqueue_script($this->plugin_name, $this->helper->assets('js/vit-social.js'), array('jquery'), $this->version, false);
        wp_enqueue_style($this->plugin_name . '_font_awesome', $this->helper->assets('vendor/font-awesome/font-awesome.min.css'), array(), '4.4.0', 'all');
    }

    public function addIcons($content)
    {
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
