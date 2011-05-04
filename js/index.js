function init() {
	$(".item-row").click(function(e) {
		var checkbox = $(this).find("input.read");
		if(e.target.className != "read") // If the user clicked on the checkbox directly, don't toggle. If they clicked on the row, toggle the checkbox
			checkbox.attr('checked', !checkbox.attr('checked')); // Toggles the checkbox
		markAsRead.apply(checkbox[0]);
	});
	
	$("#show-read").click(function() {
		$(".tabs li").removeClass("tab-selected");
		$(this).parent("li").addClass("tab-selected");
		
		$(".item-row").each(function() {
			var checkbox = $(this).find("input.read")[0];
			if(checkbox.checked) $(this).show(); //Show the Read stuff - its checked
			else $(this).hide();
		});
	});
	$("#show-unread").click(function() {
		$(".tabs li").removeClass("tab-selected");
		$(this).parent("li").addClass("tab-selected");
		
		$(".item-row").each(function() {
			var checkbox = $(this).find("input.read")[0];
			if(!checkbox.checked) $(this).show(); //Show the unread
			else $(this).hide();
		});
	});
	$("#show-all").click(function() {
		$(".tabs li").removeClass("tab-selected");
		$(this).parent("li").addClass("tab-selected");
		
		$(".item-row").show();
	});

}

function markAsRead() {
	var status = this.checked ? 1 : 0;
	var item_id = getId(this.id);
	
	loading();
	$.ajax({
		"url": "ajax/done.php?ajax=1&item_id="+item_id+"&status="+status,
		"success": function() {
			loaded();
		},
		"error": function() {
			loaded();
			ajaxError();
		}
	});
}
