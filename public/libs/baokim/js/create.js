var form;
$(document).on('change', function() {
	form = $('.tab-pane.in.active').find('form');
});

$('a[data-toggle="tab"]').on('click', function() {
	$('.alert').addClass('hide');
});

$('.register-btn').on('click', function() {
	let form = $('.tab-pane.in.active').find('form');

	if (form.valid()) {
		$('#loading-icon').show();
		form.submit();
	} else {
		$('#loading-icon').hide();
	}
});

$(document).on('click', '.card-choose__amount', function() {
	var borderActive = $('.boder_active');
	borderActive.removeClass('boder_active');
	$(this).addClass('boder_active');
	var money = $(this).html().trim();
	money = money.replace(/\./gi, "");
	money = money.replace(/đ/gi, "");
	$("[name='money']").val(money);
});

function strToMoney(str) {
	while (str.indexOf('.') != -1) {
		str = str.replace('.', '');
	}
	var result = '';
	while (str.length > 3) {
		var length = str.length;
		result = '.' + str.substring(length - 3, length) + result;
		str = str.substring(0, length - 3);
	}
	result = str + result;
	return result;
}

$(document).on('click', '.option-item', function() {
	let param = $(this).data('param');
	let name = $(this).data('name');
	let image = $(this).data('image');
	let discount = $(this).data('discount');

	// $('#select-value').attr('data-param', param);       
	$('#game-network-image').attr('src', image);
	$('#game-network-name').text(name);
	$('#game-network-discount').text('Chiết khấu - ' + discount);
	$("[name='name']").val(name);
	$("[name='discount']").val(discount);

	$.ajax({
		url: '/store/card-game/get-list-amount',
		dataType: 'json',
		type: 'get',
		data: {
			'name': name
		},
		success: function(data) {
			var html = '';
			if (data.length) {
				for (var i = 0; i < data.length; i++) {
					var money = (data[i] - data[i] * discount / 100) * 1000;
					html += `<div class="col-md-3 col-sm-3 col-xs-3">
                                    <div for="` + data[i] + `" class="card-game-choose__amount text-center">
                                        ` + data[i] + `K` +
						`<p>` + strToMoney(money.toString()) + `</p>
                                    </div>
                                </div>`;
				}
			}
			$("#amount_default").remove();
			$('#list_amount').html(html);
			$(".card-game-choose__amount:first").addClass('boder_active');
			var money = parseInt($(".card-game-choose__amount:first").text().trim());
			$("[name='money']").val(money);
		},
		error: function() {

		}
	});
});