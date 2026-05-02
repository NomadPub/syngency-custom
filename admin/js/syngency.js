jQuery(document).ready(function ($) {

    jQuery(document).ready(function ($) {
        wp.codeEditor.initialize($('#syngency-division-template'), cm_settings);
    })

    jQuery(document).ready(function ($) {
        wp.codeEditor.initialize($('#syngency-model-template'), cm_settings);
    })
    

    jQuery('.syngency-copy-button').click(function (e) {
        var temp = $("<input>");
        $("body").append(temp);
        var elementID = jQuery(this).data('id')
        var copyElement = jQuery('#sc_models_-_main').text();

        temp.val(jQuery(this).text()).select();
        console.log(copyElement);
        document.execCommand("copy");
        temp.remove();

        showNotification('clipboard', 'Shortcode Copied', 'The shortcode has been copied to your clipboard.')
    });
    function showNotification(icon, title, message) {
        var caption = $(".notification-caption");
        var captionIcon = $(".notification-caption .notification-icon");
        var captionTitle = $(".notification-caption .caption-title");
        var captionMessage = $(".notification-caption .caption-message");
        caption.toggleClass('active');
        captionIcon.html('<span class="icon icon-' + icon + '"></span>');
        captionTitle.html(title);
        captionMessage.html(message);
        setTimeout(function () {
            caption.removeClass('active');
        }, 3000);
    }

});

