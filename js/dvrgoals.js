/**
 * @file: js/dvrgoals.js
 * @author: Jake
 * @date: Oct 20, 2012
 * @updated: Feb 17, 2016
 * @brief: Site-specific javascript
 */

/* When the click is clicked, show goals */
$('.click').click(function(e){
	var id = $(e.currentTarget).attr("data-id");
	$('.click[data-id='+id+']').hide();
	$('.goals[data-id='+id+']').show();
});

/* When clicking a link, limit display to that type of well */
$('.link').click(function(e) {
	e.preventDefault();
	var id = $(e.currentTarget).attr("data-link");
	$('#goals').hide();
	$('#nogoals').hide();
	$('#upcoming').hide();
	$('#'+id).show();
	$('.link').parent().removeClass('active');
	$(this).parent().addClass('active');
});

/* When clicking the logo, clear filtering by type */
$('#logo').click(function(e) {
	e.preventDefault();
	$('#goals').show();
	$('#nogoals').show();
	$('#upcoming').show();
	$('.link').parent().removeClass('active');
});

/*
var Application = {
	setupQuickFilter: function()
	{
		var $containers = $('#display');
		$containers.each(function(i) {

			var $filterField = $($(this).find('.filterContent')[0]);
			var element = $filterField.attr('data-element');

			// the name attribute of the filter field is the div we filter
			var $filterContent = $('#' + $filterField.attr('name')).find(element);


			$filterField.keyup( function() {
				var srchform = $filterField.val();
				if (srchform === '') {
					$filterContent.show();
					$('#no-results').hide();
					return;
				}
				$filterContent.hide();
				$filterContent.find(':contains("' + srchform + '")').each(function() {
					$(this).parent(element).show();
				});

				// action when all are hidden
				if ($filterContent.children(':visible').length == 0) {
   					$('#no-results').show();
				} else {
					$('#no-results').hide();
				}
			});
		});
	},
	init: function() {
		this.setupQuickFilter();
	}
}


jQuery.expr[':'].contains = function(a, i, m) {
	return jQuery(a).text().toUpperCase()
	.indexOf(m[3].toUpperCase()) >= 0;
};
Application.init();
*/