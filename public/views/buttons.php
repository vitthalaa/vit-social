<ul class="social-icons icon-flat icon-zoom icon-rotate"> 
<?php
foreach ($sortedButtons as $button) :
    echo '<li>';
    $image = '<img title="' . $button['name'] . '" src="' . plugins_url('assets/images/' . $button['image'], __DIR__) . '" alt="' . $button['name'] . '" />';
    switch ($button['name']) :
        case 'Twitter': ?>
                <a onclick="return sharePopup(this)" class="vit-social-btn" href="javascript:" data-media="<?php echo $button['slug'] ?>"
                    data-url="http://twitter.com/share?text=<?php echo urlencode($shareTitle) ?>&amp;url=<?php echo $sharePermalink ?>">
                        <?php //echo $image ?>
                    <i class="fa fa-twitter"></i>
                </a>
                <?php
            break;

        case 'Facebook':
            ?>
                <a onclick="return sharePopup(this)" class="vit-social-btn" href="javascript:" data-media="<?php echo $button['slug'] ?>"
                    data-url="https://www.facebook.com/sharer/sharer.php?u=<?php echo $sharePermalink ?>">
                    <?php //echo $image ?>
                    <i class="fa fa-facebook"></i>
                </a>
            <?php
            break;

        case 'Google+':
            ?>
                <a onclick="return sharePopup(this)" class="vit-social-btn" href="javascript:" data-media="<?php echo $button['slug'] ?>"
                    data-url="https://plus.google.com/share?url=<?php echo $sharePermalink ?>">
                        <?php //echo $image ?>
                        <i class="fa fa-google-plus"></i>
                </a>
            <?php        
            break;

        case 'Email':
            ?>
                <a class="vit-social-btn" href="mailto:?subject=<?php echo urlencode($emailSubject) ?>&amp;body=<?php echo urlencode($emailBody) ?>" title="<?php echo $shareTitle ?>">
                    <?php //echo $image ?>
                    <i class="fa fa-envelope-o"></i>
                </a>
            <?php    
            break;

        case 'Whatsapp':
            ?>
                <a class="vit-social-btn" href="whatsapp://send?text=<?php echo urlencode($emailBody) ?>" data-action="share/whatsapp/share" title="<?php echo $shareTitle ?>">
                    <?php //echo $image ?>
                    <i class="fa fa-whatsapp"></i>
                </a>
            <?php
            break;
            
        case 'Instagram':
            ?>
                <a onclick="return sharePopup(this)" class="vit-social-btn" target="_blank" href="<?php echo get_option('instagram_link', 'https://instagram.com') ?>" title="<?php $shareTitle ?>">
                    <?php //echo $image ?>
                    <i class="fa fa-instagram"></i>
                </a>
            <?php
            break;

        case 'Linkedin':
            ?>
                <a onclick="return sharePopup(this)" class="vit-social-btn" href="javascript:" data-media="<?php echo $button['slug'] ?>"
                    data-url="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $sharePermalink ?>&amp;title=<?php echo $shareTitle ?>">
                    <?php echo $image ?>
                    
                </a>
            <?php        
            break;
    
    endswitch;
    
    echo '</li>';
endforeach;
?>
</ul>
