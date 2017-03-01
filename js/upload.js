(function($) {
    $(function() {
        var custom_uploader = wp.media({
            title: 'Choose Image',
            library: {
                type: 'image'
            },
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });

        custom_uploader.on("select", function () {
            var images = custom_uploader.state().get('selection');

            images.each(function(file) {
                $("#banner-image-url").val(file.toJSON().url);
                if($("#banner-image-alt").val() == "") {
                    $("#banner-image-alt").val(file.toJSON().alt);
                }
                $("#banner-image-view").attr("src", file.toJSON().url);
            });
        });

        $("#media-upload").on("click", function() {
            custom_uploader.open();
        });
    });
})(jQuery);