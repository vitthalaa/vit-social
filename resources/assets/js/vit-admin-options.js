/* 
 * Plugin option page events for changing view of buttons
 * @author: vitthal 
 */

(function (window, $, undefined) {
    var changeButtonShape = function (buttonShape) {
        var vitButtonView = $('#vit_btn_view');
        vitButtonView.removeClass("icon-flat");
        vitButtonView.removeClass("icon-circle");
        vitButtonView.removeClass("icon-rounded");
        vitButtonView.addClass("icon-" + buttonShape);
    };

    $(document).ready(function () {
        $(".vit_button_shape").change(function () {
            changeButtonShape($(this).val());
        });

        $(".vit_button_zoom").change(function () {
            if ($(this).val() == "y") {
                $('#vit_btn_view').addClass("icon-zoom");
            } else {
                $("#vit_btn_view").removeClass("icon-zoom");
            }
        });

        $(".vit_button_rotate").change(function () {
            if ($(this).val() == "y") {
                $('#vit_btn_view').addClass("icon-rotate");
            } else {
                $("#vit_btn_view").removeClass("icon-rotate");
            }
        });

        $('.vit_button_width, .vit_button_font_size').keydown(function (e) {
            -1 !== $.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) || /65|67|86|88/.test(e.keyCode) && (!0 === e.ctrlKey || !0 === e.metaKey) || 35 <= e.keyCode && 40 >= e.keyCode || (e.shiftKey || 48 > e.keyCode || 57 < e.keyCode) && (96 > e.keyCode || 105 < e.keyCode) && e.preventDefault()
        });

        $('.vit_button_width').change(function () {
            var width = $(this).val();
            $('#vit_btn_view').find(".fa").css({"width": width + "px", "height": width + "px", "line-height": width + "px"});
        });

        $('.vit_button_font_size').change(function () {
            var size = $(this).val();
            $('#vit_btn_view').find(".fa").css({"font-size": size + "px"});
        });
    });
}(window, jQuery));

