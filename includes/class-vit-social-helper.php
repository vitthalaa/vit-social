<?php

class Vit_Social_Helper
{

    /**
     * 
     * @param WP_Post $post
     * @param boolean $isadmin
     * @return string
     */
    public function getSortedButtons($post, $isadmin = false)
    {
        $buttons = $this->getShareButtons();
        $sortedButtons = array();
        //Create array of buttons which allowed to show and kept order as key for sorting
        foreach ($buttons as $buttonId => $button) {
            $showField = "vit_show_" . $buttonId;
            $orderField = "vit_order_" . $buttonId;

            $showValue = get_post_meta($post->ID, $showField, true);

            if (!$isadmin && $showValue == 0) {
                continue;
            }
            $orderValue = get_post_meta($post->ID, $orderField, true);

            if (!$isadmin) {
                $sortedButtons[$orderValue] = $button;
            } else {
                $showValue = ($showValue === 0 || $showValue === '0') ? 0 : 1;
                $orderValue = (!empty($orderValue)) ? $orderValue : $button['default_order'];
                $checked = $showValue ? 'checked="checked"' : '';
                $disabled = $showValue ? '' : ' ui-state-disabled';

                $html = '<li class="ui-state-default' . $disabled . '">';
                $html .= $button['name'] . '  <input type="checkbox" id="' . $showField . '" name="' . $showField . '" ' . $checked . ' class="socialShowField" value="1">';
                $html .= '<input type="hidden" id="' . $orderField . '" name="' . $orderField . '"  value="' . esc_attr($orderValue) . '" class="socialOrderField"/>';
                $html .= '</li>';
                $sortedButtons[$orderValue] = $html;
            }
        }


        ksort($sortedButtons, SORT_NUMERIC); //Sort array

        return $sortedButtons;
    }

    public function loadView($view, $module, $variables, $isReturn = false)
    {
        extract($variables);
        $viewPath = plugin_dir_path(dirname(__FILE__)) . $module . '/views/' . $view . '.php';
        
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
    
    public function getShareTitle()
    {
        return get_the_title();
    }
    
    public function getEmailSubject($title)
    {
        $subject = str_replace("{site_title}", htmlspecialchars(get_bloginfo('name')), get_option('vit_email_subject', '{site_title}:{post_title}'));

        return str_replace("{post_title}", $title, $subject);
    }
    
    public function getEmailBody($title, $link)
    {
        $body = str_replace("{post_title}", $title, get_option('vit_email_body', 'I recommend this page:{post_title}. You can read it on {url}.'));

        return str_replace("{url}", $link, $body);
    }

    public function getWhatsAppText($title, $link)
    {
        $body = str_replace("{post_title}", $title, get_option('vit_whatsapp_text', 'I recommend this page:{post_title}. You can read it on {url}.'));

        return str_replace("{url}", $link, $body);
    }

    public function doShow($postType = null)
    {
        $postType = empty($postType) ?: get_post_type();
        $showOn = get_option("vit_show_on", "both");

        return ($postType == $showOn || "both" == $showOn);
    }

    public function assets($path = "")
    {
        global $pluginDirecotyUrl;

        return $pluginDirecotyUrl . "resources/assets/" . $path;
    }
}
