$(document).ready(function() {
	/* 
	*	Check if element is null
	*	
	*	@Param: {
	*		obj: element
	*	}
	*
	* 	@return boolean
	*/
  	window.isNull = function(obj)
	{
		var is;

	    if (obj instanceof jQuery)
	        is = obj.length <= 0;
	    else
	        is = obj === null || typeof obj === 'undefined' || obj == '';

	    return is;
	}

	/* 
	*	Scroll to element on page
	*	
	*	@Param: {
	*		element: class/id/tag ('.class','#id','tag'),
	*		time: milliseconds (1000 milliseconds = 1 second)
	*	}
	*
	* 	@return void
	*/
	window.scrollToElement = function(element, time)
	{
		if (!isNull(element)) {
			$('html, body').animate({
	            scrollTop: $(element).offset().top - 120
	        }, time);
		}
	}

	if (!isNull($('meta[name="csrf-token"]'))) {
		$.ajaxSetup({
	      	headers: {
	          	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	      	}
	  	});
	}

	if (!isNull($('#loading-icon'))) {
		$(document)
			.ajaxStart(function() {
		        $('#loading-icon').show();
		    })
		    .ajaxStop(function() {
		        $('#loading-icon').hide();
		    });
	}
})