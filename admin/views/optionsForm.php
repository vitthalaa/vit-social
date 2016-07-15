<h1><?php echo $title; ?></h1>

<ul id="vit_btn_view" class="social-icons icon-flat icon-zoom icon-rotate">
    <li>
    <a class="vit-social-btn" href="javascript:">
        <i class="fa fa-twitter"></i>
    </a>
    <a class="vit-social-btn" href="javascript:">
        <i class="fa fa-facebook"></i>
    </a>
    <a class="vit-social-btn" href="javascript:">
        <i class="fa fa-google-plus"></i>
    </a>
    <a class="vit-social-btn" href="javascript:">
        <i class="fa fa-envelope-o"></i>
    </a>
    <a class="vit-social-btn" href="javascript:">
        <i class="fa fa-whatsapp"></i>
    </a>
    <a class="vit-social-btn" href="javascript:">
        <i class="fa fa-instagram"></i>
    </a>
    <a class="vit-social-btn" href="javascript:">
        <i class="fa fa-linkedin"></i>
    </a>
    </li>
</ul>
<br>

<?php
        echo '<form action="options.php" method="post" class="vit-social-options-form">';
        settings_fields('vit_social');
        do_settings_sections('vit_social');

        echo '<input name="Submit" type="submit" value="' . __('Save Changes') . '" class="button button-primary" />';
        echo '</form>';