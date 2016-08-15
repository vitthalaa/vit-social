<?php
// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}

$buttonShape = esc_attr(get_option("vit_button_shape", 'flat'));
$buttonZoom = esc_attr(get_option("vit_button_zoom", 'y'));
$buttonRotate = esc_attr(get_option("vit_button_rotate", 'y'));
?>
<ul class="social-icons <?php
echo "icon-" . $buttonShape;
echo ("y" == $buttonZoom) ? ' icon-zoom ' : '';
echo ("y" == $buttonRotate) ? ' icon-rotate ' : '';
?>">
<?php
foreach ($sortedButtons as $button) :
    echo '<li>';
    switch ($button['name']) :
        case 'Twitter': ?>
                <a onclick="return sharePopup(this)" class="vit-social-btn" href="javascript:" data-media="<?php echo $button['slug'] ?>"
                    data-url="http://twitter.com/share?text=<?php echo urlencode($shareTitle) ?>&amp;url=<?php echo $sharePermalink ?>">
                    <i class="fa fa-twitter"></i>
                </a>
                <?php
            break;

        case 'Facebook':
            ?>
                <a onclick="return sharePopup(this)" class="vit-social-btn" href="javascript:" data-media="<?php echo $button['slug'] ?>"
                    data-url="https://www.facebook.com/sharer/sharer.php?u=<?php echo $sharePermalink ?>">
                    <i class="fa fa-facebook"></i>
                </a>
            <?php
            break;

        case 'Google+':
            ?>
                <a onclick="return sharePopup(this)" class="vit-social-btn" href="javascript:" data-media="<?php echo $button['slug'] ?>"
                    data-url="https://plus.google.com/share?url=<?php echo $sharePermalink ?>">
                    <i class="fa fa-google-plus"></i>
                </a>
            <?php 
            break;

        case 'Email':
            ?>
                <a class="vit-social-btn" href="mailto:?subject=<?php echo urlencode($emailSubject) ?>&amp;body=<?php echo urlencode($emailBody) ?>" title="<?php echo $shareTitle ?>">
                    <i class="fa fa-envelope-o"></i>
                </a>
            <?php 
            break;

        case 'Whatsapp':
            ?>
                <a class="vit-social-btn" href="whatsapp://send?text=<?php echo urlencode($whatsAppText) ?>" data-action="share/whatsapp/share" title="<?php echo $shareTitle ?>">
                    <i class="fa fa-whatsapp"></i>
                </a>
            <?php
            break;
            
        case 'Instagram':
            ?>
                <a class="vit-social-btn" target="_blank" href="<?php echo get_option('vit_instagram_link', 'https://instagram.com') ?>" title="<?php $shareTitle ?>">
                    <i class="fa fa-instagram"></i>
                </a>
            <?php
            break;

        case 'Linkedin':
            ?>
                <a onclick="return sharePopup(this)" class="vit-social-btn" href="javascript:" data-media="<?php echo $button['slug'] ?>"
                    data-url="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $sharePermalink ?>&amp;title=<?php echo $shareTitle ?>">
                    <i class="fa fa-linkedin"></i>
                </a>
            <?php 
            break;
    
    endswitch;
    
    echo '</li>';
endforeach;
?>
</ul>
