$(document).ready(function() {
	$(window).on("load resize", function() {
		$("#sidebar").css({
			height: $(".payment-container").height() + $(".footer_wapper").height()
		});
		$(".sidebar-header-background").css({
			width: $(".payment-container").width()
		});
	});
	$(".slide-toggle").click(function() {
		$("#sidebar").show("slide", {
			direction: "right"
		});
	});
	$("#close-menu-btn").click(function() {
		$("#sidebar").hide("slide", {
			direction: "right"
		});
	});
	jQuery(document).click(function(e) {
		let target = e.target;
		if (jQuery(target).is("body.dislable_scorll")) {
			$("#sidebar").hide("slide", {
				direction: "right"
			});
		}
	});
	$(window).on("scroll load", function() {
		let position = $(window).scrollTop();

		if ($(window).width() <= 500) {
			if (position >= 12) {
				$(".sidebar-header").addClass("sidebar-header-sticky");
			} else {
				$(".sidebar-header").removeClass("sidebar-header-sticky");
			}
		} else {
			if (position >= 20) {
				$(".sidebar-header").addClass("sidebar-header-sticky");
			} else {
				$(".sidebar-header").removeClass("sidebar-header-sticky");
			}
		}
	});
});