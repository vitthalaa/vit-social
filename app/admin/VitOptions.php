<?php

/**
 * Description of VitOptions
 *
 * @author vitthal
 */
class VitOptions
{

    private $pluginName;
    private $helper;

    public function __construct($pluginName, $helper)
    {
        $this->pluginName = $pluginName;
        $this->helper = $helper;
    }
    
    public function enqueueScripts()
    {
        global $pageHook;
        add_action('admin_print_styles-' . $pageHook, array($this, 'enqueueScriptsStyles'));
    }

    /**
     * Register the stylesheets for the admin options area.
     */
    public function enqueueScriptsStyles($hook)
    {
        wp_register_style("vit_social_css", $this->helper->assets('css/vit-social.php'));
        wp_enqueue_style('vit_social_css');
        wp_enqueue_style($this->pluginName . '_font_awesome', $this->helper->assets('vendor/font-awesome/font-awesome.min.css'), array(), '4.4.0', 'all');
        wp_enqueue_style($this->pluginName . '_admin_options_css', $this->helper->assets('css/vit-admin-options.css'), array(), false, 'all');
        wp_enqueue_script($this->pluginName . '_admin_options_js', $this->helper->assets('js/vit-admin-options.js'), array('jquery'));
    }
    
    public function addAdminMenu()
    {
        global $pageHook;
        $pageHook = add_options_page('VIT Social', 'VIT Social', 'manage_options', 'vit-social', array($this, 'initSettingPage'));
    }

    private function addSectionSettings($page, $settingsSection)
    {
        switch ($settingsSection) {
            case 'vit_skins':
                $this->addSettingField('vit_button_shape', 'Shape', 'buttonShapeField', $page, $settingsSection);
                $this->addSettingField('vit_button_zoom', 'Hover zoom', 'buttonZoomField', $page, $settingsSection);
                $this->addSettingField('vit_button_rotate', 'Hover rotate', 'buttonRotateField', $page, $settingsSection);
                $this->addSettingField('vit_button_width', 'Size', 'buttonWidthField', $page, $settingsSection);
                $this->addSettingField('vit_button_font_size', 'Font size', 'buttonFontSizeField', $page, $settingsSection);
                $this->addSettingField('vit_show_on', 'Show on', 'buttonShowOnField', $page, $settingsSection);
                break;

            default :
                $this->addSettingField('vit_instagram_link', 'Intstagram profile link', 'instagramLinkField', $page, $settingsSection);
                $this->addSettingField('vit_email_subject', 'Email subject', 'emailSubjectField', $page, $settingsSection);
                $this->addSettingField('vit_email_body', 'Email body', 'emailBodyField', $page, $settingsSection);
                $this->addSettingField('vit_whatsapp_text', 'Whatsapp text', 'whatsappTextField', $page, $settingsSection);
                break;
        }
    }

    private function addSettingField($fieldName, $label, $funtion, $page, $settingsSection)
    {
        //register setting field
        register_setting($page, $fieldName);

        // Add field
        add_settings_field(
                $fieldName, __($label, 'vit_social'), array($this, $funtion), $page, $settingsSection
        );
    }

    public function initSettingPage()
    {
        $title = "VIT Social";
        $buttonShape = get_option("vit_button_shape", 'flat');
        $buttonZoom = get_option("vit_button_zoom", 'y');
        $buttonRotate = get_option("vit_button_rotate", 'y');
        $this->helper->loadView('optionsForm', 'admin', compact('title', 'buttonShape', 'buttonZoom', 'buttonRotate'));
    }

    public function settingsApiInit()
    {
        $page = 'vit_social';
        $settingsSection = 'vit_skins';
        add_settings_section(
                $settingsSection, __('Display', 'vit_social'), array($this, 'skinSectionDescription'), $page
        );
        $this->addSectionSettings($page, $settingsSection);

        $settingsSection = 'vit_content';
        add_settings_section(
                $settingsSection, __('Contents', 'vit_social'), array($this, 'contentSectionDescription'), $page
        );
        $this->addSectionSettings($page, $settingsSection);
    }

