<?php 
// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}

?>
<div class="vit-options-container">

	<h1><?php echo $title; ?></h1>

	<ul id="vit_btn_view" class="social-icons <?php
	echo "icon-" . $buttonShape;
	echo ("y" == $buttonZoom) ? ' icon-zoom ' : '';
	echo ("y" == $buttonRotate) ? ' icon-rotate ' : '';
	?>">
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

	<div class="vit-clear">&nbsp;</div>

	<form action="options.php" method="post" class="vit-social-options-form">
		<?php
		settings_fields('vit_social');
		do_settings_sections('vit_social');
		?>
		<input name="Submit" type="submit" value="<?php _e('Save Changes') ?>" class="button button-primary" />
	</form>


</div>
