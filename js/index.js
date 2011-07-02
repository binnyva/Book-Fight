var hover_timer = false;

function init() {
	$(".item-row").click(function(e) {
		var checkbox = $(this).find("input.read");
		if(!checkbox.length) return; // If there is no checkbox in it, never mind.
		
		if(e.target.className != "read") // If the user clicked on the checkbox directly, don't toggle. If they clicked on the row, toggle the checkbox
			checkbox.attr('checked', !checkbox.attr('checked')); // Toggles the checkbox
		markAsRead.apply(checkbox[0]);
	});
	
	$(".image img").hover(function() {
		hover_timer = setTimeout(showCover, 500, this);
	}, function() {
		clearTimeout(hover_timer);
		$("#cover_preview").hide();
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

function showCover(ele) {
	var big_img_url = ele.src.replace(/\/small\//,"/big/");
	$("#cover_preview").css({
		left:Number($(ele).position().left), 
		top:Number($(ele).position().top) + Number($(ele).height()) - 2,
	}).html("<img src='"+big_img_url+"' height='200' />").show();
}

function markAsRead() {
	var status = this.checked ? 1 : 0;
	var item_id = getId(this.id);
	
	if(status) $("#item-"+item_id+" .title").addClass("read");
	else $("#item-"+item_id+" .title").removeClass("read")
	
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
