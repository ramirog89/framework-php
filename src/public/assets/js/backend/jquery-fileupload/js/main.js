$(function () {
    'use strict';

    // Initialize the jQuery File Upload widget:
    $('#fileupload').fileupload({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        //    disableImageResize: /Android(?!.*Chrome)|Opera/
        //        .test(window.navigator.userAgent),
        url: '/api/vestuarios/addarticulo'
    });

    $('#fileupload').fileupload('option', {
        maxFileSize: 5000000,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i
    });

});
