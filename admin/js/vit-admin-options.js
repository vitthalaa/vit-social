window.$ = jQuery;

var changeButtonShape = function(buttonShape) {
    var vitButtonView = $('#vit_btn_view');
    vitButtonView.removeClass("icon-flat");
    vitButtonView.removeClass("icon-circle");
    vitButtonView.removeClass("icon-rounded");
    vitButtonView.addClass("icon-" + buttonShape);
};

$(document).ready(function() {
    var buttonShape = $('.vit_button_shape:checked').val();
    changeButtonShape(buttonShape);
    $(".vit_button_shape").change(function() {
        changeButtonShape($(this).val());
    });
});