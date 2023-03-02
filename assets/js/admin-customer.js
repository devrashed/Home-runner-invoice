(function ($) {

	$(document).on('submit', '#homebill-customer-form', function () {

		const $form = $(this);
		const $button = $form.find('input[type="submit"]');
		const $notice = $form.find('.form-notice');
		const data = $(this).serialize();

		$notice.html('Loading...').show();
		$button.prop('disabled', true);

		$.post(ajaxurl, data)
			.done(function (resp) {
				if (resp.message) {
					$notice.html(resp.message);
				} else {
					$notice.empty();
				}
			})
			.fail(function (xhr) {
				$notice.html('An unknown error occurred. Check console log.');
				console.log(xhr);
			})
			.always(function () {
				$button.prop('disabled', false);
			});

		return false;
	});

})(jQuery);