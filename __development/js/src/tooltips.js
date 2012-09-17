// JavaScript Document
// jQuery tooltips

$(document).ready(function() {
	// account home menu
	
	$("#nav_account").live('click',function(event) {
	
	  event.preventDefault();
	  
	  $(this).qtip({
		  prerender: true,
		  overwrite: false,
		  content: {
			  text: '<div class="big_loader"><img src="/img/layout/big_loader.gif" class="load_gif"></div>',
			  ajax: {
				  url: '/resources/scripts/php/account_menu.php',
				  type: 'get',
				  data: { ajax: true }
				  //once: true
			  }
		  },
		  show: {
			 event: event.type,
			 ready: true,
			 solo: true
		  },
		  hide: {
			  delay: 400,
			  fixed: true
		  },
		  position: {
			  my: 'top center',
			  at: 'bottom center',
			  target: $("#nav_account"),
			  adjust: {
				  y: -17
			  }
		  },
		  style: {
			  classes: 'ui-tooltip-light ui-tooltip-rounded',
			  tip: 'topMiddle'
		  },
		  events: {
			  toggle: function(event, api) {
					 api.elements.target.toggleClass('active', event.type === 'tooltipshow');
			  }
		  }
		  
		  
		  
		  
	  });
	  
	});
	  
	
	
});
