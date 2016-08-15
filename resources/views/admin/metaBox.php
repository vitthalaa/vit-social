<?php 
// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}

global $vitPluginDirectoryUrl;
?>
<style>
    #sortable_social { 
        list-style-type: none;
        margin: 0; 
        padding: 0; 
        zoom: 1;
        
    }
    #sortable_social li { margin: 0 5px 5px 5px; padding: 5px; width: 90%; cursor: move; 
        border: 1px solid #d3d3d3;
        font-weight: normal;
        color: #555555;
        background: #e6e6e6 url("<?php echo $vitPluginDirectoryUrl ?>resources/images/ui-bg_glass_75_e6e6e6_1x400.png") 50% 50% repeat-x;
    }
    #sortable_social li .socialShowField { float:right; margin-top:1px; }
    #sortable_social li.ui-state-disabled {
        opacity: .35;
    }
</style>
<?php wp_nonce_field('vit_inner_custom_box', 'vit_inner_custom_box_nonce'); ?>
<ul id="sortable_social">
    <?php
    foreach ($sortedButtons as $button) {
        echo $button;
    }
    ?>
</ul>