    public function skinSectionDescription()
    {
        //_e('Select your display preferences', 'vit_social');
    }

    public function contentSectionDescription()
    {
        //_e('Content for sharing', 'vit_social');
    }

    public function buttonShapeField()
    {
        $buttonShape = get_option('vit_button_shape', 'flat');
        echo '<label><input name="vit_button_shape" class="vit_button_shape" type="radio" value="flat" ' . checked('flat', $buttonShape, false) . ' /> ' . __('Flat', 'vit_social') . '</label>';
        echo '<label><input name="vit_button_shape" class="vit_button_shape" type="radio" value="rounded" ' . checked('rounded', $buttonShape, false) . ' /> ' . __('Rounded', 'vit_social') . '</label>';
        echo '<label><input name="vit_button_shape" class="vit_button_shape" type="radio" value="circle" ' . checked('circle', $buttonShape, false) . ' /> ' . __('Circle', 'vit_social') . '</label>';
    }

    public function buttonZoomField()
    {
        $buttonZoom = get_option('vit_button_zoom', 'y');
        echo '<label><input name="vit_button_zoom" class="vit_button_zoom" type="radio" value="y" ' . checked('y', $buttonZoom, false) . ' /> ' . __('Yes', 'vit_social') . '</label>';
        echo '<label><input name="vit_button_zoom" class="vit_button_zoom" type="radio" value="n" ' . checked('n', $buttonZoom, false) . ' /> ' . __('No', 'vit_social') . '</label>';
    }

    public function buttonRotateField()
    {
        $buttonRotate = get_option('vit_button_rotate', 'y');
        echo '<label><input name="vit_button_rotate" class="vit_button_rotate" type="radio" value="y" ' . checked('y', $buttonRotate, false) . ' /> ' . __('Yes', 'vit_social') . '</label>';
        echo '<label><input name="vit_button_rotate" class="vit_button_rotate" type="radio" value="n" ' . checked('n', $buttonRotate, false) . ' /> ' . __('No', 'vit_social') . '</label>';
    }

    public function buttonWidthField()
    {
        $buttonWidth = get_option('vit_button_width', 50);
        echo '<input type="number" size="50" name="vit_button_width" class="vit_button_width" value="' . $buttonWidth . '">';
    }

    public function buttonFontSizeField()
    {
        $fontSize = get_option('vit_button_font_size', 24);
        echo '<input type="number" name="vit_button_font_size" class="vit_button_font_size" value="' . $fontSize . '">';
    }

    public function buttonShowOnField()
    {
        $showOn = get_option('vit_show_on', 'both');
        echo '<select name="vit_show_on" class="vit_show_on">';
        echo '<option ', ("both" == $showOn) ? 'selected="selected"' : '', ' value="both">' . __("Both", "vit_social") . '</option>';
        echo '<option ', ("page" == $showOn) ? 'selected="selected"' : '', ' value="page">' . __("Page", "vit_social") . '</option>';
        echo '<option ', ("post" == $showOn) ? 'selected="selected"' : '', ' value="post">' . __("Post", "vit_social") . '</option>';
        echo '</select>';
    }

    public function instagramLinkField()
    {
        $link = get_option('vit_instagram_link', 'https://instagram.com');
        echo '<input type="text" name="vit_instagram_link" class="vit_instagram_link" value="' . $link . '">';
    }

    public function emailSubjectField()
    {
        $subject = get_option('vit_email_subject', '{site_title}:{post_title}');
        echo '<input type="text" name="vit_email_subject" class="vit_email_subject" value="' . $subject . '">';
    }

    public function emailBodyField()
    {
        $body = get_option('vit_email_body', 'I recommend this page:{post_title}. You can read it on {url}.');
        echo '<textarea rows="3" name="vit_email_body" class="vit_email_body">' . $body . '</textarea>';
    }

    public function whatsappTextField()
    {
        $body = get_option('vit_whatsapp_text', 'I recommend this page:{post_title}. You can read it on {url}.');
        echo '<textarea rows="3" name="vit_whatsapp_text" class="vit_whatsapp_text">' . $body . '</textarea>';
    }

}
