<?php
header('Content-type: text/css');

$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );

$buttonWidth = get_option("vit_button_width", 50);
$fontSize = get_option("vit_button_font_size", 24);
?>
.social-icons .fa, .social-icons img {
	width: <?php echo $buttonWidth; ?>px;
	height: <?php echo $buttonWidth; ?>px;
}
.social-icons .fa {
	line-height: <?php echo $buttonWidth; ?>px;
	font-size: <?php echo $fontSize; ?>px;
}

