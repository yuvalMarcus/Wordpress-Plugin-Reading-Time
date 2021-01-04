
jQuery(document).ready(function () {
    jQuery('#remove_all_reading_time_ym').on('click', function () {
        jQuery('#remove_all_reading_time_ym').prop('disabled', true);
        jQuery('.loading').addClass('fadein');
        jQuery.post(ajaxurl, {
            'action': 'remove_all_reading_time_ym',
        }, function (response) {
            jQuery('.loading').removeClass('fadein');
            jQuery('.message').html('<div class="alert alert-success fadein"><p><strong>All Reading Time Data Is Remove.</strong></p></div>');
            setTimeout(function () {
                jQuery('.message').html('');
                jQuery('#remove_all_reading_time_ym').prop('disabled', false);
            }, 2000);
        });
    });
});