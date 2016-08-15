<?php
/* 
 * Button css from admin configured options
 * @author: vitthal 
 */

header('Content-type: text/css');

$parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
require_once($parse_uri[0] . 'wp-load.php');

$buttonWidth = esc_attr(get_option("vit_button_width", 50));
$fontSize = esc_attr(get_option("vit_button_font_size", 24));
?>
.social-icons .fa, .social-icons img {
    width: <?php echo $buttonWidth; ?>px;
    height: <?php echo $buttonWidth; ?>px;
}
.social-icons .fa {
    line-height: <?php echo $buttonWidth; ?>px;
    font-size: <?php echo $fontSize; ?>px;
}
/*----- General Classes start ------*/
ul.social-icons {
    padding-left: 0;
    list-style: none;
}
ul.social-icons li {
    display: inline-block;
    float: left;
    margin: 5px;
}
/*---- Genral classes end -------*/
.social-icons img {
    line-height: 83px;
}
/*Change icons circle size and color here*/
.social-icons .fa, .social-icons img {
    text-align: center;
    color: #FFF;
    color: rgba(255, 255, 255, 0.8);
    -webkit-transition: all 0.3s ease-in-out;
    -moz-transition: all 0.3s ease-in-out;
    -ms-transition: all 0.3s ease-in-out;
    -o-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
}

.social-icons a.vit-social-btn {
    text-decoration: none;
    color: transparent;
}

.social-icons.icon-circle .fa, .social-icons.icon-circle img{
    border-radius: 50%;
}
.social-icons.icon-rounded .fa, .social-icons.icon-rounded img{
    border-radius:5px;
}
.social-icons.icon-flat .fa, .social-icons.icon-flat img{
    border-radius: 0;
}

.social-icons .fa:hover, .social-icons .fa:active, .social-icons img:hover, .social-icons img:active{
    color: #FFF;
    -webkit-box-shadow: 1px 1px 3px #333;
    -moz-box-shadow: 1px 1px 3px #333;
    box-shadow: 1px 1px 3px #333;
}
.social-icons.icon-zoom .fa:hover, .social-icons.icon-zoom .fa:active, .social-icons.icon-zoom img:hover, .social-icons.icon-zoom img:active {
    -webkit-transform: scale(1.1);
    -moz-transform: scale(1.1);
    -ms-transform: scale(1.1);
    -o-transform: scale(1.1);
    transform: scale(1.1);
}
.social-icons.icon-rotate .fa:hover, .social-icons.icon-rotate .fa:active, .social-icons.icon-rotate img:hover, .social-icons.icon-rotate img:active {
    -webkit-transform: scale(1.1) rotate(360deg);
    -moz-transform: scale(1.1) rotate(360deg);
    -ms-transform: scale(1.1) rotate(360deg);
    -o-transform: scale(1.1) rotate(360deg);
    transform: scale(1.1) rotate(360deg);
}

.social-icons .fa-facebook,.social-icons .fa-facebook-square{background-color:#3C599F;}
.social-icons .fa-google-plus,.social-icons .fa-google-plus-square{background-color:#CF3D2E;}
.social-icons .fa-instagram{background-color:#A1755C;}
.social-icons .fa-linkedin,.social-icons .fa-linkedin-square{background-color:#0085AE;}
.social-icons .fa-pinterest,.social-icons .fa-pinterest-square{background-color:#CC2127;}
.social-icons .fa-twitter,.social-icons .fa-twitter-square{background-color:#32CCFE;}
.social-icons .fa-youtube,.social-icons .fa-youtube-play,.social-icons .fa-youtube-square{background-color:#C52F30;}
.social-icons .fa-reddit{background-color:#7ccbff;}
.social-icons .fa-whatsapp{background-color:#189D0E;}
.social-icons .fa-envelope-o{background-color:#FF7300;}
