/* 
 * Add sortable event to social icon metabox in admin post page
 * @author: vitthal 
 */

jQuery(function ($) {
    //Add jquery sortable event
    $("#sortable_social").sortable({
        cancel: ".ui-state-disabled",
        update: function (event, ui) {
            //On update, loop through each li
            $('#sortable_social li').each(function (e) {
                //add current position of li to its order value
                var orderVal = $(this).index() + 1;
                $(this).children('.socialOrderField').val(orderVal);
            });
        }
    });
    
    //disable elements which are not selected
    $("#sortable_social li").disableSelection();
    
    //Enable/disable on checkbox change
    $('.socialShowField').change(function () {
        //if ($(this).prop('checked') == true) {
        console.log($(this).attr("checked"));
        if ($(this).attr("checked")) {    
            $(this).parent('li').removeClass('ui-state-disabled');
        } else {
            $(this).parent('li').addClass('ui-state-disabled');
        }
    });
});

