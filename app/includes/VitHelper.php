<?php
// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Helper class for some common and basic oprations in other classes
 *
 * @author vitthal
 */
class VitHelper
{

    /**
     * Get sorted button for post
     * 
     * @param WP_Post $post     Wordpress post object
     * @param boolean $isadmin  true if calling from admin
     * @return array
     */
    public function getSortedButtons($post, $isadmin = false)
    {
        $buttons = $this->getShareButtons();
        $sortedButtons = array();
        
        //Create array of buttons which allowed to show and kept order as key for sorting
        foreach ($buttons as $buttonId => $button) {
            $showField = "vit_show_" . $buttonId;
            $orderField = "vit_order_" . $buttonId;
            $showValue = intval(esc_attr(get_post_meta($post->ID, $showField, true)));            
            
            if ("" === $showValue || null === $showValue) {
                $showValue = 1;
            }

            if (!$isadmin && $showValue == 0) {
                continue;
            }
           
            $orderValue = intval(esc_attr(get_post_meta($post->ID, $orderField, true)));
            if ("" === $orderValue || null === $orderValue) {
                $orderValue = $button['default_order'];
            }
            
            //If calling from admin, create button as html
            if (!$isadmin) {
                $sortedButtons[$orderValue] = $button;
            } else {
                $showValue = ($showValue === 0 || $showValue === '0') ? 0 : 1;
                $orderValue = (!empty($orderValue)) ? $orderValue : $button['default_order'];
                $checked = $showValue ? 'checked="checked"' : '';
                $disabled = $showValue ? '' : ' ui-state-disabled';

                $html = '<li class="ui-state-default' . $disabled . '">';
                $html .= $button['name'] . '  <input type="checkbox" id="' . $showField . '" name="' . $showField . '" ' . $checked . ' class="socialShowField" value="1">';
                $html .= '<input type="hidden" id="' . $orderField . '" name="' . $orderField . '"  value="' . $orderValue . '" class="socialOrderField"/>';
                $html .= '</li>';
                $sortedButtons[$orderValue] = $html;
            }
        }
        
        ksort($sortedButtons, SORT_NUMERIC); //Sort array

        return $sortedButtons;
    }
    
    /**
     * Load view files of given module
     * 
     * @global  string  $vitPluginDirectoryPath     Absolute path of pligin
     * @param   string  $view                       view file name without extension
     * @param   string  $module                     Module name to load view from
     * @param   array   $variables                  Variables used in view
     * @param   boolean $isReturn                   if true then return view as string else render it
     * @return  mixed                               string if $isReturn parameter is true else void
     */
    public function loadView($view, $module, $variables, $isReturn = false)
    {
        global $vitPluginDirectoryPath;
        
        extract($variables);
        $viewPath = $vitPluginDirectoryPath . 'resources/views/' . $module . '/' . $view . '.php';
        
        if ($isReturn) {
            ob_start();
        }

        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            echo __('View ' + $view + ' does not exist!', 'vit_social');
        }
        
        if ($isReturn) {
            return ob_get_clean();
        }
    }

    /**
     * Return array of all buttons
     * @return array
     */
    public function getShareButtons()
    {
        return array(
            'twitter' => array(
                'name' => 'Twitter',
                'default_order' => 1,
                'slug' => 'twitter',
                'image' => 'twitter-icon.png'
            ),
            'google' => array(
                'name' => 'Google+',
                'default_order' => 2,
                'slug' => 'googlePlus',
                'image' => 'google-icon.png'
            ),
            'facebook' => array(
                'name' => 'Facebook',
                'default_order' => 3,
                'slug' => 'facebook',
                'image' => 'facebook-icon.png'
            ),
            'email' => array(
                'name' => 'Email',
                'default_order' => 4,
                'slug' => 'email',
                'image' => 'mail-icon.png'
            ),
            'linkedin' => array(
                'name' => 'Linkedin',
                'default_order' => 5,
                'slug' => 'linkedin',
                'image' => 'linkedin-icon.png'
            ),
            'whatsapp' => array(
                'name' => 'Whatsapp',
                'default_order' => 6,
                'slug' => 'whatsapp',
                'image' => 'whatsapp-icon.png'
            ),
            'instagram' => array(
                'name' => 'Instagram',
                'default_order' => 7,
                'slug' => 'instagram',
                'image' => 'insta-icon.png'
            )
        );
    }
    
    /**
     * Get title of current post for sharing
     * 
     * @return string
     */
    public function getShareTitle()
    {
        return get_the_title();
    }
    
    /**
     * Return admin configured email subject and insert title in it
     * 
     * @param   string $title Title of post to insert
     * @return  string
     */
    public function getEmailSubject($title)
    {
        $optionEmailSubject = esc_html(get_option('vit_email_subject', '{site_title}:{post_title}'));
        $subject = str_replace("{site_title}", htmlspecialchars(get_bloginfo('name')), $optionEmailSubject);

        return str_replace("{post_title}", $title, $subject);
    }
    
    /**
     * Return admin configured email body and insert title and link in it 
     * 
     * @param   string $title   Title of post to insert
     * @param   string $link    Link of post to insert
     * @return  string
     */
    public function getEmailBody($title, $link)
    {
        $optionEmailBody = esc_html(get_option('vit_email_body', 'I recommend this page:{post_title}. You can read it on {url}.'));
        $body = str_replace("{post_title}", $title, $optionEmailBody);

        return str_replace("{url}", esc_url($link), $body);
    }
    
    /**
     * Return admin configured whatsapp text and insert title and link in it 
     * 
     * @param   string $title
     * @param   string $link
     * @return  string
     */
    public function getWhatsAppText($title, $link)
    {
        $optionWhatsAppText = esc_html(get_option('vit_whatsapp_text', 'I recommend this page:{post_title}. You can read it on {url}.'));
        $body = str_replace("{post_title}", $title, $optionWhatsAppText);

        return str_replace("{url}", esc_url($link), $body);
    }
    
    /**
     * Check whether need to show button or not
     * 
     * @param   string $postType    Type of post, i.e. post or page
     * @return  boolean             true if can show
     */
    public function canShowButtons($postType = null)
    {
        $postType = empty($postType) ?: get_post_type();
        $showOn = esc_attr(get_option("vit_show_on", "both"));

        return ($postType == $showOn || "both" == $showOn);
    }
    
    /**
     * Return assets path url and append path parameter to it 
     * 
     * @global  string $vitPluginDirectoryUrl   Plugin directory url
     * @param   string $path                    Sub path of assets folder
     * @return  string                          Assets path url
     */
    public function assets($path = "")
    {
        global $vitPluginDirectoryUrl;

        return $vitPluginDirectoryUrl . "resources/assets/" . $path;
    }
}
