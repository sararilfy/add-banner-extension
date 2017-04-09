<?php
$no_image_path = plugins_url( '../images/no-image.png', __FILE__ );
?>
<script>
(function($) {
	$(function() {
		var custom_uploader = wp.media({
			title: '<?php _e( 'Choose Image', $this->text_domain ); ?>',
			library: {
				type: 'image'
			},
			button: {
				text: '<?php _e( 'Choose Image', $this->text_domain ); ?>'
			},
			multiple: false
		});

		custom_uploader.on('select', function () {
			var images = custom_uploader.state().get('selection');

			images.each(function(file) {
				$("#banner-image-url").val(file.toJSON().url);
				if( $('#banner-image-alt').val() == '' ) {
					$('#banner-image-alt').val(file.toJSON().alt);
				}
				$('#banner-image-view').attr('src', file.toJSON().url);
			});
		});

		$('#media-upload').on('click', function() {
			custom_uploader.open();
		});

		$("#banner-image-view").on('error', function () {
			$(this).attr({
				'src': '<?php echo $no_image_path; ?>',
				'alt': 'No image to show'
			});
		});
	});
})(jQuery);
</script>