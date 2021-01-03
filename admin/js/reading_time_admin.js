
jQuery(document).ready(function () {
    jQuery('#update_all_reading_time').on('click', function () {
        jQuery('#update_all_reading_time').prop('disabled', true);
        jQuery('.loading').addClass('fadein');
        jQuery.post(ajaxurl, {
            'action': 'update_all_reading_time',
        }, function (response) {
            jQuery('.loading').removeClass('fadein');
            jQuery('.message').html('<div class="alert alert-success fadein"><p><strong>Reading Time Data Is Update.</strong></p></div>');
            setTimeout(function () {
                jQuery('.message').html('');
                jQuery('#update_all_reading_time').prop('disabled', false);
            }, 2000);
        });
    });
});