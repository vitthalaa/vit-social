jQuery('document').ready(function($) {
    /*$('.vit-social-btn').click(function () {
       var url = $(this).data('url');
       var media = $(this).data('media');
       
       alert(media + " Clicked");
    });*/
});

function sharePopup(btn)
{
    var url = btn.getAttribute("data-url");
    var media = btn.getAttribute("data-media");
    
    window.open(url, "_blank", "scrollbars=1,resizable=1,height=400,width=550", false);
    
    return false;
}