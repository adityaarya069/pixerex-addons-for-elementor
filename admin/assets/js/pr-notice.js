(function ($) {

    var $noticeWrap = $(".pr-notice-wrap"),
        notice = $noticeWrap.data('notice');

    if (undefined !== notice) {

        $noticeWrap.find('.pr-notice-reset').on("click", function () {

            $noticeWrap.css('display', 'none');

            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'pr_reset_admin_notice',
                    notice: $noticeWrap.data('notice')
                }
            });


        });
    }

    $(".pr-notice-close").on("click", function () {

        var noticeID = $(this).data('notice');

        if (noticeID) {
            $(this).closest('.pr-new-feature-notice').remove();

            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'pr_dismiss_admin_notice',
                    notice: noticeID
                },
                success: function (res) {
                    console.log(res);
                },
                error: function (err) {
                    console.log(err);
                }
            });
        }



    });


})(jQuery);