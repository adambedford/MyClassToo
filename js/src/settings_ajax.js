// JavaScript Document

$(document).ready(function() {
	$( "#tabs" ).tabs({
		cache: false,
	  });
	
	  // For forward and back
	  $.address.externalChange(function(event){
		var name = window.location.hash != "" ? window.location.hash.split("#")[2] : ""
		$("#tabs").tabs( "select" , $("#tabs a[name="+ name + "]").attr('href') )
	  });
	  // when the tab is selected update the url with the hash
	  $("#tabs").bind("tabsselect", function(event, ui) { 
		$.address.hash(ui.tab.name);
	  });
});