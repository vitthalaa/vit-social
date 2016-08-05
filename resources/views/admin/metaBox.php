<style>
    #sortable_social { list-style-type: none; margin: 0; padding: 0; zoom: 1; }
    #sortable_social li { margin: 0 5px 5px 5px; padding: 5px; width: 90%; cursor: move; }
    #sortable_social li .socialShowField { float:right; margin-top:1px; }
</style>
<?php wp_nonce_field('vit_inner_custom_box', 'vit_inner_custom_box_nonce'); ?>
<ul id="sortable_social">
    <?php
    foreach ($sortedButtons as $button) {
        echo $button;
    }
    ?>
</ul>
