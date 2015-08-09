/**
 * @file: public/js/dvrgoals.js
 * @author: Jake
 * @date: Oct 20, 2012
 * @brief: Site-specific javascript
 */

/* When the yes/no is clicked, show goals */
$('.gameScore').click(function(e){
	var id = $(e.currentTarget).attr("data-id");
	$('.gameScore[data-id='+id+']').hide();
	$('.gameGoals[data-id='+id+']').show();
});

/* When the goals are clicked, show yes/no */
$('.gameGoals').click(function(e){
	var id = $(e.currentTarget).attr("data-id");
	$('.gameGoals[data-id='+id+']').hide();
	$('.gameScore[data-id='+id+']').show();
});

$(".gameGoals").hide();
