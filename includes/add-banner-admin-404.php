<?php
$no_image_path = plugins_url( '../images/no-image.png', __FILE__ );
?>
<script>
(function($) {
	$(function() {
		$(".banner-image-view").on('error', function () {
			$(this).attr({
				'src': '<?php echo $no_image_path; ?>',
				'alt': 'No image to show'
			});
		});
	});
})(jQuery);
</script>