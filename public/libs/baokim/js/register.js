$(document).ready(function() {
	function checkTerm(btn) {
		let term = $('input[name="term"]');

		if (term.prop('checked')) {
			$('#policy-term-error').addClass('hide');
			return true;
		} else {
			$('#policy-term-error').removeClass('hide');
		}

		return false;
	}

	$(document).on('click', '.register-btn', function() {
		$('#loading-icon').show();
		let form = $('#reg-form');

		if (form.valid() && checkTerm($(this))) {
			form.submit();
		} else {
			alert('Thông tin bên dưới ko hợp lệ!');
		}
		$('#loading-icon').hide();
	});
});